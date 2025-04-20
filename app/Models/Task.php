<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int $id
 * @property int $user_id
 * @property int|null $project_id
 * @property string $title
 * @property string|null $note
 * @property \Carbon\Carbon|null $defer_date
 * @property \Carbon\Carbon|null $due_date
 * @property string $status
 * @property int $sequence_order
 * @property string|null $recurrence_rule
 * @property bool $flagged
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\User $user
 * @property-read \App\Models\Project|null $project
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Tag> $tags
 */
class Task extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'project_id',
        'title',
        'note',
        'defer_date',
        'due_date',
        'status',
        'sequence_order',
        'recurrence_rule',
        'flagged',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'defer_date' => 'date',
        'due_date' => 'date',
        'flagged' => 'boolean',
    ];

    /**
     * Get the user that owns the task.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the project that the task belongs to.
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Get the tags for the task.
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    /**
     * Add a tag to the task.
     *
     * @param Tag|int $tag
     * @return void
     */
    public function addTag($tag): void
    {
        $tagId = $tag instanceof Tag ? $tag->id : $tag;
        if (!$this->tags()->where('tags.id', $tagId)->exists()) {
            $this->tags()->attach($tagId);
        }
    }

    /**
     * Remove a tag from the task.
     *
     * @param Tag|int $tag
     * @return void
     */
    public function removeTag($tag): void
    {
        $tagId = $tag instanceof Tag ? $tag->id : $tag;
        $this->tags()->detach($tagId);
    }

    /**
     * Flag the task.
     *
     * @return self
     */
    public function flag(): self
    {
        $this->flagged = true;
        $this->save();
        return $this;
    }

    /**
     * Unflag the task.
     *
     * @return self
     */
    public function unflag(): self
    {
        $this->flagged = false;
        $this->save();
        return $this;
    }

    /**
     * Mark the task as complete.
     *
     * @return self
     */
    public function markAsCompleted(): self
    {
        $this->status = 'completed';
        $this->save();

        // If this task is part of a sequential project, update next task
        if ($this->project && $this->project->is_sequential) {
            $nextTask = $this->project->tasks()
                ->where('id', '!=', $this->id)
                ->where('status', '!=', 'completed')
                ->orderBy('sequence_order')
                ->first();

            if ($nextTask) {
                $nextTask->status = 'next';
                $nextTask->save();
            }
        }

        return $this;
    }

    /**
     * Create a new task from this one based on recurrence rule.
     * This method should be called after completing a recurring task.
     *
     * @return Task|null The new recurring task instance or null if not recurring
     */
    public function createNextRecurrence(): ?Task
    {
        if (empty($this->recurrence_rule)) {
            return null;
        }

        // Basic implementation - would need proper recurrence rule parsing in production
        $newTask = $this->replicate(['status']);
        $newTask->status = 'ready';
        
        // If the task has a due date, calculate the next one
        if ($this->due_date) {
            // Simple example: add 1 week for weekly recurrence
            // In a real app, would parse the recurrence_rule properly
            $newTask->due_date = $this->due_date->addWeek();
            
            if ($this->defer_date) {
                $daysDifference = $this->due_date->diffInDays($this->defer_date);
                $newTask->defer_date = $newTask->due_date->copy()->subDays($daysDifference);
            }
        }
        
        $newTask->save();
        
        // Copy tags to the new task
        foreach ($this->tags as $tag) {
            $newTask->addTag($tag);
        }
        
        return $newTask;
    }
}

<?php

namespace App\Models;

use App\Enums\ProjectStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property int $user_id
 * @property int|null $area_id
 * @property string $name
 * @property string|null $note
 * @property \Carbon\Carbon|null $defer_date
 * @property \Carbon\Carbon|null $due_date
 * @property \Carbon\Carbon|null $reviewed_at
 * @property bool $is_sequential
 * @property ProjectStatus $status
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\User $user
 * @property-read \App\Models\Area|null $area
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Task> $tasks
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Tag> $tags
 */
class Project extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'area_id',
        'name',
        'note',
        'defer_date',
        'due_date',
        'reviewed_at',
        'is_sequential',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'defer_date' => 'date',
        'due_date' => 'date',
        'reviewed_at' => 'datetime',
        'is_sequential' => 'boolean',
        'status' => ProjectStatus::class,
    ];

    /**
     * Get the user that owns the project.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the area that the project belongs to.
     */
    public function area(): BelongsTo
    {
        return $this->belongsTo(Area::class);
    }

    /**
     * Get the tasks for the project.
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    /**
     * Get the tags for the project.
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    /**
     * Add a tag to the project.
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
     * Remove a tag from the project.
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
     * Mark the project as complete.
     *
     * @return self
     */
    public function markAsCompleted(): self
    {
        $this->status = ProjectStatus::COMPLETED;
        $this->save();
        return $this;
    }

    /**
     * Assign the project to an area.
     *
     * @param Area|int|null $area
     * @return self
     */
    public function assignToArea($area): self
    {
        $this->area_id = $area instanceof Area ? $area->id : $area;
        $this->save();
        return $this;
    }

    /**
     * Remove the project from its area.
     *
     * @return self
     */
    public function removeFromArea(): self
    {
        $this->area_id = null;
        $this->save();
        return $this;
    }

    /**
     * Check if the project is active.
     *
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->status->isActive();
    }

    /**
     * Get the next tasks in this project.
     * For sequential projects, returns the next uncompleted task.
     * For parallel projects, returns all uncompleted tasks.
     *
     * @return \Illuminate\Database\Eloquent\Collection<int, \App\Models\Task>
     */
    public function getNextTasks()
    {
        if ($this->is_sequential) {
            return $this->tasks()
                ->whereNot('status', 'completed')
                ->orderBy('sequence_order')
                ->limit(1)
                ->get();
        }

        return $this->tasks()->whereNot('status', 'completed')->get();
    }
}

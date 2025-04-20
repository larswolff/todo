<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property bool $in_menu
 * @property \Carbon\Carbon|null $reviewed_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\User $user
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Task> $tasks
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Project> $projects
 */
class Tag extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'name',
        'in_menu',
        'reviewed_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'in_menu' => 'boolean',
        'reviewed_at' => 'datetime',
    ];

    /**
     * Get the user that owns the tag.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the tasks for the tag.
     */
    public function tasks(): BelongsToMany
    {
        return $this->belongsToMany(Task::class);
    }

    /**
     * Get the projects for the tag.
     */
    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class);
    }

    /**
     * Find or create a tag by name for a specific user.
     *
     * @param int $userId The user ID
     * @param string $name The tag name
     * @param bool $inMenu Whether to show in menu
     * @return Tag The found or created tag
     */
    public static function findOrCreateByName(int $userId, string $name, bool $inMenu = false): Tag
    {
        return static::firstOrCreate(
            ['user_id' => $userId, 'name' => $name],
            ['in_menu' => $inMenu, 'reviewed_at' => now()]
        );
    }

    /**
     * Toggle the in_menu status.
     *
     * @return self
     */
    public function toggleInMenu(): self
    {
        $this->in_menu = !$this->in_menu;
        $this->save();
        return $this;
    }

    /**
     * Set the tag to be shown in menu.
     *
     * @return self
     */
    public function showInMenu(): self
    {
        $this->in_menu = true;
        $this->save();
        return $this;
    }

    /**
     * Set the tag to be hidden from menu.
     *
     * @return self
     */
    public function hideFromMenu(): self
    {
        $this->in_menu = false;
        $this->save();
        return $this;
    }

    /**
     * Mark the tag as reviewed.
     *
     * @return self
     */
    public function markAsReviewed(): self
    {
        $this->reviewed_at = now();
        $this->save();
        return $this;
    }

    /**
     * Get all tasks with this tag that are not completed.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getActiveTasks()
    {
        return $this->tasks()->where('status', '!=', 'completed')->get();
    }
}

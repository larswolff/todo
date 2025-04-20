<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property int $sort_order
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\User $user
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Project> $projects
 */
class Area extends Model
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
        'sort_order',
    ];

    /**
     * Get the user that owns the area.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the projects that belong to the area.
     */
    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }

    /**
     * Get active projects in this area.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getActiveProjects()
    {
        return $this->projects()
            ->where('status', '!=', 'completed')
            ->where('status', '!=', 'cancelled')
            ->orderBy('name')
            ->get();
    }

    /**
     * Get the count of active projects in this area.
     *
     * @return int
     */
    public function getActiveProjectsCount(): int
    {
        return $this->projects()
            ->where('status', '!=', 'completed')
            ->where('status', '!=', 'cancelled')
            ->count();
    }
}

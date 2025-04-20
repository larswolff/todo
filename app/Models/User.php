<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Carbon\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Area> $areas
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Project> $projects
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Task> $tasks
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Tag> $tags
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ReferenceMaterial> $referenceMaterials
 */
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the areas for the user.
     */
    public function areas(): HasMany
    {
        return $this->hasMany(Area::class);
    }

    /**
     * Get the projects for the user.
     */
    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }

    /**
     * Get the tasks for the user.
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    /**
     * Get the tags for the user.
     */
    public function tags(): HasMany
    {
        return $this->hasMany(Tag::class);
    }

    /**
     * Get tags that should appear in the menu.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getMenuTags()
    {
        return $this->tags()->where('in_menu', true)->orderBy('name')->get();
    }

    /**
     * Get the reference materials for the user.
     */
    public function referenceMaterials(): HasMany
    {
        return $this->hasMany(ReferenceMaterial::class);
    }

    /**
     * Create a new area for the user.
     *
     * @param array $attributes
     * @return \App\Models\Area
     */
    public function createArea(array $attributes): Area
    {
        return $this->areas()->create($attributes);
    }

    /**
     * Create a new project for the user.
     *
     * @param array $attributes
     * @return \App\Models\Project
     */
    public function createProject(array $attributes): Project
    {
        return $this->projects()->create($attributes);
    }

    /**
     * Create a new task for the user.
     *
     * @param array $attributes
     * @return \App\Models\Task
     */
    public function createTask(array $attributes): Task
    {
        return $this->tasks()->create($attributes);
    }

    /**
     * Create a new tag for the user.
     *
     * @param array $attributes
     * @return \App\Models\Tag
     */
    public function createTag(array $attributes): Tag
    {
        return $this->tags()->create($attributes);
    }

    /**
     * Find or create a tag by name for this user.
     *
     * @param string $name
     * @param bool $inMenu Whether to show in menu
     * @return \App\Models\Tag
     */
    public function findOrCreateTag(string $name, bool $inMenu = false): Tag
    {
        return Tag::findOrCreateByName($this->id, $name, $inMenu);
    }

    /**
     * Get tasks due today.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getTasksDueToday()
    {
        return $this->tasks()
            ->whereDate('due_date', today())
            ->where('status', '!=', 'completed')
            ->get();
    }

    /**
     * Get overdue tasks.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getOverdueTasks()
    {
        return $this->tasks()
            ->whereDate('due_date', '<', today())
            ->where('status', '!=', 'completed')
            ->get();
    }

    /**
     * Get next tasks across all projects.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getNextTasks()
    {
        // First get all tasks explicitly marked as 'next'
        $nextTasks = $this->tasks()
            ->where('status', 'next')
            ->get();

        // Then get the next task from each sequential project
        $sequentialProjects = $this->projects()
            ->where('is_sequential', true)
            ->where('status', 'ready')
            ->get();

        foreach ($sequentialProjects as $project) {
            $nextTasks = $nextTasks->merge($project->getNextTasks());
        }

        return $nextTasks;
    }
}

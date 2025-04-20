<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property string|null $note
 * @property string|null $url
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\User $user
 */
class ReferenceMaterial extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'title',
        'note',
        'url',
    ];

    /**
     * Get the user that owns the reference material.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if the reference material has a URL.
     *
     * @return bool
     */
    public function hasUrl(): bool
    {
        return !empty($this->url);
    }

    /**
     * Check if the reference material has a note.
     *
     * @return bool
     */
    public function hasNote(): bool
    {
        return !empty($this->note);
    }

    /**
     * Get a snippet of the note content.
     *
     * @param int $length The maximum length of the snippet
     * @return string|null
     */
    public function getNoteSnippet(int $length = 100): ?string
    {
        if (empty($this->note)) {
            return null;
        }

        if (mb_strlen($this->note) <= $length) {
            return $this->note;
        }

        return mb_substr($this->note, 0, $length) . '...';
    }
}

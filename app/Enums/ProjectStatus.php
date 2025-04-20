<?php

namespace App\Enums;

enum ProjectStatus: string
{
    case READY = 'ready';
    case COMPLETED = 'completed';
    case INACTIVE = 'inactive';
    case CANCELLED = 'cancelled';
    case SOMEDAY = 'someday';

    /**
     * Check if the project is considered active.
     *
     * @return bool
     */
    public function isActive(): bool
    {
        return $this === self::READY;
    }

    /**
     * Check if the project is completed.
     *
     * @return bool
     */
    public function isCompleted(): bool
    {
        return $this === self::COMPLETED;
    }

    /**
     * Get all cases as an array of value => name pairs.
     *
     * @return array<string, string>
     */
    public static function asSelectArray(): array
    {
        return [
            self::READY->value => 'Ready',
            self::COMPLETED->value => 'Completed',
            self::INACTIVE->value => 'Inactive',
            self::CANCELLED->value => 'Cancelled',
            self::SOMEDAY->value => 'Someday',
        ];
    }
}

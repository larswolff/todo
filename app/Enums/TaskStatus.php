<?php

namespace App\Enums;

enum TaskStatus: string
{
    case READY = 'ready';
    case COMPLETED = 'completed';
    case NEXT = 'next';
    case SOMEDAY = 'someday';
    case WAITING = 'waiting';

    /**
     * Check if the task is considered active.
     *
     * @return bool
     */
    public function isActive(): bool
    {
        return in_array($this, [self::READY, self::NEXT]);
    }

    /**
     * Check if the task is completed.
     *
     * @return bool
     */
    public function isCompleted(): bool
    {
        return $this === self::COMPLETED;
    }

    /**
     * Check if the task is waiting.
     *
     * @return bool
     */
    public function isWaiting(): bool
    {
        return $this === self::WAITING;
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
            self::NEXT->value => 'Next',
            self::SOMEDAY->value => 'Someday',
            self::WAITING->value => 'Waiting',
        ];
    }
}

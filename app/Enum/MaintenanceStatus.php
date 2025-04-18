<?php

namespace App\Enums;

enum MaintenanceStatus: string
{
    case OPEN = 'open';
    case IN_PROGRESS = 'in_progress';
    case RESOLVED = 'resolved';

    public function color(): string
    {
        return match($this) {
            self::OPEN => 'bg-blue-100 text-blue-800',
            self::IN_PROGRESS => 'bg-yellow-100 text-yellow-800',
            self::RESOLVED => 'bg-green-100 text-green-800'
        };
    }
}
<?php

namespace App\Enums;

enum KnowledgeStatus: string
{
    case UNTRAINED = 'untrained';
    case TRAINING = 'training';
    case TRAINED = 'trained';
    case FAILED = 'failed';

    public function color(): string
    {
        return match ($this) {
            self::UNTRAINED => 'yellow',
            self::TRAINING => 'blue',
            self::TRAINED => 'green',
            self::FAILED => 'red',
        };
    }

    public function label(): string
    {
        return match ($this) {
            self::UNTRAINED => 'Untrained',
            self::TRAINING => 'Training',
            self::TRAINED => 'Trained',
            self::FAILED => 'Failed',
        };
    }
}

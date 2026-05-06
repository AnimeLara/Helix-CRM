<?php

namespace App\Support;

use App\Models\Activity;
use Illuminate\Database\Eloquent\Model;

class CrmActivity
{
    public static function record(string $action, string $description, ?Model $subject = null, ?int $userId = null, string $icon = 'activity'): void
    {
        Activity::log($action, $description, $subject, $userId, $icon);
    }
}

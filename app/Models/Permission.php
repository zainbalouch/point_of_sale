<?php

namespace App\Models;

use Laratrust\Models\Permission as PermissionModel;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Permission extends PermissionModel
{
    use LogsActivity;

    public $guarded = [];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*'])
            ->logOnlyDirty();
    }
}

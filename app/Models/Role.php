<?php

namespace App\Models;

use Laratrust\Models\Role as RoleModel;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Role extends RoleModel
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

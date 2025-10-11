<?php

namespace App\Models;

use App\Traits\HasUuidRamsey;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    use HasUuids;
    protected $guarded = [];
}

<?php

namespace App\Traits;

use Ramsey\Uuid\Uuid;

trait HasUuidRamsey
{
    protected static function bootHasUuidRamsey()
    {
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = Uuid::uuid7()->toString();
            }
        });
    }

    public function initializeHasUuidRamsey()
    {
        $this->keyType = 'string';
        $this->incrementing = false;
    }
}

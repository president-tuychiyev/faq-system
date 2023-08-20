<?php

namespace App\Traits;

use Carbon\Carbon;

trait CreatedUpdatedBy
{
    public static function bootCreatedUpdatedBy()
    {
        static::creating(function ($model) {
            if (!$model->isDirty('createdBy')) {
                $model->createdBy = auth()->user()->id ?? 1;
            }
            if (!$model->isDirty('updatedBy')) {
                $model->updatedBy = auth()->user()->id ?? 1;
            }
        });

        static::updating(function ($model) {
            if (!$model->isDirty('updatedBy')) {
                $model->updatedBy = auth()->user()->id;
                $model->updated_at = Carbon::now()->toDateTimeString();
            }
        });
    }
}

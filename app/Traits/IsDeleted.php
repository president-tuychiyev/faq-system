<?php

namespace App\Traits;

trait IsDeleted
{
    public static function bootIsDeleted()
    {
        static::paginate(function ($model) {
            $model->where('isDeleted', false);
        });
    }
}

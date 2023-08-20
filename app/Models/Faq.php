<?php

namespace App\Models;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Faq extends Model
{
    use HasFactory;
    use CreatedUpdatedBy;

    public function creator()
    {
        return $this->hasOne(User::class, 'id', 'createdBy');
    }

    public function scopeNotDeleted(Builder $query): void
    {
        $query->where('isDeleted', false);
    }
}

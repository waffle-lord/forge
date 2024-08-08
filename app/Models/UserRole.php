<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserRole extends Model
{
    use HasFactory;

    /**
     * The relationship between a user role and users.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}

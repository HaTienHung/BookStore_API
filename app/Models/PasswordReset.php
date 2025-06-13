<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    use HasFactory;

    protected $table = 'password_resets';

    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'code',
        'email',
        'type',
        'created_at',
        'expires_at',
    ];

    public function scopeOfEmail($query, $type)
    {
        return $query->where('email', $type);
    }

    public function scopeOfCode($query, $type)
    {
        return $query->where('code', $type);
    }
}

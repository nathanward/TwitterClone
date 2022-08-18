<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Awards\Award;
use App\Models\Award as AwardModel;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function tweets()
    {
        return $this->hasMany(Tweet::class);
    }

    public function follows()
    {
        return $this->belongsToMany(User::class, 'user_follows', 'user_id', 'followed_user_id');
    }

    public function awards()
    {
        return $this->belongsToMany(AwardModel::class, 'user_awards');
    }

    public function addAward(Award $award)
    {
        $this->awards()->attach($award->getId());
    }

    public function doesFollow(int $userId)
    {
        return $this->follows()->where('followed_user_id', $userId)->exists();
    }

    public function hasAward(Award $award)
    {
        return $this->awards()->where('award_id', $award->getId())->exists();
    }

    public function follow(int $userId)
    {
        $this->follows()->attach($userId);
    }
}

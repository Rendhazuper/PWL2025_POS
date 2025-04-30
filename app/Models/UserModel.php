<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\belongsTo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class UserModel extends Authenticable implements JWTSubject
{

    public function getJWTIdentifier()
    {
        return $this->getKey();;
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
    use HasFactory;

    protected $table = 'm_user';
    protected $primaryKey = 'user_id';
    
    protected $fillable = ['level_id', 'username', 'nama', 'password', 'image'];

    protected $hidden = ['password'];
    protected $casts = ['password' => 'hashed'];  

    
    public function level()
    {
        return $this->belongsTo(LevelModel::class, 'level_id', 'level_id');
    }

    protected function image():Attribute
    {
        return Attribute::make(
            get: fn($image) => url('storage/post/' . $image),
        );
    }

    public function getRoleName(): String
    {
        return $this->level->level_nama;
    }

    public function hasRole($role): bool
    {
        return $this->level->level_nama === $role;
    }

    public function getRole()
    {
        return $this->level->level_kode;
    }
}

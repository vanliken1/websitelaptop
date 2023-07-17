<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     * 
     */
    protected $table ='nguoidung';
    protected $primaryKey ='idnguoidung';
    protected $keyType ='string';
    // public $incrementing = false;
    public $timestamps = false;

 
    protected $fillable = [
        'idnguoidung',
        'tennguoidung',
        'email',
        'password',
        'sdt',
        'diachi',
        'token',
        'level',
        'trangthai'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function orders(){
        return $this->hasMany(Donhang::class,'idnguoidung','idnguoidung');
    }
    public function social(){
        return $this->hasMany(Social::class,'idnguoidung','idnguoidung');
    }
}

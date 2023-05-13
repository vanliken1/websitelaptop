<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dohoa extends Model
{
    use HasFactory;
    protected $table ='dohoa';
    protected $primaryKey ='iddohoa';
    protected $keyType ='string';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'iddohoa',
        'tendohoa',
        'slug_dohoa',
        'motadohoa',
        'trangthai'
    ];
    public function products(){
        return $this->hasMany(Sanpham::class,'iddohoa','iddohoa');
    }
}

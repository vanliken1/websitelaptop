<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loaisp extends Model
{
    use HasFactory;
    protected $table ='loaisanpham';
    protected $primaryKey ='idloaisanpham';
    protected $keyType ='string';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'idloaisanpham',
        'tenloai',
        'slug_loai',
        'motaloai',
        'trangthai'
    ];
    public function products(){
        return $this->hasMany(Sanpham::class,'idloaisanpham','idloaisanpham');
    }
}

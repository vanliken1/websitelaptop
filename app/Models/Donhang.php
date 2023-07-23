<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donhang extends Model
{
    use HasFactory;
    protected $table ='donhang';
    protected $primaryKey ='iddonhang';
    protected $keyType ='string';
    // public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'iddonhang',
        'tennguoinhan',
        'sdtnguoinhan',
        'diachinguoinhan',
        'note',
        'hinhthuc',
        'idnguoidung',
        'idthanhtoan',
        'trangthai',
        'ngaydat',
        'ngaytinhdoanhthu'
    ];
    public function users(){
        return $this->belongsTo(User::class,'idnguoidung','idnguoidung');
    }
    public function products(){
        return $this->belongsToMany(Sanpham::class,'chitietdonhang','iddonhang','idsanpham');
    }
    public function orderdetails(){
        return $this->hasMany(Chitietdonhang::class,'iddonhang','iddonhang');
    }
 
}

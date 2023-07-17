<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chitietdonhang extends Model
{
    use HasFactory;
    // protected $table ='chitietdonhang';
    // protected $primaryKey =['idsanpham','iddonhang'];
    // protected $keyType ='string';
    // public $incrementing = false;
    // public $timestamps = false;

    // protected $fillable = [
    //     'iddonhang',
    //     'idsanpham',
    //     'soluong',
    //     'gia',
    //     'codegiamgia',
    //     'trangthai'
        
    // ];
    // public function products(){
    //     return $this->belongsTo(Sanpham::class,'idsanpham','idsanpham');
    // }
    // public function orders(){
    //     return $this->belongsTo(Donhang::class,'iddonhang','iddonhang');
    // }
    protected $table ='chitietdonhang';
    protected $primaryKey ='idsanpham'; // Chỉ định cột 'idsanpham' là khóa chính
    protected $keyType ='string'; // Khai báo kiểu dữ liệu string cho khóa chính 'idsanpham'
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'iddonhang',
        'idsanpham',
        'soluong',
        'giagoc',
        'gia',
        'codegiamgia',
        'makhuyenmai',
    ];
       public function products(){
        return $this->belongsTo(Sanpham::class,'idsanpham','idsanpham');
    }
    public function orders(){
        return $this->belongsTo(Donhang::class,'iddonhang','iddonhang');
    }
}
class ChitietdonhangIdDonhang extends Chitietdonhang
{
    protected $primaryKey ='iddonhang'; // Chỉ định cột 'iddonhang' là khóa chính
    protected $keyType ='int'; // Khai báo kiểu dữ liệu int cho khóa chính 'iddonhang'
    public function products(){
        return $this->belongsTo(Sanpham::class,'idsanpham','idsanpham');
    }
    public function orders(){
        return $this->belongsTo(Donhang::class,'iddonhang','iddonhang');
    }
}

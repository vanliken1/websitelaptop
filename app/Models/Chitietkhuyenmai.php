<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chitietkhuyenmai extends Model
{
    use HasFactory;
    protected $table ='chitietkhuyenmai';
    protected $primaryKey ='idkhuyenmai';
    protected $keyType ='int';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'idkhuyenmai',
        'idsanpham',
        'phantramkhuyenmai',
        'trangthaictkm'
        
    ];
    public function products(){
        return $this->belongsTo(Sanpham::class,'idsanpham','idsanpham');
    }
    public function khuyenmai(){
        return $this->belongsTo(Khuyenmai::class,'idkhuyenmai','idkhuyenmai');
    }

}
class ChitietkhuyenmaiIdDonhang extends Chitietkhuyenmai
{
    protected $primaryKey ='idsanpham'; // Chỉ định cột 'iddonhang' là khóa chính
    protected $keyType ='string'; // Khai báo kiểu dữ liệu int cho khóa chính 'iddonhang'
    public function products(){
        return $this->belongsTo(Sanpham::class,'idsanpham','idsanpham');
    }
    public function khuyenmai(){
        return $this->belongsTo(Khuyenmai::class,'idkhuyenmai','idkhuyenmai');
    }
}

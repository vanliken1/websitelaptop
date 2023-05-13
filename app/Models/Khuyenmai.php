<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Khuyenmai extends Model
{
    use HasFactory;
    protected $table ='khuyenmai';
    protected $primaryKey ='idkhuyenmai';
    protected $keyType ='string';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'idkhuyenmai',
        'tenkhuyenmai',
        'ngaybatdau',
        'ngayketthuc',
        'trangthai'
    ];
    public function products(){
        return $this->belongsToMany(Sanpham::class,'chitietkhuyenmai','idkhuyenmai','idsanpham');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chitietkhuyenmai extends Model
{
    use HasFactory;
    protected $table ='chitietkhuyenmai';
    protected $primaryKey ='idkhuyenmaict';
    protected $keyType ='string';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'idkhuyenmaict',
        'idkhuyenmai',
        'idsanpham',
        'phantramkhuyenmai',
        'trangthai'
        
    ];
    public function products(){
        return $this->belongsTo(Sanpham::class,'idsanpham','idsanpham');
    }
    public function khuyenmai(){
        return $this->belongsTo(Khuyenmai::class,'idkhuyenmai','idkhuyenmai');
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chitietkhuyenmai extends Model
{
    use HasFactory;
    protected $table ='chitietkhuyenmai';
    protected $primaryKey =['idkhuyenmai','idsanpham'];
    protected $keyType ='string';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
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

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sanpham extends Model
{
    use HasFactory;
    protected $table ='sanpham';
    protected $primaryKey ='idsanpham';
    protected $keyType ='string';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'idsanpham',
        'tensanpham',
        'gia',
        'img',
        'soluong',
        'motasanpham',
        'slug_sanpham',
        'noidung',
        'idthuonghieu',
        'idram',
        'idmanhinh',
        'idluutru',
        'idloaisanpham',
        'iddohoa',
        'idCPU',
        'giakhuyenmai',
        'hot',
        'ngaytao',
        'trangthai'
    ];
    public function cpus(){
        return $this->belongsTo(CPU::class,'idCPU','idCPU');
    }
    public function dohoas(){
        return $this->belongsTo(Dohoa::class,'iddohoa','iddohoa');

    }
    public function loaisp(){
        return $this->belongsTo(Loaisp::class,'idloaisanpham','idloaisanpham');
    }
    public function luutrus(){
        return $this->belongsTo(Luutru::class,'idluutru','idluutru');
    }
    public function manhinhs(){
        return $this->belongsTo(Manhinh::class,'idmanhinh','idmanhinh');
    }
    public function rams(){
        return $this->belongsTo(Ram::class,'idram','idram');
    }
    public function thuonghieu(){
        return $this->belongsTo(Thuonghieu::class,'idthuonghieu','idthuonghieu');
    }
    public function orders(){
        return $this->belongsToMany(Donhang::class,'chitietdonhang','idsanpham','iddonhang');
    }
    public function khuyenmai(){
        return $this->belongsToMany(Khuyenmai::class,'chitietkhuyenmai','idsanpham','idkhuyenmai');
    }
    public function orderdetails(){
        return $this->hasMany(Chitietdonhang::class,'idsanpham','idsanpham');
    }
    public function chitietkm(){
        return $this->hasMany(Chitietkhuyenmai::class,'idsanpham','idsanpham');
    }
    public function scopeWhereFullText(Builder $query, $column, $keyword)
    {
        return $query->whereRaw("MATCH ($column) AGAINST (? IN BOOLEAN MODE)", [$keyword]);
    }


}

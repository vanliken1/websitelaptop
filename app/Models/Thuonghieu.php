<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Thuonghieu extends Model
{
    use HasFactory;
    protected $table ='thuonghieu';
    protected $primaryKey ='idthuonghieu';
    protected $keyType ='string';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'idthuonghieu',
        'tenthuonghieu',
        'slug_thuonghieu',
        'motathuonghieu',
        'trangthai'
    ];
    public function products(){
        return $this->hasMany(Sanpham::class,'idthuonghieu','idthuonghieu');
    }
}

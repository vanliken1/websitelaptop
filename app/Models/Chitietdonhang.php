<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chitietdonhang extends Model
{
    use HasFactory;
    protected $table ='chitietdonhang';
    protected $primaryKey =['idsanpham','iddonhang'];
    protected $keyType ='string';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'iddonhang',
        'idsanpham',
        'soluong',
        'gia',
        'trangthai'
        
    ];

}

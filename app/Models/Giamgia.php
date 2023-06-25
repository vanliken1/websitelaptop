<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Giamgia extends Model
{
    use HasFactory;
    protected $table ='giamgia';
    protected $primaryKey ='idgiamgia';
    protected $keyType ='string';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'idgiamgia',
        'tengiamgia',
        'ngayketthuc',
        'codegiamgia',
        'soluong',
        'tinhnangma',
        'sotiengiam',
        'dasudung',
        'trangthai'
    ];

}

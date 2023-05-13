<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chitietkhuyenmai extends Model
{
    use HasFactory;
    protected $table ='chitietkhuyenmai';
    protected $primaryKey =['idsanpham','idkhuyenmai'];
    protected $keyType ='string';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'idkhuyenmai',
        'idsanpham',
        'phantramkhuyenmai',
        'trangthai'
        
    ];

}

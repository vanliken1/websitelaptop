<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Thongke extends Model
{
    use HasFactory;
    protected $table ='thongke';
    protected $primaryKey ='idthongke';
    protected $keyType ='string';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'idthongke',
        'ngaydat',
        'doanhthu',
        'soluongdaban',
        'tongdonhang'
    ];
}

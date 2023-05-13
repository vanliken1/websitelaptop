<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CPU extends Model
{
    use HasFactory;
    protected $table ='cpu';
    protected $primaryKey ='idCPU';
    protected $keyType ='string';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'idCPU',
        'tenCPU',
        'slug_CPU',
        'mota_CPU',
        'trangthai'
    ];
    public function products(){
        return $this->hasMany(Sanpham::class,'idCPU','idCPU');
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Luutru extends Model
{
    use HasFactory;
    protected $table ='luutru';
    protected $primaryKey ='idluutru';
    protected $keyType ='string';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'idluutru',
        'tenluutru',
        'slug_luutru',
        'motaluutru',
        'trangthai'
    ];
    public function products(){
        return $this->hasMany(Sanpham::class,'idluutru','idluutru');
    }
}

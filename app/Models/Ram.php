<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ram extends Model
{
    use HasFactory;
    protected $table ='ram';
    protected $primaryKey ='idram';
    protected $keyType ='string';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'idram',
        'tenram',
        'slug_ram',
        'motaram',
        'trangthai'
    ];
    public function products(){
        return $this->hasMany(Sanpham::class,'idram','idram');
    }
}

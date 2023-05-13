<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manhinh extends Model
{
    use HasFactory;
    protected $table ='manhinh';
    protected $primaryKey ='idmanhinh';
    protected $keyType ='string';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'idmanhinh',
        'tenmanhinh',
        'slug_manhinh',
        'motamanhinh',
        'trangthai'
    ];
    public function products(){
        return $this->hasMany(Product::class,'idmanhinh','idmanhinh');
    }
}

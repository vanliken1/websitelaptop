<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;
    protected $table ='banner';
    protected $primaryKey ='idbanner';
    protected $keyType ='string';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'idbanner',
        'tenbanner',
        'img',
        'motabanner',
        'trangthai'
    ];

}

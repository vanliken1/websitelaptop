<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;
    protected $table ='admin';
    protected $primaryKey ='idadmin';
    //protected $keyType ='int';
    //public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'idadmin',
        'tenadmin',
        'passadmin',
        'trangthai'
    ];
}

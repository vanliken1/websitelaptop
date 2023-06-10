<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Social extends Model
{
    use HasFactory;
    protected $table ='mangxahoi';
    protected $primaryKey ='idxahoi';
    protected $keyType ='string';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'idxahoi',
        'idnguoidungxahoi',
        'emailnguoidungxahoi',
        'kieumangxahoi',
        'idnguoidung'
    ];
    public function user(){
        return $this->belongsTo(User::class,'idnguoidung','idnguoidung');
    }
}

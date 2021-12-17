<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Unit extends Model
{
    //
    use SoftDeletes;

    protected $table = "unit";
    protected $dates = ['deleted_at'];

    public function user() { 
        return $this->hasMany('App\User'); 
    }

    protected $fillable = [
        'nama_unit', 'keterangan', 
    ];
}

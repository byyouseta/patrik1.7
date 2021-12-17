<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'username', 'password', 'level', 'unit_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function pegawai()
    {
        return $this->hasOne('App\Pegawai');
    }

    public function unit()
    {
        return $this->belongsTo('App\Unit');
    }

    public function agenda()
    {
        return $this->belongsToMany('App\Agenda')->withPivot('presensi', 'presensi_at')->withTimestamps();
    }

    public function picagenda()
    {
        return $this->hasMany('App\Agenda', 'id', 'pic');
    }
}

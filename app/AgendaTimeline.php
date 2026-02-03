<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class AgendaTimeline extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User', 'pic', 'id');
    }

    public function unit()
    {
        return $this->belongsTo('App\Unit');
    }

    public function bukti()
    {
        return $this->hasMany('App\BuktiTimeline');
    }
    public function catatan()
    {
        return $this->hasMany('App\CatatanSpi');
    }

    public static function getUnitTime($id)
    {
        $unit_wewenang = [4, 29, 31, 45];

        if (in_array($id, $unit_wewenang)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}

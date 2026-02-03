<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BuktiTimeline extends Model
{
    public function timeline()
    {
        return $this->belongsTo('App\AgendaTimeline');
    }
}

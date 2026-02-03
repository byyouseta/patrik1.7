<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class catatanSpi extends Model
{
    protected $fillable = [
        'catatan',
        'valid'
    ];

    public function timeline()
    {
        return $this->belongsTo('App\AgendaTimeline');
    }
}

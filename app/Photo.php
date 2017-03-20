<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{

    protected $table    = 'photo';
    protected $fillable = [
        'album_id',
        'filename',
        'original_name',
        'title',
        'description',
    ];

    public function album()
    {
        return $this->belongsTo('App\Album');
    }

}

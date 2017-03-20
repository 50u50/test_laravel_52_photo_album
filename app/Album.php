<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Album extends Model
{

    protected $table    = 'album';
    protected $fillable = [
        'title',
        'description',
        'is_active',
    ];
    protected $rules    = [
        'title'       => 'required|max:128',
        'description' => 'required|max:255',
    ];

    public function photos()
    {
        return $this->hasMany('App\Photo');
    }

    public function getValidationRules()
    {
        return $this->rules;
    }

}

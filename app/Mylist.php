<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mylist extends Model
{
    //
    protected $fillable = ['name','board_id'];

    public function cards()
    {
    	return $this->hasMany('App\Card');
    }
}

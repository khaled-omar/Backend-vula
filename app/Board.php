<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Board extends Model
{
    //
    protected $fillable = ['name','user_id'];
   
    public function Cards()
    {
		return $this->hasMany('App\Card');
    }
}

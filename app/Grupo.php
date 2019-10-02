<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    protected $table = 'grupos';

    protected $fillable = ['nombre'];

    public function producto()
    {
    	return $this->hasMany('App\Producto');
    }

    public function getDateFormat()
    {
        return 'Y-d-m H:i:s.v';
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unidad extends Model
{
    protected $table = 'grupos';

    protected $fillable = ['nombre'];

    public function pivotPedidoProducto()
    {
    	return $this->hasMany('App\PivotPedidoProducto');
    }

    public function getDateFormat()
    {
        return 'Y-d-m H:i:s.v';
    }
}

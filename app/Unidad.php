<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unidad extends Model
{
    protected $table = 'unidades';

    protected $fillable = ['nombre'];

    public function pivotPedidoProducto()
    {
    	return $this->hasMany('App\PivotPedidoProducto');
    }

}

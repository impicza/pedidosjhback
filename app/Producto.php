<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'productos';

    protected $fillable = ['nombre','grupo_id'];

    public function Grupo()
    {
        return $this->belongsTo('App\Grupo', 'grupo_id');
    }

    public function pivotPedidoProducto()
    {
    	return $this->hasMany('App\PivotPedidoProducto');
    }

    public function getDateFormat()
    {
        return 'Y-d-m H:i:s.v';
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PivotPedidoProducto extends Model
{
    protected $table = 'pivot_pedido_productos';

    protected $fillable = ['producto_id','pedido_id','unidad_id'];

    public function Producto()
    {
        return $this->belongsTo('App\Producto', 'producto_id');
    }

    public function Pedido()
    {
        return $this->belongsTo('App\Pedido', 'pedido_id');
    }

    public function Unidad()
    {
        return $this->belongsTo('App\Unidad', 'unidad_id');
    }

    public function getDateFormat()
    {
        return 'Y-d-m H:i:s.v';
    }
}

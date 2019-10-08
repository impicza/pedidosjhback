<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PivotPedidoProducto extends Model
{
    protected $table = 'pivot_pedido_productos';

    protected $fillable = ['producto_id','pedido_id','unidad_id', 'cantidad'];

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

    public static function todosPorGrupo($idpedido, $idgrupo){
    return DB::table('pivot_pedido_productos')
            ->select('pivot_pedido_productos.id as id','unidades.id As unidad_id','unidades.nombre As unidad_nombre','pivot_pedido_productos.cantidad as cantidad','productos.id As producto_id','productos.nombre As producto_nombre')
            ->join('productos', 'productos.id', '=', 'pivot_pedido_productos.producto_id')
            ->join('unidades', 'unidades.id', '=', 'pivot_pedido_productos.unidad_id')
            ->join('grupos', 'grupos.id', '=', 'productos.grupo_id')
            ->join('pedidos', 'pedidos.id', '=', 'pivot_pedido_productos.pedido_id')
            ->where('pedidos.id', $idpedido)
            ->where('grupos.id', $idgrupo)
            ->get();
    }

    public static function todosPorPedidoConUnidades($idpedido){
    return DB::table('pivot_pedido_productos')
            ->select('pivot_pedido_productos.id as id','unidades.id As unidad_id','unidades.nombre As unidad_nombre','pivot_pedido_productos.cantidad as cantidad','productos.id As producto_id','productos.nombre As producto_nombre')
            ->join('productos', 'productos.id', '=', 'pivot_pedido_productos.producto_id')
            ->join('unidades', 'unidades.id', '=', 'pivot_pedido_productos.unidad_id')
            ->join('grupos', 'grupos.id', '=', 'productos.grupo_id')
            ->join('pedidos', 'pedidos.id', '=', 'pivot_pedido_productos.pedido_id')
            ->get();
    }

}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Producto extends Model
{
    protected $table = 'productos';

    protected $fillable = ['nombre','grupo_id','activo'];

    public function Grupo()
    {
        return $this->belongsTo('App\Grupo', 'grupo_id');
    }

    public function pivotPedidoProducto()
    {
    	return $this->hasMany('App\PivotPedidoProducto');
    }

    public static function todosConGrupos($activo){
    return DB::table('productos')
            ->select('productos.id As id','productos.nombre As nombre','grupos.nombre as grupo', 'productos.activo as activo')
            ->join('grupos', 'grupos.id', '=', 'productos.grupo_id')
            ->when($activo, function ($query, $activo) {
                return $query->where('productos.activo', $activo);
            })
            ->get();
    }

}

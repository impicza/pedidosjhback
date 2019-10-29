<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Pedido extends Model
{
    protected $table = 'pedidos';

    protected $fillable = ['user_id','estado','observaciones'];

    public function User()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function getDateFormat()
    {
        return 'Y-d-m H:i:s.v';
    }

    public function getDates()
    {
        return [];
    }

    public static function todosConCliente(){
    return DB::table('pedidos')
            ->select('pedidos.id as id', 'pedidos.created_at as fecha_creacion','pedidos.estado as estado', 'users.name as cliente')
            ->join('users', 'users.id', '=', 'pedidos.user_id')
            ->orderBy('id','desc')
            ->get();
    }
}

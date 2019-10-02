<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $table = 'pedidos';

    protected $fillable = ['user_id'];

    public function User()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function getDateFormat()
    {
        return 'Y-d-m H:i:s.v';
    }
}

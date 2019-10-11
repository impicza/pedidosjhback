<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pedido;
use App\PivotPedidoProducto;
use App\User;
use PDF;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class PedidosController extends Controller
{
    public function index()
    {
        //
    }

    public function listadoPorCliente($id)
    {
        $list = Pedido::where('user_id', $id)->orderby('created_at', 'desc')->get();
        return $list;
    }

    public function listadoCompleto()
    {
        $list = Pedido::todosConCliente();
        return $list;
    }

    public function reactivar($id)
    {
        $pedido = Pedido::find($id);
        $pedido->estado = 1;
        $pedido->save();

        return 'done';
    }

    public function store(Request $request)
    {

        $user = User::find($request->user_id);
        $dias_despacho = explode(',', $user->dias_despacho);

        $dayOfTheWeek = Carbon::now()->dayOfWeek;

        $validate = array_search($dayOfTheWeek, $dias_despacho);

        $pedidosAbiertos = Pedido::where('estado', 1)->get();

        if (count($pedidosAbiertos) < 1) {
            if ($validate == false) {
                if ( count($request->productos) > 0){
                    $nuevoItem = new Pedido($request->all());
                    $nuevoItem->estado = 1;
                    $nuevoItem->save();

                    foreach ($request->productos as $producto) {
                        $prod = new PivotPedidoProducto($producto);
                        $prod->pedido_id = $nuevoItem->id;
                        $prod->save();
                    }

                    return 'done';
                } else {
                    return 'Error: Agregue al menos un producto';
                }
            } else {
                return 'Error: No esta autorizado para generar un pedido el dia de hoy.';
            }
        } else {
           return 'Error: Ya tiene un pedido activo.'; 
        }
    }

    public function show($id)
    {
        $model = Pedido::find($id);
        
        $model->productosRes = PivotPedidoProducto::todosPorGrupo($id,2);
        $model->productosCerdo = PivotPedidoProducto::todosPorGrupo($id,1);

        return $model;
    }

    public function update(Request $request, $id)
    {
        $toDestroy = PivotPedidoProducto::where('pedido_id', $request->id)->get();
        foreach ($toDestroy as $itemToDestroy) {
            $itemToDestroy->delete();
        }

        foreach ($request->productos as $producto) {
            $prod = new PivotPedidoProducto($producto);
            $prod->pedido_id = $request->id;
            $prod->save();
        }

        return 'done';
    }

    public function destroy($id)
    {
        //
    }

    public function imprimirPedido($id){

        $productosRes = PivotPedidoProducto::todosPorGrupo($id,2);
        $productosCerdo = PivotPedidoProducto::todosPorGrupo($id,1);

        $pedido = Pedido::find($id);
        $pedido->estado = 0;
        $pedido->save();

        $usuario = $pedido->User;

        $data = ['productosRes' => $productosRes,'productosCerdo' => $productosCerdo, 'pedido' => $pedido, 'usuario' => $usuario];
        $pdf = PDF::loadView('pdf.pedido', $data);
  
        // return view('certificados.pdf');

        return $pdf->stream();
    }

    public function imprimirPedidoCliente($id){

        $user = Auth::user();
        $pedido = Pedido::find($id);
        if ($user->id == $pedido->user_id ){
            $productosRes = PivotPedidoProducto::todosPorGrupo($id,2);
            $productosCerdo = PivotPedidoProducto::todosPorGrupo($id,1);
            $usuario = $pedido->User;
            $data = ['productosRes' => $productosRes,'productosCerdo' => $productosCerdo, 'pedido' => $pedido, 'usuario' => $usuario];
            $pdf = PDF::loadView('pdf.pedido', $data);
            return $pdf->stream();
        } else {
            return 'Error: no autorizado';
        }
    }

}

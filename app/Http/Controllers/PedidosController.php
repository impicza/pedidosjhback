<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pedido;
use App\PivotPedidoProducto;
use PDF;

class PedidosController extends Controller
{
    public function index()
    {
        //
    }

    public function listadoPorCliente($id)
    {
        $list = Pedido::where('user_id', $id)->get();
        return $list;
    }

    public function listadoCompleto()
    {
        $list = Pedido::todosConCliente();
        return $list;
    }


    public function store(Request $request)
    {
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

        $usuario = $pedido->User;

        $data = ['productosRes' => $productosRes,'productosCerdo' => $productosCerdo, 'pedido' => $pedido, 'usuario' => $usuario];
        $pdf = PDF::loadView('pdf.pedido', $data);
  
        // return view('certificados.pdf');

        return $pdf->stream();
    }

}

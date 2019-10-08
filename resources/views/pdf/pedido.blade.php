<!DOCTYPE html>
<html>
<head>
{{-- 	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"> --}}
	<title>Pedidos JH</title>
<style>
	.table {
	  font-family: arial, sans-serif;
	  border-collapse: collapse;
	  
	}

	.table-info {
	  font-family: arial, sans-serif;
	}

	p,h3,h1,h4{
		font-family: arial, sans-serif;
	}

	table{
		width: 100%;
		margin-top: 10px 0px;
	}

	table p{
		margin: 0px;
	}

	table h3{
		margin: 0px;
	}

	.table td, .table th {
	  border: 1px solid #dddddd;
	  text-align: left;
	  padding: 8px;
	}

	.title-table{
		font-size: 14px;
	}

	.table-even tr:nth-child(even) {
	  background-color: #dddddd;
	}

	.w100{
		width: 100%;
		display: table;
	}

	.w50{
		width: 48%;
	}

	.text-center{
		text-align: center;
	}

	.table-font td,.table-font th{
		font-size: 10px;
		margin: 3px 0px;
		padding: 3px;
	}

	.text-footer{
		font-size: 12px;
	}

	.table-info p{
		font-size: 14px;
	}
</style>
</head>
<body>
	<h3 style="text-align:center;">Pedido de : {{ $usuario->name }}</h3> 
	<h4 style="text-align:center;">Fecha : {{ $pedido->created_at }}</h3> 

	</br>

	<div>
		<h4>Cerdo</h4>
		<table class="table table-even table-font">
			<thead>
				<tr>
					<th style="width:50%;"><span class="title-table">Producto</span></th>
					<th style="width:25%;"><span class="title-table">Unidad</span></th>
					<th style="width:25%;"><span class="title-table">Cantidad</span></th>
				</tr>
			</thead>
			<tbody>
				@foreach ($productosCerdo as $element)
					<tr>
						<td>{{ $element->producto_nombre }}</td>
						<td>{{ $element->unidad_nombre	}}</td>
						<td>{{ $element->cantidad	}}</td>
					</tr>
				@endforeach

			</tbody>
		</table>
	</div>

	<div>
		<h4>Res</h4>
		<table class="table table-even table-font">
			<thead>
				<tr>
					<th style="width:50%;"><span class="title-table">Producto</span></th>
					<th style="width:25%;"><span class="title-table">Unidad</span></th>
					<th style="width:25%;"><span class="title-table">Cantidad</span></th>
				</tr>
			</thead>
			<tbody>
				@foreach ($productosRes as $producto)
					<tr>
						<td>{{ $producto->producto_nombre }}</td>
						<td>{{ $producto->unidad_nombre	}}</td>
						<td>{{ $producto->cantidad	}}</td>
					</tr>
				@endforeach

			</tbody>
		</table>
	</div>

	<br>
	<br>
	
</body>
</html>
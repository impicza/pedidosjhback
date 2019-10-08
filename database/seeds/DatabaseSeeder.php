<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
    	User::create([
            'name' => 'Admin',
            'email' => 'admin@pedidosjh.com',
            'password' => Hash::make('admin'),
            'dias_despacho' => '',
            'role' => 2
        ]);

        User::create([
            'name' => 'user',
            'email' => 'user@pedidosjh.com',
            'password' => Hash::make('user'),
            'dias_despacho' => '1,3,5',
            'role' => 1
        ]);

        $grupos = ['Cerdo','Res'];
        foreach ($grupos as $item) {
            App\Grupo::create([
                'nombre' => $item
            ]);
        }

        $unidades = ['Unidades','Kilos'];
        foreach ($unidades as $item) {
            App\Unidad::create([
                'nombre' => $item
            ]);
        }

        $productos = [
         	['Cerdo en pie','1'],
			['Cerdo en canal','1'],
			['Cañon','1'],
			['Pierna','1'],
			['Manero','1'],
			['Cabeza de cañon','1'],
			['Barriguero','1'],
			['Papada','1'],
			['Tocino grasa','1'],
			['Costilla','1'],
			['Espinazo','1'],
			['Osobuco','1'],
			['Pezuña','1'],
			['Garra','1'],
			['Cadero','1'],
			['Empella','1'],
			['Cabeza de cerdo','1'],
			['Hueso blanco de cerdo','1'],
			['Asadura de cerdo','1'],
			['Desgorde cerdo','1'],
			['Pedacitos de cerdo','1'],
			['Cuarto delantero','2'],
			['Cuarto trasero','2'],
			['Solomito','2'],
			['Solomo redondo','2'],
			['Chata','2'],
			['Punta de anca','2'],
			['Muchacho','2'],
			['Posta','2'],
			['Cabeza de res','2'],
			['Tabla','2'],
			['Solomo extranjero','2'],
			['Huevo de aldana','2'],
			['Tablon','2'],
			['Punta de espaldilla','2'],
			['Punta de falda','2'],
			['Paletero','2'],
			['Huevo de solomo','2'],
			['Cascara','2'],
			['Cascara de moler','2'],
			['Tableado','2'],
			['Copete','2'],
			['Sobrebarriga','2'],
			['Pecho','2'],
			['Lagarto','2'],
			['Trestela','2'],
			['Mondongo','2'],
			['Asadura de res','2'],
			['Lengua','2'],
			['Cola','2'],
			['Res en pie','2'],
			['Solomito de cerdo','1'],
			['Producto de prueba','2'],
			['Entrañitas','2'],
			['Nucas','2'],
			['Tapas de cadero','2'],
			['Cerdo industrial','1'],
			['Manero sexteado','1'],
			['Pierna sexteado','1'],
			['Barriguero sexteado','1'],
			['Tapa de costilla','2'],
			['Anca de cerdo','1']
		];

        foreach ($productos as $item) {
            App\Producto::create([
                'nombre' => $item[0],
                'grupo_id' => $item[1]
            ]);
        }

    }
}

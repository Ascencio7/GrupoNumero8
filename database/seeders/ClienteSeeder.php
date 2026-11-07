<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
     public function run(): void
    {
        $clientes = [
            ['Nombre' => 'Juan', 'Apellido' => 'Perez', 'Fecha_Nac' => '1990-05-15 00:00:00'],
            ['Nombre' => 'Maria', 'Apellido' => 'Gomez', 'Fecha_Nac' => '1985-08-22 00:00:00'],
            ['Nombre' => 'Carlos', 'Apellido' => 'Lopez', 'Fecha_Nac' => '1992-11-10 00:00:00'],
            ['Nombre' => 'Ana', 'Apellido' => 'Martinez', 'Fecha_Nac' => '1998-02-28 00:00:00'],
            ['Nombre' => 'Luis', 'Apellido' => 'Rodriguez', 'Fecha_Nac' => '1980-07-04 00:00:00'],
            ['Nombre' => 'Elena', 'Apellido' => 'Fernandez', 'Fecha_Nac' => '1995-12-01 00:00:00'],
            ['Nombre' => 'Jorge', 'Apellido' => 'Sanchez', 'Fecha_Nac' => '2000-03-18 00:00:00'],
            ['Nombre' => 'Lucia', 'Apellido' => 'Ramirez', 'Fecha_Nac' => '1993-09-09 00:00:00'],
            ['Nombre' => 'Pedro', 'Apellido' => 'Torres', 'Fecha_Nac' => '1988-01-30 00:00:00'],
            ['Nombre' => 'Sofia', 'Apellido' => 'Flores', 'Fecha_Nac' => '1997-06-12 00:00:00'],
            ['Nombre' => 'Diego', 'Apellido' => 'Rivera', 'Fecha_Nac' => '1991-10-25 00:00:00'],
            ['Nombre' => 'Carmen', 'Apellido' => 'Gutierrez', 'Fecha_Nac' => '1983-04-14 00:00:00'],
        ];

        foreach ($clientes as &$cliente) {
            $cliente['created_at'] = now();
            $cliente['updated_at'] = now();
        }

        DB::table('clientes')->insert($clientes);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('productos')->insert([
            [
                'sku' => 'PROD001',
                'nombre' => 'Producto A',
                'tipo' => 'Electrónica',
                'etiqueta' => 'gadget,tecnología',
                'precio' => 99.99,
                'unidad_de_medida' => 'unidad',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'sku' => 'PROD002',
                'nombre' => 'Producto B',
                'tipo' => 'Hogar',
                'etiqueta' => 'decoración,muebles',
                'precio' => 49.50,
                'unidad_de_medida' => 'unidad',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'sku' => 'PROD003',
                'nombre' => 'Producto C',
                'tipo' => 'Jardinería',
                'etiqueta' => 'plantas,herramientas',
                'precio' => 75.00,
                'unidad_de_medida' => 'unidad',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'sku' => 'PROD004',
                'nombre' => 'Producto D',
                'tipo' => 'Alimentos',
                'etiqueta' => 'orgánico,frutas',
                'precio' => 20.75,
                'unidad_de_medida' => 'kilogramo',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'sku' => 'PROD005',
                'nombre' => 'Producto E',
                'tipo' => 'Ropa',
                'etiqueta' => 'moda,verano',
                'precio' => 35.99,
                'unidad_de_medida' => 'pieza',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}

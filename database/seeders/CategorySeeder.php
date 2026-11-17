<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $data = [
            [
                'name' => 'Electrónicos',
                'slug' => 'electronicos',
                'description' => 'Teléfonos, computadoras, accesorios y gadgets tecnológicos.',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Ropa y Moda',
                'slug' => 'ropa-y-moda',
                'description' => 'Prendas de vestir, calzado y accesorios para damas, caballeros y niños.',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Hogar y Cocina',
                'slug' => 'hogar-y-cocina',
                'description' => 'Muebles, decoración, electrodomésticos y utensilios para el hogar.',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Deportes y Fitness',
                'slug' => 'deportes-y-fitness',
                'description' => 'Artículos deportivos, ropa de entrenamiento y accesorios para fitness.',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Salud y Belleza',
                'slug' => 'salud-y-belleza',
                'description' => 'Productos para el cuidado personal, cosméticos, cuidado de la piel y bienestar.',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Juguetes y Juegos',
                'slug' => 'juguetes-y-juegos',
                'description' => 'Juguetes didácticos, figuras de acción, juegos de mesa y entretenimiento infantil.',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Libros y Papelería',
                'slug' => 'libros-y-papeleria',
                'description' => 'Libros, agendas, útiles escolares y material de oficina.',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Automotriz',
                'slug' => 'automotriz',
                'description' => 'Accesorios, herramientas, repuestos y cuidado de vehículos.',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        Category::insert($data);
    }
}

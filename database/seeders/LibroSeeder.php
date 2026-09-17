<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Libro;

class LibroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
    
        Libro::create([
            'titulo' => 'Mangoré: Genio de la Guitarr',
            'autor' => 'José Candido Morales',
            'genero' => 'Biografía',
            'anio' => 1994,
            'estado' => 'disponible',
        ]);

        Libro::create([
            'titulo' => 'Jicaras Tristes',
            'autor' => 'Alfredo Espino',
            'genero' => 'Antología poética',
            'anio' => 1977,
            'estado' => 'prestado',
        ]);

        Libro::create([
            'titulo' => 'Tierra de Infancia',
            'autor' => 'Claudia Lars',
            'genero' => 'Autobiografía',
            'anio' => 1958,
            'estado' => 'disponible',
        ]);
    }
}

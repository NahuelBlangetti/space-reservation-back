<?php

namespace Database\Seeders;

use App\Models\Space;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SpaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $spaces = [
            [
                'name' => 'Sala de Reuniones A',
                'capacity' => 10,
            ],
            [
                'name' => 'Sala de Reuniones B',
                'capacity' => 12,
            ],
            [
                'name' => 'Auditorio',
                'capacity' => 50,
            ],
            [
                'name' => 'Oficina Privada',
                'capacity' => 4,
            ],
            [
                'name' => 'Sala de Capacitación',
                'capacity' => 20,
            ],
            [
                'name' => 'Sala de Conferencias A',
                'capacity' => 30,
            ],
            [
                'name' => 'Sala de Conferencias B',
                'capacity' => 25,
            ],
            [
                'name' => 'Sala de Estrategia',
                'capacity' => 15,
            ],
            [
                'name' => 'Espacio Colaborativo',
                'capacity' => 40,
            ],
            [
                'name' => 'Sala de Proyectos',
                'capacity' => 8,
            ],
            [
                'name' => 'Sala de Descanso',
                'capacity' => 5,
            ],
            [
                'name' => 'Oficina Compartida',
                'capacity' => 6,
            ],
            [
                'name' => 'Sala de Innovación',
                'capacity' => 18,
            ],
            [
                'name' => 'Espacio para Talleres',
                'capacity' => 22,
            ],
            [
                'name' => 'Sala de Creatividad',
                'capacity' => 12,
            ],
            [
                'name' => 'Sala de Prototipado',
                'capacity' => 10,
            ],
        ];
        

        // Insertar los espacios en la base de datos
        foreach ($spaces as $space) {
            Space::create($space);
        }
    }
}

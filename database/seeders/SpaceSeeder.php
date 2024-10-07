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
                'name' => 'Sala de Reuniones Ejecutiva',
                'description' => 'Una sala de reuniones de alta gama equipada con proyector, sistema de videoconferencia y cómodos asientos para hasta 10 personas.',
                'capacity' => 10,
                'type' => 'meeting_room',
                'is_available' => true,
                'photo' => 'https://via.placeholder.com/150?text=Sala+Ejecutiva',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Espacio de Coworking Moderno',
                'description' => 'Un amplio espacio de coworking con luz natural, acceso a internet de alta velocidad, y cafetería disponible todo el día.',
                'capacity' => 20,
                'type' => 'coworking',
                'is_available' => true,
                'photo' => 'https://via.placeholder.com/150?text=Coworking+Moderno',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Oficina Privada de Lujo',
                'description' => 'Oficina privada con muebles de lujo, ideal para ejecutivos. Tiene capacidad para 5 personas y viene equipada con todas las comodidades necesarias.',
                'capacity' => 5,
                'type' => 'office',
                'is_available' => false,
                'photo' => 'https://via.placeholder.com/150?text=Oficina+Privada',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Auditorio Corporativo',
                'description' => 'Auditorio con capacidad para 100 personas, perfecto para eventos corporativos y presentaciones. Equipado con sistemas de sonido e iluminación de última generación.',
                'capacity' => 10,
                'type' => 'office',
                'is_available' => true,
                'photo' => 'https://via.placeholder.com/150?text=Auditorio',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Sala de Reuniones Pequeña',
                'description' => 'Sala ideal para pequeñas reuniones, con capacidad para 4 personas. Incluye pizarra y acceso a internet de alta velocidad.',
                'capacity' => 20,
                'type' => 'meeting_room',
                'is_available' => true,
                'photo' => 'https://via.placeholder.com/150?text=Sala+Pequena',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Sala de Conferencias',
                'description' => 'Sala de conferencias con capacidad para 50 personas. Equipada con proyector, sistema de sonido y acceso a internet de alta velocidad.',
                'capacity' => 10,
                'type' => 'meeting_room',
                'is_available' => true,
                'photo' => 'https://via.placeholder.com/150?text=Sala+Conferencias',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Sala de Juntas',
                'description' => 'Sala de juntas con capacidad para 8 personas. Equipada con pizarra, proyector y acceso a internet de alta velocidad.',
                'capacity' => 5,
                'type' => 'meeting_room',
                'is_available' => true,
                'photo' => 'https://via.placeholder.com/150?text=Sala+Juntas',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Sala de Entrevistas',
                'description' => 'Sala de entrevistas con capacidad para 2 personas. Equipada con sillas cómodas y acceso a internet de alta velocidad.',
                'capacity' => 20,
                'type' => 'meeting_room',
                'is_available' => true,
                'photo' => 'https://via.placeholder.com/150?text=Sala+Entrevistas',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Sala de Capacitación',
                'description' => 'Sala de capacitación con capacidad para 30 personas. Equipada con proyector, pizarra y acceso a internet de alta velocidad.',
                'capacity' => 5,
                'type' => 'meeting_room',
                'is_available' => true,
                'photo' => 'https://via.placeholder.com/150?text=Sala+Capacitacion',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Sala de Reuniones Pequeña',
                'description' => 'Sala de reuniones con capacidad para 6 personas. Equipada con proyector, pizarra y acceso a internet de alta velocidad.',
                'capacity' => 10,
                'type' => 'meeting_room',
                'is_available' => true,
                'photo' => 'https://via.placeholder.com/150?text=Sala+Pequena',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];
        

        // Insertar los espacios en la base de datos
        foreach ($spaces as $space) {
            Space::create($space);
        }
    }
}

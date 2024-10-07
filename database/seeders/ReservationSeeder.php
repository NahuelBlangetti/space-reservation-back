<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReservationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $reservations = [
            [
                'user_id' => 1,
                'space_id' => 1,
                'start_time' => Carbon::now()->addDays(1)->toDateTimeString(),
                'end_time' => Carbon::now()->addDays(1)->addHours(2)->toDateTimeString(),
            ],
            [
                'user_id' => 1,
                'space_id' => 2,
                'start_time' => Carbon::now()->addDays(2)->toDateTimeString(),
                'end_time' => Carbon::now()->addDays(2)->addHours(3)->toDateTimeString(),
            ],
            [
                'user_id' => 1,
                'space_id' => 3, 
                'start_time' => Carbon::now()->addDays(3)->toDateTimeString(),
                'end_time' => Carbon::now()->addDays(3)->addHours(4)->toDateTimeString(),
            ]
        ];

        // Inserta las reservaciones en la tabla
        DB::table('reservations')->insert($reservations);
    }
}

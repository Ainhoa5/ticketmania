<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Event::factory(10)->create()->each(function ($event) {
            $event->concerts()->saveMany(\App\Models\Concert::factory(3)->make());
        });
    }
}

<?php

use App\Profession;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProfessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

      factory(Profession::class)->create([
        'title' => 'Ingeniería Informática',
      ]);

      factory(Profession::class)->create([
        'title' => 'Ingeniería Industrial',
      ]);

      factory(Profession::class)->create([
        'title' => 'Ingeniería Quimica',
      ]);

      factory(Profession::class)->create([
        'title' => 'Ingeniería Civil',
      ]);

      factory(Profession::class, 11)->create();
    }
}

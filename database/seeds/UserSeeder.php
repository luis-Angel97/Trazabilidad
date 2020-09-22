<?php

use App\User;
use App\Profession;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $professionId = Profession::whereTitle('Ingeniería Informática')->value('id');       // traer el usuario que esta relacionado con una profesion id

      factory(User::class)->create([
        'name' => 'Luis Angel',
        'email' => 'luis_cardenas_5@hotmail.com',
        'password' => bcrypt('2015330059'),
        'profession_id' => $professionId,                                     // se obtiene la profession relacionada con el usuario en la llave foranea
        'is_admin' => true,
      ]);

      factory(User::class)->create([
        'profession_id' => $professionId,                                     // se obtiene la profession relacionada con el usuario en la llave foranea
      ]);

      factory(User::class, 8)->create();
    }
}

<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UsersModuleTests extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function muestra_la_lista_de_usuarios()
    {

        factory(User::class)->create([
          'name' => 'Joel',
        ]);

        factory(User::class)->create([
          'name' => 'Ellie',
        ]);

        $this->get('/usuarios');
             ->assertStatus(200)
             ->assertSee('Listado de suarios')
             ->assertSee('Joel')
             ->assertSee('Ellie');
    }

    /** @test */
    function muestra_un_mensaje_predeterminado_si_la_lista_de_usuarios_está_vacía()
    {
      //DB::table('users')->truncate();

        $this->get('/usuarios');
             ->assertStatus(200)
             ->assertSee('No hay usuarios registrados.')
    }

    /** @test */
    function muestra_los_detalles_del_usuarios()
    {
      $user = factory(User::class)->create([
        'name' => 'Luis'
      ]);

      $this->get("/usuarios/{$user->id}");   // usuarios/5
           ->assertStatus(200)
           ->assertSee('Luis');
    }

    /** @test */
    function muestra_un_error_404_si_no_se_encuentra_al_usuario()
    {
      $this->get('/usuarios/999');
           ->assertStatus(400)
           ->assertSee('Página no encontrada');
    }

    /** @test */
    function carga_la_página_nuevo_usuario()
    {
      $this->get('/usuarios/nuevo');
           ->assertStatus(200)
           ->assertSee('Crear usuario');
    }

    /** @test */
    function crear_un_nuevo_usuario()
    {
      $this->post('/usuarios/crear', [
        'name' => 'Luis Angel',
        'email' => 'luis_cardenas_5@hotmail.com',
        'password' => '2015330059'
      ])->assertRedirect(route('users.index'));

      $this->assertCredentials([                                                // assertCredentials: este metodo nos permite
        'name' => 'Luis Angel',                                                 // comprobar que tenemos un usuario en la BD
        'email' => 'luis_cardenas_5@hotmail.com',                               // que tenga las siguientes credenciales
        'password' => '2015330059',
      ]);
    }

    /** @test */
    function el_nombre_es_obligatorio()
    {
      $this->from('users.create')
           ->post('/usuarios', [
              'name' => '',
              'email' => 'luis_cardenas_5@hotmail.com',
              'password' => '2015330059'
           ])
           ->assertRedirect(route('users.create')
           ->assertSessionHasErrors(['name' => 'El campo nombre es obligatorio']));

           $this->assertEquals(0, User::count());
    }

    /** @test */
    function el_email_es_obligatorio()
    {
      $this->from('users.create')
           ->post('/usuarios', [
              'name' => 'Luis Angel',
              'email' => '',
              'password' => '2015330059'
           ])
           ->assertRedirect(route('users.create')
           ->assertSessionHasErrors(['email']));

           $this->assertEquals(0, User::count());
    }

    /** @test */
    function el_correo_electronico_no_es_valido()
    {
      $this->from('users.create')
           ->post('/usuarios', [
              'name' => 'Luis Angel',
              'email' => 'correo-no-valido',
              'password' => '2015330059'
           ])
           ->assertRedirect(route('users.create')
           ->assertSessionHasErrors(['email']));

           $this->assertEquals(0, User::count());
    }

    /** @test */
    function el_correo_electronico_deve_ser_unico()
    {
      factory(User::class)->create([
        'email' => 'luis_cardenas_5@hotmail.com'
      ]);

      $this->from('users.create')
           ->post('/usuarios', [
              'name' => 'Luis Angel',
              'email' => 'luis_cardenas_5@hotmail.com',
              'password' => '2015330059'
           ])
           ->assertRedirect(route('users.create')
           ->assertSessionHasErrors(['email']));

           $this->assertEquals(1, User::count());
    }

    /** @test */
    function el_password_es_obligatorio()
    {
      $this->from('users.create')
           ->post('/usuarios', [
              'name' => 'Luis Angel',
              'email' => 'luis_cardenas_5@hotmail.com',
              'password' => ''
           ])
           ->assertRedirect(route('users.create')
           ->assertSessionHasErrors(['password']));

           $this->assertEquals(0, User::count());
    }

    /** @test */
    function carga_la_página_editar_usuario()
    {
      $user = factory(User::class)->create();

      $this->get("/usuarios/{$user->id}/editar");               // usuarios/5/editar
           ->assertStatus(200)
           ->asserViewIs('users.edit')
           ->assertSee('Editar usuario')
           ->assertViewHas('user', function ($viewUser) use ($user) {
               return $viewUser->id == $user->id;
           });
    }

    /** @test */
    function editar_a_un_usuario()
    {
      $this->put("/usuarios/{$user->id}", [
        'name' => 'Luis Angel',
        'email' => 'luis_cardenas_5@hotmail.com',
        'password' => '2015330059'
      ])->assertRedirect(route("/usuarios/{$user->id}"));

      $this->assertCredentials([                                                // assertCredentials: este metodo nos permite
        'name' => 'Luis Angel',                                                 // comprobar que tenemos un usuario en la BD
        'email' => 'luis_cardenas_5@hotmail.com',                               // que tenga las siguientes credenciales
        'password' => '2015330059',
      ]);
    }

    /** @test */
    function el_nombre_es_obligatorio_al_actualizar_el_usuario()
    {
      $user = factory(User::class)->create();

      $this->from("usuarios/{$user->id}/editar")
           ->put("usuarios/{$user->id}", [
              'name' => '',
              'email' => 'luis_cardenas_5@hotmail.com',
              'password' => '2015330059'
           ])
           ->assertRedirect(route("usuarios/{$user->id}/editar")
           ->assertSessionHasErrors(['name']));

           $this->assertDatabaseMissing('user', ['email' => 'luis_cardenas_5@hotmail.com']);
    }

    /** @test */
    function el_correo_electronico_no_es_valido_al_actualizar_el_usuario()
    {
      $user = factory(User::class)->create();

      $this->from("usuarios/{$user->id}/editar")
           ->put("usuarios/{$user->id}", [
              'name' => 'Luis Angel',
              'email' => 'correo-no-valido',
              'password' => '2015330059'
           ])
           ->assertRedirect(route("usuarios/{$user->id}/editar")
           ->assertSessionHasErrors(['email']));

           $this->assertDatabaseMissing('user', ['name' => 'Luis Angel']);
    }

    /** @test */
    function el_correo_electronico_deve_ser_unico_al_actualizar_el_usuario()
    {
      factory(User::class)->create([
        'email' => 'existing-email@example.com',
      ]);

       $user = factory(User::class)->create([
        'email' => 'luis_cardenas_5@hotmail.com'
      ]);

      $this->from("usuarios/{$user->id}/editar")
           ->put("usuarios/{$user->id}", [
              'name' => 'Luis Angel',
              'email' => 'existing-email@example.com',
              'password' => '2015330059'
           ])
           ->assertRedirect("usuarios/{$user->id}/editar")
           ->assertSessionHasErrors(['email']);

           $this->assertEquals(1, User::count());
    }

        /** @test */
        function el_correo_electrónico_del_usuario_puede_permanecer_igual_al_actualizar_al_usuario()
        {
          $oldPassword = 'CLAVE_ANTERIOR';
          $user = factory(User::class)->create([
            'email' => 'luis_cardenas_5@hotmail.com'
          ]);

         $this->from("usuarios/{$user->id}/editar")
              ->put("usuarios/{$user->id}", [
                  'name' => 'Luis Angel',
                  'email' => 'luis_cardenas_5@hotmail.com',
                  'password' => '12345'
               ])
               ->assertRedirect(route('users.show'));

               $this->assertCredentials('users', [
                 'name' => 'Luis Angel',
                 'email' => 'luis_cardenas_5@hotmail.com',
               ]);
        }

    /** @test */
    function el_correo_electrónico_del_usuario_puede_permanecer_igual_al_actualizar_al_usuario()
      {
      $oldPassword = 'CLAVE_ANTERIOR';
      $user = factory(User::class)->create([
        'email' => 'luis_cardenas_5@hotmail.com'
        ]);

     $this->from("usuarios/{$user->id}/editar")
          ->put("usuarios/{$user->id}", [
              'name' => 'Luis Angel',
              'email' => 'luis_cardenas_5@hotmail.com',
              'password' => '12345'
              ])
              ->assertRedirect(route('users.show'));

           $this->assertCredentials('users', [
                'name' => 'Luis Angel',
             'email' => 'luis_cardenas_5@hotmail.com',
           ]);

    /** @test */
    function el_password_es_opcional_al_actualizar_el_usuario()
    {
      $oldPassword = 'CLAVE_ANTERIOR';
      $user = factory(User::class)->create([
        'password' => bcrypt($oldPassword)
      ]);

     $this->from("usuarios/{$user->id}/editar")
          ->put("usuarios/{$user->id}", [
              'name' => 'Luis Angel',
              'email' => 'luis_cardenas_5@hotmail.com',
              'password' => ''
           ])
           ->assertRedirect(route('users.show'));

           $this->assertCredentials([
             'name' => 'Luis Angel',
             'email' => 'luis_cardenas_5@hotmail.com',
             'password' => $oldPassword
           ]);
    }

    /** @test */
    function elimina_a_un_usuario()
    {
      $user = factory(User::class)->create();

      $this->delete("usuarios/{$user->id}")
           ->assertRedirect('usuarios');

      $this->assertDatabaseMissing('users', [
        'id' => $user->id
      ]);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\User;

class UserController extends Controller
{
    public function index(Request $request)
    {

      if ($request) {
        $query = trim($request->get('search'));

        $users = User::where('name', 'LIKE', '%' . $query . '%')
                     ->orderBy('id', 'asc')
                     ->get();

        $title = 'Listado de usuarios';

        return view('users.index', ['title', 'users' => $users, 'search' => $query]);
      }

      //$users = DB::table('users');
      // $users = User::all();
      //
      // $title = 'Listado de usuarios';
      //
      // return view('users.index', compact('title', 'users'));
    }

    public function show(User $user)
    {
      return view('users.show', compact('user'));
    }

    public function create()
    {
      return view('users.create');
    }

    public function store()
    {
      $data = request()->validate([                                             // validate : metodo para madar un msm de error
        'name' => 'required',
        'email' => 'required|email|unique:users|email',
        'password' => 'required',
      ], [
        'name.required' => 'El campo nombre es obligatorio',
        'email' => 'El campo email es obligatorio',
        'password' => 'El campo password es obligatorio',
      ]);

      User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => bcrypt($data['password'])
      ]);
      Session::flash('message', 'El usuario fue creado con exito');

      return redirect()->route('users.index');                                  // redirige al listado de usuarios
    }

    public function edit(User $user)
    {
      return view('users.edit', ['user' => $user]);
    }

    public function update(User $user)
    {
      $data = request()->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users,email,'.$user->id,
        'password' => '',
      ]);

      if ($data['password'] != null) {
          $data['password'] = bcrypt($data['password']);
      }else {
        unset($data['password']);
      }

      $user->update($data);

      Session::flash('message', 'El usuario fue editado con exito');

      return redirect()->route('users.index');
    }

    public function destroy(User $user)
    {
      $user->delete();

      Session::flash('message', 'El usuario fue eliminado con exito');

      return redirect()->route('users.index');
    }
}

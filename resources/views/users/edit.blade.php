@extends('layout')

@section('title', "Editar usuario")

@section('content')

<div class="card" style="width: 45.5rem;">
     <h4 class="card-header text-center" style="width: 45.5rem;">Editar usuario</h4>
     <div class="card-body">

       <form method="POST" action="{{ url("usuarios/{$user->id}") }}">
         {{ method_field('PUT') }}
         {{ csrf_field() }}

            <form>
              <div class="form-group" enctype="multipart/form-data">
                <label for="Name">Nombre:</label>
                <input type="text" class="form-control" name="name" id="name" placeholder="Ejm: Luis Ángel" value="{{ old('name', $user->name) }}">
                  @if ($errors->has('name'))
                    <div class="alert alert-danger">
                       <p>{{ $errors->first('name') }}</p>
                    </div>
                  @endif
              </div>
              <div class="form-group">
                <label for="Email">Email address:</label>
                <input type="email" class="form-control" name="email" id="email" aria-describedby="emailHelp" placeholder="Ejm: pedro@example.com" value="{{ old('email', $user->email) }}">       <!-- old('email') : metodo para cargar los datos en un campo de texto -->
                   @if ($errors->has('email'))                                                                                                                                                     <!-- $user->email : metodo para cargar los datos en un campo de texto ejemplo edit -->
                     <div class="alert alert-danger">
                     <p>{{ $errors->first('email') }}</p>
                     </div>
                   @endif
                <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
              </div>
              <div class="form-group">
                <label for="Password">Password:</label>
                <input type="password" class="form-control" name="password" id="password" placeholder="Mayor a 6 caracteres" value="{{ old('password') }}">
                    @if ($errors->has('password'))
                      <div class="alert alert-danger">
                      <p>{{ $errors->first('password') }}</p>
                      </div>
                    @endif
              </div>
                <button type="submit" name="Crear usuario" class="btn btn-primary">Actualizar</button>
                <a href="{{ route('users.index') }}" class="btn btn-link">Cancelar</a>
            </form>

       </form>

     </div>
</div>

@endsection

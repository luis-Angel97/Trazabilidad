@extends('layout')

@section('title', "Listado de usuarios")

@section('content')


<div class="card" style="width: 45.5rem;">
     <h4 class="card-header" style="width: 45.5rem">Listado de usuarios

       <form class="form-inline float-right mt-2 mt-md-0">
         <input class="form-control mr-sm-2" type="text" placeholder="Search user" name="search" aria-label="Search">
       </form>

     </h4>

     <div class="card-body">

         <p>
           <a href="{{ route('users.create') }}" class="btn btn-primary">Nuevo usuario</a>
         </p>

         <h6>
           @if($search)
           <div class="alert alert-primary" role="alert">
             Los resultados de tu busqueda <strong>{{ $search }}</strong> son:
             <button type="button" class="close" data-dismiss="alert" aria-label="Close">
               <span aria-hidden="true">&times;</span>
             </button>
           </div>
           @endif
         </h6>

         @if (Session::has('message'))
             <p class="alert alert-success">{{ Session::get('message') }}
               <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                 <span aria-hidden="true">&times;</span>
               </button>
             </p>
         @endif

   @if ($users->isNotEmpty())
   <table class="table table-striped">
     <thead>
       <tr>
         <th scope="col">Id</th>
         <th scope="col">Nombre</th>
         <th scope="col">E-mail</th>
         <th scope="col">Acciones</th>
       </tr>
     </thead>
     <tbody>
       @foreach($users as $user)
       <tr>
         <th scope="row">{{ $user->id }}</th>
         <td><a href="{{ route('users.edit', ['user' => $user]) }}">{{ $user->name }}</a></td>
         <td>{{ $user->email }}</td>
         <td>

             <form action="{{ route('users.destroy', $user) }}" method="POST">
               {{ csrf_field() }}
               {{ method_field('DELETE') }}
               <a href="{{ route('users.show', ['id' => $user]) }}" class="btn btn-link"><span class="oi oi-eye"></span></a>
               <button type="submit" class="btn btn-link" onclick="return confirm('Seguro que desea eliminar?')"><span class="oi oi-trash"></span></button>
               @include('sweet::alert')
             </form>

         </td>
       </tr>
       @endforeach
     </tbody>
   </table>
   @else
       <p>No hay usuarios registrados.</p>
   @endif

     </div>
</div>


@endsection

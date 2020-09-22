@extends('layout')

@section('title', "Usuario {$user->id}")

@section('content')

  <div class="card" style="width: 20.5rem;">
       <h4 class="card-header " style="width: 20.5rem;">Usuario #{{ $user->id }}</h4>
       <div class="card-body">

         @if (Session::has('message'))
             <p class="alert alert-success">{{ Session::get('message') }}
               <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                 <span aria-hidden="true">&times;</span>
               </button>
             </p>
         @endif

           <div class="card" style="width: 18rem;">
             <img src="/imagenes/error 404.jpg" class="card-img-top" alt="...">
             <div class="card-body">
               <h3 class="card-title">{{ $user->name }}</h3>
               <p class="card-text">{{ $user->email }}</p>
               <a href="#" class="btn btn-primary">Catalogo</a>
               <a href="{{ route('users.index') }}" class="btn btn-link">Cancelar</a>
             </div>
           </div>

       </div>
  </div>


@endsection

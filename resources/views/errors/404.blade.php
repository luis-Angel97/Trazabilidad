
@extends('layout')


@section('title', "Página no encontrada")

<br>
@section('content')

<div class="col-xs-12">
       <div class="center-imagen">
            <img src="/imagenes/error 404.jpg" alt="Nature"  style="width:30%">
       </div>
</div>

<body>

<div class="col-xs-12">
<div class="center-block">
  <br>
       <h1>Página no encontrada</h1>
       <h4><b>404.</b> That's an error.</h4>
  <br>
  <br>
       <h5>Parece que la página que usted está intentando visitar no existe.</h5>
       <h5>Por favor verifique la URL e intentelo nuevamente.</h5>
  <br>

  <tr>
          <td><a href="{{ route('users.index') }}">Regresar</a></td>
  </tr>
  </div>
  </div>

</body>


@endsection

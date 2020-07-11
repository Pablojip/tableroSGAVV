
@extends('layouts.layoutExpirada')


@section('content')
 <div class="d-flex justify-content-center full-height full-width align-items-center">
      <div class="error-container text-center">
        <h1 class="error-number">404</h1>
        <h2 class="semi-bold">La pagina que intenta ingresar ya expiró.</h2>
        <p class="p-b-10">Esto se debe a que la solicitud ya fue completada ó que se supero el tiempo de proceso<a href="#"> ¿Quieres reportarlo?</a>
        </p>
        
      </div>
    </div>
    <div class="pull-bottom sm-pull-bottom full-width d-flex align-items-center justify-content-center">
      <div class="error-container">
        <div class="error-container-innner">
          <div class="p-b-30 sm-m-t-20 sm-p-r-15 sm-p-b-10 clearfix d-flex-md-up row no-margin">
             <div class="col-sm-3 no-padding">
              <img alt="" class="m-t-5" data-src="{{ asset('assets/img/logo-48x48_c.png') }}" data-src-retina="{{ asset('assets/img/logo-48x48_c.png') }}" height="60" src="{{ asset('assets/img/logo-48x48_c.png') }}" width="60">
            </div>
            <div class="col-sm-9 no-padding">
              <p><small>Crea una cuenta en el sistema SGA. si aun no la tienes, entonces comunicate con nuestro
                    equipo de soporte, pulsa 
                  <a href="#" class="text-info">aqui</a> </small>
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>

    


@endsection
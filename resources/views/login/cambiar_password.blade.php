@extends('login.partials._layout_login')


@section('container')
 <div class="login-container bg-white" id="app">
        <div class="p-l-50 p-r-50 p-t-50 m-t-30 sm-p-l-15 sm-p-r-15 sm-p-t-40 loadingContent">
          <img src="{{ asset('assets/img/logo-48x48_c.png') }}" alt="logo" data-src="{{ asset('assets/img/logo-48x48_c.png') }}" data-src-retina="{{ asset('assets/img/logo-48x48_c.png') }}" width="48" height="48">
          <h2 class="p-t-25">Cambiar la contraseña</h2>
          <p class="mw-80 m-t-5">Hola {{ $model['nombreCompleto'] }}, por favor ingresa correctamente la nueva contraseña.</p>
          <p class="m-t-3 text-danger" id="message"></p>
          <!-- START Login Form -->
          <form id="form-login" class="p-t-15" role="form" >
              <input type="hidden" name="clave" value="{{ $model['clave'] }}">
            <!-- START Form Control-->
            <div class="form-group form-group-default">
              <label>Nueva contraseña</label>
              <div class="controls">
                <input type="password" name="password"  id="password"  placeholder="minimo de 6 caracteres"  class="form-control" required>
              </div>
            </div>
            <!-- END Form Control-->
            <!-- START Form Control-->
            <div class="form-group form-group-default">
              <label>Confirmar nueva contraseña</label>
              <div class="controls">
                <input type="password" class="form-control" id="repeat_password" name="repeat_password" placeholder="minimo de 6 caracteres" required>
              </div>
            </div>
            <!-- START Form Control-->
            <div class="row">
                <div class="col-md-12 d-flex align-items-center justify-content-end">
                    <button aria-label="" class="btn btn-primary btn-lg m-t-10" type="submit">Cambiar contraseña</button>
                </div>
            </div>
          <!--  <div>
              <a href="#" class="normal">Not a member yet? Signup now.</a>
            </div>-->
            <!-- END Form Control-->
          </form>
          <!--END Login Form-->
          <div class="pull-bottom sm-pull-bottom">
            <div class="m-b-30 p-r-80 sm-m-t-20 sm-p-r-15 sm-p-b-20 clearfix">
              <div class="col-sm-9 no-padding m-t-10">
                <p class="small-text normal hint-text">
                  ©2019-2020 Todos los derechos reservador. <a href="">Politica sobre cookies</a>, <a href=""> Terminos & privacidad</a>.
                </p>
              </div>
            </div>
          </div>
        </div>
       
      </div>
    
@endsection



@section('script')
    @parent

    <script>
        $(function()
        {
          var message = $('#message');

          $('#form-login').validate({
            rules:{
              password:{ required: true,  minlength: 6 } ,
              repeat_password:{ required: true, equalTo: '#password',  minlength: 6  },
            },
            messages: {
              password: {
                    required: "Este campo es obligatorio.",
                    minlength: "la contraseña debe de contenr 6 o mas caracteres"
                },
                repeat_password: {
                    required: "Este campo es obligatorio.",
                    equalTo: "El campo debe de ser igual de contraseña.",
                    minlength: "la contraseña debe de contenr 6 o mas caracteres"
                }
            }
          });
          
          $('#form-login').submit(function (e){
            e.preventDefault();
            let form = $('#form-login');
            let valido = form.valid();
            if(valido){
    
              $('.loadingContent').card({refresh: true});
    
              try{
                showLoading();
                $.post('{{ route("putChangePassword") }}',form.serialize())
                .done(function(data) {
                  //console.log(data)
                  if(data.valido){
                    //console.log(data)
                    window.location = '{{ route("home")  }}';
                    //location.reload();
                  }else{
                    message.text(data.mensaje);
                  }
                  
                  //$('.loadingContent').card({refresh: true});
                })
                .fail(function(e) {
                  //hideLoading();
                  message.text('Ocurrio un error.');
                })
                .always(function() {
                  hideLoading();
                });
                
              }catch(e){
                
              }
              
              
            }
            
            return valido;
            
    
          });
    
        });
        </script>
	
@stop


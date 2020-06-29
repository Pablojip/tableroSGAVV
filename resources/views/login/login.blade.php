@extends('login.partials._layout_login')


@section('container')
 <div class="login-container bg-white" id="app">
        <div class="p-l-50 p-r-50 p-t-50 m-t-30 sm-p-l-15 sm-p-r-15 sm-p-t-40 loadingContent">
          <img src="assets/img/logo-48x48_c.png" alt="logo" data-src="assets/img/logo-48x48_c.png" data-src-retina="assets/img/logo-48x48_c@2x.png" width="48" height="48">
          <h2 class="p-t-25">Iniciar Sesión</h2>
          <p class="mw-80 m-t-5">Ingresa con tu usario y contraseña por favor.</p>
          <p class="m-t-3 text-danger" id="message"></p>
          <!-- START Login Form -->
          <form id="form-login" class="p-t-15" role="form" >
           
            <!-- START Form Control-->
            <div class="form-group form-group-default">
              <label>Correo eléctronico</label>
              <div class="controls">
                <input type="text" name="correoElectronico"  id="correoElectronico"  placeholder="ejemplo@correo.com"  class="form-control" required>
              </div>
            </div>
            <!-- END Form Control-->
            <!-- START Form Control-->
            <div class="form-group form-group-default">
              <label>Contraseña</label>
              <div class="controls">
                <input type="password" class="form-control" id="password" name="password" placeholder="****" required>
              </div>
            </div>
            <!-- START Form Control-->
            <div class="row">
              <div class="col-md-6 no-padding sm-p-l-10">
                <div class="form-check">
                  <input type="checkbox" value="1" id="checkbox1">
                  <label for="checkbox1">Recordar contraseña</label>
                </div>
              </div>
              <div class="col-md-6 d-flex align-items-center justify-content-end">
                <button aria-label="" class="btn btn-primary btn-lg m-t-10" type="submit">Ingresar</button>
              </div>
            </div>
            <div class="m-b-5 m-t-30">
              <a href="#" class="normal">¿Olvido su contraseña?</a>
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
              correoElectronico:{ required: true },
              password:{ required: true } 
            },
            messages: {
              correoElectronico: {
                    required: "Este campo es obligatorio."
                },
                password: {
                    required: "Este campo es obligatorio."
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
                $.post('{{ route("verificaLogin") }}',form.serialize())
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


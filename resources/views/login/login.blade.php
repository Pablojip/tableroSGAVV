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
              <a href="#" class="normal" data-target="#modalFillIn" data-toggle="modal">¿Olvido su contraseña?</a>
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
    

      <form class="sendEmail-valid">
          <div class="modal fade fill-in" id="modalFillIn" tabindex="-1" role="dialog" aria-hidden="true">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
              <i class="pg-close"></i>
            </button>
            <div class="modal-dialog ">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="text-left p-b-5">Escribe el correo asociado al sistema </h5>
                </div>
                <div class="modal-body form-valid">
                  <div class="row">
                    <div class="col-md-9 ">
                      <input type="text" id="correoSend" name="correoSend" placeholder="Escribe tu correo aqui" class="form-control input-lg" id="icon-filter" name="icon-filter">
                    </div>
                    <div class="col-md-3" >
                      <button type="button" class="btn-lg btn-primary mt-1" id="btnRememberPassword"> Enviar </button>
                    </div>
                  </div>
                  <p class="text-left sm-text-center hinted-text p-t-10 p-r-10">Enviaremos a tu correo las instrucciones para recuperar la cuenta.</p>
                  <h4 id="EmailMessage" class="sm-text-center text-info" style="text-align: center;"></h4>
                </div>
                <div class="modal-footer">
                </div>
                <!-- PROCESANDO  -->
                <div id="EmailProgress">
                    <div class="progress" >
                        <div class="progress-bar-indeterminate"></div>
                    </div>
                    <h3 class="sm-text-center tituloEnvio" style="text-align: center;"></h3>
                </div>
                <!-- END PROCESANDO -->
              </div>

              <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
          </div>
</form>
@endsection



@section('script')
    @parent

    <script>
        $(function()
        {
          $(".progress").hide();
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

        $('#btnRememberPassword').click(function (e){
            //Iniciamos el proceso.
            loadingEmail();
            // Disable #x
            $( "#BtnEnviar" ).prop( "disabled", true );
            $(".progress").show();
            $(".tituloEnvio").html('Procesando la solicitud...');
            //$( "#EmailProgress" ).show();
            //parametros
            var correo = $("#correoSend").val();
            var data = { 'correoSend': $("#correoSend").val() }
            $.post('{{ route("mailRecuperar")}}',data,function(data){
              if(data.valido){
                $(".tituloEnvio").html(data.mensaje);
              }else{
                $(".tituloEnvio").html(data.mensaje).addClass( "text-danger" );
              }
            }).fail(function() {
              $(".tituloEnvio").addClass( "text-danger" ).html('Ocurrio un error inesperado, por favor contacte al administrador del sistema.');
            }).always(function() {
              $(".progress").hide();
              $( "#BtnEnviar" ).prop( "disabled", false );
            }); 

          });
        
        </script>
	
@stop


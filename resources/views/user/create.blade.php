@extends('layouts._layout')

@section('container')
<div class="col-xl-12 col-lg-12 ">
        <!-- START card -->
        <div class="card">
          <div class="card-header ">
            <div class="card-title">Creación de usuario.
            </div>
          </div>
          <div class="card-body">
            <h2 class="mw-80">Nuevo usuario</h2>
            <p class="fs-16 mw-80 m-b-40">Por favor llene los campos correctamente.</p>
            <form id="form-create" role="form" autocomplete="off"  class="limpiar">
              <div class="row clearfix loadingContent">
                <div class="col-xl-4">
                  <div class="form-group form-group-default required">
                    {{  Form::label('Nombres') }}
                    <input type="text" class="form-control" name="nombres" required  placeholder="nombre">
                  </div>
                </div>
                <div class="col-xl-4">
                    <div class="form-group form-group-default">
                        {{  Form::label('Apellido paterno') }}
                        <input type="text" class="form-control" name="apellido_paterno" placeholder="apellido paterno">
                    </div>
                </div>
                <div class="col-xl-4">
                    <div class="form-group form-group-default">
                        {{  Form::label('Apellido materno') }}
                        <input type="text" class="form-control" name="apellido_materno" placeholder="apellido materno">
                    </div>
                </div>
              </div>
              <div class="row clearfix">
                    <div class="col-xl-4">
                        <div class="form-group form-group-default required">
                            {{  Form::label('Correo eléctronico') }}
                            <input type="text" class="form-control" name="email" placeholder="ejemplo@correo.com" required > 
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <div class="form-group form-group-default required">
                            {{  Form::label('Contraseña') }}
                            <input type="password" class="form-control" id="password" name="password" placeholder="minimo de 6 caracteres" required >
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <div class="form-group form-group-default required">
                            {{  Form::label('Repetir contraseña') }}
                            <input type="password" class="form-control" id="repeat_password" name="repeat_password" placeholder="minimo de 6 caracteres" required>
                        </div>
                    </div>
              </div>

              <div class="row">
                <div class="col-md-6">
                    <div class="form-group form-group-default form-group-default-select2 required">
                        {{  Form::label('Permiso') }}
                        {!! Form::select('role_id', $roles, null, ['class' => 'full-width required','data-init-plugin'=>'select2']) !!}                          </div>
                </div>
              </div>
              <div class="clearfix"></div>
              <div class="row m-t-25">
                    <div class="col-xl-8"></div>
                <div class="col-xl-2">
                    <button id="btnLimpiar" aria-label="" class="btn btn-secondary pull-right btn-lg btn-block" type="button">
                        Borrar
                    </button>
                </div>
                <div class="col-xl-2">
                    <button aria-label="" class="btn btn-primary pull-right btn-lg btn-block" type="submit">
                        Guardar
                    </button>
                </div>
              </div>
            </form>
          </div>
        </div>
        <!-- END card -->
      </div>
@endsection


@section('js')

<script>
        $(function()
        {
          var message = $('#message');
          $('#form-create').validate({
            rules:{
                nombres:{ required: true, nombres: true },
                apellido_paterno:{  nombres: true },
                apellido_materno:{  nombres: true },
                email:{ required: true, email: true },
                password:{ required: true,  minlength: 6 } ,
                repeat_password:{ required: true, equalTo: '#password',  minlength: 6  },
                role_id: { required:true }
            },
            messages: {
                nombres: {
                    required: "Este campo es obligatorio."
                },
                email: {
                    required: "Este campo es obligatorio.",
                    email: "Este no es correo  eléctronico valido."
                },
                password: {
                    required: "Este campo es obligatorio.",
                    minlength: "la contraseña debe de contenr 6 o mas caracteres"
                },
                repeat_password: {
                    required: "Este campo es obligatorio.",
                    equalTo: "El campo debe de ser igual de contraseña.",
                    minlength: "la contraseña debe de contenr 6 o mas caracteres"
                },
                role_id: {
                    required: "Este campo es obligatorio."
                }
            }
          });

        //limpiar
         $('#form-create').submit(function (e){
            e.preventDefault();
            let valido = $(this).valid();
            if(valido){    
                try{
                    showLoading();
                    $.post('{{ route("usuarioStore") }}',$(this).serialize())
                    .done(function(data) {
                    //console.log(data)
                    if(data.valido){
                        limpiar();
                        alert(data.mensaje);
                        //console.log(data)
                        //window.location = '{{ route("home")  }}';
                        //location.reload();
                    }else{
                        alert(data.mensaje,'danger');
                    }
                    //$('.loadingContent').card({refresh: true});
                    })
                    .fail(function(e) {
                        alert('Ocurrio un error inesperado, contacte al administrador.','danger');
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
@endsection
    

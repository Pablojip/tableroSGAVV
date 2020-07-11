@extends('layouts._layout')

@section('container')
<div class="col-xl-12 col-lg-12 ">
        <!-- START card -->
        <div class="card">
          <div class="card-header ">
            <div class="card-title">Perfil del usuario.
            </div>
          </div>
          <div class="card-body loadingContent">
            <h2 class="mw-80">Perfil del usuario</h2>
            <p class="fs-16 mw-80 m-b-40">Por favor llene los campos correctamente.</p>
            <form id="form-create" role="form" autocomplete="off"  class="limpiar">
                    <input type="hidden" name="id" value="{{ $model->id }}"/>
              <div class="row clearfix">
                <div class="col-xl-4">
                  <div class="form-group form-group-default required">
                    {{  Form::label('Nombres') }}
                  <input type="text" class="form-control" name="nombres" required  placeholder="nombre" value="{{ $model->nombres }}">
                  </div>
                </div>
                <div class="col-xl-4">
                    <div class="form-group form-group-default">
                        {{  Form::label('Apellido paterno') }}
                        <input type="text" class="form-control" name="apellido_paterno" placeholder="apellido paterno" value="{{ $model->apellido_paterno }}">
                    </div>
                </div>
                <div class="col-xl-4">
                    <div class="form-group form-group-default">
                        {{  Form::label('Apellido materno') }}
                        <input type="text" class="form-control" name="apellido_materno" placeholder="apellido materno" value="{{ $model->apellido_materno }}">
                    </div>
                </div>
              </div>
              <div class="row clearfix">
                    <div class="col-xl-4">
                        <div class="form-group form-group-default required">
                            {{  Form::label('Correo eléctronico') }}
                            <input type="text" class="form-control" name="email" placeholder="ejemplo@correo.com" required  value="{{ $model->email }}"> 
                        </div>
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
                email:{ required: true, email: true }
            },
            messages: {
                nombres: {
                    required: "Este campo es obligatorio."
                },
                email: {
                    required: "Este campo es obligatorio.",
                    email: "Este no es correo  eléctronico valido."
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
                    $.post('{{ route("usuarioPerfilStore") }}',$(this).serialize())
                    .done(function(data) {
                    //console.log(data)
                    if(data.valido){
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
    

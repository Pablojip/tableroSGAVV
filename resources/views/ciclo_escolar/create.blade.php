@extends('layouts._layout')

@section('container')
<div class="col-xl-12 col-lg-12 ">
        <!-- START card -->
        <div class="card">
          <div class="card-header ">
            <div class="card-title">Creación de ciclo escolar.
            </div>
          </div>
          <div class="card-body">
            <h2 class="mw-80">Nuevo  ciclo escolar</h2>
            <p class="fs-16 mw-80 m-b-40">Por favor llene los campos correctamente.</p>
            <form id="form-create" role="form" autocomplete="off"  class="limpiar">
              <div class="row clearfix loadingContent">
                <div class="col-xl-4">
                  <div class="form-group form-group-default required">
                    {{  Form::label('Inicio') }}
                    <input type="text" class="form-control" name="inicio" required  placeholder="año de inicio del ciclo escolar">
                  </div>
                </div>
                <div class="col-xl-4">
                    <div class="form-group form-group-default">
                        {{  Form::label('Fin') }}
                        <input type="text" class="form-control" name="fin" placeholder="año de termino del ciclo escolar">
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

          $('#form-create').validate({
            rules:{
                inicio:{ required: true } ,
                fin:{ required: true } 
            },
            messages: {
                inicio: {
                    required: "Este campo es obligatorio."
                },
                fin: {
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
                    $.post('{{ route("cicloEscolarStore") }}',$(this).serialize())
                    .done(function(data) {
                        if(data.valido){
                            limpiar();
                            alert(data.mensaje);
                        }else{
                            alert(data.mensaje,'danger');
                        }
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
    

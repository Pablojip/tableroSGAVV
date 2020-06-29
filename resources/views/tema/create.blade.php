@extends('layouts._layout')

@section('container')
<div class="col-xl-12 col-lg-12 ">
        <!-- START card -->
        <div class="card">
          <div class="card-header ">
            <div class="card-title">Creación de temas.
            </div>
          </div>
          <div class="card-body">
            <h2 class="mw-80">Nuevo tema</h2>
            <p class="fs-16 mw-80 m-b-40">Por favor llene los campos correctamente.</p>
            <form id="form-create" role="form" autocomplete="off"  class="limpiar">
              <div class="row clearfix loadingContent">
                <div class="col-xl-4">
                  <div class="form-group form-group-default required">
                    {{  Form::label('Nombre') }}
                    <input type="text" class="form-control" name="nombre" required  placeholder="nombre">
                  </div>
                </div>
                <div class="col-xl-4">
                    <div class="form-group form-group-default">
                        {{  Form::label('Descripción') }}
                        <input type="text" class="form-control" name="descripcion" placeholder="descripción">
                    </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group form-group-default form-group-default-select2 required">
                      {{  Form::label('Materia') }}
                      {!! Form::select('materia_id', $materias, null, ['class' => 'full-width required','data-init-plugin'=>'select2']) !!}                          </div>
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
                nombre:{ required: true },
                materia_id:{ required: true } 
            },
            messages: {
                nombre: {
                    required: "Este campo es obligatorio."
                },
                materia_id: {
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
                    $.post('{{ route("temaStore") }}',$(this).serialize())
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
    

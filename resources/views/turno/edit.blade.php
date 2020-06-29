@extends('layouts._layout')

@section('container')
<div class="col-xl-12 col-lg-12 ">
        <!-- START card -->
        <div class="card">
          <div class="card-header ">
            <div class="card-title">Editar turno.
            </div>
          </div>
          <div class="card-body">
            <h2 class="mw-80">Edición</h2>
            <p class="fs-16 mw-80 m-b-40">Por favor llene los campos correctamente.</p>
            <form id="form-edit" role="form" autocomplete="off"  class="limpiar">
            <input type="hidden" name="id" value="{{ $model->id }}"/>
              <div class="row clearfix loadingContent">
                <div class="col-xl-4">
                  <div class="form-group form-group-default required">
                    {{  Form::label('Turno') }}
                  <input type="text" class="form-control" name="turno" required  placeholder="Turno" value="{{ $model->turno }}">
                  </div>
                </div>
                <div class="col-md-1">
                    <div class="form-group form-group-default">
                        {{  Form::label('Activo') }}
                        <div class="form-check form-check-inline switch switch-lg success">
                                <input type="checkbox" id="activo" name="activo"  value="1" {{ $model->activo ? 'checked' : '' }}>
                                <label for="activo"> </label>
                              </div>
                    </div>
                </div>
              </div>

              <div class="clearfix"></div>
              <div class="row m-t-25">
                    <div class="col-xl-8"></div>
                <div class="col-xl-2">
                    <a href="{{ route("turnoIndex") }}" aria-label="" class="btn btn-secondary pull-right btn-lg btn-block" type="button">
                        consulta
                    </a>
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

          $('#form-edit').validate({
            rules:{
              turno:{ required: true }
            },
            messages: {
              turno: {
                    required: "Este campo es obligatorio."
                }
            }
          });

        //limpiar
         $('#form-edit').submit(function (e){
            e.preventDefault();
            let valido = $(this).valid();
            if(valido){    
                try{
                    showLoading();
                    $.post('{{ route("turnoUpdate") }}',$(this).serialize())
                    .done(function(data) {
                        if(data.valido){
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
    

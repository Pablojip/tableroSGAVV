@extends('layouts._layout')

@section('container')
<div class="col-xl-12 col-lg-12 ">
        <!-- START card -->
        <div class="card">
          <div class="card-header ">
            <div class="card-title">Buscar usuarios.
            </div>
          </div>
          <div class="card-body">
            <h2 class="mw-80">Buscar</h2>
            <p class="fs-16 mw-80 m-b-40">Use los filtros para buscar.</p>
            <form id="form-create" role="form" autocomplete="off"  class="limpiar">
              <div class="row clearfix loadingContent">
                <div class="col-xl-4">
                  <div class="form-group form-group-default">
                    {{  Form::label('Nombres') }}
                    <input type="text" class="form-control" name="nombres"  placeholder="nombre">
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
                        <div class="form-group form-group-default">
                            {{  Form::label('Correo eléctronico') }}
                            <input type="text" class="form-control" name="email" placeholder="ejemplo@correo.com" > 
                        </div>
                    </div>
                    <div class="col-md-4">
                            <div class="form-group form-group-default form-group-default-select2">
                                {{  Form::label('Permiso') }}
                                {!! Form::select('role_id', ['' => 'Seleccione...'] + $roles, null, ['class' => 'full-width','data-init-plugin'=>'select2']) !!}          
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
                        buscar
                    </button>
                </div>
              </div>
            </form>


            <hr>
            <div id="lista">
                    @include('user._list')
            </div>
            
          </div>
        </div>
        <!-- END card -->
      </div>
@endsection


@section('js')

<script>
        $(function()
        {
           
        //limpiar
        
         $('#form-create').submit(function (e){
            e.preventDefault();
                try{
                    showLoading();
                    $.get('{{ route("usuarioIndex") }}',$(this).serialize())
                    .done(function(data) {
                        console.log(data);
                    if(data.valido){
                        $("#lista").html(data.mensaje);
                        //console.log(data)
                        //window.location = '{{ route("home")  }}';
                        //location.reload();
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
          });
          
            //paginador
            $(document).on('click','.pagination a',function(event){
                event.preventDefault();
                var pagina = $(this).attr('href').split('page=')[1]; //?page=2
                var form = $('#form-create').serialize();
                fetch_data('{{ route("usuarioIndex") }}?page='+pagina,form);
            });


        }); 
       
        </script>
@endsection
    

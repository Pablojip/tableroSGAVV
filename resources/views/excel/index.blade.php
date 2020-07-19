@extends('layouts._layout')

@section('container')
<div class="col-xl-12 col-lg-12 ">
        <!-- START card -->
        <div class="card">
          <div class="card-header ">
            <div class="card-title">Administración de datos.
            </div>
          </div>
          <div class="card-body">
            <h2 class="mw-80">Administración de datos.</h2>
            <p class="fs-16 mw-80 m-b-40">Por favor, descarge y suba los archivos con los datos que quiere guardar.</p>
            <form id="form-create1" role="form" autocomplete="off">
              <div class="row clearfix loadingContent">
                <div class="col-md-4">
                  <div class="form-group form-group-default form-group-default-select2">
                      {{  Form::label('Seleccione el catalogo que quiera descargar plantilla') }}
                      {!! Form::select('catalogo_id', ['' => 'Seleccione...'] + $catologos, null, ['class' => 'full-width catalogos','data-init-plugin'=>'select2']) !!}          
                  </div>
                </div>
                <div class="col-xl-2">
                  <button id="btnDownload" aria-label="" class="btn btn-primary pull-right btn-lg btn-block" type="button">
                      Descargar Template
                  </button>
              </div>
              </div>
            </form>
            <hr/>
            <form id="form-create" role="form" autocomplete="off"  class="limpiar" enctype="multipart/form-data" class="limpiar"> 
              <div class="row clearfix loadingContent">
                <div class="col-md-4">
                  <div class="form-group form-group-default form-group-default-select2">
                      {{  Form::label('Seleccione el catalogo que quiera subir información') }}
                      {!! Form::select('id', ['' => 'Seleccione...'] + $catologos, null, ['class' => 'full-width catalogos','data-init-plugin'=>'select2']) !!}          
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" id="archivo" name="archivo" lang="es">
                    <label class="custom-file-label" for="customFileLang">Seleccionar Archivo</label>
                  </div>
                </div>
                <div class="col-xl-2">
                  <button aria-label="" class="btn btn-primary pull-right btn-lg btn-block" type="submit">
                      Subir datos
                  </button>
              </div>
              </div>
            </form>
           

            <hr>
            <div id="lista">
                   
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
           
          $('#btnDownload').click(function (e){
            var catalogo_id = $(".catalogos").val();

            //var url = "{{route('excelTemplate',"+catalogo_id+")}}";
            var url = '{{url("http://localhost:8000/Excel/GetTemplate")}}' + '/' + catalogo_id;

            console.log(url);
            window.location = url;
          });
        //limpiar
        

        $('#form-create').validate({
            rules:{
              id:{ required: true },
              archivo:{ required: true } 
            },
            messages: {
                id: {
                    required: "Este campo es obligatorio."
                },
                archivo: {
                    required: "Este campo es obligatorio."
                }
            }
          });

          $('#form-create').submit(function (e){
            e.preventDefault();
            var formData = new FormData($(this)[0]);

            console.log(formData);
            let valido = $(this).valid();
            if(valido){
                try{
                    showLoading();
                    $.ajax({
                      url: '{{ route("excelImport") }}',
                      data: formData,
                      processData: false,
                      contentType: false,
                      type: 'POST',
                      success: function(data){
                        if(data.valido){
                            limpiar();
                            alert(data.mensaje);
                        }else{
                          if(data.Errores){
                            alert("Documento no valido, por favor revisar.",'warning');
                            $("#lista").html(data.view_Excel);
                          }else{
                            alert(data.mensaje,'danger');
                          }
                            
                        }
                      }
                    });
                    /*$.post('{{ route("excelImport") }}',formData)
                    .done(function(data) {
                       
                    })
                    .fail(function(e) {
                        alert('Ocurrio un error inesperado, contacte al administrador.','danger');
                    })
                    .always(function() {
                        hideLoading();
                    });*/
                    
                }catch(e){
                    
                } 
            }               
            return valido;
            
    
          });

        }); 
       
        </script>
@endsection
    

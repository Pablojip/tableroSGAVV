@extends('layouts._layout')

@section('container')
<div class="col-xl-12 col-lg-12 ">
        <!-- START card -->
        <div class="card">
          <div class="card-header ">
            <div class="card-title">Detalle del alumno.
            </div>
          </div>
          <div class="card-body">
            <h2 class="mw-80">Detalles</h2>
            <p class="fs-16 mw-80 m-b-40">Detalles de los campos del usuario.</p>
            <form id="form-edit" role="form" autocomplete="off"  class="limpiar">
            <input type="hidden" name="id" value="{{ $model->id }}"/>
            <div class="row clearfix loadingContent">
                <div class="col-xl-4">
                  <div class="form-group form-group-default">
                    {{  Form::label('Matricula') }}
                    {{  Form::label('',$model->matricula) }}
                  </div>
                </div>
              </div>
              <div class="row clearfix loadingContent">
                <div class="col-xl-4">
                  <div class="form-group form-group-default">
                    {{  Form::label('Nombres') }}
                    {{  Form::label('',$model->nombres) }}
                  </div>
                </div>
                <div class="col-xl-4">
                    <div class="form-group form-group-default">
                        {{  Form::label('Apellido paterno') }}
                        {{  Form::label('',$model->apellido_paterno) }}
                    </div>
                </div>
                <div class="col-xl-4">
                    <div class="form-group form-group-default">
                        {{  Form::label('Apellido materno') }}
                        {{  Form::label('',$model->apellido_materno ) }}
                    </div>
                </div>
              </div>
              <div class="row clearfix">
                  <div class="col-md-1">
                    <div class="form-group form-group-default">
                      {{  Form::label('Activo') }}
                      {!! $model->Activo() !!}
                    </div>
                  </div>
               </div>
              <div class="clearfix"></div>
              <div class="row m-t-25">
                    <div class="col-xl-8"></div>
                <div class="col-xl-2">
                    <a href="{{ route("alumnoIndex") }}" aria-label="" class="btn btn-secondary pull-right btn-lg btn-block" type="button">
                        consulta
                    </a>
                </div>
                <div class="col-xl-2">
                    <a href="{{ route("alumnoEdit",['id' => $model->id]) }}" aria-label="" class="btn btn-warning pull-right btn-lg btn-block" type="submit">
                        Editar
                    </a>
                </div>
              </div>
            </form>
          </div>
        </div>
        <!-- END card -->
      </div>
@endsection



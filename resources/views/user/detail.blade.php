@extends('layouts._layout')

@section('container')
<div class="col-xl-12 col-lg-12 ">
        <!-- START card -->
        <div class="card">
          <div class="card-header ">
            <div class="card-title">Detalle de usuario.
            </div>
          </div>
          <div class="card-body">
            <h2 class="mw-80">Detalles</h2>
            <p class="fs-16 mw-80 m-b-40">Detalles de los campos del usuario.</p>
            <form id="form-edit" role="form" autocomplete="off"  class="limpiar">
            <input type="hidden" name="id" value="{{ $user->id }}"/>
              <div class="row clearfix loadingContent">
                <div class="col-xl-4">
                  <div class="form-group form-group-default">
                    {{  Form::label('Nombres') }}
                    {{  Form::label('',$user->nombres) }}
                  </div>
                </div>
                <div class="col-xl-4">
                    <div class="form-group form-group-default">
                        {{  Form::label('Apellido paterno') }}
                        {{  Form::label('',$user->apellido_paterno) }}
                    </div>
                </div>
                <div class="col-xl-4">
                    <div class="form-group form-group-default">
                        {{  Form::label('Apellido materno') }}
                        {{  Form::label('',$user->apellido_materno ) }}
                    </div>
                </div>
              </div>
              <div class="row clearfix">
                    <div class="col-xl-4">
                        <div class="form-group form-group-default">
                            {{  Form::label('Correo eléctronico') }}
                            {{  Form::label('',$user->email ) }}
                        </div>
                    </div>
                    <div class="col-md-4">
                            <div class="form-group form-group-default">
                                {{  Form::label('Permiso') }}
                                {{  Form::label('',$user->roles->nombre ) }}
                            </div>
                        </div>
                        <div class="col-md-1">
                                <div class="form-group form-group-default">
                                    {{  Form::label('Activo') }}
                                    {!! $user->Activo() !!} 
                                </div>
                            </div>
              </div>

              <div class="clearfix"></div>
              <div class="row m-t-25">
                    <div class="col-xl-8"></div>
                <div class="col-xl-2">
                    <a href="{{ route("usuarioIndex") }}" aria-label="" class="btn btn-secondary pull-right btn-lg btn-block" type="button">
                        consulta
                    </a>
                </div>
                <div class="col-xl-2">
                    <a href="{{ route("usuarioEdit",['id' => $user->id]) }}" aria-label="" class="btn btn-warning pull-right btn-lg btn-block" type="submit">
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



<div class="table-responsive">
        <table class="table table-hover" id="basicTable">
          <thead>
            <tr>
              <!-- NOTE * : Inline Style Width For Table Cell is Required as it may differ from user to user
                                  Comman Practice Followed
                                  -->
              <th style="width:20%">Nombre</th>
              <th style="width:20%">Descripcion</th>
              <th style="width:15%">Activo</th>
              <th style="width:15%">Acciones</th>
            </tr>
          </thead>
          <tbody>

            @if($listados != null && count($listados) > 0) 
                @foreach ($listados as $listado)
                    <tr>
                        <td class="v-align-middle">
                          <p>{{ $listado->nombre }}</p>
                        </td>
                        <td class="v-align-middle">
                          <p>{{ $listado->descripcion }}</p>
                        </td>
                        <td class="v-align-middle">
                          <p>{!! $listado->Activo() !!}</p>
                        </td>
                        <td class="v-align-middle">
                                <div class="dropdown dropdown-default">
                                    <button aria-label="" class="btn dropdown-toggle text-center" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                      <i class="pg-icon">settings</i>  Acciones
                                    </button>
                                    <div class="dropdown-menu">
                                      <a class="dropdown-item" href="{{ route("materiaEdit",['id' => $listado->id]) }}"><i class="pg-icon">edit</i>  Editar</a>
                                      <a class="dropdown-item" href="{{ route("materiaDetail",['id' => $listado->id]) }}"><i class="pg-icon">text_align_justify</i>  Detalles</a>
                                    </div>
                                </div>
                        </td>
                      </tr>
                @endforeach
            @else
                <tr>
                    <td class="text-center text-danger" colspan="5"> No se encontraron datos.</td>
                </tr>
            @endif
          </tbody>
        </table>
    </div>
    <br>

    {{ $listados != null ?  $listados->links() : '' }}
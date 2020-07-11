<div class="table-responsive">
        <table class="table table-hover" id="basicTable">
          <thead>
            <tr>
              <!-- NOTE * : Inline Style Width For Table Cell is Required as it may differ from user to user
                                  Comman Practice Followed
                                  -->
              <th style="width:20%">Movimiento</th>
              <th style="width:20%">Modulo</th>
              <th style="width:20%">Usuario que realizo</th>
              <th style="width:20%">Fecha</th>
              <th style="width:15%">Acciones</th>
            </tr>
          </thead>
          <tbody>

            @if($listados != null && count($listados) > 0) 
                @foreach ($listados as $listado)
                    <tr>
                        <td class="v-align-middle">
                          <p>{!! $listado->accion() !!}</p>
                        </td>
                        <td class="v-align-middle">
                          <p>{{ $listado->tabla_publico }}</p>
                        </td>
                        <td class="v-align-middle">
                          <p>{!! $listado->usuarioRealizo() !!}</p>
                        </td>
                        <td class="v-align-middle">
                          <p>{!! $listado->fechaFormato() !!}</p>
                          
                        </td>
                        <td class="v-align-middle">
                          <button onclick="detalleBitacora('{{ $listado->tabla_publico }}','{{ $listado->accion() }}',{{ $listado->cambios }})" data-target="#modalFillIn" data-toggle="modal" class="btn btn-default btn-icon-left m-b-10" type="button"><i class="pg-icon">text_align_justify</i> Detalles</button>
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
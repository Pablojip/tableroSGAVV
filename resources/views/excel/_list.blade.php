<div class="table-responsive">
        <table class="table" id="basicTable">
          <thead>
            <tr>
              <!-- NOTE * : Inline Style Width For Table Cell is Required as it may differ from user to user
                                  Comman Practice Followed
                                  -->
              <th style="width:20%">#</th>
                @if($headers != null && count($headers) > 0) 
                  @foreach ($headers as $header)
                                <th style="width:20%">{!! $header !!}</th>
                  @endforeach   
                @endif           
            </tr>
          </thead>
          <tbody>

            @if($listados != null && count($listados) > 0) 
                @foreach ($listados as $listado)
                <tr>
                    <td class="v-align-middle">
                        <p> Renglón {{ $listado['Linea'] }}</p>
                      </td>
                  @foreach ($listado['Datos'] as $columna)
                    <td class="v-align-middle tooltip_ajax {{ strlen($columna['errores_msg']) > 0 ? 'bg-danger text-white' : '' }}" data-toggle="tooltip" data-original-title="{{ $columna['errores_msg'] }}">
                      <p>{{ $columna['columna'] }} </p>
                    </td>
                  @endforeach
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

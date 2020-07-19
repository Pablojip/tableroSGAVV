<table>
    <thead>
        <tr>
            @if($columnas != null && count($columnas) > 0) 
            @foreach ($columnas as $columna)
                <th><b>{{$columna}}</b></th>
            @endforeach
        @endif
        </tr>
    </thead>
</table>
<form action="/permissions/grupo/{{ $aclgrupo->id }}/permisos" method="POST" class="form-horizontal">
    {!! csrf_field() !!}
    <table style="width:100%;">
        @foreach ($listado as $controlador)
        <tr>
            <th>{{ ($controlador->es_hijo ? " └ " : "") . $controlador->rotulo }}</th>
            <td>
                <ul>
                    @foreach ($controlador->permisos as $permiso)
                    <li><input type="checkbox" name="accion[{{ $controlador->id }}][{{ $permiso->accion }}]" value="1" {{ ($permiso->checked ? 'checked' : '') }}> {{ $permiso->accion }}</li>

                    @endforeach
                </ul>
            </td>
        </tr>
        @endforeach
    </table>
    <div style="text-align:right;">
        <button type="submit" class="btn btn-default btn-sm" style="color: #fff;background-color: #d87300;border-color: #af5d00;">
            Guardar
        </button>
    </div>
</form>

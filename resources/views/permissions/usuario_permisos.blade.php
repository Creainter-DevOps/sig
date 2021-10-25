<form action="/permissions/usuario/{{ $aclusuario->id }}/permisos" method="POST" class="form-horizontal">
    {!! csrf_field() !!}
    <table style="width:100%;">
        @foreach ($listado as $grupo)
        <tr>
            <th>{{ $grupo->nombre }}</th>
            <td>
                <input type="checkbox" name="accion[{{ $grupo->id }}]" value="1" {{ ($grupo->checked ? 'checked' : '') }}>
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


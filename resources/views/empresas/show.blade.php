<table class="table table-bordered table-vcenter">
    <tr>
        <th>Razón Social</th>
        <td>{{ $empresa->razon_social }}</td>
    </tr>
    <tr>
        <th>Seudonimo</th>
        <td>{{ $empresa->seudonimo }}</td>
    </tr>
    <tr>
        <th>RUC</th>
        <td>{{ $empresa->ruc }}</td>
    </tr>
    <tr>
        <th>Dirección</th>
        <td>{{ $empresa->direccion }}</td>
    </tr>
    <tr>
        <th>Referencia</th>
        <td>{{ $empresa->referencia }}</td>
    </tr>
    <tr>
        <th>Telefono</th>
        <td>{{ $empresa->telefono }}</td>
    </tr>
    <tr>
        <th>Correo electrónico</th>
        <td>{{ $empresa->correo_electronico }}</td>
    </tr>
    <tr>
        <th>Web</th>
        <td>{{ $empresa->web }}</td>
    </tr>
    <tr>
        <th>Aniversario</th>
        <td>{{ $empresa->aniversario }}</td>
    </tr>
    <tr>
        <th>Es agente de Retención</th>
        <td>{{ empty($empresa->es_agente_retencion) ? 'Si' : 'No' }}</td>
    </tr>
</table>

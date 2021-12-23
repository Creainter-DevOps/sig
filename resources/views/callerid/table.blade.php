<table class="table table-sm mb-0 table-bordered table-vcenter"  style="width:100%">
<thead>
  <tr>
    <th colspan="4" class="table-head"><a class="link-primary"  href="{{ route('callerid.show', [ 'caller' => $caller->id ]) }}" target="_blank">Proyecto</a></th>
  </tr>
</thead>
              <tbody>
              
                <tr>
                  <th>Rotulo:</th>
                  <td>{{ $caller->empresa()->rotulo}}</td>
                </tr>
                <tr>
                  <th>Uri:</th>
                  <td>{{ $caller->uri}}</td>
                </tr>
                <tr>
                  <th>Number:</th>
                  <td>{{ $caller->number}}</td>
                </tr>
                <tr>
                  <th>Empresa:</th>
                  <td>{{ $caller->empresa()->empresa_id}}</td>
                </tr>
             
              </tbody>
</table>


<!-- table success start -->
<section id="table-success">
  <div class="card">
    <div class="card-body" >
      <h5 class="card-title">Lista de contactos </h5>
    <div class="table-responsive table-sm ">
      <table id="table-extended-success" class="table mb-0 dataTable">
        <thead>
          <tr>
            <th>Nombres</th>
            <th>Apellidos</th>
            <th>Celular</th>
            <th>Correo</th>
          </tr>
        </thead>
        <tbody id="table-body" >
          @foreach ( $listado as $contacto ) 
          <tr>
            <td class="pr-0">{{ $contacto->nombres }}</td>
            <td class="text-success" align ="left" >{{ $contacto->apellidos }}</td>
            <td class="" align ="left" >
              <span data-outgoing="{{ $contacto->celular}}" data-outgoing-title="{{ $contacto->nombres }}"></span>
            </td>
            <td class="" align ="left" >{{ $contacto->correo }}</td>
          </tr>
        @endforeach
        </tbody>
      </table>
    </div>
    </div>
    </div>
  </div>
</section>

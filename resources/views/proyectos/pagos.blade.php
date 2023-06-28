@php
 $did = uniqid();
@endphp

<!--<div style="margin-bottom: 15px;text-align: right;">
  <button type="button" class="btn btn-sm m-0" data-popup="/pagos/crear?proyecto_id={{ $proyecto->id }}">
    <i class="bx bx-plus"></i>Nuevo Pago
  </button>
</div>-->
<table id="{{ $did }}"></table>
<script>
readyLoad(function() {
        window.t{{ $did }} = new Tablefy({
            title: 'RELACIÓN DE PAGOS',
            dom: '#{{ $did }}',
            height: 480,
            request: {
              url: '/proyectos/{{ $proyecto->id }}/pagos/tablefy',
              type: 'POST',
              data: {},
              headers : {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute("content")
              },
            },
            headers: [
              {
                name: 'Código',
                width: 100,
                style: {'text-align':'center'},
              },
              {
                name: 'Usuario',
                width: 80,
              },
              {
                name: 'Fecha',
                width: 90,
              },
              {
                name: 'Número',
                width: 70,
              },
              {
                name: 'Descripción',
                width: 350,
              },
              {
                name: 'Monto',
                width: 100,
              },
              {
                name: 'Moneda',
                width: 70,
              },
              {
                name: 'Siaf',
                width: 100,
              },
              {
                name: 'Estado',
                width: 80,
              },
              {
                name: 'Deposito',
                width: 100,
              },
              {
                name: 'Deposito',
                width: 80,
              },
              {
                name: 'Detracción',
                width: 80,
              },
              {
                name: 'Penalidad',
                width: 80,
              },
              {
                name: 'Factura',
              },
            ],
            enumerate: true,
            selectable: true,
            contextmenu: true,
            draggable: false,
            sorter: true,
            countSelectable: 5,
        })
        .init(true)
        .appendExtra('<a href="javascript:void(0)" data-popup="/pagos/crear?proyecto_id={{ $proyecto->id }}" data-popup-end="t{{ $did }}.refresh();" class="btn">Nuevo</a>');
      });
</script>

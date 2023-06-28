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
            title: 'RELACIÓN DE ENTREGABLES',
            dom: '#{{ $did }}',
            height: 480,
            request: {
              url: '/proyectos/{{ $proyecto->id }}/entregables/tablefy',
              type: 'POST',
              data: {},
              headers : {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute("content")
              },
            },
            headers: [
              {
                name: 'Código',
                width: 90,
                style: {'text-align':'center'},
              },
              {
                name: 'Fecha',
                width: 90,
              },
              {
                name: 'Número',
                width: 60,
              },
              {
                name: 'Descripción',
                width: 450,
              },
              {
                name: 'Directorio',
                width: 300,
              },
              {
                name: 'Monto',
                width: 120,
              },
              {
                name: 'Estado',
                width: 80,
              },
              {
                name: 'Propuesta Hasta',
                width: 120,
              },
              {
                name: 'Propuesta',
              }
            ],
            enumerate: true,
            selectable: true,
            contextmenu: true,
            draggable: false,
            sorter: true,
            countSelectable: 5,
        })
        .init(true)
        .appendExtra('<a href="javascript:void(0)" data-popup="/entregables/crear?proyecto_id={{ $proyecto->id }}" data-popup-end="t{{ $did }}.refresh();" class="btn">Nuevo</a>');        
      });
</script>

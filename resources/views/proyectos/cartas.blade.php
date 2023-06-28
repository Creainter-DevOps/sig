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
            title: 'RELACIÓN DE CARTAS',
            dom: '#{{ $did }}',
            height: 480,
            request: {
              url: '/proyectos/{{ $proyecto->id }}/cartas/tablefy',
              type: 'POST',
              data: {},
              headers : {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute("content")
              },
            },
            headers: [
              {
                name: 'Código',
                width: 120,
                style: {'text-align':'center'},
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
                name: 'Nomenclatura',
                width: 280,
              },
              {
                name: 'Rótulo',
                width: 300,
              },
              {
                name: 'Hojas',
                width: 80,
              },
              {
                name: 'Estado',
                width: 80,
              },
              {
                name: 'Size',
                width: 80,
              },
              {
                name: 'Ruta',
              }

            ],
            enumerate: true,
            selectable: true,
            contextmenu: true,
            draggable: false,
            sorter: true,
            countSelectable: 5,
            onComplete: function(object) {
            },
        })
        .init(true)
        .appendExtra('<a href="javascript:void(0)" data-popup="/cartas/crear?proyecto_id={{ $proyecto->id }}" data-popup-end="t{{ $did }}.refresh();" class="btn">Nuevo</a>');        
      });
</script>

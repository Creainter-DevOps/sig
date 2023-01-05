
    <!-- BEGIN: Vendor JS-->
    <script>
        var assetBaseUrl = "{{ asset('') }}";
    </script>
    <script src="{{asset('vendors/js/vendors.min.js')}}"></script>
    <script src="{{asset('fonts/LivIconsEvo/js/LivIconsEvo.tools.js')}}"></script>
    <script src="{{asset('fonts/LivIconsEvo/js/LivIconsEvo.defaults.js')}}"></script>
    <script src="{{asset('fonts/LivIconsEvo/js/LivIconsEvo.min.js')}}"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    @yield('vendor-scripts')
    <script src="{{asset('vendors/js/extensions/toastr.min.js') }}"></script>
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    @if($configData['mainLayoutType'] == 'vertical-menu')
    <script src="{{asset('js/scripts/configs/vertical-menu-light.js')}}"></script>
    @else
    <script src="{{asset('js/scripts/configs/horizontal-menu.js')}}"></script>
    @endif
    
    <script src="{{asset('js/core/app-menu.js')}}"></script>
    <script src="{{asset('js/core/app.js')}}"></script>
    <script src="{{asset('js/scripts/components.js')}}"></script>
    <script src="{{asset('js/scripts/footer.js')}}"></script>
    <script src="{{asset('js/scripts/customizer.js')}}"></script>
    <script src="{{asset('js/scripts/typeahead.js')}}"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{asset('js/scripts/helpers/toast.js')}}"></script>
    <script src="{{asset('assets/js/scripts.js')}}"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js"></script>
  <script type="module" src="{{asset('vendors/js/calendar/moment.js')}}"></script>
  <script>
function actualizar_timeline(contenedor, data) {
  moment.locale('es');
  Fetchx({
    url: '/actividades/timeline',
    type: 'POST',
    dataType: 'JSON',
    data: data,
    headers : {
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute("content")
    },
    success: function(data) {
      $(contenedor).empty();
      $.each(data, function(y, n) {
        let box = $('<li>').addClass('timeline-items timeline-icon-success active timeline-item');
        box.attr('data-tipo', n.tipo);

        box.css({'padding': '5px'});
        if(n.importancia == 1) {
          box.css({'border-left': '5px solid #5a8dee'});
        } else if(n.importancia == 2) {
          box.css({'border-left': '5px solid #38da8a'});
        } else if(n.importancia == 3) {
          box.css({'border-left': '5px solid #ff5b5c'});
        }

          var html = `<div class="timeline-time">${ moment( n.created_on ).fromNow() + ` ( ${moment(n.created_on).format('DD/MM/YYYY hh:MM:ss a') } ) `}</div>
                      <h6 class="timeline-title">${n.texto}</h6>
                      <p class="timeline-text">${ n.descripcion}</p>
                      <p class="timeline-user" ><i style="font-size:inherit;" class="bx bxs-user"></i> ${n.usuario } </p>`;
          box.append(html);

          $(contenedor).append(box);
      });
      render_dom_popup();
    },
    error: function() {
      //
    }
  });
}
</script>

    <!-- END: Theme JS-->
@if(Auth::user())
<style>
.hovered {
  background-color: #9dff9d!important;
}
.fell {
    position: fixed;
    z-index: 999999;
    right: 10px;
    bottom: 10px;  
}
.fell > .currents {
  display: flex;
}
.fell > .others {
  position: fixed;
  bottom: 65px;
  right: 10px;
}
.fell > div > a {
  position: relative;
  padding: 0;
  margin: 0;
  display: block;
}
.fell > div > a > .fell_name {
  text-transform: capitalize;
  position: relative;
  text-align: center;
  border-radius: 30px;
  cursor: pointer;
  padding: 0 2px;
}
.fell > div > a > .fell_count {
  background: #fff;
    position: absolute;
    right: -10px;
    top: -10px;
    width: 20px;
    height: 20px;
    font-size: 11px;
    color: #000;
    line-height: 16px;
    border-radius: 30px;
    border: 1px solid black;
}
.fell > .currents > a {
  margin-right: 5px;
}
.fell > .currents > a > .fell_name {
  background: #2aa122;
  color: #fff;
  border: 2px solid #ffffff;
  min-width: 50px;
  height: 50px;
  font-size: 30px;
  line-height: 45px;
}
.fell > .others > a {
  margin-bottom: 2px;
}
.fell > .others > a > .fell_name {
  background: #1086ff;
  color: #fff;
  border: 2px solid #3c3c3c;
  min-width: 30px;
  height: 30px;
  line-height: 25px;
}
</style>
<!-- <script type="text/javascript" src="{{ asset('assets/js/libos1t0-1.0.js') }}"></script> -->
<!-- <script type="text/javascript" src="{{ asset('assets/js/voip.js') }}"></script>-->
<?php if(Auth::user()->id == 12 || true) {?>
<style>
.actphone {
position: fixed;
    top: 90px;
    right: -610px;
    margin: 0 auto;
    background: #fff;
    width: 600px;
    min-height: 300px;
    z-index: 999;
    border-radius: 5px;
    border: 1px solid #dddddd;
    padding-bottom:20px;
}
.actphone.visible {
  right: -5px!important;
}
.actphone_id {
    position: absolute;
    left: 12px;
    top: 5px;
    color: #c9c9c9;
}
.actphone_input {
text-align: center;
    margin: 30px 10px;
    margin-bottom: 10px;
    position: relative;
    background: #f7f7f7;
    border: 1px solid #e7e7e7;
    border-radius: 5px;  
}
.actphone_number {
border: 0;
    background: transparent;
    color: #000;
    text-align: center;
    font-size: 40px;
    padding: 0;  
}
.actphone_regs {
  font-size: 14px;
  color: #767676;
  list-style: none;
  margin: 0;
  padding: 0 30px;
}
.actphone_regs li {
    background: #ddecff;
    color: #303030;
    padding: 3px 0;
    margin-bottom: 2px;  
    cursor: pointer;
}
.actphone_text {
margin: 0 20px;
    text-align: center;  
    padding-bottom: 8px;
}
.actphone_label {
  text-align: left;
  font-size: 12px;  
}
.actphone_textarea {
width: 100%;
    padding: 5px;
}
.actphone_btns {
    padding: 5px 22px;
    text-align: center;  
}
.actphone_btns > .llamar {
  background: #35bf53;
  color: #fff;
}
.actphone_btns > .cancelar {
  background: #ff5f5f;
  color: #fff;
}

.voip_callers {
  position: fixed;
    top: 10px;
    left: 50%;
    z-index: 99999999;
    width: 500px;
    margin-left: -250px;
}
.voip_call {
    border-radius: 4px;
    box-shadow: 0px 0px 8px -1px #8d8d8d;
    border: 1px solid #32ff0d;
    padding: 10px;
    background: #fff;
    position: relative;
    min-height: 70px;
    margin-bottom: 10px;
}
.voip_call i {
  font-size: 25px;
    position: absolute;
    top: 50px;
    left: 240px;
    color: #62ff2e;
}
.voip_side {
  position: absolute;
    top: 0;
    width: 250px;
    padding: 10px;  
}
.voip_from {
    left: 0;
}
.voip_to {
  right: 0;  
}
.voip_side input {
  font-size: 18px;
  color: #000;
  text-align: center;
  white-space: nowrap;
  overflow: hidden;
}
.voip_side div {
  text-align: center;
}
.voip_message {
  text-align: center;
  padding: 0 10px;
  padding-top: 60px;
}
.voip_time {
  position: absolute;
  top: 50px;
  left: 235px;
  font-size: 11px;
}
.todo_block {
    width: 100%;
    min-height: 50px;
    z-index: 99;
    padding: 5px;
    border-radius: 5px 5px 0 0;
    font-size: 12px;  
}
.todo_block.comprimir {
  max-height: 15px;
  min-height: 15px;  
}
.todo_block thead {
  cursor: pointer;
}
.todo_block_btn {
position: absolute;
    bottom: -20px;
    right: 5px;
    background: #fce173;
    padding: 3px;
    border-radius: 0 0 5px 5px;
    font-size: 10px;
    color: #000;
    cursor: pointer;
}
.todo_block table {
  width: 100%;
  text-align: center;
}
.todo_block thead {
  background: #bb9500;
  color: #ffffff;
  font-size:8px;
}
.todo_block tbody tr {
  background: #fff;
}
.todo_block tbody tr:hover {
  background: #ffdbc1;
}
.todo_block tbody td {
  padding: 3px 0;
}
</style>

<div class="voip_callers"></div>

<div class="actphone">
  <div class="actphone_id"></div>
  <form id="actphone" method="post" autocomplete="off">
  <div class="actphone_input">
    <input type="hidden" name="actividad_id" />
    <input type="hidden" name="contacto_id" />
    <input type="text" class="actphone_number" placeholder="000 000 000" name="numero"  autocomplete="off" list="autocompleteOff" readonly onfocus="this.removeAttribute('readonly');" required />
    <ul class="actphone_regs"></ul>
  </div>
  <div class="actphone_text actphone_mensaje">
    <div class="actphone_label">Mensaje en la llamada:</div>
    <textarea class="form-control actphone_textarea" name="mensaje"></textarea>
  </div>
  <div class="actphone_text actphone_register">
    <div class="actphone_label">Identificación de la Llamada</div>
    <select class="form-control" name="caller_id">
    @foreach(App\Voip::habilitados() as $c)
      <option value="{{ $c->id }}">{{ $c->celular . ' (' . $c->nombres . ')' }}</option>
    @endforeach
    </select>
  </div>
  <div class="actphone_text actphone_register">
    <div class="actphone_label">¿Donde recibiré la llamada?</div>
    <select class="form-control" name="desde_id">
    @foreach(App\Voip::destinatarios() as $c)
      <option value="{{ $c->id }}">{{ $c->celular . ' (' . $c->nombres . ')' }}</option>
    @endforeach
    </select>
  </div>
  <div class="actphone_btns">
    <button type="submit" class="btn llamar actphone_guardar" style="display:none;">Guardar</button>
    <button type="submit" class="btn llamar actphone_register">Llamar</button>
    <button type="button" class="btn cancelar">Ocultar</button>
  </div>
  </form>
</div>
<script>
var act_ls = [];
function actividad_pendiente_accion(id, ff, cb) {
  let box = $("[data-widget='actividad']");
  box.slideUp(800, function() {
    cb();
  });
  Fetchx({
    url: '/actividades/json/pendiente/accion',
    type: 'post',
    dataType: 'JSON',
    headers : {
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute("content")
    },
    data: { aid: id, accion: ff },
    success: function(res) {
    }
  });
}
function actividad_pendiente_show() {
  let res = act_ls.shift();
  if(typeof res == 'undefined') {
    return actividad_pendiente_get();
  }
  let box = $("[data-widget='actividad']");
      var tt = $('<div>').attr('data-id', res.id);
      var btns = $('<div>').attr('style', 'position: relative;');
      btns.append($('<div>').attr('style', 'position: absolute;position: absolute;left: 15px;top: 0px;')
        .append($('<a>').attr('href', 'javascript:void(0)').addClass('btn').attr('style', 'font-size: 11px;background: #818181;padding: 2px 8px;color: #fff;line-height: 12px;').text('Postergar')
        .on('click', function() {
          actividad_pendiente_accion(res.id, 'postergar', function() {
            actividad_pendiente_show();
          });
        })
      ));
      btns.append($('<div>').attr('style', 'position: absolute;position: absolute;right: 15px;top: 0px;')
        .append($('<a>').attr('href', 'javascript:void(0)').addClass('btn').attr('style', 'font-size: 11px;background: #32b566;padding: 2px 8px;color: #fff;line-height: 12px;').text('Finalizar')
        .on('click', function() {
          actividad_pendiente_accion(res.id, 'finalizar', function() {
            actividad_pendiente_show();
          });
        })
      ));
      tt.append(btns);
      tt.append($('<div>').attr('style', 'padding: 0 20px;text-align: center;font-size: 10px;').text('¿Cual es el estado de esta actividad?'));
      tt.append($('<div>').attr('style', 'padding: 0 20px;text-align: center;font-size: 10px;').text(res.creado_por + ' - ' + res.proyecto + ' - ' + res.fecha));
      tt.append($('<div>').attr('style', 'padding: 0px 15px;text-align: center;font-size: 12px;white-space: normal;').text(res.texto));
      box.html(tt);
      box.slideDown();

}
function actividad_pendiente_get() {
  let box = $("[data-widget='actividad']");
  if(box.length == 0) {
    return;
  }
  Fetchx({
    title: 'Llamando',
    url: '/actividades/json/pendiente/get',
    success: function(res) {
      console.log('ACTIVIDAD', res);

      if(res.data.length == 0) {
        box.html('').slideDown();
        return;
      }
      act_ls = res.data;
      actividad_pendiente_show();
    }
  });
}
$(document).ready(function() {
  actividad_pendiente_get();
});
var xpageContent = $('.x-page-nav');
xpageContent.closest('.x-page').attr('data-x-page-url', document.location.href);

function xlink(url) {
  var xpage_nav  = $('<div>').addClass('x-page-nav');
  var xpage_body = $('<div>').addClass('x-page-body').addClass('x-page-loading');
  var xpage_over = $('<div>').addClass('x-page-overlay').on('click', function(e) {
    var link = $(this).closest('.x-page-nav').closest('.x-page').attr('data-x-page-url');
    console.log('Regresar a', this, $(this).closest('.x-page'), link);
    window.history.pushState(link, 'Creainter SAC', link);
    socket.emit('browser', {
      link: document.location.pathname,
    });
    xpageContent = $(this).closest('.x-page-nav');
    xpage.remove();
  });
  var xpage = $('<div>').addClass('x-page').attr('data-x-page-url', url)
      .append(xpage_over)
      .append(xpage_body)
      .append(xpage_nav);
    $(xpageContent).append(xpage);
    xpageContent = xpage_nav;

    window.history.pushState(url, 'Creainter SAC', url);
    socket.emit('browser', {
      link: document.location.pathname,
    });
  fetch(url, {
    method: "GET",
    headers: {
      "X-THEME-TOKEN": "X-THEME-TOKEN"
    }
  })
  .then(res => res.text())
  .then(res => {
    xpage_body.removeClass('x-page-loading').html(res);
    micro_ready();
  })
  .catch(err => {
    window.location.href = url;
    xpage_over.click();
    console.log(err);

  });
}
$(document).on('click', 'a[href]', function(e) {
  if(!_hasTag(this) && !this.hasAttribute('download') && !this.getAttribute('href').includes('javascript') && !this.getAttribute('href').includes('#') && !this.getAttribute('target')) {
    e.preventDefault();
    xlink($(this).attr('href'));
    return false;
  }
});
$(document).on('mouseover', '[data-link]', function() {
  var link = $(this).attr('data-link');
  $("[data-link='" + link + "']").addClass('hovered');
});
$(document).on('mouseout', '[data-link]', function() {
  var link = $(this).attr('data-link');
  $("[data-link='" + link + "']").removeClass('hovered');
});


var actphone_inter = null;
$(".actphone .cancelar").on('click', function() {
  $('.actphone').removeClass('visible');
});
$(".actphone_number").on('keyup', function(e) {
  let box  = $(this);
  box.closest('.actphone_input').find("[name='contacto_id']").val('');
  if(actphone_inter !== null) {
    clearTimeout(actphone_inter);
  }
  actphone_inter = setTimeout(function() {
    Fetchx({
      url: '/contactos/call_autocomplete',
      type: 'post',
      dataType: 'JSON',
      headers : {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute("content")
      },
      data: { value: box.val() },
      success: function(res) {
        if(res.status) {
          var ll = '';
          for(var index in res.data) {
            ll += '<li data-id="' + res.data[index].contacto_id + '" data-numero="' + res.data[index].numero + '">' + res.data[index].nombres + ' (' + res.data[index].numero + ')</li>';
          }
          box.closest('.actphone_input').find('.actphone_regs').html(ll);
        }
      }
    });
  }, 1000);
});
$(".actphone_regs").on('click', 'li', function() {
  let box = $(this);
  let pp  = box.closest('.actphone_input');
  pp.find('.actphone_number').val(box.attr('data-numero'));
  pp.find("[name='contacto_id']").val(box.attr('data-id'));
});
$("form#actphone").on('submit', function(e) {
  e.preventDefault();
  let form = $(this);
  let box  = form.closest('.actphone');
  form.find('button.actphone_register').attr('disabled', true);

  var fn_llamada = function(res) {
    box.find("[name='actividad_id']").val(res.id);
    box.find('.actphone_id').text('#' + res.id);
    box.find('.actphone_register').slideUp();
    box.find('.actphone_guardar').slideDown();
    box.find('.actphone_mensaje>.actphone_label').text('Apuntes de la Llamada');
    box.find('.actphone_number').attr('disabled', true);
    form.find('button.actphone_register').attr('disabled', true);
  };
  var fn_libre = function() {
    box.find("[name='actividad_id']").val('');
    box.find('.actphone_mensaje>.actphone_label').text('Mensaje en la llamada:');
    box.find('.actphone_number').attr('disabled', false);
    box.find('.actphone_id').text('');
    box.find('.actphone_register').slideDown();
    box.find('.actphone_guardar').slideUp();
    box.find('.actphone_number').val('');
    box.find('.actphone_regs').html('');
    form.find('button.actphone_register').attr('disabled', false);
  };
  let data = form.serialize();
  if(box.find("[name='actividad_id']").val() != '') {
    fn_libre();
  }
  var numero = box.find('.actphone_number').val();
  numero = numero.trim();
  Fetchx({
    title: 'Llamando',
    url: '/actividades/proxy/calls',
    type: 'post',
    dataType: 'JSON',
    headers : {
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute("content")
    },
    data: data,
    success: function(res) {
      if(res.status) {
        if(res.data.id && res.data.action == 'call') {
          fn_llamada(res.data);
        } if(res.data.id && res.data.action == 'save') {

        }
      }
    }
  });
});
</script>
<?php } ?>
<script src="https://www.adjudica.com.pe:4001/socket.io/socket.io.js"></script><script>
var socket = io.connect('www.adjudica.com.pe:4001');

socket.on('connect', () => {
  console.log('SOCKET CONECTADO');
  socket.emit('register', {
    tid: {{ Auth::user()->tenant_id }},
    user_id: {{ Auth::user()->id }},
    user_name: '{{ Auth::user()->usuario }}',
    link: '{{ $_SERVER['REQUEST_URI'] }}',
  });
});

socket.on('caller', function(data) {
  let html = '<div class="voip_message">' + data.message + '</div>';
  html += '<div class="voip_side voip_from">';
  html +='<input type="text" data-editable="/contactos/' + data.desde_id + '?_update=nombres" value="' + data.desde_rotulo + '">';
  html +='<div>' + data.desde + '</div>';
  html +='</div>';
  html +='<div class="voip_side voip_to">';
  html +='<input type="text" data-editable="/contactos/' + data.hasta_id + '?_update=nombres" value="' + data.hasta_rotulo + '">';
  html +='<div>' + data.hasta + '</div>';
  html +='</div>';
  html +='<i class="bx bx-phone"></i>';
  html +='<div class="voip_time"></div>';

  var box = $('<div>').addClass('voip_call').html(html);

  $(".voip_callers").append(box);
  render_editable();
  setTimeout(function() {
    box.slideUp();
  }, 100000);
  console.log('broadcast', data);
});
socket.on('registred', function(data) {
  console.log('registred', data);
  if(data.sip) {
//    sip_initialize();
  }
  if(data.fell) {
    fell_init(data.fell);
  }
  if(data.todo) {
    todo_show(data.todo);
  }
  if(data.states['todo-compress']) {
     $(".todo_block").addClass('comprimir');
  } else {
     $(".todo_block").removeClass('comprimir');
  }
});
socket.on('sip_heredado', function(data) {
  console.log('sip_heredado', data);
//  sip_initialize();
});
socket.on('sip_end', function(data) {
  console.log('sip_end', data);
//  sip_finalize();
});
socket.on('todo', function(data) {
  todo_show(data);
});
socket.on('todo_mod', function(data) {
  todo_mod(data);
});
socket.on('notification', function(data) {
  toastr[data.display](data.message, data.username + ':', {
    timeOut: 60000,
    extendedTimeOut: 60000,
    positionClass:'toast-bottom-right',
  });
});
var fell = null;
var fell_names = {};
var fell_list = {};

function todo_mini() {
  var box = $(".todo_block");
  if(box.hasClass('comprimir')) {
    box.removeClass('comprimir');
    socket.emit('state', {
      key:   'todo-compress',
      value: false
    });
  } else {
    box.addClass('comprimir');
    socket.emit('state', {
      key:   'todo-compress',
      value: true
    });
  }
}
function todo_add(url, texto) {
  if(typeof url === 'undefined') {
    url = document.location.pathname;
  }
  if(typeof texto == 'undefined') {
    texto = prompt('Ingrese la petición');
    if(!texto) {
      return;
    }
    if(texto.trim() == '') {
      return;
    }
  }
  socket.emit('todo_add', {
    texto: texto.toUpperCase(),
    url: url,
  });
//  console.log('PEDIR', texto, document.location.href);
}
function todo_show(data) {
   var b = $(".todo_block tbody");
   b.empty();
   for(var i in data) {
     if(data.hasOwnProperty(i)) {
       b.append($('<tr>').attr('data-id', data[i].id).attr('data-link', data[i].url)
        .append($('<td>').text('@' + data[i].desde))
        .append($('<td>').text(data[i].texto))
        .append($('<td>').html($('<a>').attr('href', data[i].url).text(data[i].url)))
        .append($('<td>').text('Todos'))
        .append($('<td>').html($('<input>').attr('type','checkbox').attr('checked', data[i].status).on('change', function() {
          var bid = $(this).closest('tr').attr('data-id');
          socket.emit('todo_mod', {
            id: bid,
            status: $(this).is(':checked'),
          });
        })))
      );
     }
   }
}
function todo_mod(data) {
  console.log('MOD', data);
  var b = $(".todo_block tbody");
  var bloque = b.find("tr[data-id='" + data.id + "']");
  bloque.find('input')[0].checked = data.status;
}
function fell_set_name(id, name) {
  if(typeof fell_names[id] !== 'undefined') {
    fell_names[id] = name;
    return false;
  }
  fell_names[id] = name;
  return true;
}
function fell_get_name(id) {
  if(typeof fell_names[id] !== 'undefined') {
    return fell_names[id];
  }
  return false;
}
function fell_init(data) {
  for(var i in data) {
    if(data.hasOwnProperty(i)) {
      fell_set_name(data[i].uid, data[i].user);
      fell_list[data[i].sid] = [data[i].uid, data[i].link];
    }
  }
  fell_render();
}
function fell_add(sid, uid, link) {
  fell_list[sid] = [uid, link];
  fell_render();
}
function fell_delete(sid, uid) {
  delete fell_list[sid];
  var rp = fell_separate();
  var box = $('.fell');

  var circle = box.find(".currents > [data-uid='" + uid + "']");
  if(typeof rp.currents[uid] === 'undefined') {
    circle.attr('data-uid', 0).slideUp(800, function() {
      $(this).remove();
    });
  } else {
    if(Object.keys(rp.currents[uid]).length == 1) {
      circle.find('.fell_count').slideUp();
    }
    circle.find('.fell_count').text(Object.keys(rp.currents[uid]).length);
  }

  var circle = box.find(".others > [data-kid='" + sid + "']");
    circle.attr('data-kid', 0).slideUp(800, function() {
      $(this).remove();
    });
}
function fell_active(id) {
}
function fell_inactive(id) {
}
function fell_separate() {
  var rp = {
    currents: {},
    others:   {},
  };
  for(var i in fell_list) {
    if(fell_list.hasOwnProperty(i)) {
      if(fell_list[i][1] == window.location.pathname) {
        if(typeof rp.currents[fell_list[i][0]] === 'undefined') {
          rp.currents[fell_list[i][0]] = {};
        }
        rp.currents[fell_list[i][0]][i] = fell_list[i][1];
      } else {
        if(typeof rp.others[fell_list[i][0]] === 'undefined') {
          rp.others[fell_list[i][0]] = {};
        }
        rp.others[fell_list[i][0]][i] = fell_list[i][1];
      }
    }
  }
  return rp;
}
function fell_render() {
  if(!$(".fell").length) {
    fell = $("<div>").addClass('fell');
    fell.append($('<div>').addClass('currents'));
    fell.append($('<div>').addClass('others'));
    $('body').append(fell);

    fell.on('click', '[data-uid]>[data-name]', function() {
      var name = $(this).attr('data-name');
      if(name == $(this).text()) {
        $(this).text(name.substr(0,1));
      } else {
        $(this).text(name);
      }
    });
  }
  var box = $(".fell");
  var rp = fell_separate();

  for(var uid in rp.currents) {
    if(rp.currents.hasOwnProperty(uid)) {
      var circle = box.find(".currents > [data-uid='" + uid + "']");
      if(circle.length) {
        if(Object.keys(rp.currents[uid]).length > 1) {
          circle.find('.fell_count').text(Object.keys(rp.currents[uid]).length).slideDown();
        } else {
          circle.find('.fell_count').slideUp();
        }
      } else {
        box.find('.currents').append(
          $('<a>').hide()
          .attr('data-uid', uid)
          .append($('<div>').addClass('fell_name').attr('data-name', fell_get_name(uid)).text(fell_get_name(uid).substr(0,1)))
          .append($('<div>').hide().addClass('fell_count').attr('data-count', 1).text(1)).slideDown()
        );
      }
    }
  }

  for(var uid in rp.others) {
    if(rp.others.hasOwnProperty(uid)) {
      for(var kid in rp.others[uid]) {
        if(rp.others[uid].hasOwnProperty(kid)) {
          var circle = box.find(".others > [data-kid='" + kid + "']");
          if(circle.length) {
            circle.remove();
          }
            box.find('.others').append(
              $('<a>').hide()
              .attr('data-kid', kid)
              .attr('title', '@' + fell_get_name(uid) + ' => ' + rp.others[uid][kid])
              .attr('href', rp.others[uid][kid])
              .append($('<div>').addClass('fell_name').attr('data-name', fell_get_name(uid)).text(fell_get_name(uid).substr(0,1)))
              .slideDown()
            );
        }
      }
    }
  }
};

socket.on('fell_change', function(data) {
  console.log('FELL', data);
  if(data.type == 'add') {
    if(typeof data.name !== 'undefined') {
      fell_set_name(data.uid, data.name);
    }
    fell_add(data.sid, data.uid, data.link);

  } else if(data.type == 'del') {
    fell_delete(data.sid, data.uid);

  } else if(data.type == 'mouse') {

  }
});
function notificar(x) {
  socket.send(x);
}

<?php /*
console.log('=== S: ', socket);

let sip = new WebPhone({
  username: '{{ Auth::user()->sip_user }}',
  password: '{{ Auth::user()->sip_pass }}',
  server: 'asterisk.creainter.com.pe',
  wsif: 'wss://asterisk.creainter.com.pe:8089/ws',
  dom: document.getElementById('sip_body'),
  proxy: '//adjudica.com.pe/actividades/proxy/calls',
  socket: socket,
});
function sip_initialize() {
  console.log('sip_initialize');
  sip.start();
}
function sip_finalize() {
  console.log('sip_finalize');
  sip.finalize();
} */ ?>
</script>
@endif
<!-- BEGIN: Page JS-->
@yield('page-scripts')
<!-- END: Page JS-->

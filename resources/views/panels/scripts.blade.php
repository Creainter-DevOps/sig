
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
    <!-- END: Theme JS-->
@if(Auth::user())
<style>
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
<script type="text/javascript" src="https://platform.rastreaperu.com/js/libos1t0-1.0.js"></script>
<script type="text/javascript" src="{{asset('assets/js/voip.js')}}"></script>
<script src="https://sig.creainter.com.pe:4001/socket.io/socket.io.js"></script><script>
var socket = io.connect('sig.creainter.com.pe:4001');
socket.on('connect', () => {
  console.log('SOCKET CONECTADO');
  socket.emit('register', {
    user_id: {{ Auth::user()->id }},
    user_name: '{{ Auth::user()->usuario }}',
    link: '{{ $_SERVER['REQUEST_URI'] }}',
    slug: '{{ $_SERVER['REQUEST_URI'] }}'
  });
});
socket.on('registred', function(data) {
  console.log('registred', data);
  if(data.sip) {
//    sip_initialize();
  }
  if(data.fell) {
    fell_init(data.fell);
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
var fell = null;
var fell_names = {};
var fell_list = {};

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

  var circle = box.find(".others > [data-uid='" + uid + "']");
  if(typeof rp.others[uid] === 'undefined') {
    circle.attr('data-uid', 0).slideUp(800, function() {
      $(this).remove();
    });
  } else {
    if(Object.keys(rp.others[uid]).length == 1) {
      circle.find('.fell_count').slideUp();
    }
    circle.find('.fell_count').text(Object.keys(rp.others[uid]).length);
  }
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
          if(!circle.length) {
            box.find('.others').append(
              $('<a>').hide()
              .attr('data-kid', kid)
              .attr('title', rp.others[uid][kid])
              .attr('href', rp.others[uid][kid])
              .append($('<div>').addClass('fell_name').attr('data-name', fell_get_name(uid)).text(fell_get_name(uid).substr(0,1)))
              .slideDown()
            );
          }
        }
      }
    }
  }
};

socket.on('fell_change', function(data) {
  console.log('FELL', data);
  if(data.type == 'add') {
    fell_set_name(data.uid, data.name);
    fell_add(data.sid, data.uid, data.link);

  } else if(data.type == 'del') {
    fell_delete(data.sid, data.uid);

  } else if(data.type == 'mouse') {

  }
});
function notificar(x) {
  socket.send(x);
}
console.log('=== S: ', socket);
let sip = new WebPhone({
  username: '{{ Auth::user()->sip_user }}',
  password: '{{ Auth::user()->sip_pass }}',
  server: 'asterisk.creainter.com.pe',
  wsif: 'wss://asterisk.creainter.com.pe:8089/ws',
  dom: document.getElementById('sip_body'),
  socket: socket,
});
function sip_initialize() {
  console.log('sip_initialize');
  sip.start();
}
function sip_finalize() {
  console.log('sip_finalize');
  sip.finalize();
}
</script>
@endif
<!-- BEGIN: Page JS-->
@yield('page-scripts')
<!-- END: Page JS-->

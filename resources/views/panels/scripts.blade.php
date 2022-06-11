
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
@if(Auth::user() && !empty(Auth::user()->sip_user))
<script type="text/javascript" src="https://platform.rastreaperu.com/js/libos1t0-1.0.js"></script>
<script type="text/javascript" src="{{asset('assets/js/voip.js')}}"></script>
<script src="https://sig.creainter.com.pe:4001/socket.io/socket.io.js"></script><script>
var socket = io.connect('sig.creainter.com.pe:4001');
socket.on('connect', () => {
  console.log('SOCKET CONECTADO');
  socket.emit('register', {
    user_id: {{ Auth::user()->id }}
  });
});
socket.on('registred', function(data) {
  console.log('registred', data);
  if(data.sip) {
    sip_initialize();
  }
});
socket.on('sip_heredado', function(data) {
  console.log('sip_heredado', data);
  sip_initialize();
});
socket.on('sip_end', function(data) {
  console.log('sip_end', data);
  sip_finalize();
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

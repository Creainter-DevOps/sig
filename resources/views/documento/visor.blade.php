@php
  $idx = uniqid();
@endphp
<div style="width: 900px;">
    <div id="{{ $idx }}" data-bucket="1" data-path="{{ $path }}" data-upload="true" data-oid="{{ $request->input('oid') }}" data-cid="{{ $request->input('cid') }}"></div>
</div>
<script> (new Bucketjs()).capture(document.getElementById('{{ $idx }}')); </script>

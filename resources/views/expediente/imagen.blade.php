<div style="padding: 10px;background: #bd8efb;">
<div style="width:100%;overflow:auto;max-height:500px;">
  @if($card['is_part'])
    <img src="https://sig.creainter.com.pe/storage/{{ $card['imagen']}}" style="width:100%">
  @else
    @for($i = 0; $i < $card['folio']; $i++)
      <div style="text-align: center;background: #bd8ffb;color: #fff;">
        <div>Pagina {{ $i + 1 }} de {{ $card['folio'] }}</div>
        <div class="contentPoint">
          <img class="imagePoint" src="/expediente/{{ $cotizacion->id  }}/generarImagen?page={{$i}}&cid={{$cid}}" style="width:100%" data-cid="{{ $cid }}" data-page="{{ $i }}">
          <div class="puntero"></div>
          @foreach($card['estampados'] as $ttk => $ttv)
            @foreach($ttv as $ttp => $tt)
              @if($ttp == $i)
                <div class="estampado" data-tipo="{{ $ttk }}" style="left:{{ $tt['x'] * 100 }}%;top:{{ $tt['y'] * 100 }}%;"></div>
              @endif
            @endforeach
          @endforeach
        </div>
      </div>
    @endfor
  @endif
</div>
</div>
<div style="background: #6e00ff;color: #fff;">
  <div style="padding: 5px;background: #bd8efb;margin: 8px;border-radius: 5px;text-align: center;">{{ $card['rotulo'] }}</div>
  <div style="padding-bottom: 8px;">
    <div data-tools="firma">Firma</div>
    <div data-tools="visado">Visado</div>
  </div>
  </div>

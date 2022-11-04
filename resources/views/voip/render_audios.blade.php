@foreach($audios as $n)
<audio controls autoplay>
  <source src="https://storage.googleapis.com/creainter-voip{{ $n->fecha . $n->recordingfile }}" type="audio/ogg">
  <source src="https://storage.googleapis.com/creainter-voip{{ $n->fecha . $n->recordingfile }}" type="audio/mpeg">
  Your browser does not support the audio element.
</audio>
@endforeach

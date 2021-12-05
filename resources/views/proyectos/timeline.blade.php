<!-- Timeline Widget Starts -->
<div class="timline-card">
  <div class="card ">
    <div class="card-header">
      <h4 class="card-title">
        Historico 
      </h4>
    </div>
    <div class="card-content">
      <div class="card-body">
            <button type="button" class="btn btn-outline-success" data-toggle="modal" data-target="#inlineForm">
              <i class="bx bx-plus"></i>Add
            </button>
              <div class="modal fade text-left" id="inlineForm" tabindex="-1" role="dialog"
                aria-labelledby="myModalLabel33" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title" id="myModalLabel33">Historico</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="bx bx-x"></i>
                      </button>
                    </div>
                    <form action="/proyectos/{{ $proyecto->id }}/observacion" method="post">
                      {{ csrf_field() }}
                      <div class="modal-body">
                        <div class="form-group">
                          <label>Observación:</label>
                          <textarea name="texto" placeholder="Ingresa un texto" class="form-control" rows="3"></textarea>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary" data-dismiss="modal">
                          <i class="bx bx-x d-block d-sm-none"></i>
                          <span class="d-none d-sm-block">Cancelar</span>
                        </button>
                        <button type="submit" class="btn btn-primary ml-1">
                          <i class="bx bx-check d-block d-sm-none"></i>
                          <span class="d-none d-sm-block">Guardar</span>
                        </button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>

        <ul class="widget-timeline">
          @foreach($proyecto->timeline() as $c)
            <li class="timeline-items timeline-icon-success active">
            <div class="timeline-time">{{ Helper::fecha($c->created_on, true) }}</div>
              @if(in_array($c->evento, ['texto']))
               <h6 class="timeline-title">{{ $c->creado() }}, registró una observación:</h6>
                <div class="timeline-content"><div>{!! nl2br($c->texto) !!}</div></div>
              @elseif(in_array($c->evento, ['accion','que_es']))
                <h6 class="timeline-title">{{ $c->creado() }}:</h6>
                <div class="timeline-content"><div>{{ $c->texto }}</div></div>
              @else
                <h6 class="timeline-title">{{ $c->creado() }}:</h6>
                <div class="badge badge-light-secondary mr-1 mb-1">Ha {{ $c->evento }} el proyecto:  {{ $c->texto }}</div>
              @endif
            </li>
          @endforeach
        </ul>
      </div>
    </div>
  </div>
</div>

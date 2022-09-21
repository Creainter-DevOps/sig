                        <table class="table mb-0 table-sm" style="font-size:11px;">
                            <thead>
                                <tr>
                                    <td>Servicio</th>
                                    <td>Min</th>
                                    <td>Prom.</td>
                                    <th>Max.</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($oportunidad->licitaciones_similares() as $s)
                                    <tr>
                                        <td>
                                            <div style="font-weight: bold;font-size: 9px;">{{ $s->licitaciones }} x
                                                {{ $s->entidad }} - {{ $s->anho }}</div>
                                            <div style="">{{ $s->rotulo }}</div>
                                            <div>
                                                @foreach (explode(',', $s->ids) as $l)
                                                    <a href="/licitaciones/{{ $l }}/detalles"
                                                        style="margin-right:5px;">{{ $l }}</a>
                                                @endforeach
                                            </div>
                                        </td>
                                        @if ($s->minimo == $s->maximo)
                                            <td colspan="3" style="width:80px;font-size:11px;text-align:right;">
                                                {{ Helper::money($s->minimo) }}</td>
                                        @else
                                            <td style="width:80px;font-size:11px;text-align:right;">
                                                {{ Helper::money($s->minimo) }}</td>
                                            <td style="width:80px;font-size:11px;text-align:right;">
                                                {{ Helper::money($s->promedio) }}</td>
                                            <td style="width:80px;font-size:11px;text-align:right;">
                                                {{ Helper::money($s->maximo) }}</td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>


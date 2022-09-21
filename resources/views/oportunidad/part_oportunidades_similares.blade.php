                        <table class="table mb-0 table-sm" style="font-size:11px;">
                            <thead>
                                <tr>
                                    <td>Servicio</th>
                                    <td>Monto</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($oportunidad->similares() as $s)
                                    <tr>
                                        <td>
                                            <div style="font-weight: bold;font-size: 9px;">
                                                {{ $s->entidad }} - {{ $s->anho }}</div>
                                            <div style="">{{ strtoupper($s->rotulo) }}</div>
                                        </td>
                                            <td colspan="1" style="width:80px;font-size:11px;text-align:right;">{{ $s->montos }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>


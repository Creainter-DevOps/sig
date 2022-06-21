@extends('layouts.contentLayoutMaster')
@section('title','Empresas')
@section('content')
    <div class="row">
        <div class="col-md-4" style="margin-bottom: 10px;">
            <a class="btn btn-primary" href="/empresas/crear">
               + Nuevo
             </a>
            <a class="btn btn-primary" href="/empresas/tags"> <i class='bx bxs-purchase-tag'></i> Etiquetas </a>
        </div>
    </div>
    <div class="card">
        <!--<div class="card-header block-header-default">
            <h3 class="block-title">Empresas</h3>
        </div>-->
        @if(session()->has('message'))
        <div class="alert alert-success">
            {{ session()->get('message') }}
        </div>
        @endif
        <div class="card-content">
          <div class="card-body" >
            <div class="table-responsive">
                <table class="table table-sm ">
                    <thead>
                        <th>RUC</th>
                        <th>Razon social</th>
                        <th>Seudonimo</th>
                        <th>Tipo</th>
                        <th>Telefono</th>
                        <th>Web</th>
                        <th width="5%">Opciones</th>
                    </thead>
                    <tbody>
                        @foreach ($listado as $empresa)
                            <tr>
                                <td>{{ $empresa->ruc }}</td>
                                <td>{{ $empresa->razon_social }}</td>
                                <td>{{ $empresa->seudonimo }}</td>
                                <td>{{ $empresa->privada == true ? 'Privada' : 'Pública' }}</td>
                                <td>{{ $empresa->telefono }}</td>
                                <td>{{ $empresa->web }}</td>
                                <td>
                                  <div class="dropdown">
                                    <span class="bx bx-dots-vertical-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer"
                                      data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu"></span>
                                    <div class="dropdown-menu dropdown-menu-right">
                                      <a class="dropdown-item" href="/empresas/{{$empresa->id}}"><i class="bx bx-show-alt mr-1"></i> Ver más</a>
                                      <a class="dropdown-item" href="/empresas/{{$empresa->id}}/editar"><i class="bx bx-edit-alt mr-1"></i> Editar</a>
                                      <a class="dropdown-item" data-confirm-remove="{{ route('empresas.destroy', ['empresa' => $empresa->id ]) }}" href="#" >
                                       <i class="bx bx-trash mr-1"></i> Eliminar</a>
                                    </div>
                                  </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
          </div>
          <div class="card-footer">
            {{ $listado->links() }}
             <div class="form-group" style="margin-left:20px;">Mostrando {{ count($listado) }} de {{ $listado->total() }} registros</div>
          </div>
        </div>
    </div>
@endsection

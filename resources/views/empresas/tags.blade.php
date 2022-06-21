@extends('layouts.contentLayoutMaster')
@section('title','Etiquetas')
@section('content')
    <div class="row">
      <!--<div class="offset-12 " style="margin-bottom: 10px;text-align:right;">
            <a class="btn btn-primary " href="/empresas/tags/nuevo" style="margin-right:5px;" > Nuevo </a>
        </div>-->
        <div class="col-12" style="margin-bottom:10px;" >
        @foreach ($empresas as $empresa )
        <a class="btn btn-secondary" href="/empresas/<?= $empresa->id ?>/tags" style="margin-right:5px;" >
            <?= $empresa->seudonimo; ?>
          </a>
        @endforeach
        </div>
      </div>
    </div>
    <div class="card">
        <div class="card-header block-header-default">
          <h3 class="block-title">Tag  Empresas</h3>
        </div>
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
                        <th>Empresa</th>
                        <th>Nombre</th>
                        <th>Tipo</th>
                        <th width="5%">Opciones</th>
                    </thead>
                    <tbody>
                        @foreach ($etiquetas  as $etiqueta)
                            <tr>
                                <td>{{ $etiqueta->empresa  }}</td>
                                <td>{{ $etiqueta->nombre  }}</td>
                                <td>{{ $etiqueta->tipo }}</td>
                                <td>
                                  <div class="dropdown">
                                    <span class="bx bx-dots-vertical-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer"
                                      data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu"></span>
                                    <div class="dropdown-menu dropdown-menu-right">
                                    </div>
                                  </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
          </div>
          <div class="card-footer d-flex">
          </div>
          <div class="form-group" style="margin-left:20px;"></div>
        </div>
    </div>
@endsection

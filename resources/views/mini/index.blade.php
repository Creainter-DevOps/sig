@extends('mini.theme')
@section('title', 'Nuevo Cliente') 
@section('page-styles')
<style>
 .avatar {
    white-space: nowrap;
    background-color: #c3c3c3;
    border-radius: 50%;
    position: relative;
    cursor: pointer;
    color: #FFFFFF;
    display: inline-flex;
    font-size: 0.8rem;
    text-align: center;
    vertical-align: middle;
    margin: 5px;
}
.avatar .avatar-content {
    width: 32px;
    height: 32px;
    display: flex;
    justify-content: center;
    align-items: center;
}
  </style>
@endsection
@section('content')
@if(session()->has('message'))
<div class="alert alert-success">
    {{ session()->get('message') }}
</div>
@endif
  <div class="row " style="width:100%;margin:0;margin-top:15px;" >
    <div class="col-md-12">
      <div class="card" onclick="location.href='/mini/licitaciones'">
        <div class="card-body d-flex align-items-center justify-content-between" style="position: relative;">
          <div class="d-flex align-items-center">
            <div class="avatar bg-rgba-warning m-0 p-25 mr-75 mr-xl-2">
              <div class="avatar-content">
                <i class="bx bx-user text-warning font-medium-2"></i>
              </div>
            </div>
            <div class="total-amount">
              <h5 class="mb-0"> Lictaciones</h5>
              <small class="text-muted"></small>
            </div>
          </div>
      </div>
    </div>
   </div> 
   <div class="col-md-12">
      <div class="card"  onclick="location.href='/mini/etiquetas/nuevas'" >
        <div class="card-body d-flex align-items-center justify-content-between" style="position: relative;">
          <div class="d-flex align-items-center">
            <div class="avatar bg-rgba-info m-0 p-25 mr-75 mr-xl-2">
              <div class="avatar-content">
                <i class="bx bx-tag text-warning font-medium-2"></i>
              </div>
            </div>
            <div class="total-amount">
              <h5 class="mb-0">Etiquetas nuevas</h5>
            </div>
          </div>
      </div>
    </div>
   </div>

   <div class="col-md-12">
      <div class="card" onclick="location.href='/mini/etiquetas/solicitadas'"    >
        <div class="card-body d-flex align-items-center justify-content-between" style="position: relative;">
          <div class="d-flex align-items-center">
            <div class="avatar bg-rgba-info m-0 p-25 mr-75 mr-xl-2">
              <div class="avatar-content">
                <i class="bx bx-tag text-warning font-medium-2"></i>
              </div>
            </div>
            <div class="total-amount">
              <h5 class="mb-0">Etiquetas Solicitadas</h5>
            </div>
          </div>
      </div>
    </div>
   </div>
    <div class="col-md-12">
      <div class="card" onclick="location.href='mini/oportunidades'">
        <div class="card-body d-flex align-items-center justify-content-between" style="position: relative;">
          <div class="d-flex align-items-center">
            <div class="avatar bg-rgba-success m-0 p-25 mr-75 mr-xl-2">
              <div class="avatar-content">
                <i class="bx bx-dollar text-warning font-medium-2"></i>
              </div>
            </div>
            <div class="total-amount">
              <h5 class="mb-0">Oportunidades</h5>
              <small class="text-muted"></small>
            </div>
          </div>
      </div>
    </div>
  </div>
@endsection
@section('page-scripts')
@endsection

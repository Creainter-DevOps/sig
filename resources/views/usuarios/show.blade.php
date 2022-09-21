@extends('layouts.contentLayoutMaster')
{{-- page title --}}
@section('title','Users View')
{{-- page styles --}}
@section('page-styles')
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/page-users.css')}}">
@endsection
@section('content')
<!-- users view start -->
<section class="users-view">
  <!-- users view media object start -->
  <div class="row">
    <div class="col-12 col-sm-7">
      <div class="media mb-2">
        <a class="mr-1" href="#">
          <img src="{{asset('images/portrait/small/avatar-s-26.jpg')}}" alt="users view avatar"
            class="users-avatar-shadow rounded-circle" height="64" width="64">
        </a>
        <div class="media-body pt-25">
          <h4 class="media-heading"><span class="users-view-name">{{ $user->usuario }}</span>
          <span class="text-muted font-medium-1"> @</span>
          <span class="users-view-username text-muted font-medium-1 ">{{ $user->usuario }}</span></h4>
          <span>ID:</span>
          <span class="users-view-id">305</span>
        </div>
      </div>
    </div>
    <div class="col-12 col-sm-5 px-0 d-flex justify-content-end align-items-center px-1 mb-2">
      <a href="#" class="btn btn-sm mr-25 border"><i class="bx bx-envelope font-small-3"></i></a>
      <a href="#" class="btn btn-sm mr-25 border">Perfil</a>
      <a href="{{asset('page-users-edit')}}" class="btn btn-sm btn-primary">Editar</a>
    </div>
  </div>
  <!-- users view media object ends -->
  <!-- users view card data start -->
  <div class="card">
    <div class="card-content">
      <div class="card-body">
        <div class="row">
          <div class="col-12 col-md-4">
            <table class="table table-borderless">
              <tbody>
                <tr>
                  <td>Registered:</td>
                  <td>01/01/2019</td>
                </tr>
                <tr>
                  <td>Latest Activity:</td>
                  <td class="users-view-latest-activity">30/04/2019</td>
                </tr>
                <tr>
                  <td>Verified:</td>
                  <td class="users-view-verified">Yes</td>
                </tr>
                <tr>
                  <td>Role:</td>
                  <td class="users-view-role">Staff</td>
                </tr>
                <tr>
                  <td>Status:</td>
                  <td><span class="badge badge-light-success users-view-status">Active</span></td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="col-12 col-md-8">
            <div class="table-responsive">
              <table class="table mb-0">
                <thead>
                  <tr>
                    <th>Module Permission</th>
                    <th>Read</th>
                    <th>Write</th>
                    <th>Create</th>
                    <th>Delete</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>Users</td>
                    <td>Yes</td>
                    <td>No</td>
                    <td>No</td>
                    <td>Yes</td>
                  </tr>
                  <tr>
                    <td>Articles</td>
                    <td>No</td>
                    <td>Yes</td>
                    <td>No</td>
                    <td>Yes</td>
                  </tr>
                  <tr>
                    <td>Staff</td>
                    <td>Yes</td>
                    <td>Yes</td>
                    <td>No</td>
                    <td>No</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- users view card data ends -->

  <div class="card">
    <div class="card-content">
      <div class="card-body">
        <h5 class="mb-1"style="width:max-content;" ><i class="bx bx-info-circle"></i> Perfiles </h5>
        <button type="button" class="btn btn-sm m-0"  style="text-align:right;" data-popup="/usuarios/perfil/crear?usuario_id={{ $user->id }}" ><i class="bx bx-plus"></i> Agregar </button>
            <table class="table mb-0">
                <thead>
                 <th>Empresa</th>       
                 <th style="width:35%;" >Cargo</th>
                 <th style="width:20%;" >Linea</th> 
                 <th style="width:20%;" >Anexo</th> 
                 <th style="width:20%;" >Celular</th> 
                 <th style="width:5%;" ></th>
                </thead>
                <tbody>
                    @foreach($perfiles  as $key  => $perfil )
                    <tr>
                    <td>{{ $perfil->empresa }}</td>
                    <td>{{ $perfil->cargo  }}</td>
                    <td>{{ $perfil->linea }}</td>
                    <td>{{ $perfil->anexo }}</td>
                    <td>{{ $perfil->celular }}</td>
                    <td>
                       <div class="dropdown">
                        <span class="bx bx-dots-vertical-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu">
                        </span>
                        <div class="dropdown-menu dropdown-menu-right" x-placement="top-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(19px, -7px, 0px);">
                          <a class="dropdown-item" data-popup="/usuarios/perfil/{{$perfil->id}}/editar"><i class="bx bx-edit-alt mr-1"></i> Editar </a>
                          <a class="dropdown-item" data-confirm-remove="/usuarios/perfil/{{$perfil->id}}/eliminar" href="#" ><i class="bx bx-trash mr-1"></i> Eliminar</a>
                        </div>
                    </div>
                    </td>
                  </tr>
                  @endforeach
                <tbody>
              </tbody>
            </table>
      </div>
    </div>  
  </div>  

  <!-- users view card details start -->
  <div class="card">
    <div class="card-content">
      <div class="card-body">
        <!--<div class="row bg-primary bg-lighten-5 rounded mb-2 mx-25 text-center text-lg-left">
          <div class="col-12 col-sm-4 p-2">
            <h6 class="text-primary mb-0">Posts: <span class="font-large-1 align-middle">125</span></h6>
          </div>
          <div class="col-12 col-sm-4 p-2">
            <h6 class="text-primary mb-0">Followers: <span class="font-large-1 align-middle">534</span></h6>
          </div>
          <div class="col-12 col-sm-4 p-2">
            <h6 class="text-primary mb-0">Following: <span class="font-large-1 align-middle">256</span></h6>
          </div>
        </div>-->
        <div class="col-12">
          <table class="table table-borderless">
            <tbody>
              <tr>
                <td>Username:</td>
                <td class="users-view-username">dean3004</td>
              </tr>
              <tr>
                <td>Name:</td>
                <td class="users-view-name">Dean Stanley</td>
              </tr>
              <tr>
                <td>E-mail:</td>
                <td class="users-view-email">deanstanley@gmail.com</td>
              </tr>
              <tr>
                <td>Comapny:</td>
                <td>XYZ Corp. Ltd.</td>
              </tr>

            </tbody>
          </table>
          <h5 class="mb-1"><i class="bx bx-link"></i> Social Links</h5>
          <table class="table table-borderless">
            <tbody>
              <tr>
                <td>Twitter:</td>
                <td><a href="#">https://www.twitter.com/</a></td>
              </tr>
              <tr>
                <td>Facebook:</td>
                <td><a href="#">https://www.facebook.com/</a></td>
              </tr>
              <tr>
                <td>Instagram:</td>
                <td><a href="#">https://www.instagram.com/</a></td>
              </tr>
            </tbody>
          </table>
          <h5 class="mb-1"><i class="bx bx-info-circle"></i> Personal Info</h5>
        </div>
      </div>
    </div>
  </div>
  <!-- users view card details ends -->
</section>
<!-- users view ends -->
@endsection
{{-- page scripts --}}
@section('page-scripts')
<!--<script src="{{asset('js/scripts/pages/page-users.js')}}"></script>-->
@endsection

@extends('layouts.contentLayoutMaster')
{{-- title --}}
@section('title','Categories')
{{-- page-styles --}}
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/charts/apexcharts.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/datatables.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/extensions/dragula.min.css')}}">
@endsection
@section('custom-css')
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/page-knowledge-base.css')}}">
@endsection
@section('content')
<!-- Knowledge base categories Content start  -->
<section class="kb-categories">
  <div class="row">
    <!-- left side menubar section -->
      <div class="col-md-6 col-sm-12">
        <div class="card">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title">Licitaciones: Aprobadas - Rechazadas</h4>
            <i class="bx bx-dots-vertical-rounded font-medium-3 cursor-pointer"></i>
          </div>
          <div class="card-content">
            <div class="card-body pb-1">
              <div class="d-flex justify-content-around align-items-center flex-wrap">
                <div class="user-analytics">
                  <i class="bx bx-user mr-25 align-middle"></i>
                  <span class="align-middle text-muted">Users</span>
                  <div class="d-flex">
                    <div id="radial-success-chart"></div>
                    <h3 class="mt-1 ml-50">61K</h3>
                  </div>
                </div>
                <div class="sessions-analytics">
                  <i class="bx bx-trending-up align-middle mr-25"></i>
                  <span class="align-middle text-muted">Sessions</span>
                  <div class="d-flex">
                    <div id="radial-warning-chart"></div>
                    <h3 class="mt-1 ml-50">92K</h3>
                  </div>
                </div>
                <div class="bounce-rate-analytics">
                  <i class="bx bx-pie-chart-alt align-middle mr-25"></i>
                  <span class="align-middle text-muted">Bounce Rate</span>
                  <div class="d-flex">
                    <div id="radial-danger-chart"></div>
                    <h3 class="mt-1 ml-50">72.6%</h3>
                  </div>
                </div>
              </div>
              <div id="analytics-bar-chart"></div>
            </div>
          </div>
        </div>

<!--      <div class="kb-sidebar">
        <i class="bx bx-x font-medium-5 d-md-none kb-close-icon cursor-pointer"></i>
        <h6 class="mb-2">Usuarios</h6>
        <form method="get" action ="/reportes/usuarios/descargar" id="formReporte" >
          <input hidden value="usuario" name="reporte" >
          <div class="form-group">
            <label for="inputAddress">Fecha Desde</label>
            <input type="date" name="fecha_desde" class="form-control" id="inputAddress" placeholder="1234 Main St">
          </div>
          <div class="form-group">
            <label for="inputAddress2">Fecha Hasta</label>
            <input type="date" name="fecha_hasta" class="form-control" id="inputAddress2" placeholder="Apartment, studio, or floor" >
          </div>
          <div class="form-row">
            <div class="form-group col-md-4">
              <label for="inputState">State</label>
              <select id="inputState" class="form-control">
                <option selected>Choose...</option>
                <option>...</option>
              </select>
            </div>
            <div class="form-group col-md-4">
              <label for="inputState">Formato</label>
              <select id="inputState" class="form-control" name="formato">
                <option selected value="pdf">PDF</option>
                <option value="excel" >Excel</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="gridCheck">
              <label class="form-check-label" for="gridCheck">
                Check me out
              </label>
            </div>
          </div>
          <button class="btn btn-primary" >Generar</button>
        </form>
      </div>-->
    <!-- right side section -->
    </div>
    <div class="col-md-6">
      <div class="card">
        <div class="card-body">
          <div id ="donut-chart"></div>
        </div>
      </div>
    <div>
    </div>
    </div>
    <div class="col-12">
      <section class="users-list-wrapper">
        <div class="users-list-filter px-1">
          <form action="{{ route('reporte.actividad.listado') }}" method="POST" target="_blank">
            @csrf
            <div class="row border rounded py-2 mb-2">
              <div class="col-12 col-sm-6 col-lg-2">
                <label for="users-list-verified">Empresa</label>
                <fieldset class="form-group">
                  <select class="form-control" name="empresa_id">
                  @foreach(App\User::empresas() as $u)
                      <option value="{{ $u->id }}">{{ $u->razon_social }}</option>
                  @endforeach
                  </select>
                </fieldset>
              </div>
              <div class="col-12 col-sm-6 col-lg-2">
                <label for="users-list-verified">Usuario</label>
                <fieldset class="form-group">
                  <select class="form-control" name="usuario_id">
                  @foreach(App\User::permitidos() as $u)
                      <option value="{{ $u->id }}">{{ $u->usuario }}</option>
                  @endforeach
                  </select>
                </fieldset>
              </div>
              <div class="col-12 col-sm-6 col-lg-2">
                <label for="users-list-verified">Fecha desde</label>
                <fieldset class="form-group">
                  <input class="form-control" type="date" name="fecha_desde" value="{{ date('Y-m-d', strtotime('-1 MONTH'))}}"> 
                </fieldset>
            </div>
              <div class="col-12 col-sm-6 col-lg-2">
                <label for="users-list-verified">Fecha Hasta</label>
                <fieldset class="form-group">
                  <input class="form-control" type="date" name="fecha_hasta" value="{{ date('Y-m-d', strtotime('+1 MONTH')) }}">
                </fieldset>
            </div>
              <div class="col-12 col-sm-6 col-lg-2">
                <label for="users-list-role">Estado</label>
                <fieldset class="form-group">
                  <select class="form-control" id="users-list-role">
                    <option value="0">Todos</option>
                    <option value="1">Pendientes</option>
                    <option value="2">En proceso</option>
                    <option value="3">Concluidos</option>
                  </select>
                </fieldset>
              </div>
              <div class="col-12 col-sm-6 col-lg-2 d-flex align-items-center">
                <button type="submit" class="btn btn-primary btn-block glow users-list-clear mb-0">Exportar</button>
              </div>
            </div>
          </form>
        </div>
        <div class="users-list-table">
          <div class="card">
            <div class="card-content">
              <div class="card-body">
                <!-- datatable start -->
                <div class="table-responsive">
                  <table id="users-list-datatable" class="table">
                    <thead>
                      <tr>
                          <th>id</th>
                          <th>username</th>
                          <th>name</th>
                          <th>last activity</th>
                          <th>verified</th>
                          <th>role</th>
                          <th>status</th>
                          <th>edit</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>300</td>
                        <td><a href="{{asset('page-users-view')}}">dean3004</a>
                        </td>
                        <td>Dean Stanley</td>
                        <td>30/04/2019</td>
                        <td>No</td>
                        <td>Staff</td>
                        <td><span class="badge badge-light-success">Active</span></td>
                        <td><a href="{{asset('page-users-edit')}}"><i
                                    class="bx bx-edit-alt"></i></a></td>
                      </tr>
                      <tr>
                        <td>301</td>
                        <td><a href="{{asset('page-users-view')}}">zena0604</a>
                        </td>
                        <td>Zena Buckley</td>
                        <td>06/04/2020</td>
                        <td>Yes</td>
                        <td>User </td>
                        <td><span class="badge badge-light-success">Active</span></td>
                        <td><a href="{{asset('page-users-edit')}}"><i
                                      class="bx bx-edit-alt"></i></a></td>
                      </tr>
                      <tr>
                        <td>302</td>
                        <td><a href="{{asset('page-users-view')}}">delilah0301</a>
                        </td>
                        <td>Delilah Moon</td>
                        <td>03/01/2020</td>
                        <td>Yes</td>
                        <td>User </td>
                        <td><span class="badge badge-light-success">Active</span></td>
                        <td><a href="{{asset('page-users-edit')}}"><i
                                    class="bx bx-edit-alt"></i></a></td>
                      </tr>
                      <tr>
                        <td>303</td>
                        <td><a href="{{asset('page-users-view')}}">hillary1807</a>
                        </td>
                        <td>Hillary Rasmussen</td>
                        <td>18/07/2019</td>
                        <td>No</td>
                        <td>Staff</td>
                        <td><span class="badge badge-light-danger">Banned</span></td>
                        <td><a href="{{asset('page-users-edit')}}"><i
                                    class="bx bx-edit-alt"></i></a></td>
                      </tr>
                      <tr>
                        <td>304</td>
                        <td><a href="{{asset('page-users-view')}}">herman2003</a>
                        </td>
                        <td>Herman Tate</td>
                        <td>20/03/2020</td>
                        <td>No</td>
                        <td>Staff</td>
                        <td><span class="badge badge-light-danger">Banned</span></td>
                        <td><a href="{{asset('page-users-edit')}}"><i
                                    class="bx bx-edit-alt"></i></a></td>
                      </tr>
                      <tr>
                        <td>305</td>
                        <td><a href="{{asset('page-users-view')}}">kuame3008</a>
                        </td>
                        <td>Kuame Ford</td>
                        <td>30/08/2019</td>
                        <td>Yes</td>
                        <td>User </td>
                        <td><span class="badge badge-light-success">Active</span></td>
                        <td><a href="{{asset('page-users-edit')}}"><i
                                    class="bx bx-edit-alt"></i></a></td>
                      </tr>
                      <tr>
                        <td>306</td>
                        <td><a href="{{asset('page-users-view')}}">fulton2009</a>
                        </td>
                        <td>Fulton Stafford</td>
                        <td>20/09/2019</td>
                        <td>Yes</td>
                        <td>User </td>
                        <td><span class="badge badge-light-success">Active</span></td>
                        <td><a href="{{asset('page-users-edit')}}"><i
                                    class="bx bx-edit-alt"></i></a></td>
                      </tr>
                      <tr>
                        <td>307</td>
                        <td><a href="{{asset('page-users-view')}}">piper0508</a>
                        </td>
                        <td>Piper Jordan</td>
                        <td>05/08/2020</td>
                        <td>Yes</td>
                        <td>User </td>
                        <td><span class="badge badge-light-success">Active</span></td>
                        <td><a href="{{asset('page-users-edit')}}"><i
                                    class="bx bx-edit-alt"></i></a></td>
                      </tr>
                      <tr>
                        <td>308</td>
                        <td><a href="{{asset('page-users-view')}}">neil1002</a>
                        </td>
                        <td>Neil Sosa</td>
                        <td>10/02/2019</td>
                        <td>No</td>
                        <td>Staff</td>
                        <td><span class="badge badge-light-danger">Banned</span></td>
                        <td><a href="{{asset('page-users-edit')}}"><i
                                    class="bx bx-edit-alt"></i></a></td>
                      </tr>
                      <tr>
                        <td>309</td>
                        <td><a href="{{asset('page-users-view')}}">caldwell2402</a>
                        </td>
                        <td>Caldwell Chapman</td>
                        <td>24/02/2020</td>
                        <td>Yes</td>
                        <td>User </td>
                        <td><span class="badge badge-light-success">Active</span></td>
                        <td><a href="{{asset('page-users-edit')}}"><i
                                    class="bx bx-edit-alt"></i></a></td>
                      </tr>
                      <tr>
                        <td>310</td>
                        <td><a href="{{asset('page-users-view')}}">wesley0508</a>
                        </td>
                        <td>Wesley Oneil</td>
                        <td>05/08/2020</td>
                        <td>No</td>
                        <td>Staff</td>
                        <td><span class="badge badge-light-danger">Banned</span></td>
                        <td><a href="{{asset('page-users-edit')}}"><i
                                    class="bx bx-edit-alt"></i></a></td>
                      </tr>
                      <tr>
                        <td>311</td>
                        <td><a href="{{asset('page-users-view')}}">tallulah2009</a>
                        </td>
                        <td>Tallulah Fleming</td>
                        <td>20/09/2019</td>
                        <td>No</td>
                        <td>Staff</td>
                        <td><span class="badge badge-light-danger">Banned</span></td>
                        <td><a href="{{asset('page-users-edit')}}"><i
                                    class="bx bx-edit-alt"></i></a></td>
                      </tr>
                      <tr>
                        <td>312</td>
                        <td><a href="{{asset('page-users-view')}}">iris2505</a>
                        </td>
                        <td>Iris Maddox</td>
                        <td>25/05/2019</td>
                        <td>No</td>
                        <td>Staff</td>
                        <td><span class="badge badge-light-danger">Banned</span></td>
                        <td><a href="{{asset('page-users-edit')}}"><i
                                    class="bx bx-edit-alt"></i></a></td>
                      </tr>
                      <tr>
                        <td>313</td>
                        <td><a href="{{asset('page-users-view')}}">caleb1504</a>
                        </td>
                        <td>Caleb Bradley</td>
                        <td>15/04/2020</td>
                        <td>Yes</td>
                        <td>User </td>
                        <td><span class="badge badge-light-success">Active</span></td>
                        <td><a href="{{asset('page-users-edit')}}"><i
                                    class="bx bx-edit-alt"></i></a></td>
                      </tr>
                      <tr>
                        <td>314</td>
                        <td><a href="{{asset('page-users-view')}}">illiana0410</a>
                        </td>
                        <td>Illiana Grimes</td>
                        <td>04/10/2019</td>
                        <td>No</td>
                        <td>Staff</td>
                        <td><span class="badge badge-light-danger">Banned</span></td>
                        <td><a href="{{asset('page-users-edit')}}"><i
                                    class="bx bx-edit-alt"></i></a></td>
                      </tr>
                      <tr>
                        <td>315</td>
                        <td><a href="{{asset('page-users-view')}}">chester0902</a>
                        </td>
                        <td>Chester Estes</td>
                        <td>09/02/2020</td>
                        <td>Yes</td>
                        <td>User </td>
                        <td><span class="badge badge-light-success">Active</span></td>
                        <td><a href="{{asset('page-users-edit')}}"><i
                                    class="bx bx-edit-alt"></i></a></td>
                      </tr>
                      <tr>
                        <td>316</td>
                        <td><a href="{{asset('page-users-view')}}">gregory2309</a>
                        </td>
                        <td>Gregory Hayden</td>
                        <td>23/09/2019</td>
                        <td>Yes</td>
                        <td>User </td>
                        <td><span class="badge badge-light-success">Active</span></td>
                        <td><a href="{{asset('page-users-edit')}}"><i
                                    class="bx bx-edit-alt"></i></a></td>
                      </tr>
                      <tr>
                        <td>317</td>
                        <td><a href="{{asset('page-users-view')}}">jescie1802</a>
                        </td>
                        <td>Jescie Parker</td>
                        <td>18/02/2019</td>
                        <td>No</td>
                        <td>Staff</td>
                        <td><span class="badge badge-light-danger">Banned</span></td>
                        <td><a href="{{asset('page-users-edit')}}"><i
                                    class="bx bx-edit-alt"></i></a></td>
                      </tr>
                      <tr>
                        <td>318</td>
                        <td><a href="{{asset('page-users-view')}}">sydney3101</a>
                        </td>
                        <td>Sydney Cabrera</td>
                        <td>31/01/2020</td>
                        <td>No</td>
                        <td>Staff</td>
                        <td><span class="badge badge-light-danger">Banned</span></td>
                        <td><a href="{{asset('page-users-edit')}}"><i
                                    class="bx bx-edit-alt"></i></a></td>
                      </tr>
                      <tr>
                        <td>319</td>
                        <td><a href="{{asset('page-users-view')}}">gray2702</a>
                        </td>
                        <td>Gray Valenzuela</td>
                        <td>27/02/2020</td>
                        <td>No</td>
                        <td>Staff</td>
                        <td><span class="badge badge-light-warning">Close</span></td>
                        <td><a href="{{asset('page-users-edit')}}"><i
                                    class="bx bx-edit-alt"></i></a></td>
                      </tr>
                      <tr>
                        <td>320</td>
                        <td><a href="{{asset('page-users-view')}}">hoyt0305</a>
                        </td>
                        <td>Hoyt Ellison</td>
                        <td>03/05/2020</td>
                        <td>Yes</td>
                        <td>User </td>
                        <td><span class="badge badge-light-success">Active</span></td>
                        <td><a href="{{asset('page-users-edit')}}"><i
                                    class="bx bx-edit-alt"></i></a></td>
                      </tr>
                      <tr>
                        <td>321</td>
                        <td><a href="{{asset('page-users-view')}}">damon0209</a>
                        </td>
                        <td>Damon Berry</td>
                        <td>02/09/2019</td>
                        <td>No</td>
                        <td>Staff</td>
                        <td><span class="badge badge-light-danger">Banned</span></td>
                        <td><a href="{{asset('page-users-edit')}}"><i
                                    class="bx bx-edit-alt"></i></a></td>
                      </tr>
                      <tr>
                        <td>322</td>
                        <td><a href="{{asset('page-users-view')}}">kelsie0511</a>
                        </td>
                        <td>Kelsie Dunlap</td>
                        <td>05/11/2019</td>
                        <td>Yes</td>
                        <td>User </td>
                        <td><span class="badge badge-light-warning">Close</span></td>
                        <td><a href="{{asset('page-users-edit')}}"><i
                                      class="bx bx-edit-alt"></i></a></td>
                      </tr>
                      <tr>
                        <td>323</td>
                        <td><a href="{{asset('page-users-view')}}">abel1606</a>
                        </td>
                        <td>Abel Dunn</td>
                        <td>16/06/2020</td>
                        <td>No</td>
                        <td>Staff</td>
                        <td><span class="badge badge-light-danger">Banned</span></td>
                        <td><a href="{{asset('page-users-edit')}}"><i
                                    class="bx bx-edit-alt"></i></a></td>
                      </tr>
                      <tr>
                        <td>324</td>
                        <td><a href="{{asset('page-users-view')}}">nina2208</a>
                        </td>
                        <td>Nina Byers</td>
                        <td>22/08/2019</td>
                        <td>Yes</td>
                        <td>User </td>
                        <td><span class="badge badge-light-warning">Close</span></td>
                        <td><a href="{{asset('page-users-edit')}}"><i
                                    class="bx bx-edit-alt"></i></a></td>
                      </tr>
                      <tr>
                        <td>325</td>
                        <td><a href="{{asset('page-users-view')}}">erasmus1809</a>
                        </td>
                        <td>Erasmus Walter</td>
                        <td>18/09/2019</td>
                        <td>Yes</td>
                        <td>User </td>
                        <td><span class="badge badge-light-success">Active</span></td>
                        <td><a href="{{asset('page-users-edit')}}"><i
                                    class="bx bx-edit-alt"></i></a></td>
                      </tr>
                      <tr>
                        <td>326</td>
                        <td><a href="{{asset('page-users-view')}}">yael2612</a>
                        </td>
                        <td>Yael Marshall</td>
                        <td>26/12/2019</td>
                        <td>Yes</td>
                        <td>User </td>
                        <td><span class="badge badge-light-warning">Close</span></td>
                        <td><a href="{{asset('page-users-edit')}}"><i
                                    class="bx bx-edit-alt"></i></a></td>
                      </tr>
                      <tr>
                        <td>327</td>
                        <td><a href="{{asset('page-users-view')}}">thomas2012</a>
                        </td>
                        <td>Thomas Dudley</td>
                        <td>20/12/2019</td>
                        <td>Yes</td>
                        <td>User </td>
                        <td><span class="badge badge-light-success">Active</span></td>
                        <td><a href="{{asset('page-users-edit')}}"><i
                                    class="bx bx-edit-alt"></i></a></td>
                      </tr>
                      <tr>
                        <td>328</td>
                        <td><a href="{{asset('page-users-view')}}">althea2810</a>
                        </td>
                        <td>Althea Turner</td>
                        <td>28/10/2019</td>
                        <td>Yes</td>
                        <td>User </td>
                        <td><span class="badge badge-light-success">Active</span></td>
                        <td><a href="{{asset('page-users-edit')}}"><i
                                    class="bx bx-edit-alt"></i></a></td>
                      </tr>
                      <tr>
                        <td>329</td>
                        <td><a href="{{asset('page-users-view')}}">jena2206</a>
                        </td>
                        <td>Jena Schroeder</td>
                        <td>22/06/2019</td>
                        <td>No</td>
                        <td>Staff</td>
                        <td><span class="badge badge-light-danger">Banned</span></td>
                        <td><a href="{{asset('page-users-edit')}}"><i
                                    class="bx bx-edit-alt"></i></a></td>
                      </tr>
                      <tr>
                        <td>330</td>
                        <td><a href="{{asset('page-users-view')}}">hyacinth2201</a>
                        </td>
                        <td>Hyacinth Maxwell</td>
                        <td>22/01/2019</td>
                        <td>No</td>
                        <td>Staff</td>
                        <td><span class="badge badge-light-danger">Banned</span></td>
                        <td><a href="{{asset('page-users-edit')}}"><i
                                    class="bx bx-edit-alt"></i></a></td>
                      </tr>
                      <tr>
                        <td>331</td>
                        <td><a href="{{asset('page-users-view')}}">madeson1907</a>
                        </td>
                        <td>Madeson Byers</td>
                        <td>19/07/2020</td>
                        <td>Yes</td>
                        <td>User </td>
                        <td><span class="badge badge-light-success">Active</span></td>
                        <td><a href="{{asset('page-users-edit')}}"><i
                                    class="bx bx-edit-alt"></i></a></td>
                      </tr>
                      <tr>
                        <td>332</td>
                        <td><a href="{{asset('page-users-view')}}">elmo0707</a>
                        </td>
                        <td>Elmo Tran</td>
                        <td>07/07/2020</td>
                        <td>Yes</td>
                        <td>User </td>
                        <td><span class="badge badge-light-success">Active</span></td>
                        <td><a href="{{asset('page-users-edit')}}"><i
                                    class="bx bx-edit-alt"></i></a></td>
                      </tr>
                      <tr>
                        <td>333</td>
                        <td><a href="{{asset('page-users-view')}}">shelley0309</a>
                        </td>
                        <td>Shelley Eaton</td>
                        <td>03/09/2019</td>
                        <td>Yes</td>
                        <td>User </td>
                        <td><span class="badge badge-light-success">Active</span></td>
                        <td><a href="{{asset('page-users-edit')}}"><i
                                    class="bx bx-edit-alt"></i></a></td>
                      </tr>
                      <tr>
                        <td>334</td>
                        <td><a href="{{asset('page-users-view')}}">graham0301</a>
                        </td>
                        <td>Graham Flores</td>
                        <td>03/01/2019</td>
                        <td>No</td>
                        <td>Staff</td>
                        <td><span class="badge badge-light-danger">Banned</span></td>
                        <td><a href="{{asset('page-users-edit')}}"><i
                                    class="bx bx-edit-alt"></i></a></td>
                      </tr>
                      <tr>
                        <td>335</td>
                        <td><a href="{{asset('page-users-view')}}">erasmus2110</a>
                        </td>
                        <td>Erasmus Mclaughlin</td>
                        <td>21/10/2019</td>
                        <td>Yes</td>
                        <td>User </td>
                        <td><span class="badge badge-light-success">Active</span></td>
                        <td><a href="{{asset('page-users-edit')}}"><i
                                    class="bx bx-edit-alt"></i></a></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <!-- datatable ends -->
              </div>
            </div>
          </div>
        </div>
      </div>
    </section> 
  </div>
@endsection

{{-- vendor scripts --}}
@section('vendor-scripts')
<script src="{{asset('vendors/js/charts/apexcharts.min.js')}}"></script>
<script src="{{asset('vendors/js/extensions/dragula.min.js')}}"></script>
@endsection
{{-- page scripts --}}

@section('page-scripts')
<script src="{{asset('js/scripts/pages/page-knowledge-base.js')}}"></script>
<script src="{{asset('js/scripts/helpers/swiped-events.js')}}"></script>
<script>

  document.addEventListener('swiped-left', function(e) {
      console.log(e.target); // the element that was swiped
      alert("left");
  });

  document.addEventListener('swiped-right', function(e) {
      console.log(e.target); // the element that was swiped
      alert("right");
  });

 var $primary = '#5A8DEE';
  var $success = '#39DA8A';
  var $danger = '#FF5B5C';
  var $warning = '#FDAC41';
  var $info = '#00CFDD';
  var $label_color = '#475f7b';
  var $primary_light = '#E2ECFF';
  var $danger_light = '#ffeed9';
  var $gray_light = '#828D99';
  var $sub_label_color = "#596778";
  var $radial_bg = "#e7edf3";

 var analyticsBarChartOptions = {
    chart: {
      height: 260,
      type: 'bar',
      toolbar: {
        show: false
      }
    },
    plotOptions: {
      bar: {
        horizontal: false,
        columnWidth: '20%',
        endingShape: 'rounded'
      },
    },
    legend: {
      horizontalAlign: 'right',
      offsetY: -10,
      markers: {
        radius: 50,
        height: 8,
        width: 8
      }
    },
    dataLabels: {
      enabled:false
    },
    colors: [$primary, $danger_light],
    fill: {
      type: 'gradient',
      gradient: {
        shade: 'light',
        type: "vertical",
        inverseColors: true,
        opacityFrom: 1,
        opacityTo: 1,
        stops: [0, 50, 100]
      },
    },
    /*series: [{
     name: '2019',
      data: [80, 95, 150, 210, 140, 230, 300, 280, 130]
    }, {
      name: '2018',
      data: [50, 70, 130, 180, 90, 180, 270, 220, 110]
    }],*/
    series:   {!! $data_chart !!},
    xaxis: {
      categories: {!!  $data_categorias  !!} ,
      axisBorder: {
        show: false
      },
      axisTicks: {
        show: false
      },
      labels: {
        style: {
          colors: $gray_light
        }
      }
    },
    yaxis: {
      min: 0,
      max: 50,
      tickAmount: 3,
      labels: {
        style: {
          color: $gray_light
        }
      }
    },
    legend: {
      show: true
    },
    tooltip: {
      y: {
        formatter: function (val) {
          return " " + val + " Licitaciones"
        }
      }
    }
  }

   var analyticsBarChart = new ApexCharts(
    document.querySelector("#analytics-bar-chart"),
    analyticsBarChartOptions
  );

  analyticsBarChart.render();

   // Donut Chart
  // ---------------------
  var donutChartOption = {
    chart: {
      width: 400,
      type: 'donut',
    },
    dataLabels: {
      enabled: false
    },
    //series: [80, 30, 60],
   // labels: ["Social", "Email", "Search"],
   {!!substr(   substr( $data_pie ,1), 0, -1 ) !!},
    stroke: {
      width: 0,
      lineCap: 'round',
    },
    colors: [$primary, $info, $warning,$success,$danger, $primary_light,$danger_light ],
    plotOptions: {
      pie: {
        donut: {
          size: '90%',
          labels: {
            show: true,
            name: {
              show: true,
              fontSize: '15px',
              colors: $sub_label_color,
              offsetY: 40,
              fontFamily: 'IBM Plex Sans',
            },
            value: {
              show: true,
              fontSize: '26px',
              fontFamily: 'Rubik',
              color: $label_color,
              offsetY: -40,
              formatter: function (val) {
                return val
              }
            }, total: {
              show: true,
              label: 'Actividades',
              color: $gray_light,
              formatter: function (w) {
                return w.globals.seriesTotals.reduce(function (a, b) {
                  return a + b
                }, 0)
              }
            }
          }
        }
      }
    },
    legend: {
      show: false
    }
  }

  var donutChart = new ApexCharts(
    document.querySelector("#donut-chart"),
    donutChartOption
  );

  donutChart.render();


  /*function reporte(e){
    e.preventDefault();
  }
  let formReporte = document.getElementById('formReporte');
  formReporte.addEventListener( 'submit',(e) => {

    e.preventDefault();
    var action = document.getElementById('formReporte').action;     
    console.log(action); 
    let formData = new FormData(formReporte);
    let parameters = '?';
    for(const pair of formData.entries()) {
      parameters +=`${pair[0]}=${pair[1]}&`;
    }
    console.log(parameters);
    reportPreview.src = action + parameters;   
    reportPreview.removeAttribute('hidden');

  })*/
  
</script>
@endsection

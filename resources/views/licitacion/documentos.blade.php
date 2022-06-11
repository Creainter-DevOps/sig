@extends('layouts.contentLayoutMaster')
{{-- page Title --}}
@section('title','Widgets')
{{-- vendor scripts --}}
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/charts/apexcharts.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/extensions/dragula.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/pickers/daterange/daterangepicker.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/extensions/swiper.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/plugins/forms/wizard.css')}}">
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
{{-- page styles --}}
@section('page-styles')
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/widgets.css')}}">
@endsection
@section('content')
<!-- Form wizard with number tabs section end -->
<!-- Form wizard with icon tabs section start -->
<section id="icon-tabs">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Licitacion::{{$licitacion->rotulo}}</h4>
        </div>
        <div class="card-content mt-2">
          <div class="card-body">
            <form action="#" class="wizard-horizontal">
              <!-- Step 1 -->
              <h6>
                <i class="step-icon"></i>
                <span class="fonticon-wrap">
                  <i class="livicon-evo"
                    data-options="name:morph-doc.svg; size: 50px; style:lines; strokeColor:#adb5bd;"></i>
                </span>
              </h6>
              <!-- Step 1 end-->
              <!-- body content step 1 -->
              <fieldset>
                <div class="row">
                      <div class="col-12">
                        <div class="card widget-todo">
                          <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                            <h4 class="card-title d-flex">
                              <i class='bx bx-check font-medium-5 pl-25 pr-75'></i>Documentos
                            </h4>
                            <ul class="list-inline d-flex mb-0">
                              <li class="d-flex align-items-center">
                                <i class='bx bx-check-circle font-medium-3 mr-50'></i>
                                <div class="dropdown">
                                  <div class="dropdown-toggle mr-1" role="button" id="dropdownMenuButton" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">Todos
                                  </div>
                                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="#">Option 1</a>
                                    <a class="dropdown-item" href="#">Option 2</a>
                                    <a class="dropdown-item" href="#">Option 3</a>
                                  </div>
                                </div>
                              </li>
                              <li class="d-flex align-items-center">
                                <i class='bx bx-sort mr-50 font-medium-3'></i>
                                <div class="dropdown">
                                  <div class="dropdown-toggle" role="button" id="dropdownMenuButton2" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">All Task
                                  </div>
                                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                    <a class="dropdown-item" href="#">Option 1</a>
                                    <a class="dropdown-item" href="#">Option 2</a>
                                    <a class="dropdown-item" href="#">Option 3</a>
                                  </div>
                                </div>
                              </li>
                            </ul>
                          </div>
                          <div class="card-body px-0 py-1">
                            <ul class="widget-todo-list-wrapper" id="widget-todo-list">
                              <li class="widget-todo-item" data-id="anexo_1" >
                                <div class="widget-todo-title-wrapper d-flex justify-content-between align-items-center mb-50">
                                  <div class="widget-todo-title-area d-flex align-items-center">
                                    <i class='bx bx-grid-vertical mr-25 font-medium-4 cursor-move'></i>
                                    <div class="checkbox checkbox-shadow">
                                      <input type="checkbox" class="checkbox__input" id="check_anexo1">
                                      <label for="check_anexo1"></label>
                                    </div>
                                    <span class="widget-todo-title ml-50">Anexo 1</span>
                                  </div>
                                  <div class="widget-todo-item-action d-flex align-items-center">
                                    <div class="badge badge-pill badge-light-success mr-1">Word</div>
                                    <div class="avatar bg-rgba-primary m-0 mr-50">
                                      <div class="avatar-content">
                                        <span class="font-size-base text-primary">RA</span>
                                      </div>
                                    </div>
                                    <i class="bx bx-dots-vertical-rounded font-medium-3 cursor-pointer"></i>
                                  </div>
                                </div>
                              </li>
                              <li class="widget-todo-item" data-id="anexo_2"  >
                                <div class="widget-todo-title-wrapper d-flex justify-content-between align-items-center mb-50">
                                  <div class="widget-todo-title-area d-flex align-items-center">
                                    <i class='bx bx-grid-vertical mr-25 font-medium-4 cursor-move'></i>
                                    <div class="checkbox checkbox-shadow">
                                      <input type="checkbox" class="checkbox__input" id="check_anexo2">
                                      <label for="check_anexo2"></label>
                                    </div>
                                    <span class="widget-todo-title ml-50">Anexo 2</span>
                                  </div>
                                  <div class="widget-todo-item-action d-flex align-items-center">
                                    <div class="badge badge-pill badge-light-danger mr-1">Word</div>
                                    <div class="avatar m-0 mr-50">
                                      <img src="{{asset('images/profile/user-uploads/social-2.jpg')}}" alt="img placeholder"
                                        height="32" width="32">
                                    </div>
                                    <i class="bx bx-dots-vertical-rounded font-medium-3 cursor-pointer"></i>
                                  </div>
                                </div>
                              </li>
                              <li class="widget-todo-item" data-id="anexo_3"  >
                                <div class="widget-todo-title-wrapper d-flex justify-content-between align-items-center mb-50">
                                  <div class="widget-todo-title-area d-flex align-items-center">
                                    <i class='bx bx-grid-vertical mr-25 font-medium-4 cursor-move'></i>
                                    <div class="checkbox checkbox-shadow">
                                      <input type="checkbox" class="checkbox__input" id="check_anexo3">
                                      <label for="check_anexo3"></label>
                                    </div>
                                    <span class="widget-todo-title ml-50">Anexo 3</span>
                                  </div>
                                  <div class="widget-todo-item-action d-flex align-items-center">
                                    <div class="badge badge-pill badge-light-danger mr-1">Word</div>
                                    <div class="avatar m-0 mr-50">
                                      <img src="{{asset('images/profile/user-uploads/social-2.jpg')}}" alt="img placeholder"
                                        height="32" width="32">
                                    </div>
                                    <i class="bx bx-dots-vertical-rounded font-medium-3 cursor-pointer"></i>
                                  </div>
                                </div>
                              </li>
                              
                              <li class="widget-todo-item"  data-id="anexo_4"  >
                                <div class="widget-todo-title-wrapper d-flex justify-content-between align-items-center mb-50">
                                  <div class="widget-todo-title-area d-flex align-items-center">
                                    <i class='bx bx-grid-vertical mr-25 font-medium-4 cursor-move'></i>
                                    <div class="checkbox checkbox-shadow">
                                      <input type="checkbox" class="checkbox__input" id="check_anexo4">
                                      <label for="check_anexo4"></label>
                                    </div>
                                    <span class="widget-todo-title ml-50">Anexo 4</span>
                                  </div>
                                  <div class="widget-todo-item-action d-flex align-items-center">
                                    <div class="badge badge-pill badge-light-danger mr-1">Word</div>
                                    <div class="avatar m-0 mr-50">
                                      <img src="{{asset('images/profile/user-uploads/social-2.jpg')}}" alt="img placeholder"
                                        height="32" width="32">
                                    </div>
                                    <i class="bx bx-dots-vertical-rounded font-medium-3 cursor-pointer"></i>
                                  </div>
                                </div>
                              </li>

                              <li class="widget-todo-item" data-id="anexo_5" >
                                <div class="widget-todo-title-wrapper d-flex justify-content-between align-items-center mb-50">
                                  <div class="widget-todo-title-area d-flex align-items-center">
                                    <i class='bx bx-grid-vertical mr-25 font-medium-4 cursor-move'></i>
                                    <div class="checkbox checkbox-shadow">
                                      <input type="checkbox" class="checkbox__input" id="check_anexo5">
                                      <label for="check_anexo5"></label>
                                    </div>
                                    <span class="widget-todo-title ml-50">Anexo 5</span>
                                  </div>
                                  <div class="widget-todo-item-action d-flex align-items-center">
                                    <div class="badge badge-pill badge-light-danger mr-1">Word</div>
                                    <div class="avatar m-0 mr-50">
                                      <img src="{{asset('images/profile/user-uploads/social-2.jpg')}}" alt="img placeholder"
                                        height="32" width="32">
                                    </div>
                                    <i class="bx bx-dots-vertical-rounded font-medium-3 cursor-pointer"></i>
                                  </div>
                                </div>
                              </li>
                              
                              <li class="widget-todo-item" data-id="anexo_6" >
                                <div class="widget-todo-title-wrapper d-flex justify-content-between align-items-center mb-50">
                                  <div class="widget-todo-title-area d-flex align-items-center">
                                    <i class='bx bx-grid-vertical mr-25 font-medium-4 cursor-move'></i>
                                    <div class="checkbox checkbox-shadow">
                                      <input type="checkbox" class="checkbox__input" id="check_anexo6">
                                      <label for="check_anexo6"></label>
                                    </div>
                                    <span class="widget-todo-title ml-50">Anexo 6</span>
                                  </div>
                                  <div class="widget-todo-item-action d-flex align-items-center">
                                    <div class="badge badge-pill badge-light-danger mr-1">Word</div>
                                    <div class="avatar m-0 mr-50">
                                      <img src="{{asset('images/profile/user-uploads/social-2.jpg')}}" alt="img placeholder"
                                        height="32" width="32">
                                    </div>
                                    <i class="bx bx-dots-vertical-rounded font-medium-3 cursor-pointer"></i>
                                  </div>
                                </div>
                              </li>
                              
                              <li class="widget-todo-item" data-id="anexo_7" >
                                <div class="widget-todo-title-wrapper d-flex justify-content-between align-items-center mb-50">
                                  <div class="widget-todo-title-area d-flex align-items-center">
                                    <i class='bx bx-grid-vertical mr-25 font-medium-4 cursor-move'></i>
                                    <div class="checkbox checkbox-shadow">
                                      <input type="checkbox" class="checkbox__input" id="check_anexo7">
                                      <label for="check_anexo7"></label>
                                    </div>
                                    <span class="widget-todo-title ml-50">Anexo 7</span>
                                  </div>
                                  <div class="widget-todo-item-action d-flex align-items-center">
                                    <div class="badge badge-pill badge-light-danger mr-1">Word</div>
                                    <div class="avatar m-0 mr-50">
                                      <img src="{{asset('images/profile/user-uploads/social-2.jpg')}}" alt="img placeholder"
                                        height="32" width="32">
                                    </div>
                                    <i class="bx bx-dots-vertical-rounded font-medium-3 cursor-pointer"></i>
                                  </div>
                                </div>
                              </li>
                              
                              <li class="widget-todo-item" data-id="anexo_8" >
                                <div class="widget-todo-title-wrapper d-flex justify-content-between align-items-center mb-50">
                                  <div class="widget-todo-title-area d-flex align-items-center">
                                    <i class='bx bx-grid-vertical mr-25 font-medium-4 cursor-move'></i>
                                    <div class="checkbox checkbox-shadow">
                                      <input type="checkbox" class="checkbox__input" id="check_anexo8">
                                      <label for="check_anexo8"></label>
                                    </div>
                                    <span class="widget-todo-title ml-50">Anexo 8</span>
                                  </div>
                                  <div class="widget-todo-item-action d-flex align-items-center">
                                    <div class="badge badge-pill badge-light-danger mr-1">Word</div>
                                    <div class="avatar m-0 mr-50">
                                      <img src="{{asset('images/profile/user-uploads/social-2.jpg')}}" alt="img placeholder"
                                        height="32" width="32">
                                    </div>
                                    <i class="bx bx-dots-vertical-rounded font-medium-3 cursor-pointer"></i>
                                  </div>
                                </div>
                              </li>
                              
                              <li class="widget-todo-item" id="anexo_9" >
                                <div class="widget-todo-title-wrapper d-flex justify-content-between align-items-center mb-50">
                                  <div class="widget-todo-title-area d-flex align-items-center">
                                    <i class='bx bx-grid-vertical mr-25 font-medium-4 cursor-move'></i>
                                    <div class="checkbox checkbox-shadow">
                                      <input type="checkbox" class="checkbox__input" id="check_anexo9">
                                      <label for="check_anexo9"></label>
                                    </div>
                                    <span class="widget-todo-title ml-50">Anexo 9</span>
                                  </div>
                                  <div class="widget-todo-item-action d-flex align-items-center">
                                    <div class="badge badge-pill badge-light-danger mr-1">Word</div>
                                    <div class="avatar m-0 mr-50">
                                      <img src="{{asset('images/profile/user-uploads/social-2.jpg')}}" alt="img placeholder"
                                        height="32" width="32">
                                    </div>
                                    <i class="bx bx-dots-vertical-rounded font-medium-3 cursor-pointer"></i>
                                  </div>
                                </div>
                              </li>
                            </ul>
                            <a class="btn btn-primary" onclick="" id="save">Generar</a>
                          </div>
                        </div>
                      </div>
                  <!-- Task App Widget Ends -->
                  <!--<div class="col-12">
                    <h6 class="py-50">Enter Your Personal Details</h6>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="firstName13">First Name </label>
                      <input type="text" class="form-control" id="firstName13" placeholder="Enter Your First Name">
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="lastName12">Last Name</label>
                      <input type="text" class="form-control" id="lastName12" placeholder="Enter Your Last Name">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="emailAddress1">Email</label>
                      <input type="email" class="form-control" id="emailAddress1" placeholder="Enter Your Email">
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label>Phone</label>
                      <input type="number" class="form-control" placeholder="Enter Your Phone Number">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>age</label>
                      <input type="number" class="form-control" placeholder="Enter Your Age">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="d-block">Gender</label>
                      <div class="custom-control-inline">
                        <div class="radio mr-1">
                          <input type="radio" name="bsradio" id="radio1" checked="">
                          <label for="radio1">Male</label>
                        </div>
                        <div class="radio">
                          <input type="radio" name="bsradio" id="radio2" checked="">
                          <label for="radio2">Female</label>
                        </div>
                      </div>
                    </div>
                  </div>-->
                </div>
              </fieldset>
              <!-- body content step 1 end-->
              <!-- Step 2 -->
              <h6>
                <i class="step-icon"></i>
                <span class="fonticon-wrap">
                  <i class="livicon-evo"
                    data-options="name:truck.svg; size: 50px; style:lines; strokeColor:#adb5bd;"></i>
                </span>
              </h6>
              <!-- Step 2 end-->
              <!-- body content of step 2 -->
              <fieldset>
                <div class="row">
                  <div class="col-12">
                    <h6 class="py-50">Enter Your Location</h6>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label>Address Line 1</label>
                      <input type="text" class="form-control" placeholder="Enter House no./ Flate no.">
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label>Address Line 2</label>
                      <input type="text" class="form-control" placeholder="Enter Society name/ Area name">
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label>LandMark</label>
                      <input type="text" class="form-control" placeholder="Enter A Landmark">
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label>TOWN/CITY</label>
                      <input type="text" class="form-control" placeholder="Enter Town/City">
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label>PINCODE</label>
                      <input type="text" class="form-control" placeholder="Enter Your Pincode">
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label>STATE</label>
                      <input type="text" class="form-control" placeholder="Enter Your State">
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label>Country</label>
                      <select name="country" class="form-control">
                        <option value="">Select</option>
                        <option value="AF">Afghanistan</option>
                        <option value="AX">Åland Islands</option>
                        <option value="AL">Albania</option>
                        <option value="DZ">Algeria</option>
                        <option value="AS">American Samoa</option>
                        <option value="AD">Andorra</option>
                        <option value="AO">Angola</option>
                        <option value="AI">Anguilla</option>
                        <option value="AQ">Antarctica</option>
                        <option value="ZW">Zimbabwe</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-sm-6 d-flex align-items-center">
                    <div class="form-group">
                      <div class="checkbox">
                        <input type="checkbox" class="checkbox__input" id="checkbox1" checked="">
                        <label for="checkbox1">Permanent Delivery address</label>
                      </div>
                    </div>
                  </div>
                </div>
              </fieldset>
              <!-- body content of step 2 end-->
              <!-- Step 3 -->
              <h6>
                <i class="step-icon"></i>
                <span class="fonticon-wrap">
                  <i class="livicon-evo"
                    data-options="name:home.svg; size: 50px; style:lines; strokeColor:#adb5bd;"></i>
                </span>
              </h6>
              <!-- Step 3 end-->
              <!-- body content of Step 3 -->
              <fieldset>
                <div class="row">
                  <div class="col-12">
                    <h6 class="py-50">Enter Your Payment Methods</h6>
                  </div>
                  <div class="col-12">
                    <div class="form-group">
                      <div class="d-flex justify-content-between flex-wrap align-items-center">
                        <div class="vs-radio-con vs-radio-primary">
                          <img src="{{asset('images/pages/bank.png')}}" alt="img-placeholder" height="40">
                          <span>Card 12XX XXXX XXXX 0000</span>
                        </div>
                        <div class="card-holder-name">
                          John Doe
                        </div>
                        <div class="card-expiration-date">
                          11/2020
                        </div>
                        <div>
                          <label>Enter CVV</label>
                          <input type="password" class="form-control" placeholder="Enter Your CVV no.">
                        </div>
                      </div>
                    </div>
                    <hr>
                  </div>
                  <div class="col-12">
                    <div class="form-group">
                      <ul class="other-payment-options list-unstyled">
                        <li class="pb-1">
                          <div class="radio">
                            <input type="radio" name="pyradio" id="radio6" checked="">
                            <label for="radio6">Credit / Debit / ATM Card</label>
                          </div>
                        </li>
                        <li class="pb-1">
                          <div class="radio">
                            <input type="radio" name="pyradio" id="radio7" checked="">
                            <label for="radio7">Net Banking</label>
                          </div>
                        </li>
                        <li class="pb-1">
                          <div class="radio">
                            <input type="radio" name="pyradio" id="radio8" checked="">
                            <label for="radio8"> EMI (Easy Installment)</label>
                          </div>
                        </li>
                        <li class="pb-1">
                          <div class="radio">
                            <input type="radio" name="pyradio" id="radio9" checked="">
                            <label for="radio9"> Cash On Delivery</label>
                          </div>
                        </li>
                      </ul>
                    </div>
                    <hr>
                  </div>
                  <div class="col-12 d-flex">
                    <div class="paypal cursor-pointer d-flex align-items-center">
                      <div class="radio">
                        <input type="radio" name="onlportal" id="paypal" checked="">
                        <label for="paypal"></label>
                      </div>
                      <img src="{{asset('images/pages/PayPal_logo.png')}}" alt="PayPal Logo">
                    </div>
                    <div class="googlepay cursor-pointer pl-1 d-flex align-items-center">
                      <div class="radio">
                        <input type="radio" name="onlportal" id="googlepay" checked="">
                        <label for="googlepay"></label>
                      </div>
                      <img src="{{asset('images/pages/google-pay.png')}}" height="30" alt="google Logo">
                    </div>
                  </div>
                  <div class="col-md-6 col-12">
                    <hr>
                    <div class="form-group">
                      <label>Enter Your Promocode</label>
                      <input type="text" class="form-control" placeholder="Enter Your Promocode">
                    </div>
                  </div>
                </div>
              </fieldset>
              <!-- body content of Step 3 end-->
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- Form wizard with number tabs section end -->
    <!-- Task App Widget Starts -->
    <div class="col-lg-7">
      <div class="row">
        <div class="col-12">
          <div class="card widget-todo">
            <div class="card-header border-bottom d-flex justify-content-between align-items-center">
              <h4 class="card-title d-flex">
                <i class='bx bx-check font-medium-5 pl-25 pr-75'></i>Documentos
              </h4>
              <ul class="list-inline d-flex mb-0">
                <li class="d-flex align-items-center">
                  <i class='bx bx-check-circle font-medium-3 mr-50'></i>
                  <div class="dropdown">
                    <div class="dropdown-toggle mr-1" role="button" id="dropdownMenuButton" data-toggle="dropdown"
                      aria-haspopup="true" aria-expanded="false">Todos
                    </div>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                      <a class="dropdown-item" href="#">Option 1</a>
                      <a class="dropdown-item" href="#">Option 2</a>
                      <a class="dropdown-item" href="#">Option 3</a>
                    </div>
                  </div>
                </li>
                <li class="d-flex align-items-center">
                  <i class='bx bx-sort mr-50 font-medium-3'></i>
                  <div class="dropdown">
                    <div class="dropdown-toggle" role="button" id="dropdownMenuButton2" data-toggle="dropdown"
                      aria-haspopup="true" aria-expanded="false">All Task
                    </div>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                      <a class="dropdown-item" href="#">Option 1</a>
                      <a class="dropdown-item" href="#">Option 2</a>
                      <a class="dropdown-item" href="#">Option 3</a>
                    </div>
                  </div>
                </li>
              </ul>
            </div>
            <div class="card-body px-0 py-1">
              <ul class="widget-todo-list-wrapper" id="widget-todo-list">
                <li class="widget-todo-item">
                  <div class="widget-todo-title-wrapper d-flex justify-content-between align-items-center mb-50">
                    <div class="widget-todo-title-area d-flex align-items-center">
                      <i class='bx bx-grid-vertical mr-25 font-medium-4 cursor-move'></i>
                      <div class="checkbox checkbox-shadow">
                        <input type="checkbox" class="checkbox__input" id="check_anexo1">
                        <label for="check_anexo1"></label>
                      </div>
                      <span class="widget-todo-title ml-50">Anexo 1</span>
                    </div>
                    <div class="widget-todo-item-action d-flex align-items-center">
                      <div class="badge badge-pill badge-light-success mr-1">Word</div>
                      <div class="avatar bg-rgba-primary m-0 mr-50">
                        <div class="avatar-content">
                          <span class="font-size-base text-primary">RA</span>
                        </div>
                      </div>
                      <i class="bx bx-dots-vertical-rounded font-medium-3 cursor-pointer"></i>
                    </div>
                  </div>
                </li>
                <li class="widget-todo-item">
                  <div class="widget-todo-title-wrapper d-flex justify-content-between align-items-center mb-50">
                    <div class="widget-todo-title-area d-flex align-items-center">
                      <i class='bx bx-grid-vertical mr-25 font-medium-4 cursor-move'></i>
                      <div class="checkbox checkbox-shadow">
                        <input type="checkbox" class="checkbox__input" id="check_anexo2">
                        <label for="check_anexo2"></label>
                      </div>
                      <span class="widget-todo-title ml-50">Anexo 2</span>
                    </div>
                    <div class="widget-todo-item-action d-flex align-items-center">
                      <div class="badge badge-pill badge-light-danger mr-1">Word</div>
                      <div class="avatar m-0 mr-50">
                        <img src="{{asset('images/profile/user-uploads/social-2.jpg')}}" alt="img placeholder"
                          height="32" width="32">
                      </div>
                      <i class="bx bx-dots-vertical-rounded font-medium-3 cursor-pointer"></i>
                    </div>
                  </div>
                </li>
                <li class="widget-todo-item">
                  <div class="widget-todo-title-wrapper d-flex justify-content-between align-items-center mb-50">
                    <div class="widget-todo-title-area d-flex align-items-center">
                      <i class='bx bx-grid-vertical mr-25 font-medium-4 cursor-move'></i>
                      <div class="checkbox checkbox-shadow">
                        <input type="checkbox" class="checkbox__input" id="check_anexo3">
                        <label for="check_anexo3"></label>
                      </div>
                      <span class="widget-todo-title ml-50">Anexo 3</span>
                    </div>
                    <div class="widget-todo-item-action d-flex align-items-center">
                      <div class="badge badge-pill badge-light-danger mr-1">Word</div>
                      <div class="avatar m-0 mr-50">
                        <img src="{{asset('images/profile/user-uploads/social-2.jpg')}}" alt="img placeholder"
                          height="32" width="32">
                      </div>
                      <i class="bx bx-dots-vertical-rounded font-medium-3 cursor-pointer"></i>
                    </div>
                  </div>
                </li>
                
                <li class="widget-todo-item">
                  <div class="widget-todo-title-wrapper d-flex justify-content-between align-items-center mb-50">
                    <div class="widget-todo-title-area d-flex align-items-center">
                      <i class='bx bx-grid-vertical mr-25 font-medium-4 cursor-move'></i>
                      <div class="checkbox checkbox-shadow">
                        <input type="checkbox" class="checkbox__input" id="check_anexo4">
                        <label for="check_anexo4"></label>
                      </div>
                      <span class="widget-todo-title ml-50">Anexo 4</span>
                    </div>
                    <div class="widget-todo-item-action d-flex align-items-center">
                      <div class="badge badge-pill badge-light-danger mr-1">Word</div>
                      <div class="avatar m-0 mr-50">
                        <img src="{{asset('images/profile/user-uploads/social-2.jpg')}}" alt="img placeholder"
                          height="32" width="32">
                      </div>
                      <i class="bx bx-dots-vertical-rounded font-medium-3 cursor-pointer"></i>
                    </div>
                  </div>
                </li>

                <li class="widget-todo-item">
                  <div class="widget-todo-title-wrapper d-flex justify-content-between align-items-center mb-50">
                    <div class="widget-todo-title-area d-flex align-items-center">
                      <i class='bx bx-grid-vertical mr-25 font-medium-4 cursor-move'></i>
                      <div class="checkbox checkbox-shadow">
                        <input type="checkbox" class="checkbox__input" id="check_anexo5">
                        <label for="check_anexo5"></label>
                      </div>
                      <span class="widget-todo-title ml-50">Anexo 5</span>
                    </div>
                    <div class="widget-todo-item-action d-flex align-items-center">
                      <div class="badge badge-pill badge-light-danger mr-1">Word</div>
                      <div class="avatar m-0 mr-50">
                        <img src="{{asset('images/profile/user-uploads/social-2.jpg')}}" alt="img placeholder"
                          height="32" width="32">
                      </div>
                      <i class="bx bx-dots-vertical-rounded font-medium-3 cursor-pointer"></i>
                    </div>
                  </div>
                </li>
                
                <li class="widget-todo-item">
                  <div class="widget-todo-title-wrapper d-flex justify-content-between align-items-center mb-50">
                    <div class="widget-todo-title-area d-flex align-items-center">
                      <i class='bx bx-grid-vertical mr-25 font-medium-4 cursor-move'></i>
                      <div class="checkbox checkbox-shadow">
                        <input type="checkbox" class="checkbox__input" id="check_anexo6">
                        <label for="check_anexo6"></label>
                      </div>
                      <span class="widget-todo-title ml-50">Anexo 6</span>
                    </div>
                    <div class="widget-todo-item-action d-flex align-items-center">
                      <div class="badge badge-pill badge-light-danger mr-1">Word</div>
                      <div class="avatar m-0 mr-50">
                        <img src="{{asset('images/profile/user-uploads/social-2.jpg')}}" alt="img placeholder"
                          height="32" width="32">
                      </div>
                      <i class="bx bx-dots-vertical-rounded font-medium-3 cursor-pointer"></i>
                    </div>
                  </div>
                </li>
                
                <li class="widget-todo-item">
                  <div class="widget-todo-title-wrapper d-flex justify-content-between align-items-center mb-50">
                    <div class="widget-todo-title-area d-flex align-items-center">
                      <i class='bx bx-grid-vertical mr-25 font-medium-4 cursor-move'></i>
                      <div class="checkbox checkbox-shadow">
                        <input type="checkbox" class="checkbox__input" id="check_anexo7">
                        <label for="check_anexo7"></label>
                      </div>
                      <span class="widget-todo-title ml-50">Anexo 7</span>
                    </div>
                    <div class="widget-todo-item-action d-flex align-items-center">
                      <div class="badge badge-pill badge-light-danger mr-1">Word</div>
                      <div class="avatar m-0 mr-50">
                        <img src="{{asset('images/profile/user-uploads/social-2.jpg')}}" alt="img placeholder"
                          height="32" width="32">
                      </div>
                      <i class="bx bx-dots-vertical-rounded font-medium-3 cursor-pointer"></i>
                    </div>
                  </div>
                </li>
                
                <li class="widget-todo-item">
                  <div class="widget-todo-title-wrapper d-flex justify-content-between align-items-center mb-50">
                    <div class="widget-todo-title-area d-flex align-items-center">
                      <i class='bx bx-grid-vertical mr-25 font-medium-4 cursor-move'></i>
                      <div class="checkbox checkbox-shadow">
                        <input type="checkbox" class="checkbox__input" id="check_anexo8">
                        <label for="check_anexo8"></label>
                      </div>
                      <span class="widget-todo-title ml-50">Anexo 8</span>
                    </div>
                    <div class="widget-todo-item-action d-flex align-items-center">
                      <div class="badge badge-pill badge-light-danger mr-1">Word</div>
                      <div class="avatar m-0 mr-50">
                        <img src="{{asset('images/profile/user-uploads/social-2.jpg')}}" alt="img placeholder"
                          height="32" width="32">
                      </div>
                      <i class="bx bx-dots-vertical-rounded font-medium-3 cursor-pointer"></i>
                    </div>
                  </div>
                </li>
                
                <li class="widget-todo-item">
                  <div class="widget-todo-title-wrapper d-flex justify-content-between align-items-center mb-50">
                    <div class="widget-todo-title-area d-flex align-items-center">
                      <i class='bx bx-grid-vertical mr-25 font-medium-4 cursor-move'></i>
                      <div class="checkbox checkbox-shadow">
                        <input type="checkbox" class="checkbox__input" id="check_anexo9">
                        <label for="check_anexo4"></label>
                      </div>
                      <span class="widget-todo-title ml-50">Anexo 9</span>
                    </div>
                    <div class="widget-todo-item-action d-flex align-items-center">
                      <div class="badge badge-pill badge-light-danger mr-1">Word</div>
                      <div class="avatar m-0 mr-50">
                        <img src="{{asset('images/profile/user-uploads/social-2.jpg')}}" alt="img placeholder"
                          height="32" width="32">
                      </div>
                      <i class="bx bx-dots-vertical-rounded font-medium-3 cursor-pointer"></i>
                    </div>
                  </div>
                </li>
              </ul>
              <a class="btn btn-primary" href="{{ route( 'documentos.show', [ 'document' => 1 ] )}} ">Generar</a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Task App Widget Ends -->
  </div>
  <!--<div class="row">-->
    <!-- Statistics progress Widget -->
    <!--<div class="col-xl-4 col-md-6 progress-card">
      <div class="card">
        <div class="card-header border-bottom d-flex justify-content-between align-items-center pr-2">
          <h5 class="card-title">Statistics</h5>
          <ul class="list-inline mb-0">
            <li class="mr-50"> <i class="bullet bullet-xs bullet-primary mr-50"></i>First </li>
            <li><i class="bx bx-dots-vertical-rounded font-medium-3 align-middle cursor-pointer"></i></li>
          </ul>
        </div>
        <div class="table-responsive">
          <table class="table table-borderless">
            <tbody>
              <tr>
                <td class="w-25">Graphic</td>
                <td>
                  <div class="progress progress-bar-info progress-sm mb-0">
                    <div class="progress-bar" role="progressbar" aria-valuenow="24" aria-valuemin="80"
                      aria-valuemax="100" style="width:24%;"></div>
                  </div>
                </td>
                <td class="w-25 text-right">24%</td>
              </tr>
              <tr>
                <td class="w-25">Prototyping</td>
                <td>
                  <div class="progress progress-bar-success progress-sm mb-0">
                    <div class="progress-bar" role="progressbar" aria-valuenow="61" aria-valuemin="80"
                      aria-valuemax="100" style="width:61%;"></div>
                  </div>
                </td>
                <td class="w-25 text-right">61%</td>
              </tr>
              <tr>
                <td class="w-25">Sketching</td>
                <td>
                  <div class="progress progress-bar-primary progress-sm mb-0">
                    <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="80"
                      aria-valuemax="100" style="width:60%;"></div>
                  </div>
                </td>
                <td class="w-25 text-right">24%</td>
              </tr>
              <tr>
                <td class="w-25">Modeling</td>
                <td>
                  <div class="progress progress-bar-info progress-sm mb-0">
                    <div class="progress-bar" role="progressbar" aria-valuenow="35" aria-valuemin="80"
                      aria-valuemax="100" style="width:35%;"></div>
                  </div>
                </td>
                <td class="w-25 text-right">35%</td>
              </tr>
              <tr>
                <td class="w-25">Images</td>
                <td>
                  <div class="progress progress-bar-primary progress-sm mb-0">
                    <div class="progress-bar" role="progressbar" aria-valuenow="65" aria-valuemin="80"
                      aria-valuemax="100" style="width:65%;"></div>
                  </div>
                </td>
                <td class="w-25 text-right">65%</td>
              </tr>
              <tr>
                <td class="w-25">HTML</td>
                <td>
                  <div class="progress progress-bar-success progress-sm mb-0">
                    <div class="progress-bar" role="progressbar" aria-valuenow="32" aria-valuemin="80"
                      aria-valuemax="100" style="width:32%;"></div>
                  </div>
                </td>
                <td class="w-25 text-right">32%</td>
              </tr>
              <tr>
                <td class="w-25">Laravel</td>
                <td>
                  <div class="progress progress-bar-danger progress-sm mb-0">
                    <div class="progress-bar" role="progressbar" aria-valuenow="40" aria-valuemin="80"
                      aria-valuemax="100" style="width:40%;"></div>
                  </div>
                </td>
                <td class="w-25 text-right">40%</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>-->
    <!-- Statistics progress Widget Ends -->
    <!-- Earnings Widget Swiper Starts -->
    <!--<div class="col-xl-4 col-md-6 earnings-card" id="widget-earnings">
      <div class="card">
        <div class="card-header border-bottom d-flex justify-content-between align-items-center">
          <h5 class="card-title"><i class="bx bx-dollar font-medium-5 align-middle"></i> Earnings</h5>
          <i class="bx bx-dots-vertical-rounded font-medium-3 cursor-pointer"></i>
        </div>
        <div class="card-content">
          <div class="card-body py-1">
            <div class="widget-earnings-swiper swiper-container p-1">
              <div class="swiper-wrapper">
                <div class="swiper-slide rounded swiper-shadow py-75 px-2 d-flex align-items-center" id="repo-design">
                  <i class="bx bx-pyramid mr-50 font-large-1"></i>
                  <div class="swiper-text">Repo Design
                    <p class="mb-0 font-small-2 font-weight-normal">Incontico</p>
                  </div>
                </div>
                <div class="swiper-slide rounded swiper-shadow py-75 px-2 d-flex align-items-center" id="laravel-temp">
                  <i class="bx bx-sitemap mr-50 font-large-1"></i>
                  <div class="swiper-text">Laravel Temp
                    <p class="mb-0 font-small-2 font-weight-normal">Global dish</p>
                  </div>
                </div>
                <div class="swiper-slide rounded swiper-shadow py-75 px-2 d-flex align-items-center" id="admin-theme">
                  <i class="bx bx-check-shield mr-50 font-large-1"></i>
                  <div class="swiper-text">Admin Theme
                    <p class="mb-0 font-small-2 font-weight-normal">Medal owner</p>
                  </div>
                </div>
                <div class="swiper-slide rounded swiper-shadow py-75 px-2 d-flex align-items-center" id="ux-devloper">
                  <i class="bx bx-devices mr-50 font-large-1"></i>
                  <div class="swiper-text">UX Devloper
                    <p class="mb-0 font-small-2 font-weight-normal">Generic name</p>
                  </div>
                </div>
                <div class="swiper-slide rounded swiper-shadow py-75 px-2 d-flex align-items-center"
                  id="marketing-guide">
                  <i class="bx bx-book-bookmark mr-50 font-large-1"></i>
                  <div class="swiper-text">Marketing Guide
                    <p class="mb-0 font-small-2 font-weight-normal">Cool stuff</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="main-wrapper-content">
          <div class="wrapper-content" data-earnings="repo-design">
            <div class="widget-earnings-scroll table-responsive">
              <table class="table table-borderless widget-earnings-width mb-0">
                <tbody>
                  <tr>
                    <td class="pr-75">
                      <div class="media align-items-center">
                        <a class="media-left mr-50" href="#">
                          <img src="{{asset('images/portrait/small/avatar-s-8.jpg')}}" alt="avatar"
                            class="rounded-circle" height="30" width="30">
                        </a>
                        <div class="media-body">
                          <h6 class="media-heading mb-0">Mera Baker</h6>
                          <span class="font-small-2">Ux Designer</span>
                        </div>
                      </div>
                    </td>
                    <td class="px-0 w-25">
                      <div class="progress progress-bar-primary progress-sm mb-0">
                        <div class="progress-bar" role="progressbar" aria-valuenow="55" aria-valuemin="80"
                          aria-valuemax="100" style="width:55%;"></div>
                      </div>
                    </td>
                    <td class="text-center"><span class="badge badge-light-primary">+ $860</span>
                    </td>
                  </tr>
                  <tr>
                    <td class="pr-75">
                      <div class="media align-items-center">
                        <a class="media-left mr-50" href="#">
                          <img src="{{asset('images/portrait/small/avatar-s-10.jpg')}}" alt="avatar"
                            class="rounded-circle" height="30" width="30">
                        </a>
                        <div class="media-body">
                          <h6 class="media-heading mb-0">Jerry Lter</h6>
                          <span class="font-small-2">Designer</span>
                        </div>
                      </div>
                    </td>
                    <td class="px-0 w-25">
                      <div class="progress progress-bar-info progress-sm mb-0">
                        <div class="progress-bar" role="progressbar" aria-valuenow="33" aria-valuemin="80"
                          aria-valuemax="100" style="width:33%;"></div>
                      </div>
                    </td>
                    <td class="text-center"><span class="badge badge-light-warning">- $280</span>
                    </td>
                  </tr>
                  <tr>
                    <td class="pr-75">
                      <div class="media align-items-center">
                        <a class="media-left mr-50" href="#">
                          <img src="{{asset('images/portrait/small/avatar-s-11.jpg')}}" alt="avatar"
                            class="rounded-circle" height="30" width="30">
                        </a>
                        <div class="media-body">
                          <h6 class="media-heading mb-0">Pauly uez</h6>
                          <span class="font-small-2">Devloper</span>
                        </div>
                      </div>
                    </td>
                    <td class="px-0 w-25">
                      <div class="progress progress-bar-success progress-sm mb-0">
                        <div class="progress-bar" role="progressbar" aria-valuenow="10" aria-valuemin="80"
                          aria-valuemax="100" style="width:10%;"></div>
                      </div>
                    </td>
                    <td class="text-center"><span class="badge badge-light-success">+ $853</span>
                    </td>
                  </tr>
                  <tr>
                    <td class="pr-75">
                      <div class="media align-items-center">
                        <a class="media-left mr-50" href="#">
                          <img src="{{asset('images/portrait/small/avatar-s-11.jpg')}}" alt="avatar"
                            class="rounded-circle" height="30" width="30">
                        </a>
                        <div class="media-body">
                          <h6 class="media-heading mb-0">Lary Masey</h6>
                          <span class="font-small-2">Marketing</span>
                        </div>
                      </div>
                    </td>
                    <td class="px-0 w-25">
                      <div class="progress progress-bar-primary progress-sm mb-0">
                        <div class="progress-bar" role="progressbar" aria-valuenow="15" aria-valuemin="80"
                          aria-valuemax="100" style="width:15%;"></div>
                      </div>
                    </td>
                    <td class="text-center"><span class="badge badge-light-primary">+ $125</span>
                    </td>
                  </tr>
                  <tr>
                    <td class="pr-75">
                      <div class="media align-items-center">
                        <a class="media-left mr-50" href="#">
                          <img src="{{asset('images/portrait/small/avatar-s-12.jpg')}}" alt="avatar"
                            class="rounded-circle" height="30" width="30">
                        </a>
                        <div class="media-body">
                          <h6 class="media-heading mb-0">Lula Taylor</h6>
                          <span class="font-small-2">Degigner</span>
                        </div>
                      </div>
                    </td>
                    <td class="px-0 w-25">
                      <div class="progress progress-bar-danger progress-sm mb-0">
                        <div class="progress-bar" role="progressbar" aria-valuenow="35" aria-valuemin="80"
                          aria-valuemax="100" style="width:35%;"></div>
                      </div>
                    </td>
                    <td class="text-center"><span class="badge badge-light-danger">- $310</span>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div class="wrapper-content" data-earnings="laravel-temp">
            <div class="widget-earnings-scroll table-responsive">
              <table class="table table-borderless widget-earnings-width mb-0">
                <tbody>
                  <tr>
                    <td class="pr-75">
                      <div class="media align-items-center">
                        <a class="media-left mr-50" href="#">
                          <img src="{{asset('images/portrait/small/avatar-s-11.jpg')}}" alt="avatar"
                            class="rounded-circle" height="30" width="30">
                        </a>
                        <div class="media-body">
                          <h6 class="media-heading mb-0">Myra Baker</h6>
                          <span class="font-small-2">Ux Designer</span>
                        </div>
                      </div>
                    </td>
                    <td class="px-0 w-25">
                      <div class="progress progress-bar-primary progress-sm mb-0">
                        <div class="progress-bar" role="progressbar" aria-valuenow="25" aria-valuemin="80"
                          aria-valuemax="100" style="width:25%;"></div>
                      </div>
                    </td>
                    <td class="text-center"><span class="badge badge-light-primary">+ $120</span>
                    </td>
                  </tr>
                  <tr>
                    <td class="pr-75">
                      <div class="media align-items-center">
                        <a class="media-left mr-50" href="#">
                          <img src="{{asset('images/portrait/small/avatar-s-9.jpg')}}" alt="avatar"
                            class="rounded-circle" height="30" width="30">
                        </a>
                        <div class="media-body">
                          <h6 class="media-heading mb-0">Jesus Lter</h6>
                          <span class="font-small-2">Designer</span>
                        </div>
                      </div>
                    </td>
                    <td class="px-0 w-25">
                      <div class="progress progress-bar-info progress-sm mb-0">
                        <div class="progress-bar" role="progressbar" aria-valuenow="28" aria-valuemin="80"
                          aria-valuemax="100" style="width:28%;"></div>
                      </div>
                    </td>
                    <td class="text-center"><span class="badge badge-light-info">- $280</span></td>
                  </tr>
                  <tr>
                    <td class="pr-75">
                      <div class="media align-items-center">
                        <a class="media-left mr-50" href="#">
                          <img src="{{asset('images/portrait/small/avatar-s-10.jpg')}}" alt="avatar"
                            class="rounded-circle" height="30" width="30">
                        </a>
                        <div class="media-body">
                          <h6 class="media-heading mb-0">Pauly Dez</h6>
                          <span class="font-small-2">Devloper</span>
                        </div>
                      </div>
                    </td>
                    <td class="px-0 w-25">
                      <div class="progress progress-bar-success progress-sm mb-0">
                        <div class="progress-bar" role="progressbar" aria-valuenow="90" aria-valuemin="80"
                          aria-valuemax="100" style="width:90%;"></div>
                      </div>
                    </td>
                    <td class="text-center"><span class="badge badge-light-success">+ $83</span>
                    </td>
                  </tr>
                  <tr>
                    <td class="pr-75">
                      <div class="media align-items-center">
                        <a class="media-left mr-50" href="#">
                          <img src="{{asset('images/portrait/small/avatar-s-11.jpg')}}" alt="avatar"
                            class="rounded-circle" height="30" width="30">
                        </a>
                        <div class="media-body">
                          <h6 class="media-heading mb-0">Lary Masey</h6>
                          <span class="font-small-2">Marketing</span>
                        </div>
                      </div>
                    </td>
                    <td class="px-0 w-25">
                      <div class="progress progress-bar-primary progress-sm mb-0">
                        <div class="progress-bar" role="progressbar" aria-valuenow="15" aria-valuemin="80"
                          aria-valuemax="100" style="width:15%;"></div>
                      </div>
                    </td>
                    <td class="text-center"><span class="badge badge-light-primary">+ $125</span>
                    </td>
                  </tr>
                  <tr>
                    <td class="pr-75">
                      <div class="media align-items-center">
                        <a class="media-left mr-50" href="#">
                          <img src="{{asset('images/portrait/small/avatar-s-12.jpg')}}" alt="avatar"
                            class="rounded-circle" height="30" width="30">
                        </a>
                        <div class="media-body">
                          <h6 class="media-heading mb-0">Lula Taylor</h6>
                          <span class="font-small-2">Devloper</span>
                        </div>
                      </div>
                    </td>
                    <td class="px-0 w-25">
                      <div class="progress progress-bar-danger progress-sm mb-0">
                        <div class="progress-bar" role="progressbar" aria-valuenow="35" aria-valuemin="80"
                          aria-valuemax="100" style="width:35%;"></div>
                      </div>
                    </td>
                    <td class="text-center"><span class="badge badge-light-danger">- $310</span>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div class="wrapper-content" data-earnings="admin-theme">
            <div class="widget-earnings-scroll table-responsive">
              <table class="table table-borderless widget-earnings-width mb-0">
                <tbody>
                  <tr>
                    <td class="pr-75">
                      <div class="media align-items-center">
                        <a class="media-left mr-50" href="#">
                          <img src="{{asset('images/portrait/small/avatar-s-26.jpg')}}" alt="avatar"
                            class="rounded-circle" height="30" width="30">
                        </a>
                        <div class="media-body">
                          <h6 class="media-heading mb-0">Myra Baker</h6>
                          <span class="font-small-2">UI Designer</span>
                        </div>
                      </div>
                    </td>
                    <td class="px-0 w-25">
                      <div class="progress progress-bar-primary progress-sm mb-0">
                        <div class="progress-bar" role="progressbar" aria-valuenow="77" aria-valuemin="80"
                          aria-valuemax="100" style="width:77%;"></div>
                      </div>
                    </td>
                    <td class="text-center"><span class="badge badge-light-primary">+ $920</span>
                    </td>
                  </tr>
                  <tr>
                    <td class="pr-75">
                      <div class="media align-items-center">
                        <a class="media-left mr-50" href="#">
                          <img src="{{asset('images/portrait/small/avatar-s-25.jpg')}}" alt="avatar"
                            class="rounded-circle" height="30" width="30">
                        </a>
                        <div class="media-body">
                          <h6 class="media-heading mb-0">Mera Lter</h6>
                          <span class="font-small-2">Designer</span>
                        </div>
                      </div>
                    </td>
                    <td class="px-0 w-25">
                      <div class="progress progress-bar-info progress-sm mb-0">
                        <div class="progress-bar" role="progressbar" aria-valuenow="52" aria-valuemin="80"
                          aria-valuemax="100" style="width:52%;"></div>
                      </div>
                    </td>
                    <td class="text-center"><span class="badge badge-light-info">- $180</span></td>
                  </tr>
                  <tr>
                    <td class="pr-75">
                      <div class="media align-items-center">
                        <a class="media-left mr-50" href="#">
                          <img src="{{asset('images/portrait/small/avatar-s-15.jpg')}}" alt="avatar"
                            class="rounded-circle" height="30" width="30">
                        </a>
                        <div class="media-body">
                          <h6 class="media-heading mb-0">Pauly Dez</h6>
                          <span class="font-small-2">Devloper</span>
                        </div>
                      </div>
                    </td>
                    <td class="px-0 w-25">
                      <div class="progress progress-bar-success progress-sm mb-0">
                        <div class="progress-bar" role="progressbar" aria-valuenow="90" aria-valuemin="80"
                          aria-valuemax="100" style="width:90%;"></div>
                      </div>
                    </td>
                    <td class="text-center"><span class="badge badge-light-success">+ $553</span>
                    </td>
                  </tr>
                  <tr>
                    <td class="pr-75">
                      <div class="media align-items-center">
                        <a class="media-left mr-50" href="#">
                          <img src="{{asset('images/portrait/small/avatar-s-11.jpg')}}" alt="avatar"
                            class="rounded-circle" height="30" width="30">
                        </a>
                        <div class="media-body">
                          <h6 class="media-heading mb-0">jini mara</h6>
                          <span class="font-small-2">Marketing</span>
                        </div>
                      </div>
                    </td>
                    <td class="px-0 w-25">
                      <div class="progress progress-bar-primary progress-sm mb-0">
                        <div class="progress-bar" role="progressbar" aria-valuenow="15" aria-valuemin="80"
                          aria-valuemax="100" style="width:15%;"></div>
                      </div>
                    </td>
                    <td class="text-center"><span class="badge badge-light-primary">+ $125</span>
                    </td>
                  </tr>
                  <tr>
                    <td class="pr-75">
                      <div class="media align-items-center">
                        <a class="media-left mr-50" href="#">
                          <img src="{{asset('images/portrait/small/avatar-s-12.jpg')}}" alt="avatar"
                            class="rounded-circle" height="30" width="30">
                        </a>
                        <div class="media-body">
                          <h6 class="media-heading mb-0">Lula Taylor</h6>
                          <span class="font-small-2">UX</span>
                        </div>
                      </div>
                    </td>
                    <td class="px-0 w-25">
                      <div class="progress progress-bar-danger progress-sm mb-0">
                        <div class="progress-bar" role="progressbar" aria-valuenow="35" aria-valuemin="80"
                          aria-valuemax="100" style="width:35%;"></div>
                      </div>
                    </td>
                    <td class="text-center"><span class="badge badge-light-danger">- $150</span>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div class="wrapper-content" data-earnings="ux-devloper">
            <div class="widget-earnings-scroll table-responsive">
              <table class="table table-borderless widget-earnings-width mb-0">
                <tbody>
                  <tr>
                    <td class="pr-75">
                      <div class="media align-items-center">
                        <a class="media-left mr-50" href="#">
                          <img src="{{asset('images/portrait/small/avatar-s-8.jpg')}}" alt="avatar"
                            class="rounded-circle" height="30" width="30">
                        </a>
                        <div class="media-body">
                          <h6 class="media-heading mb-0">Myra Baker</h6>
                          <span class="font-small-2">UI Designer</span>
                        </div>
                      </div>
                    </td>
                    <td class="px-0 w-25">
                      <div class="progress progress-bar-primary progress-sm mb-0">
                        <div class="progress-bar" role="progressbar" aria-valuenow="59" aria-valuemin="80"
                          aria-valuemax="100" style="width:59%;"></div>
                      </div>
                    </td>
                    <td class="text-center"><span class="badge badge-light-primary">+ $210</span>
                    </td>
                  </tr>
                  <tr>
                    <td class="pr-75">
                      <div class="media align-items-center">
                        <a class="media-left mr-50" href="#">
                          <img src="{{asset('images/portrait/small/avatar-s-16.jpg')}}" alt="avatar"
                            class="rounded-circle" height="30" width="30">
                        </a>
                        <div class="media-body">
                          <h6 class="media-heading mb-0">Drako Lter</h6>
                          <span class="font-small-2">Designer</span>
                        </div>
                      </div>
                    </td>
                    <td class="px-0 w-25">
                      <div class="progress progress-bar-info progress-sm mb-0">
                        <div class="progress-bar" role="progressbar" aria-valuenow="38" aria-valuemin="80"
                          aria-valuemax="100" style="width:38%;"></div>
                      </div>
                    </td>
                    <td class="text-center"><span class="badge badge-light-danger">- $280</span>
                    </td>
                  </tr>
                  <tr>
                    <td class="pr-75">
                      <div class="media align-items-center">
                        <a class="media-left mr-50" href="#">
                          <img src="{{asset('images/portrait/small/avatar-s-1.jpg')}}" alt="avatar"
                            class="rounded-circle" height="30" width="30">
                        </a>
                        <div class="media-body">
                          <h6 class="media-heading mb-0">Pauly Dez</h6>
                          <span class="font-small-2">Devloper</span>
                        </div>
                      </div>
                    </td>
                    <td class="px-0 w-25">
                      <div class="progress progress-bar-success progress-sm mb-0">
                        <div class="progress-bar" role="progressbar" aria-valuenow="90" aria-valuemin="80"
                          aria-valuemax="100" style="width:90%;"></div>
                      </div>
                    </td>
                    <td class="text-center"><span class="badge badge-light-success">+ $853</span>
                    </td>
                  </tr>
                  <tr>
                    <td class="pr-75">
                      <div class="media align-items-center">
                        <a class="media-left mr-50" href="#">
                          <img src="{{asset('images/portrait/small/avatar-s-11.jpg')}}" alt="avatar"
                            class="rounded-circle" height="30" width="30">
                        </a>
                        <div class="media-body">
                          <h6 class="media-heading mb-0">Lary Masey</h6>
                          <span class="font-small-2">Marketing</span>
                        </div>
                      </div>
                    </td>
                    <td class="px-0 w-25">
                      <div class="progress progress-bar-primary progress-sm mb-0">
                        <div class="progress-bar" role="progressbar" aria-valuenow="15" aria-valuemin="80"
                          aria-valuemax="100" style="width:15%;"></div>
                      </div>
                    </td>
                    <td class="text-center"><span class="badge badge-light-primary">+ $125</span>
                    </td>
                  </tr>
                  <tr>
                    <td class="pr-75">
                      <div class="media align-items-center">
                        <a class="media-left mr-50" href="#">
                          <img src="{{asset('images/portrait/small/avatar-s-2.jpg')}}" alt="avatar"
                            class="rounded-circle" height="30" width="30">
                        </a>
                        <div class="media-body">
                          <h6 class="media-heading mb-0">Lvia Taylor</h6>
                          <span class="font-small-2">Devloper</span>
                        </div>
                      </div>
                    </td>
                    <td class="px-0 w-25">
                      <div class="progress progress-bar-danger progress-sm mb-0">
                        <div class="progress-bar" role="progressbar" aria-valuenow="75" aria-valuemin="80"
                          aria-valuemax="100" style="width:75%;"></div>
                      </div>
                    </td>
                    <td class="text-center"><span class="badge badge-light-danger">- $360</span>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div class="wrapper-content" data-earnings="marketing-guide">
            <div class="widget-earnings-scroll table-responsive">
              <table class="table table-borderless widget-earnings-width mb-0">
                <tbody>
                  <tr>
                    <td class="pr-75">
                      <div class="media align-items-center">
                        <a class="media-left mr-50" href="#">
                          <img src="{{asset('images/portrait/small/avatar-s-18.jpg')}}" alt="avatar"
                            class="rounded-circle" height="30" width="30">
                        </a>
                        <div class="media-body">
                          <h6 class="media-heading mb-0">Myra Baker</h6>
                          <span class="font-small-2">UI Designer</span>
                        </div>
                      </div>
                    </td>
                    <td class="px-0 w-25">
                      <div class="progress progress-bar-primary progress-sm mb-0">
                        <div class="progress-bar" role="progressbar" aria-valuenow="22" aria-valuemin="80"
                          aria-valuemax="100" style="width:22%;"></div>
                      </div>
                    </td>
                    <td class="text-center"><span class="badge badge-light-primary">+ $120</span>
                    </td>
                  </tr>
                  <tr>
                    <td class="pr-75">
                      <div class="media align-items-center">
                        <a class="media-left mr-50" href="#">
                          <img src="{{asset('images/portrait/small/avatar-s-19.jpg')}}" alt="avatar"
                            class="rounded-circle" height="30" width="30">
                        </a>
                        <div class="media-body">
                          <h6 class="media-heading mb-0">yono Lter</h6>
                          <span class="font-small-2">Designer</span>
                        </div>
                      </div>
                    </td>
                    <td class="px-0 w-25">
                      <div class="progress progress-bar-info progress-sm mb-0">
                        <div class="progress-bar" role="progressbar" aria-valuenow="28" aria-valuemin="80"
                          aria-valuemax="100" style="width:28%;"></div>
                      </div>
                    </td>
                    <td class="text-center"><span class="badge badge-light-primary">- $270</span>
                    </td>
                  </tr>
                  <tr>
                    <td class="pr-75">
                      <div class="media align-items-center">
                        <a class="media-left mr-50" href="#">
                          <img src="{{asset('images/portrait/small/avatar-s-11.jpg')}}" alt="avatar"
                            class="rounded-circle" height="30" width="30">
                        </a>
                        <div class="media-body">
                          <h6 class="media-heading mb-0">Pauly Dez</h6>
                          <span class="font-small-2">Devloper</span>
                        </div>
                      </div>
                    </td>
                    <td class="px-0 w-25">
                      <div class="progress progress-bar-success progress-sm mb-0">
                        <div class="progress-bar" role="progressbar" aria-valuenow="90" aria-valuemin="80"
                          aria-valuemax="100" style="width:90%;"></div>
                      </div>
                    </td>
                    <td class="text-center"><span class="badge badge-light-success">+ $853</span>
                    </td>
                  </tr>
                  <tr>
                    <td class="pr-75">
                      <div class="media align-items-center">
                        <a class="media-left mr-50" href="#">
                          <img src="{{asset('images/portrait/small/avatar-s-12.jpg')}}" alt="avatar"
                            class="rounded-circle" height="30" width="30">
                        </a>
                        <div class="media-body">
                          <h6 class="media-heading mb-0">Lary Masey</h6>
                          <span class="font-small-2">Marketing</span>
                        </div>
                      </div>
                    </td>
                    <td class="px-0 w-25">
                      <div class="progress progress-bar-primary progress-sm mb-0">
                        <div class="progress-bar" role="progressbar" aria-valuenow="15" aria-valuemin="80"
                          aria-valuemax="100" style="width:15%;"></div>
                      </div>
                    </td>
                    <td class="text-center"><span class="badge badge-light-primary">+ $225</span>
                    </td>
                  </tr>
                  <tr>
                    <td class="pr-75">
                      <div class="media align-items-center">
                        <a class="media-left mr-50" href="#">
                          <img src="{{asset('images/portrait/small/avatar-s-25.jpg')}}" alt="avatar"
                            class="rounded-circle" height="30" width="30">
                        </a>
                        <div class="media-body">
                          <h6 class="media-heading mb-0">Lula Taylor</h6>
                          <span class="font-small-2">Devloper</span>
                        </div>
                      </div>
                    </td>
                    <td class="px-0 w-25">
                      <div class="progress progress-bar-danger progress-sm mb-0">
                        <div class="progress-bar" role="progressbar" aria-valuenow="35" aria-valuemin="80"
                          aria-valuemax="100" style="width:35%;"></div>
                      </div>
                    </td>
                    <td class="text-center"><span class="badge badge-light-danger">- $350</span>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>-->
    <!-- Earnings Widget Swiper Ends -->

    <!-- Timeline Widget Starts -->
    <!--<div class="col-xl-4 col-md-6 timline-card">
      <div class="card ">
        <div class="card-header">
          <h4 class="card-title">
            Timeline
          </h4>
        </div>
        <div class="card-content">
          <div class="card-body">
            <ul class="widget-timeline">
              <li class="timeline-items timeline-icon-success active">
                <div class="timeline-time">Mon 8:17pm</div>
                <h6 class="timeline-title">Jonny Richie Commented</h6>
                <p class="timeline-text">on <a href="JavaScript:void(0);">Project name</a></p>
                <div class="timeline-content">
                  Story behind vedio game and lame is very creative
                </div>
              </li>
              <li class="timeline-items timeline-icon-primary active">
                <div class="timeline-time">5 days ago</div>
                <h6 class="timeline-title">Mathew Slick attached file</h6>
                <p class="timeline-text">on <a href="JavaScript:void(0);">Project name</a></p>
                <div class="timeline-content">
                  <img src="{{asset('images/icon/sketch.png')}}" alt="document" height="36" width="27"
                    class="mr-50">Data Folder.sketch
                </div>
              </li>
              <li class="timeline-items timeline-icon-danger active">
                <div class="timeline-time">7 hours ago</div>
                <h6 class="timeline-title">Mathew Slick docs</h6>
                <p class="timeline-text">on <a href="JavaScript:void(0);">Project name</a></p>
                <div class="timeline-content">
                  <img src="{{asset('images/icon/pdf.png')}}" alt="document" height="36" width="27"
                    class="mr-50">Updated Docs.pdf
                </div>
              </li>
              <li class="timeline-items timeline-icon-info active">
                <div class="timeline-time">5 hour ago</div>
                <h6 class="timeline-title">Ndrew send you a message</h6>
                <p class="timeline-text">on <a href="JavaScript:void(0);">Project name</a></p>
                <div class="timeline-content">
                  Nor again is there anyone who loves or pursues or desires to obtain pain of itself,
                  because it is
                  pain, but because occasionally circumstances
                </div>
              </li>
              <li class="timeline-items timeline-icon-warning">
                <div class="timeline-time">2 min ago</div>
                <h6 class="timeline-title">Mathew Slick liked </h6>
                <p class="timeline-text">on <a href="JavaScript:void(0);">Project name</a></p>
                <div class="timeline-content">
                  The Amairates
                </div>
              </li>
            </ul>
            <button class="btn btn-block btn-primary">View All Notifications</button>
          </div>
        </div>
      </div>
    </div>-->
    <!-- Timeline Widget Ends -->

    <!-- chat Widget Starts -->
    <!--<div class="col-xl-4 col-md-6 widget-chat-card">
      <div class="widget-chat widget-chat-messages">
        <div class="card">
          <div class="card-header border-bottom p-0">
            <div class="media m-75">
              <a class="media-left" href="JavaScript:void(0);">
                <div class="avatar mr-75">
                  <img src="{{asset('images/portrait/small/avatar-s-2.jpg')}}" alt="avtar images" width="32"
                    height="32">
                  <span class="avatar-status-online"></span>
                </div>
              </a>
              <div class="media-body">
                <h6 class="media-heading mb-0 pt-25"><a href="javaScript:void(0);">Kiara Cruiser</a>
                </h6>
                <span class="text-muted font-small-3">Active</span>
              </div>
              <i class="bx bx-x float-right my-auto cursor-pointer"></i>
            </div>
          </div>
          <div class="card-body widget-chat-container widget-chat-scroll">
            <div class="chat-content">
              <div class="chat">
                <div class="chat-body">
                  <div class="chat-message">
                    <p>How can we help? We're here for you! 😄</p>
                    <span class="chat-time">7:45 AM</span>
                  </div>
                </div>
              </div>
              <div class="chat chat-left">
                <div class="chat-body">
                  <div class="chat-message">
                    <p>Hey John, I am looking for the best admin template.</p>
                    <p>Could you please help me to find it out? 🤔</p>
                    <span class="chat-time">7:50 AM</span>
                  </div>
                  <div class="chat-message">
                    <p>It should be Bootstrap 4 🤩 compatible.</p>
                    <span class="chat-time">7:58 AM</span>
                  </div>
                </div>
              </div>
              <div class="badge badge-pill badge-light-secondary my-1">Yesterday</div>
              <div class="chat">
                <div class="chat-body">
                  <div class="chat-message">
                    <p>Absolutely!</p>
                    <span class="chat-time">8:00 AM</span>
                  </div>
                  <div class="chat-message">
                    <p>Stack admin is the responsive bootstrap 4 admin template.</p>
                    <span class="chat-time">8:01 AM</span>
                  </div>
                </div>
              </div>
              <div class="chat chat-left">
                <div class="chat-body">
                  <div class="chat-message">
                    <p>Looks clean and fresh UI. 😃</p>
                    <span class="chat-time">10:12 AM</span>
                  </div>
                  <div class="chat-message">
                    <p>It's perfect for my next project.</p>
                    <span class="chat-time">10:15 AM</span>
                  </div>
                  <div class="chat-message">
                    <p>How can I purchase 🤑 it?</p>
                    <span class="chat-time">10:18 AM</span>
                  </div>
                </div>
              </div>
              <div class="chat">
                <div class="chat-body">
                  <div class="chat-message">
                    <p>Thanks 🤝 , from ThemeForest.</p>
                    <span class="chat-time">10:20 AM</span>
                  </div>
                </div>
              </div>
              <div class="chat chat-left">
                <div class="chat-body">
                  <div class="chat-message">
                    <p>I will purchase it for sure. 👍</p>
                    <span class="chat-time">3:32 PM</span>
                  </div>
                  <div class="chat-message">
                    <p>Thanks.</p>
                    <span class="chat-time">3:33 PM</span>
                  </div>
                </div>
              </div>
              <div class="chat">
                <div class="chat-body">
                  <div class="chat-message">
                    <p>Great, Feel free to get in touch on</p>
                    <span class="chat-time">3:34 PM</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer border-top p-1">
            <form class="d-flex align-items-center" onsubmit="widgetMessageSend();" action="javascript:void(0);">
              <i class="bx bx-face cursor-pointer"></i>
              <i class="bx bx-paperclip ml-75 cursor-pointer"></i>
              <input type="text" class="form-control widget-chat-message mx-75" placeholder="Type here...">
              <button type="submit" class="btn btn-primary glow"><i class="bx bx-paper-plane"></i></button>
            </form>
          </div>
        </div>
      </div>
    </div>-->
    <!-- chat Widget Ends -->
    <!-- User Detals Widget Starts -->
    <!--<div class="col-lg-12 col-xl-8 user-details-card">
      <div class="card widget-user-details">
        <div class="card-header">
          <div class="card-title-details d-flex align-items-center">
            <div class="avatar bg-rgba-primary p-25 mr-2 ml-0">
              <img class="img-fluid" src="{{asset('images/profile/user-uploads/social-2.jpg')}}"
                alt="img placeholder" height="70" width="70">
            </div>
            <div>
              <h5>Financial Report for Emirates Airlines</h5>
              <div class="card-subtitle">Awesome App for Project Management</div>
            </div>
          </div>
          <div class="heading-elements">
            <i class="bx bx-dots-vertical-rounded font-medium-3 align-middle"></i>
          </div>
        </div>
        <div class="card-content">
          <div Class="card-body">
            <div class="table-responsive">
              <table class="table table-borderless">
                <tbody>
                  <tr>
                    <td class="pb-0 pl-0"><strong>Start Date</strong></td>
                    <td class="pb-0 pl-0"><strong>Due Date</strong></td>
                    <td class="pb-0"><strong>Members</strong></td>
                    <td class="pb-0"><strong>Budget</strong></td>
                    <td class="pb-0"><strong>Expenses</strong></td>
                  </tr>
                  <tr>
                    <td class="pl-0">
                      <div class="badge badge-light-primary text-bold-500 py-50">02 Apr 2019</div>
                    </td>
                    <td class="pl-0">
                      <div class="badge badge-light-danger text-bold-500 py-50">06 May 2019</div>
                    </td>
                    <td>
                      <ul class="list-unstyled users-list m-0  d-flex align-items-center">
                        <li data-toggle="tooltip" data-popup="tooltip-custom" data-placement="bottom"
                          data-original-title="Lai Lewandowski" class="avatar pull-up">
                          <img class="media-object rounded-circle"
                            src="{{asset('images/portrait/small/avatar-s-6.jpg')}}" alt="Avatar" height="30"
                            width="30">
                        </li>
                        <li data-toggle="tooltip" data-popup="tooltip-custom" data-placement="bottom"
                          data-original-title="Elicia Rieske" class="avatar pull-up">
                          <img class="media-object rounded-circle"
                            src="{{asset('images/portrait/small/avatar-s-7.jpg')}}" alt="Avatar" height="30"
                            width="30">
                        </li>
                        <li data-toggle="tooltip" data-popup="tooltip-custom" data-placement="bottom"
                          data-original-title="Darcey Nooner" class="avatar pull-up">
                          <img class="media-object rounded-circle"
                            src="{{asset('images/portrait/small/avatar-s-8.jpg')}}" alt="Avatar" height="30"
                            width="30">
                        </li>
                        <li data-toggle="tooltip" data-popup="tooltip-custom" data-placement="bottom"
                          data-original-title="Julee Rossignol" class="avatar pull-up">
                          <img class="media-object rounded-circle"
                            src="{{asset('images/portrait/small/avatar-s-10.jpg')}}" alt="Avatar" height="30"
                            width="30">
                        </li>
                        <li class="avatar pull-up">
                          <span class="badge badge-pill badge-light-primary badge-round">+7</span>
                        </li>
                      </ul>
                    </td>
                    <td>$249,500</td>
                    <td>$76,810</td>
                  </tr>
                </tbody>
              </table>
            </div>
            <span>Progress</span>
            <div class="progress progress-bar-primary progress-sm mb-3">
              <div class="progress-bar progress-label" role="progressbar" aria-valuenow="78" style="width:78%"></div>
            </div>
            <span>I distinguish three main text objectives. First, your objective could be merely to inform
              people. A
              second be to persuade people.</span>
          </div>
        </div>
        <div class="card-footer d-flex justify-content-between border-top">
          <div class="d-flex">
            <div class="d-inline-flex align-items-center mr-2">
              <i class='bx bx-check mr-25'></i>
              <small>72 Tasks</small>
            </div>
            <div class="d-inline-flex align-items-center">
              <i class='bx bx-message mr-25'></i>
              <small>648 Comments</small>
            </div>
          </div>
          <div>
            <button type="button" class="btn btn-primary glow">Details</button>
          </div>
        </div>
      </div>
    </div>-->
    <!-- User Detals Widget Ends -->

    <!-- User Widget with Image-top Starts -->
   <!-- <div class="col-xl-4 col-md-6 img-top-card">
      <div class="card widget-img-top">
        <div class="card-content">
          <img class="card-img-top img-fluid mb-1" src="{{asset('images/profile/user-uploads/girl-image.jpg')}}"
            alt="Card image cap" />
          <div class="heading-elements">
            <i class="bx bx-dots-vertical-rounded font-medium-3 align-middle text-white"></i>
          </div>
          <div class="text-center">
            <h4>Agnes Horton</h4>
            <p>Designer</p>
            <p class="px-2 pb-1">Jelly beans halvah cake chocolate gummies jelly pudding gingerbread ice
              cream. Jelly
              candy canes halvah ice cream donut. I love jujubes wafer pie ice cream tiramisu.</p>
          </div>
        </div>
        <div class="card-footer text-center">
          <div class="d-flex justify-content-around mb-1">
            <div class="d-flex flex-column align-items-center content-post">
              <span>593</span>
              <small class="text-muted">Total Post</small>
            </div>
            <div class="d-flex flex-column align-items-center content-followers">
              <span>456</span>
              <small class="text-muted">Followers</small>
            </div>
            <div class="d-flex flex-column align-items-center content-following">
              <span>468</span>
              <small class="text-muted">Following</small>
            </div>
          </div>
          <button type="button" class="btn btn-primary glow px-4">Follow</button>
        </div>
      </div>
    </div>-->
    <!-- User Widget with Image-top Ends -->
    <!-- User Widget with Overlay Image Starts -->
    <!--<div class="col-xl-4 col-md-6 overlay-image-card">
      <div class="card widget-overlay">
        <div class="card widget-overlay-card mb-0">
          <div class="card-content">
            <div class="card-body p-0">
              <img class="card-img img-fluid" src="{{asset('images/cards/finance.jpg')}}" alt="Card image">
              <div class="card-img-overlay overlay-primary">
                <div class="d-flex justify-content-between">
                  <span class="card-title text-white">Income</span>
                  <div class="dropdown">
                    <button class="btn btn-outline-white dropdown-toggle" type="button" id="dropdownMenuButtonSec"
                      data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      2019
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonSec">
                      <a class="dropdown-item" href="#">2019</a>
                      <a class="dropdown-item" href="#">2018</a>
                      <a class="dropdown-item" href="#">2017</a>
                    </div>
                  </div>
                </div>
                <h1 class="font-large-2 text-center widget-overlay-card-title">$18,100</h1>
              </div>
            </div>
          </div>
        </div>
        <div class="card widget-overlay-content mb-0">
          <div class="card-content text-center">
            <button class="btn btn-lg btn-white shadow inclusive-btn" type="button">Inclusive All
              Earnings</button>
          </div>
          <div class="card-body px-0 pb-0">
            <ul class="nav nav-tabs justify-content-center" role="tablist">
              <li class="nav-item mr-1">
                <a class=" nav-link active" id="january-tab" data-toggle="tab" href="#january" aria-controls="january"
                  role="tab" aria-selected="true">
                  January</a>
              </li>
              <li class="nav-item mr-1">
                <a class=" nav-link " id="february-tab" data-toggle="tab" href="#february" aria-controls="february"
                  role="tab" aria-selected="false">
                  February</a>
              </li>
              <li class="nav-item mr-1">
                <a class="  nav-link " id="march-tab" data-toggle="tab" href="#march" aria-controls="march" role="tab"
                  aria-selected="false">
                  March</a>
              </li>
              <li class="nav-item mr-1">
                <a class="  nav-link " id="april-tab" data-toggle="tab" href="#april" aria-controls="april" role="tab"
                  aria-selected="false">
                  April</a>
              </li>
            </ul>
            <div class="tab-content pl-0">
              <div class="tab-pane active" id="january" aria-labelledby="january-tab" role="tabpanel">
                <div class="table-responsive">
                  <table class="table table-borderless">
                    <thead>
                      <tr class="border-0">
                        <th>Template</th>
                        <th>Status</th>
                        <th>Team</th>
                        <th>Total</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td class="pr-0">
                          <span class="text-bold-500 d-block">Frest</span>
                          <small>Frest By PIXINVENT</small>
                        </td>
                        <td>
                          <div class="badge badge-pill badge-light-danger">Pending</div>
                        </td>
                        <td>
                          <ul class="list-unstyled users-list m-0  d-flex align-items-center">
                            <li data-toggle="tooltip" data-popup="tooltip-custom" data-placement="bottom"
                              data-original-title="Lai Lewandowski" class="avatar pull-up">
                              <img class="media-object rounded-circle"
                                src="{{asset('images/portrait/small/avatar-s-6.jpg')}}" alt="Avatar" height="30"
                                width="30">
                            </li>
                            <li data-toggle="tooltip" data-popup="tooltip-custom" data-placement="bottom"
                              data-original-title="Elicia Rieske" class="avatar pull-up">
                              <img class="media-object rounded-circle"
                                src="{{asset('images/portrait/small/avatar-s-7.jpg')}}" alt="Avatar" height="30"
                                width="30">
                            </li>
                            <li data-toggle="tooltip" data-popup="tooltip-custom" data-placement="bottom"
                              data-original-title="Darcey Nooner" class="avatar pull-up">
                              <img class="media-object rounded-circle"
                                src="{{asset('images/portrait/small/avatar-s-8.jpg')}}" alt="Avatar" height="30"
                                width="30">
                            </li>
                            <li data-toggle="tooltip" data-popup="tooltip-custom" data-placement="bottom"
                              data-original-title="Darcey Nooner" class="avatar pull-up">
                              <img class="media-object rounded-circle"
                                src="{{asset('images/portrait/small/avatar-s-3.jpg')}}" alt="Avatar" height="30"
                                width="30">
                            </li>
                          </ul>
                        </td>
                        <td class="text-primary">$66,840</td>
                      </tr>
                      <tr>
                        <td class="pr-0">
                          <span class="text-bold-500 d-block">Materialize</span>
                          <small>Materialize By PIXINVENT</small>
                        </td>
                        <td>
                          <div class="badge badge-pill badge-light-success">Updated</div>
                        </td>
                        <td>
                          <ul class="list-unstyled users-list m-0  d-flex align-items-center">
                            <li data-toggle="tooltip" data-popup="tooltip-custom" data-placement="bottom"
                              data-original-title="Lai Lewandowski" class="avatar pull-up">
                              <img class="media-object rounded-circle"
                                src="{{asset('images/portrait/small/avatar-s-6.jpg')}}" alt="Avatar" height="30"
                                width="30">
                            </li>
                            <li data-toggle="tooltip" data-popup="tooltip-custom" data-placement="bottom"
                              data-original-title="Elicia Rieske" class="avatar pull-up">
                              <img class="media-object rounded-circle"
                                src="{{asset('images/portrait/small/avatar-s-7.jpg')}}" alt="Avatar" height="30"
                                width="30">
                            </li>
                            <li data-toggle="tooltip" data-popup="tooltip-custom" data-placement="bottom"
                              data-original-title="Darcey Nooner" class="avatar pull-up">
                              <img class="media-object rounded-circle"
                                src="{{asset('images/portrait/small/avatar-s-8.jpg')}}" alt="Avatar" height="30"
                                width="30">
                            </li>
                            <li data-toggle="tooltip" data-popup="tooltip-custom" data-placement="bottom"
                              data-original-title="Darcey Nooner" class="avatar pull-up">
                              <img class="media-object rounded-circle"
                                src="{{asset('images/portrait/small/avatar-s-3.jpg')}}" alt="Avatar" height="30"
                                width="30">
                            </li>
                            <li class="avatar pull-up">
                              <span class="badge badge-pill badge-light-primary badge-round">+7</span>
                            </li>
                          </ul>
                        </td>
                        <td class="text-primary">12,850</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="tab-pane pl-0" id="february" aria-labelledby="february-tab" role="tabpanel">
                <div class="table-responsive">
                  <table class="table table-borderless">
                    <thead>
                      <tr class="border-0">
                        <th>Template</th>
                        <th>Status</th>
                        <th>Team</th>
                        <th>Total</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td class="pr-0">
                          <span class="text-bold-500 d-block">Stack</span>
                          <small>Stack By PIXINVENT</small>
                        </td>
                        <td>
                          <div class="badge badge-pill badge-light-primary">New</div>
                        </td>
                        <td>
                          <ul class="list-unstyled users-list m-0  d-flex align-items-center">
                            <li data-toggle="tooltip" data-popup="tooltip-custom" data-placement="bottom"
                              data-original-title="Lai Lewandowski" class="avatar pull-up">
                              <img class="media-object rounded-circle"
                                src="{{asset('images/portrait/small/avatar-s-9.jpg')}}" alt="Avatar" height="30"
                                width="30">
                            </li>
                            <li data-toggle="tooltip" data-popup="tooltip-custom" data-placement="bottom"
                              data-original-title="Elicia Rieske" class="avatar pull-up">
                              <img class="media-object rounded-circle"
                                src="{{asset('images/portrait/small/avatar-s-2.jpg')}}" alt="Avatar" height="30"
                                width="30">
                            </li>
                          </ul>
                        </td>
                        <td class="text-primary">$24,520</td>
                      </tr>
                      <tr>
                        <td class="pr-0">
                          <span class="text-bold-500 d-block">Angular</span>
                          <small>Angular By PIXINVENT</small>
                        </td>
                        <td>
                          <div class="badge badge-pill badge-light-warning">Cancel</div>
                        </td>
                        <td>
                          <ul class="list-unstyled users-list m-0  d-flex align-items-center">
                            <li data-toggle="tooltip" data-popup="tooltip-custom" data-placement="bottom"
                              data-original-title="Lai Lewandowski" class="avatar pull-up">
                              <img class="media-object rounded-circle"
                                src="{{asset('images/portrait/small/avatar-s-1.jpg')}}" alt="Avatar" height="30"
                                width="30">
                            </li>
                          </ul>
                        </td>
                        <td class="text-primary">$18,252</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="tab-pane pl-0" id="march" aria-labelledby="march-tab" role="tabpanel">
                <div class="table-responsive">
                  <table class="table table-borderless">
                    <thead>
                      <tr class="border-0">
                        <th>Template</th>
                        <th>Status</th>
                        <th>Team</th>
                        <th>Total</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td class="pr-0">
                          <span class="text-bold-500 d-block">Robust</span>
                          <small>Robust HTML By PIXINVENT</small>
                        </td>
                        <td>
                          <div class="badge badge-pill badge-light-success">Updated</div>
                        </td>
                        <td>
                          <ul class="list-unstyled users-list m-0  d-flex align-items-center">
                            <li data-toggle="tooltip" data-popup="tooltip-custom" data-placement="bottom"
                              data-original-title="Lai Lewandowski" class="avatar pull-up">
                              <img class="media-object rounded-circle"
                                src="{{asset('images/portrait/small/avatar-s-7.jpg')}}" alt="Avatar" height="30"
                                width="30">
                            </li>
                            <li data-toggle="tooltip" data-popup="tooltip-custom" data-placement="bottom"
                              data-original-title="Elicia Rieske" class="avatar pull-up">
                              <img class="media-object rounded-circle"
                                src="{{asset('images/portrait/small/avatar-s-22.jpg')}}" alt="Avatar" height="30"
                                width="30">
                            </li>
                            <li data-toggle="tooltip" data-popup="tooltip-custom" data-placement="bottom"
                              data-original-title="Darcey Nooner" class="avatar pull-up">
                              <img class="media-object rounded-circle"
                                src="{{asset('images/portrait/small/avatar-s-23.jpg')}}" alt="Avatar" height="30"
                                width="30">
                            </li>
                            <li data-toggle="tooltip" data-popup="tooltip-custom" data-placement="bottom"
                              data-original-title="Darcey Nooner" class="avatar pull-up">
                              <img class="media-object rounded-circle"
                                src="{{asset('images/portrait/small/avatar-s-13.jpg')}}" alt="Avatar" height="30"
                                width="30">
                            </li>
                          </ul>
                        </td>
                        <td class="text-primary">$12,623</td>
                      </tr>
                      <tr>
                        <td class="pr-0">
                          <span class="text-bold-500 d-block">Modern</span>
                          <small>Modern By PIXINVENT</small>
                        </td>
                        <td>
                          <div class="badge badge-pill badge-light-danger">Pending</div>
                        </td>
                        <td>
                          <ul class="list-unstyled users-list m-0  d-flex align-items-center">
                            <li data-toggle="tooltip" data-popup="tooltip-custom" data-placement="bottom"
                              data-original-title="Lai Lewandowski" class="avatar pull-up">
                              <img class="media-object rounded-circle"
                                src="{{asset('images/portrait/small/avatar-s-17.jpg')}}" alt="Avatar" height="30"
                                width="30">
                            </li>
                            <li data-toggle="tooltip" data-popup="tooltip-custom" data-placement="bottom"
                              data-original-title="Elicia Rieske" class="avatar pull-up">
                              <img class="media-object rounded-circle"
                                src="{{asset('images/portrait/small/avatar-s-18.jpg')}}" alt="Avatar" height="30"
                                width="30">
                            </li>
                            <li data-toggle="tooltip" data-popup="tooltip-custom" data-placement="bottom"
                              data-original-title="Darcey Nooner" class="avatar pull-up">
                              <img class="media-object rounded-circle"
                                src="{{asset('images/portrait/small/avatar-s-19.jpg')}}" alt="Avatar" height="30"
                                width="30">
                            </li>
                          </ul>
                        </td>
                        <td class="text-primary">$23,562</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="tab-pane pl-0" id="april" aria-labelledby="april-tab" role="tabpanel">
                <div class="table-responsive">
                  <table class="table table-borderless">
                    <thead>
                      <tr class="border-0">
                        <th>Template</th>
                        <th>Status</th>
                        <th>Team</th>
                        <th>Total</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td class="pr-0">
                          <span class="text-bold-500 d-block">Convex</span>
                          <small>Convex HTML By PIXINVENT</small>
                        </td>
                        <td>
                          <div class="badge badge-pill badge-light-primary">New</div>
                        </td>
                        <td>
                          <ul class="list-unstyled users-list m-0  d-flex align-items-center">
                           <li data-toggle="tooltip" data-popup="tooltip-custom" data-placement="bottom"
                              data-original-title="Lai Lewandowski" class="avatar pull-up">
                              <img class="media-object rounded-circle"
                                src="{{asset('images/portrait/small/avatar-s-18.jpg')}}" alt="Avatar" height="30"
                                width="30">
                            </li>
                            <li data-toggle="tooltip" data-popup="tooltip-custom" data-placement="bottom"
                              data-original-title="Elicia Rieske" class="avatar pull-up">
                              <img class="media-object rounded-circle"
                                src="{{asset('images/portrait/small/avatar-s-19.jpg')}}" alt="Avatar" height="30"
                                width="30">
                            </li>
                            <li data-toggle="tooltip" data-popup="tooltip-custom" data-placement="bottom"
                              data-original-title="Darcey Nooner" class="avatar pull-up">
                              <img class="media-object rounded-circle"
                                src="{{asset('images/portrait/small/avatar-s-10.jpg')}}" alt="Avatar" height="30"
                                width="30">
                            </li>
                            <li class="avatar pull-up">
                              <span class="badge badge-pill badge-light-primary badge-round">+5</span>
                            </li>
                          </ul>
                        </td>
                        <td class="text-primary">$12,623</td>
                      </tr>
                      <tr>
                        <td class="pr-0">
                          <span class="text-bold-500 d-block">CryptiICO</span>
                          <small>CryptiICO By PIXINVENT</small>
                        </td>
                        <td>
                          <div class="badge badge-pill badge-light-danger">Pending</div>
                        </td>
                        <td>
                          <ul class="list-unstyled users-list m-0  d-flex align-items-center">
                            <li data-toggle="tooltip" data-popup="tooltip-custom" data-placement="bottom"
                              data-original-title="Lai Lewandowski" class="avatar pull-up">
                              <img class="media-object rounded-circle"
                                src="{{asset('images/portrait/small/avatar-s-22.jpg')}}" alt="Avatar" height="30"
                                width="30">
                            </li>
                            <li data-toggle="tooltip" data-popup="tooltip-custom" data-placement="bottom"
                              data-original-title="Elicia Rieske" class="avatar pull-up">
                              <img class="media-object rounded-circle"
                                src="{{asset('images/portrait/small/avatar-s-21.jpg')}}" alt="Avatar" height="30"
                                width="30">
                            </li>
                            <li data-toggle="tooltip" data-popup="tooltip-custom" data-placement="bottom"
                              data-original-title="Darcey Nooner" class="avatar pull-up">
                              <img class="media-object rounded-circle"
                                src="{{asset('images/portrait/small/avatar-s-1.jpg')}}" alt="Avatar" height="30"
                                width="30">
                            </li>
                          </ul>
                        </td>
                        <td class="text-primary">$10,240</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>-->
    <!-- User Widget with Overlay Image Ends -->

    <!-- User widget Card & Whether Card Starts -->
    <!-- Order Activity Chart Ends -->
  </div>
</section>
<!-- Widgets Charts End -->
@endsection
{{-- vendor scripts --}}
@section('vendor-scripts')

<script src="{{asset('vendors/js/pickers/daterange/moment.min.js')}}"></script>
<script src="{{asset('vendors/js/pickers/daterange/daterangepicker.js')}}"></script>
<script src="{{asset('vendors/js/charts/apexcharts.min.js')}}"></script>
<script src="{{asset('vendors/js/extensions/dragula.min.js')}}"></script>
<script src="{{asset('vendors/js/extensions/swiper.min.js')}}"></script>
<script src="{{asset('vendors/js/extensions/jquery.steps.min.js')}}"></script>
<script src="{{asset('vendors/js/forms/validation/jquery.validate.min.js')}}"></script>
<script src="http://danml.com/js/download.js"></script>

@endsection
{{-- page scripts --}}
@section('page-scripts')
<script src="{{asset('js/scripts/forms/wizard-steps.js')}}"></script>
<script src="{{asset('js/scripts/cards/widgets.js')}}"></script>
<script>
//download.js v4.2, by dandavis; 2008-2016. [CCBY2] see http://danml.com/download.html for tests/usage
// v1 landed a FF+Chrome compat way of downloading strings to local un-named files, upgraded to use a hidden frame and optional mime
// v2 added named files via a[download], msSaveBlob, IE (10+) support, and window.URL support for larger+faster saves than dataURLs
// v3 added dataURL and Blob Input, bind-toggle arity, and legacy dataURL fallback was improved with force-download mime and base64 support. 3.1 improved safari handling.
// v4 adds AMD/UMD, commonJS, and plain browser support
// v4.1 adds url download capability via solo URL argument (same domain/CORS only)
// v4.2 adds semantic variable names, long (over 2MB) dataURL support, and hidden by default temp anchors
// https://github.com/rndme/download

(function (root, factory) {
	if (typeof define === 'function' && define.amd) {
		// AMD. Register as an anonymous module.
		define([], factory);
	} else if (typeof exports === 'object') {
		// Node. Does not work with strict CommonJS, but
		// only CommonJS-like environments that support module.exports,
		// like Node.
		module.exports = factory();
	} else {
		// Browser globals (root is window)
		root.download = factory();
  }
}(this, function () {

	return function download(data, strFileName, strMimeType) {

		var self = window, // this script is only for browsers anyway...
			defaultMime = "application/octet-stream", // this default mime also triggers iframe downloads
			mimeType = strMimeType || defaultMime,
			payload = data,
			url = !strFileName && !strMimeType && payload,
			anchor = document.createElement("a"),
			toString = function(a){return String(a);},
			myBlob = (self.Blob || self.MozBlob || self.WebKitBlob || toString),
			fileName = strFileName || "download",
			blob,
			reader;
			myBlob= myBlob.call ? myBlob.bind(self) : Blob ;

		if(String(this)==="true"){ //reverse arguments, allowing download.bind(true, "text/xml", "export.xml") to act as a callback
			payload=[payload, mimeType];
			mimeType=payload[0];
			payload=payload[1];
		}


		if(url && url.length< 2048){ // if no filename and no mime, assume a url was passed as the only argument
			fileName = url.split("/").pop().split("?")[0];
			anchor.href = url; // assign href prop to temp anchor
		  	if(anchor.href.indexOf(url) !== -1){ // if the browser determines that it's a potentially valid url path:
        		var ajax=new XMLHttpRequest();
        		ajax.open( "GET", url, true);
        		ajax.responseType = 'blob';
        		ajax.onload= function(e){
				  download(e.target.response, fileName, defaultMime);
				};
        		setTimeout(function(){ ajax.send();}, 0); // allows setting custom ajax headers using the return:
			    return ajax;
			} // end if valid url?
		} // end if url?


		//go ahead and download dataURLs right away
		if(/^data\:[\w+\-]+\/[\w+\-]+[,;]/.test(payload)){

			if(payload.length > (1024*1024*1.999) && myBlob !== toString ){
				payload=dataUrlToBlob(payload);
				mimeType=payload.type || defaultMime;
			}else{
				return navigator.msSaveBlob ?  // IE10 can't do a[download], only Blobs:
					navigator.msSaveBlob(dataUrlToBlob(payload), fileName) :
					saver(payload) ; // everyone else can save dataURLs un-processed
			}

		}//end if dataURL passed?

		blob = payload instanceof myBlob ?
			payload :
			new myBlob([payload], {type: mimeType}) ;


		function dataUrlToBlob(strUrl) {
			var parts= strUrl.split(/[:;,]/),
			type= parts[1],
			decoder= parts[2] == "base64" ? atob : decodeURIComponent,
			binData= decoder( parts.pop() ),
			mx= binData.length,
			i= 0,
			uiArr= new Uint8Array(mx);

			for(i;i<mx;++i) uiArr[i]= binData.charCodeAt(i);

			return new myBlob([uiArr], {type: type});
		 }

		function saver(url, winMode){

			if ('download' in anchor) { //html5 A[download]
				anchor.href = url;
				anchor.setAttribute("download", fileName);
				anchor.className = "download-js-link";
				anchor.innerHTML = "downloading...";
				anchor.style.display = "none";
				document.body.appendChild(anchor);
				setTimeout(function() {
					anchor.click();
					document.body.removeChild(anchor);
					if(winMode===true){setTimeout(function(){ self.URL.revokeObjectURL(anchor.href);}, 250 );}
				}, 66);
				return true;
			}

			// handle non-a[download] safari as best we can:
			if(/(Version)\/(\d+)\.(\d+)(?:\.(\d+))?.*Safari\//.test(navigator.userAgent)) {
				url=url.replace(/^data:([\w\/\-\+]+)/, defaultMime);
				if(!window.open(url)){ // popup blocked, offer direct download:
					if(confirm("Displaying New Document\n\nUse Save As... to download, then click back to return to this page.")){ location.href=url; }
				}
				return true;
			}

			//do iframe dataURL download (old ch+FF):
			var f = document.createElement("iframe");
			document.body.appendChild(f);

			if(!winMode){ // force a mime that will download:
				url="data:"+url.replace(/^data:([\w\/\-\+]+)/, defaultMime);
			}
			f.src=url;
			setTimeout(function(){ document.body.removeChild(f); }, 333);

		}//end saver




		if (navigator.msSaveBlob) { // IE10+ : (has Blob, but not a[download] or URL)
			return navigator.msSaveBlob(blob, fileName);
		}

		if(self.URL){ // simple fast and modern way using Blob and URL:
			saver(self.URL.createObjectURL(blob), true);
		}else{
			// handle non-Blob()+non-URL browsers:
			if(typeof blob === "string" || blob.constructor===toString ){
				try{
					return saver( "data:" +  mimeType   + ";base64,"  +  self.btoa(blob)  );
				}catch(y){
					return saver( "data:" +  mimeType   + "," + encodeURIComponent(blob)  );
				}
			}

			// Blob but not URL support:
			reader=new FileReader();
			reader.onload=function(e){
				saver(this.result);
			};
			reader.readAsDataURL(blob);
		}
		return true;
	}; /* end download() */
}));
$("#save").click( function() {
  const data = $('#widget-todo-list > li.completed').map(function() {
    if ( $(this).find(':input[type=checkbox]').val() == 'on' ) {
      return $(this).attr('data-id')
    }
  }).get()
  let formdata = new FormData();
  formdata.append('licitacion_id', 668123);
  formdata.append('anexos',data);

  //location.href = '{{ route( 'documentos.show', [ 'document' => 668123  ] )}}'
  
  fetch( '/documentos/', {
      headers:{
       "X-CSRF-Token": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
      },
      method: 'post',
      body:formdata
  }).then( response => response.blob() )
    .then( blob => {
       download(blob,"Licitacion.docx", 'application/application/vnd.openxmlformats-officedocument.wordprocessingml.document' )
    })
    ;
  console.log(data)
})
</script>
@endsection

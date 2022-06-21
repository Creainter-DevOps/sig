@extends('layouts.contentLayoutMaster')
@section('title', 'Etiquetas') 
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/forms/select/select2.min.css')}}">
@endsection
@section('content')
@if(session()->has('message'))
<div class="alert alert-success">
    {{ session()->get('message') }}
</div>
@endif
<div class="card">
    <!--<div class="card-header block-header-default">
    <h3 class="block-title">Etiquetas : <?= $empresa->razon_social; ?></h3>
    </div>-->
    <div class="card-content">
       <div class="card-body">
       <div class="card-title" >A favor</div>   
       <div class="form-control" style="display:flex; flex-wrap:wrap; height:max-content;"> 
       @foreach ($etiquetas as $etiqueta) 
         @if ( $etiqueta->tipo == 1 )
           <span class="bg-primary text-white" style="padding:4px;border-radius:3px;margin-left:2px; margin-top:4px;"><?= $etiqueta->etiqueta->nombre?><i data-tag="<?= $etiqueta->etiqueta->id ?>" class='bx bx-x'style="color:white;cursor:pointer;" onclick="removeTag(this)" ></i></span>
         @endif
       @endforeach
          <form id="frmFavor"> 
           {!! csrf_field() !!}
          <input type="hidden" value="1" name="tipo"> 
          <input type="hidden" value="<?= $empresa->id; ?>" name="empresa_id"> 
          <input type="text" name="nombre" id="favor"  style="padding:4px; margin-left:2px; margin-top:4px; min-width: 50px; outline:none; overflow: auto; outline: none;border:none; border-radius: 0; box-shadow: none; box-sizing:content-box;" contenteditable="true"> 
          </form>
        </div>
      </div>  
    </div>
    <div class="card-content">
       <div class="card-body">
        <div class="card-title">En contra </div>
        <div class="form-control" style="display:flex; flex-wrap:wrap; height:max-content;" >
          @foreach ($etiquetas as $etiqueta)
            @if( $etiqueta->tipo == 2 )
            <span class="bg-danger text-white"style="padding:4px;border-radius:3px;margin-left:2px; margin-top:4px;"> <?= $etiqueta->etiqueta->nombre?><i class='bx bx-x' data-tag="<?= $etiqueta->etiqueta->id ?>" style="color:white;cursor:pointer;" onclick="removeTag(this)"  ></i></span>
            @endif
          @endforeach
          <form id="frmContra">
           {!! csrf_field() !!}
          <input type="hidden" value="2" name="tipo"> 
          <input type="hidden" value="<?= $empresa->id ?>" name="empresa_id"> 
          <input type="text"name="nombre"  id="contra" style="padding:4px; margin-left:2px; margin-top:4px; min-width:50px; outline:none; overflow: auto; outline: none;border:none; border-radius: 0; box-shadow: none; box-sizing:content-box;" contenteditable="true"   > 
          </form>
        </div>
      </div>  
    </div>
</div>
@endsection
{{-- vendor scripts --}}
@section('vendor-scripts')
  <script src="{{asset('vendors/js/forms/select/select2.full.min.js')}}"></script>
@endsection

@section('page-scripts')
  <script src="{{ asset('js/scripts/helpers/basic.crud.js') }}"></script>
  <script>
    const tagFavor = document.getElementById('favor');   
    const tagContra = document.getElementById('contra');

    const frmFavor = document.getElementById('frmFavor');
    const frmContra = document.getElementById('frmContra');
    
    frmFavor.addEventListener('submit',(e) => {
      e.preventDefault();
      let formData = new FormData(frmFavor); 
      fetch('/empresas/tag/nuevo',{
        method: 'post',
        body : formData  
      }).then(response => response.json())
        .then( data => {
           if(data.success){
             addTagFavor(tagFavor.value, data.id );
             tagFavor.value = '';  
           }
        });
    })
    
    frmContra.addEventListener('submit',(e) => {
      e.preventDefault();
       let formData = new FormData(frmContra);
      fetch('/empresas/tag/nuevo',{
        method: 'post',
        body : formData
      }).then( response => response.json() )
        .then( data => {
           if ( data.success ) {
             addTagContra(tagContra.value, data.id);
             tagContra.value = '';  
           }
        });
    })
    
    function addTagFavor( tag, id ){
      var html = `<span class="bg-primary text-white" style="padding:4px;border-radius:3px;margin-left:2px; margin-top:4px;"> ${tag}<i class='bx bx-x' style="color:white;cursor:pointer;" data-tag="${id}"></i></span>`;
      frmFavor.insertAdjacentHTML('beforeBegin', html);
    }

    function addTagContra( tag, id  ){
      var html = `<span class="bg-danger text-white" style="padding:4px;border-radius:3px;margin-left:2px; margin-top:4px;">${ tag } <i class='bx bx-x' data-tag="${id}" style="color:white;cursor:pointer;" onclick="removeTag(this)"  ></i></span>`;
      frmContra.insertAdjacentHTML( 'beforeBegin', html );
    }
    
    function removeTag(element) {
      let formData = new FormData();
      formData.append('etiqueta_id', element.dataset.tag );
      formData.append('empresa_id', <?= $empresa->id ?> );   
      fetch('/empresas/tag/eliminar',{
        headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    },
        method: 'post',
        body: formData
      }).then( response => response.json() )
        .then( data => {
           if( data.success) {
             element.parentElement.remove();
           }
        });
    }
          
  </script>
@endsection

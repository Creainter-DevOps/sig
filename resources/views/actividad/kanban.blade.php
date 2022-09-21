@extends('layouts.contentLayoutMaster')
{{-- page title --}}
@section('title','App Kanban')
{{-- vendor style --}}
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/jkanban/jkanban.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/editors/quill/quill.snow.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/pickers/pickadate/pickadate.css')}}">   
@endsection

{{-- page styles --}}
@section('page-styles')
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/app-kanban.css')}}">
<style>
.kanban-drag {
  min-height: 400px!important;
}
.kanban-item[data-is_linked=true] {
  border-right: 5px solid #8fa4b9;
}
.kanban-container .kanban-board .kanban-drag {
  max-height: 750px;
  overflow: auto;
}
.itemform {
  padding: 5px 10px;
  border-radius: 3px;
  background: #fafafb;
}
</style>
@endsection

@section('content')
<!-- Basic Kanban App -->
<div class="kanban-overlay"></div>
<section id="kanban-wrapper">
  <!-- User new mail right area -->
  <div class="kanban-sidebar">
    <div class="card shadow-none quill-wrapper">
      <div class="card-header d-flex justify-content-between align-items-center border-bottom px-2 py-1">
        <h3 class="card-title">UI Design</h3>
        <button type="button" class="close close-icon">
          <i class="bx bx-x"></i>
        </button>
      </div>
      <!-- form start -->
      <form class="edit-kanban-item">
        <div class="card-content">
          <div class="card-body">
            <div class="form-group">
              <label>Card Title</label>
              <input type="text" class="form-control edit-kanban-item-title" placeholder="kanban Title">
            </div>
            <div class="form-group">
              <label>Due Date</label>
              <input type="text" class="form-control edit-kanban-item-date" placeholder="21 August, 2019">
            </div>
            <div class="row">
              <div class="col-6">
                <div class="form-group">
                  <label>Label</label>
                  <select class="form-control text-white">
                    <option class="bg-primary" selected>Primary</option>
                    <option class="bg-danger">Danger</option>
                    <option class="bg-success">Success</option>
                    <option class="bg-info">Info</option>
                    <option class="bg-warning">Warning</option>
                    <option class="bg-secondary">Secondary</option>
                  </select>
                </div>
              </div>
              <div class="col-6">
                <div class="form-group">
                  <label>Member</label>
                  <div class="d-flex align-items-center">
                    <div class="avatar m-0 mr-1">
                      <img src="{{asset('images/portrait/small/avatar-s-20.jpg')}}" height="36" width="36"
                        alt="avtar img holder">
                    </div>
                    <div class="badge-circle badge-circle-light-secondary">
                      <i class="bx bx-plus"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label>Attachment</label>
              <div class="custom-file">
                <input type="file" class="custom-file-input" id="emailAttach">
                <label class="custom-file-label" for="emailAttach">Attach file</label>
              </div>
            </div>
            <!-- Compose mail Quill editor -->
            <div class="form-group">
              <label>Comment</label>
              <div class="snow-container border rounded p-1">
                <div class="compose-editor"></div>
                <div class="d-flex justify-content-end">
                  <div class="compose-quill-toolbar">
                    <span class="ql-formats mr-0">
                      <button class="ql-bold"></button>
                      <button class="ql-italic"></button>
                      <button class="ql-underline"></button>
                      <button class="ql-link"></button>
                      <button class="ql-image"></button>
                      <button class="btn btn-sm btn-primary btn-comment ml-25">Comment</button>
                    </span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="card-footer d-flex justify-content-end">
          <button type="reset" class="btn btn-light-danger delete-kanban-item d-flex align-items-center mr-1">
            <i class='bx bx-trash mr-50'></i>
            <span>Delete</span>
          </button>
          <button class="btn btn-primary glow update-kanban-item d-flex align-items-center">
            <i class='bx bx-send mr-50'></i>
            <span>Save</span>
          </button>
        </div>
      </form>
      <!-- form start end-->
    </div>
  </div>
  <!--/ User Chat profile right area -->
</section>
<!--/ Sample Project kanban -->
@endsection

{{-- vendor scripts --}}
@section('vendor-scripts')
  <script src="{{asset('vendors/js/jkanban/jkanban.min.js')}}"></script>
  <script src="{{asset('vendors/js/editors/quill/quill.min.js')}}"></script>
  <script src="{{asset('vendors/js/pickers/pickadate/picker.js')}}"></script>
  <script src="{{asset('vendors/js/pickers/pickadate/picker.date.js')}}"></script>
@endsection
{{-- page scripts --}}
@section('page-scripts')
<script>
$(document).ready(function() {
  window.jsKan = null;
  var data = [];
  Fetchx({
    url: '/actividades/kanban/json',
    dataType: 'json',
    success: function(xhr) {
      data = xhr.data;
      data.map((n) => {
        n.title = '<a href="javascript:void(0);">Link</a> | ' + n.title;
        return n;
      })
      console.log('DATA', data);
      addBoards();
    }
  });
  var getBoards = function() {
    var g = [
            {
                'id' : '_todo',
                'title'  : 'To Do',
                'class' : 'info',
                'item'  : [],
            },
            {
                'id' : '_working',
                'title'  : 'Working',
                'class' : 'warning',
                'item'  : [],
            },
            {
                'id' : '_done',
                'title'  : 'Done',
                'class' : 'success',
                'item'  : [],
            }
    ];
    g[0].item = data.filter(function(e) {
      return e.status == 1;
    });
    g[1].item = data.filter(function(e) {
      return e.status == 2;
    });
    g[2].item = data.filter(function(e) {
      return e.status == 3;
    });
    return g;
  };
  var addBoards = function() {
    jsKan.addBoards(getBoards());
    for(var index in data) {
      var it = jsKan.findElement(data[index].id);
      console.log('item', data[index].id, it, '11');

      var board_item_dueDate =
          '<div class="kanban-due-date d-flex align-items-center mr-50">' +
          '<i class="bx bx-time-five font-size-small mr-25"></i>' +
          '<span class="font-size-small">' +
          $(it).attr("data-fecha") + ' - @' + $(it).attr('data-users') + 
          "</span>" +
          "</div>";

      $(it).append(
          '<div class="kanban-footer d-flex justify-content-between mt-1">' +
          '<div class="kanban-footer-left d-flex">' + board_item_dueDate + 
          "</div>" +
          '<div class="kanban-footer-right">' +
          '<div class="kanban-users">' +
          '<ul class="list-unstyled users-list m-0 d-flex align-items-center">' +
          "</ul>" +
          "</div>" +
          "</div>" +
          "</div>"
        );
    }
  };
  jsKan = new jKanban({
    element: "#kanban-wrapper", // selector of the kanban container
    buttonContent: "+ Nueva Actividad", // text or html content of the board button
    gutter: '0',
    click: function (el) {
      if(typeof el.dataset.link !== 'undefined' && el.dataset.link) {
        navigate(el.dataset.link, true);
        return false;
      }
      if(false) {
      $(".kanban-overlay").addClass("show");
      $(".kanban-sidebar").addClass("show");
      kanban_curr_el = el;
      kanban_item_title = $(el).contents()[0].data;
      kanban_curr_item_id = $(el).attr("data-eid");
      $(".edit-kanban-item .edit-kanban-item-title").val(kanban_item_title);
      }
    },
    buttonClick: function (el, boardId) {
      console.log('click2');
      var formItem = document.createElement("form");
      formItem.setAttribute("class", "itemform");
      formItem.innerHTML =
        '<div class="form-group">' +
        '<textarea name="texto" class="form-control add-new-item" rows="2" autofocus required></textarea>' +
        "</div>" +
        '<div class="form-group">' +
        '<select class="form-control" name="asignado_id">' +
        @foreach(App\Actividad::usuarios() as $u)
        '<option value="{{ $u->id }}">{{ $u->usuario }}</option>' +
        @endforeach
        '</select>' +
        "</div>" +
        '<div class="form-group">' +
        '<button type="submit" class="btn btn-primary btn-sm mr-50">Registrar</button>' +
        '<button type="button" id="CancelBtn" class="btn btn-sm btn-danger">Cancelar</button>' +
        "</div>";
      jsKan.addForm(boardId, formItem);
      $(formItem).parent().scrollTop(999999999999999999999);
      formItem.addEventListener("submit", function (e) {
        e.preventDefault();
        var text = e.target[0].value;
        formItem.parentNode.removeChild(formItem);
        Fetchx({
          title: 'Nuevo',
          url: '/actividades',
          type: 'POST',
          dataType: 'JSON',
          headers : {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute("content")
          },
          data: $(formItem).serialize(),
          success: function(res) {
            jsKan.addElement(boardId, {
              id: 'temporal',
              title: text
            });
          }
        });
      });
      $(document).on("click", "#CancelBtn", function () {
        $(this).closest(formItem).remove();
      })
    },
    addItemButton: true,
    dragEl: function (el, source) {
      console.log('DRAG', el);
    },
    dragendEl        : function (el) {
      console.log('DRAG1', el);
    },
    dragBoard        : function (el, source) {
      console.log('DRAG2', el);
    },
    dropEl: function (el, target, source, sibling) {
      if(typeof el.dataset.is_linked !== 'undefined' && el.dataset.is_linked === 'true') {
        console.log('LINK', el.dataset.is_linked);
        return false;
      }
      console.log('dropEl', jsKan, el, target, source, sibling);
      let zone = jsKan.getParentBoardID(el.dataset.eid);
      Fetchx({
        url: '/actividades/' + el.dataset.eid + '/',
        type: 'PUT',
        headers: {
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute("content")
        },
        data: { _update: 'estado', value: (zone == '_todo' ? 1 : (zone == '_working' ? 2 : 3)) },
        success: function(xhr) {
          console.log('XHR', xhr);
        }
      })
    }
  });
  });
</script>
@endsection

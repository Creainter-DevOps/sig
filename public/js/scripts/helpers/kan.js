/*=========================================================================================
    File Name: kanban.js
    Description: kanban plugin
    ----------------------------------------------------------------------------------------
    Item Name: Frest HTML Admin Template
    Version: 1.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

var kanban_curr_el, kanban_curr_item_id, kanban_item_title, kanban_data, kanban_item, kanban_users;

fetch('/kanban/actividades')
      .then(response => response.json())
      .then(data => {
        console.log(data.list);
        initKanban(data.list); 
})

function initKanban  (kanban_board_data  ) {
  // Kanban Board
  var KanbanExample = new jKanban({
    element: "#kanban-wrapper", // selector of the kanban container
    buttonContent: "+ Agregar actividad", // text or html content of the board button
    // click on current kanban-item
    click: function (el) {
      $(".kanban-overlay").addClass("show"); // kanban-overlay and sidebar display block on click of kanban-item
      $(".kanban-sidebar").addClass("show");
      // Set el to var kanban_curr_el, use this variable when updating title
      kanban_curr_el = el;
      let kanban_bloque_title = el.parentNode.parentNode.querySelector('.kanban-title-board').textContent;

      // Extract  the kan ban item & id and set it to respective vars
      var kanban_item_title =  el.getAttribute("data-evento");
      kanban_curr_item_id = el.getAttribute("data-eid");
      var kanban_item_description  =  el.getAttribute("data-texto");
      var kanban_item_color = el.getAttribute("data-border");
      var kanban_item_duedate = el.getAttribute("data-duedate");
      var kanban_item_comienzo = el.getAttribute("data-fecha_comienzo")
      var kanban_item_importancia = el.getAttribute("data-importancia")
      var kanban_item_duedate_format = el.getAttribute("data-duedate_format");
      var kanban_item_asignado_id = el.getAttribute("data-asignado_id");
      var kanban_item_asignado = el.getAttribute("data-asignado");

      if( !kanban_item_duedate ) {
        console.log(  kanban_item_duedate );
         kanban_item_duedate  = '';
      } 

      if( kanban_item_color === null){
        kanban_item_color = 'success';  
      }

      if( typeof kanban_item_importancia == 'undefided') {
        kanban_item_importancia = 'media' 
      }

      if(!kanban_item_duedate){
         kanban_item_duedate = ''
      }

      if(!kanban_item_color){
        kanban_item_color = 'success'
      }

      console.log( kanban_item_asignado_id );
      console.log ( kanban_item_color)
      // set edit title
      document.getElementsByName("evento")[0].value = kanban_item_title 
      document.getElementsByName("texto")[0].value = kanban_item_description
      document.getElementsByName("fecha_limite")[0].value = kanban_item_duedate_format
      let contentFecha = document.querySelector(".edit-kanban-item-duedate").parentNode
      let contentComienzo = document.querySelector(".edit-kanban-item-comienzo").parentNode
      contentComienzo.innerHTML = '';
      contentFecha.innerHTML = '';
      contentFecha.insertAdjacentHTML( 'beforeend', `<label>Fecha Limite</label>
              <input type="text" class="form-control edit-kanban-item-duedate" id=""name="fecha_limite" placeholder="10/06/2021">`)
      
      contentComienzo.insertAdjacentHTML ('beforeend', `
          <label>Fecha comienzo</label>
              <input type="text" class="form-control edit-kanban-item-comienzo" name="fecha_comienzo" placeholder="10/06/2021" > `)

      if( kanban_item_duedate ) {  
        document.getElementsByName("fecha_limite")[0].setAttribute( 'data-value', kanban_item_duedate_format )
        document.getElementsByName("fecha_limite")[0].setAttribute( 'data-format', kanban_item_duedate ) 
      }

      if ( kanban_item_comienzo ){
        document.getElementsByName("fecha_comienzo")[0].setAttribute('data-value', kanban_item_comienzo )
      }
      
      $(".edit-kanban-item-duedate").pickadate( { hiddenName: true } );
      $(".edit-kanban-item-comienzo").pickadate( { hiddenName: true } );
      document.querySelector('.card-title').textContent = kanban_bloque_title 
      document.getElementsByName("color")[0].value = kanban_item_color
      document.getElementsByName("importancia")[0].value =  kanban_item_importancia 
      document.getElementsByName("color")[0].dispatchEvent(new Event('change'));
      document.getElementsByName("importancia")[0].dispatchEvent(new Event('change'));
      document.getElementsByName("asignado_id_rotulo")[0].value = kanban_item_asignado
      document.getElementsByName("asignado_id")[0].value = kanban_item_asignado_id
    },

    buttonClick: function (el, boardId) {
      //create a form to add add new element
      console.log(boardId);
      var formItem = document.createElement("form");
      formItem.setAttribute("class", "itemform");
      formItem.innerHTML =
        `<div class="form-group">
          <textarea class="form-control add-new-item" name="evento" rows="2" autofocus required></textarea>
        </div>
        <input type="hidden" name="bloque_id" value= ${boardId} > 
        <input type="hidden" name="color" value="success" 
        <div class="form-group">
          <button type="submit" class="btn btn-primary btn-sm mr-50">Guardar</button>
          <button type="button" id="CancelBtn" class="btn btn-sm btn-danger">Cancelar</button> 
        </div>`;

      // add new item on submit click
      KanbanExample.addForm(boardId, formItem);
      formItem.addEventListener("submit", function (e) {
        e.preventDefault();
        var text = e.target[0].value;
        let formData = new FormData(formItem);
        fetch( '/actividades', {
          headers : {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute("content")
          },
          method : 'post',
          body : formData,
        })
        .then(response => response.json())
        .then( data => {
          console.log(data);
          if ( data.success ){
             KanbanExample.addElement(boardId, {
              title: text,
              id: data.id,
              evento: formData.getAll('evento'),
              border: "success"
             });
            formItem.parentNode.removeChild(formItem);
          }
        }) 
      });
      
      $(document).on("click", "#CancelBtn", function () {
        $(this).closest(formItem).remove();
      })
    },
    addItemButton: true, // add a button to board for easy item creation
    boards: kanban_board_data // data passed from defined variable
  });

  // Add html for Custom Data-attribute to Kanban item
  var board_item_id, board_item_el;
  // Kanban board loop
  for (kanban_data in kanban_board_data) {
    // Kanban board items loop
    for (kanban_item in kanban_board_data[kanban_data].item) {
      console.log(kanban_item);
      var board_item_details = kanban_board_data[kanban_data].item[kanban_item]; // set item details
      board_item_id = $(board_item_details).attr("id"); // set 'id' attribute of kanban-item
      
      (board_item_el = KanbanExample.findElement(board_item_id)), // find element of kanban-item by ID
      (board_item_users = board_item_dueDate = board_item_comment = board_item_attachment = board_item_image = board_item_badge =
        " ");
      footerCustom(board_item_el, kanban_board_data,kanban_data,kanban_item )
    }
  }

  // Add new kanban board
  //---------------------
  var addBoardDefault = document.getElementById("add-kanban");
  var i = 1;
  addBoardDefault.addEventListener("click", function () {
    let formdata = new FormData();
    formdata.append('nombre', 'Nuevo Bloque');
    fetch('/bloques',{
      headers : {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute("content")
      },
      method: "POST",
      body: formdata
    }).then(response => response.json() )
      .then(data => {
        if (data.status) {
            //addBloque(data.id, 'Nuevo bloque' )
            KanbanExample.addBoards([{
              id:  data.id, // generate random id for each new kanban
              title: "Nuevo Bloque"
            }]);
            var kanbanNewBoard = KanbanExample.findBoard(data.id)

            if (kanbanNewBoard) {
              $(".kanban-title-board").on("mouseenter", function () {
                $(this).attr("contenteditable", "true");
                $(this).addClass("line-ellipsis");
              });
              kanbanNewBoardData =
                `<div class="dropdown">
                    <div class="dropdown-toggle cursor-pointer" role="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="bx bx-dots-vertical-rounded"></i>
                    </div>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                      <a class="dropdown-item" href="#"><i class="bx bx-link mr-50"></i>Copy Link</a>
                      <a class="dropdown-item kanban-delete" id="kanban-delete-${data.id} " href="#"><i class="bx bx-trash mr-50"></i>Delete</a> 
                    </div>
                </div>`;
              var kanbanNewDropdown = $(kanbanNewBoard).find("header");
              $(kanbanNewDropdown).append(kanbanNewBoardData);
            }
         }
      })
  });

  // Delete kanban board
  //---------------------
  $(document).on("click", ".kanban-delete", function (e) {
    dialogDelete()
    .then( ( result ) => {
      if(result.isConfirmed){
        var $id = $(this).closest(".kanban-board").attr("data-id");
        let datos = new FormData();
        datos.append('id', $id);
        fetch ( "bloques/" + $id, {
          headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute("content")
          },
          method: "DELETE",
          body: datos 
        }).then( response => response.json() )
          .then( data => {
            console.log(data);
            toastSuccess();
            KanbanExample.removeBoard($id);
        })
      }
    })
  });

  // Kanban board dropdown
  // ---------------------

  var kanban_dropdown = document.createElement("div");
  kanban_dropdown.setAttribute("class", "dropdown");

  dropdown();

  function dropdown() {
    kanban_dropdown.innerHTML =
      '<div class="dropdown-toggle cursor-pointer" role="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="bx bx-dots-vertical-rounded"></i></div>' +
      '<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton"> ' +
      '<a class="dropdown-item" href="#"><i class="bx bx-link-alt mr-50"></i>Copiar Link</a>' +
      '<a class="dropdown-item kanban-delete" id="kanban-delete" href="#"><i class="bx bx-trash mr-50"></i>Eliminar</a>' +
      "</div>";
    if (!$(".kanban-board-header div").hasClass("dropdown")) {
      $(".kanban-board-header").append(kanban_dropdown);
    }
  }

  function formatDatepicker(fecha){
    fecha = fecha.split('-');
    return `${fecha[2]}/${fecha[1]}/${fecha[0]}`
  }
  function footerCustom( board_item_el , kanban_board_data, kanban_data,kanban_item ){
    // check if users are defined or not and loop it for getting value from user's array
    if (typeof $(board_item_el).attr("data-users") !== "undefined") {
      let kamban_users = $(board_item_el).attr("data-users").split(',');
      let asignado = $(board_item_el).attr("data-asignado") 
       //board_item_users = ''; 
       /*board_item_users =
          '<li class="avatar pull-up my-0">' +
          '<img class="media-object rounded-circle" src=" ' +
          kamban_users[user] +
          '" alt="Avatar" height="24" width="24">' +
            '<span class="font-size-small">' +
            $(board_item_el).attr("data-asignado") +
          "</span>" +
          "</li>";*/
          board_item_users = 
             '<div class="kanban-due-date d-flex align-items-center mr-50">' +
               '<i class="bx bxs-user font-size-small mr-25"></i>' +
               '<span class="font-size-small">' +
                  asignado +
              "</span>" +
          "</div>";
    }
    var board_item_descripcion  = 'Descripcion de actividad';
    // check if dueDate is defined or not
    if (typeof $(board_item_el).attr("data-dueDate") !== "undefined") {
      board_item_dueDate =
        '<div class="kanban-due-date d-flex align-items-center mr-50">' +
        '<i class="bx bx-time-five font-size-small mr-25"></i>' +
        '<span class="font-size-small">' +
        $(board_item_el).attr("data-dueDate") +
        "</span>" +
        "</div>";
    }
    // check if comment is defined or not
    if (typeof $(board_item_el).attr("data-comment") !== "undefined") {
      board_item_comment =
        '<div class="kanban-comment d-flex align-items-center mr-50">' +
        '<i class="bx bx-message font-size-small mr-25"></i>' +
        '<span class="font-size-small">' +
        $(board_item_el).attr("data-comment") +
        "</span>" +
        "</div>";
    }
    // check if attachment is defined or not
    if (typeof $(board_item_el).attr("data-attachment") !== "undefined") {
      board_item_attachment =
        '<div class="kanban-attachment d-flex align-items-center">' +
        '<i class="bx bx-link-alt font-size-small mr-25"></i>' +
        '<span class="font-size-small">' +
        $(board_item_el).attr("data-attachment") +
        "</span>" +
        "</div>";
    }
    // check if Image is defined or not
    if (typeof $(board_item_el).attr("data-image") !== "undefined") {
      board_item_image =
        '<div class="kanban-image mb-1">' +
        '<img class="img-fluid" src=" ' +
        kanban_board_data[kanban_data].item[kanban_item].image +
        '" alt="kanban-image">';
      ("</div>");
    }
    // check if Badge is defined or not
    if (typeof $(board_item_el).attr("data-badgeContent") !== "undefined") {
      board_item_badge =
        '<div class="kanban-badge">' +
        '<div class="badge-circle badge-circle-sm badge-circle-light-' +
          kanban_board_data[kanban_data].item[kanban_item].badgeColor +
        ' font-size-small font-weight-bold">' +
          kanban_board_data[kanban_data].item[kanban_item].badgeContent +
        "</div>";
      ("</div>");
    }
    // add custom 'kanban-footer'
    if (
      typeof ( $(board_item_el).attr("data-dueDate") || $(board_item_el).attr("data-comment") || $(board_item_el).attr("data-users") ||
        $(board_item_el).attr("data-attachment")) !== "undefined"
    ) {
      console.log('agregando_item');
      $(board_item_el).append(
        `
        <span class="form-control">${board_item_descripcion}</span>
        <div class="kanban-footer d-flex justify-content-between mt-1"> 
          <div class="kanban-footer-left d-flex"> 
            ${board_item_dueDate}
            ${board_item_comment}
            ${board_item_attachment} 
          </div>
        <div class="kanban-footer-right"> 
        <div class="kanban-users"> 
           ${board_item_badge }
           <ul class="list-unstyled users-list m-0 d-flex align-items-center"> 
             ${board_item_users}
            </ul>
          </div>
        </div> 
        </div>`
      );
    }
    // add Image prepend to 'kanban-Item'
    if (typeof $(board_item_el).attr("data-image") !== "undefined") {
      $(board_item_el).prepend(board_item_image);
    }
  }


  // Kanban-overlay and sidebar hide
  // --------------------------------------------
  $(
    ".kanban-sidebar .delete-kanban-item, .kanban-sidebar .close-icon, .kanban-sidebar .update-kanban-item, .kanban-overlay"
  ).on("click", function () {
    $(".kanban-overlay").removeClass("show");
    $(".kanban-sidebar").removeClass("show");
  });

  // Updating Data Values to Fields
  // -------------------------------
  $(".update-kanban-item").on("click", function (e) {
    e.preventDefault();
    let formData = document.getElementById('formData');
    console.log( $(kanban_curr_el) );
    let id = $(kanban_curr_el).attr("data-eid");
    let datos = new FormData(formData);
    //$(kanban_curr_el).attr('data-duedate',$fecha_limite )
     fetch( `/actividades/${id}` , {
        headers: {
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute("content")
        },
        method: 'post',
        body: datos 
      })
      .then(response => response.json())
      .then( data => {
        kanban_curr_el.textContent =  datos.getAll('evento');
        kanban_curr_el.setAttribute('data-border', datos.getAll('color'));  
        kanban_curr_el.setAttribute('data-asignado', datos.getAll('asignado_id_rotulo'));
        kanban_curr_el.setAttribute('data-fecha_comienzo', datos.getAll('fecha_comienzo'));
        
        if(document.getElementsByName('fecha_limite')[0].value) {
          kanban_curr_el.dataset.duedate = formatDatepicker(document.getElementsByName('fecha_limite')[0].value); 
        }

        footerCustom( kanban_curr_el );  
        formData.reset();
        toastSuccess("Actividad actualizada");

      })
  });
    
  // Change Title Board 
  // -------------------------------
  var srt = null;
  $(".kanban-title-board").on('input' ,(event) => {
     if(srt !== null) {
       clearTimeout(srt);
     }
     srt = setTimeout( () => {
     let text = (event.target.textContent);
     console.log(text);
     let id = event.target.parentNode.parentNode.dataset.id;
     console.log(id);
     let formData = new FormData();
      formData.append('nombre', text)
      formData.append('_method', 'PUT');   
      fetch( `/bloques/${id}` , {
        headers: {
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute("content")
        },
        method: 'post',
        body: formData 
      })
      .then(response => response.json())
      .then( data => {
        console.log(data);
        toastSuccess("Titulo Guardado");
      })
    }, 1000 )
  })

  // Delete Kanban Item
  // -------------------
  $(".delete-kanban-item").on("click", function () {
    let item_id  = kanban_curr_item_id;
    let formData = new FormData();
    formData.append('id', item_id );
    fetch(`/actividades/${item_id}`,{
      headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute("content") 
      },
      method: 'delete',
      body: formData
    })
     .then( response => response.json())
     .then( data => {
       if( data.status){
         toastSuccess();
         KanbanExample.removeElement(item_id);
       }
    })  
  });

  // Kanban Quill Editor
  // -------------------
  /*var composeMailEditor = new Quill(".snow-container .compose-editor", {
    modules: {
      toolbar: ".compose-quill-toolbar"
    },
    placeholder: "Write a Comment... ",
    theme: "snow"
  });*/

  // Making Title of Board editable
  // ------------------------------
  $(".kanban-title-board").on("mouseenter", function () {
    $(this).attr("contenteditable", "true");
    $(this).addClass("line-ellipsis");
  });

  // kanban Item - Pick-a-Date
  // $(".edit-kanban-item-duedate").pickadate( {  hiddenName: true }  );

  // Perfect Scrollbar - card-content on kanban-sidebar
  if ($(".kanban-sidebar .edit-kanban-item .card-content").length > 0) {
    new PerfectScrollbar(".card-content", {
      wheelPropagation: false
    });
  }

  // select default bg color as selected option
  $("select").addClass($(":selected", this).attr("class"));

  // change bg color of select form-control
  $("select").change(function () {
    $(this)
      .removeClass($(this).attr("class"))
      .addClass($(":selected", this).attr("class") + " form-control text-white");
  });
}


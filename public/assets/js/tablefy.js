var FuncionesUtiles = {
  implode: function(glue, pieces) {
    var i = '', retVal = '', tGlue = '';
    if (arguments.length === 1) { pieces = glue; glue = ''; } if (typeof pieces === 'object') {
    if (Object.prototype.toString.call(pieces) === '[object Array]') { return pieces.join(glue);
    } for (i in pieces) { retVal += tGlue + pieces[i]; tGlue = glue; } return retVal; } return pieces; },
  is_array: function(x) {
    return typeof x === 'object';
  },
  isset: function(x) {
    return typeof x !== 'undefined';
  },
  onUnset: function(x, y) {
    return !FuncionesUtiles.isset(x) ? y : x;
  },
 empty: function(mixed_var) {
  var undef, key, i, len;
  var emptyValues = [undef, null, false, 0, '', '0'];
  for (i = 0, len = emptyValues.length; i < len; i++) {
    if (mixed_var === emptyValues[i]) {
      return true;
    }
  }
  if (typeof mixed_var === 'object') {
    for (key in mixed_var) {
      if (mixed_var.hasOwnProperty(key)) {
        return false;
      }
    }
    return true;
  }
  return false;
},
  in_array: function (needle, haystack) {
    if(!FuncionesUtiles.empty(haystack)) {
      for(var i in haystack) {
        if(haystack[i] == needle) return true;
      }
    }
    return false;
  },
  array_merge: function(x,y) {
    return FuncionesUtiles.mergeParams(x,y);
  },
  array_map: function(callback, listado) {
    for(var index in listado) {
      if(listado.hasOwnProperty(index)) {
        listado[index] = callback(listado[index]);
      }
    }
    return listado;
  },
  array_values: function(input) {
    var tmp_arr = [], key = '';
    if (input && typeof input === 'object' && input.change_key_case) {
      return input.values();
    }
    for (key in input) {
      tmp_arr[tmp_arr.length] = input[key];
    }
    return tmp_arr;
  },
  array_keys: function (input, search_value, argStrict) {
    var search = typeof search_value !== 'undefined',
    tmp_arr = [],
    strict = !! argStrict,
    include = true,
    key = '';
    if (input && typeof input === 'object' && input.change_key_case) { // Duck-type check for our own array()-created PHPJS_Array
    return input.keys(search_value, argStrict);
    }
    for (key in input) {
    if (input.hasOwnProperty(key)) {
    include = true;
    if (search) {
    if (strict && input[key] !== search_value) {
    include = false;
    } else if (input[key] != search_value) {
    include = false;
    }
    }
    if (include) {
    tmp_arr[tmp_arr.length] = key;
    }
    }
    }
    return tmp_arr;
  },
  mergeParams: function(obj1, obj2){
    var obj3 = {};
    for (var attrname in obj1) { if(obj1.hasOwnProperty(attrname)) {obj3[attrname] = obj1[attrname];}}
    for (var attrname in obj2) { if(obj2.hasOwnProperty(attrname)) {obj3[attrname] = obj2[attrname];}}
      return obj3;
    },
};
function timestrToSec(timestr) {
  var parts = timestr.split(":");
  return (parts[0] * 3600) +
         (parts[1] * 60) +
         (+parts[2]);
}

function pad(num) {
  if(num < 10) {
    return "0" + num;
  } else {
    return "" + num;
  }
}

function formatTime(seconds) {
  return [pad(Math.floor(seconds/3600)%60),
          pad(Math.floor(seconds/60)%60),
          pad(seconds%60),
          ].join(":");
}
function Tablefy (params) {
  var count  = function(x) {
    return x == null ? 0 : (typeof x.length !== 'undefined' ? x.length : Object.keys(x).length);
  }
  var _instance = this;
  var isInit = false;
  var contenedor = null;
  var elementosSeleccionados = {};
  var cantidadFilas = 0;
  var cantidadSeleccionados = 0;
  var trConflict = 0;
  var refreshConflit = true;

  var parametros = {};
  var table  = null;
  var columnsAdditionals = 0;

  var sorterColumn = null;
  var sorterOrder  = true;

  this.current_page = 1;
  this.last_page    = null;
  this.prev_page  = null;
  this.next_page  = null;
  this.search     = null;
  this.filters    = null;
  this.filters_x  = {};
  this.modifiable_columns = [];

  var elementosContent = []; //Se almacena todo el arreglo

  var waitShake = false;

  this.privado = {};
  this.publico = {};

  var elementosTablefy = {
    contenedor:       null,
    header:           null,
    tableBody:        null,
    tableBodyContent: null,
    footer:           null,
    loading:          null,
    actions:          null,
    refresh:          null,
    extras:           null,
  };

  _instance.privado = {
    init: function(x) {
      if(isInit) {
        return;
      }
      isInit = true;
      elementosTablefy.contenedor = typeof parametros.table !== 'undefined' ? parametros.table : null;
      if(FuncionesUtiles.empty(elementosTablefy.contenedor)) {
        var tableId = 'tablefy_temp_' + Math.floor((Math.random() * 9999999) + 1);
        elementosTablefy.contenedor = $(parametros.dom);
      } else {
        tableId = Math.floor((Math.random() * 999) + 1);
      }
      var styleContentBody = '';
      if(typeof parametros.height !== 'undefined') {
        if(typeof parametros.height === 'number') {
            styleContentBody += 'height:' + parametros.height + 'px;';
            styleContentBody += 'max-height:' + parametros.height + 'px;';
        } else {
          styleContentBody += 'height:' + parametros.height + 'px;';
          styleContentBody += 'max-height:' + parametros.height + ';';
        }
        styleContentBody += 'overflow:auto;';
      }
      window.tablefyAu = typeof window.tablefyAu !== 'undefined' ? window.tablefyAu + 1 : 1;
      var granContenedor = $("<div>").attr('id', 'tablefy_' + tableId).addClass('tablefy').addClass('tablefy-id-' + window.tablefyAu);
      granContenedor.html("<ul class=\"tablefy_menu\"></ul><div class=\"tablefy_loading\">Cargando...<br><img src=\"https://cdn.dribbble.com/users/503653/screenshots/3143656/fluid-loader.gif\"></div><div class=\"tablefy_block\"></div><div class=\"tablefy_tables\"><table class=\"tablefy_table_header\"></table><div class=\"tablefy_overflow\" style=\"width:100%;background:#E8F5FF;overflow-y: auto;" + styleContentBody + "\"><div class=\"tablefy_rulertime\"></div><table class=\"tablefy_table_body tablefy_xtable\" id=\"table_" + tableId + "\"></table></div><div class=\"tablefy_rulertime_end\"></div><table class=\"tablefy_table_footer\"></table></div>");
      elementosTablefy.contenedor.after(granContenedor);
      elementosTablefy.contenedor.remove();
      elementosTablefy.contenedor = $("#tablefy_" + tableId);
      elementosTablefy.tables     = elementosTablefy.contenedor.find('.tablefy_tables');
      elementosTablefy.header     = elementosTablefy.tables.find('.tablefy_table_header');
      elementosTablefy.overflow   = elementosTablefy.tables.find('.tablefy_overflow');
      elementosTablefy.tableBody  = elementosTablefy.tables.find('.tablefy_table_body');
      elementosTablefy.footer     = elementosTablefy.tables.find('.tablefy_table_footer');
      elementosTablefy.loading    = elementosTablefy.contenedor.find('.tablefy_loading');
      elementosTablefy.menu       = elementosTablefy.contenedor.find('.tablefy_menu');
      elementosTablefy.blocking   = elementosTablefy.contenedor.find('.tablefy_block');
      elementosTablefy.rulertime  = elementosTablefy.contenedor.find('.tablefy_rulertime');
      elementosTablefy.rulertime_end  = elementosTablefy.contenedor.find('.tablefy_rulertime_end');
      
      var html_header = "<thead>";
      html_header += "<tr class=\"title\"><th><div class=\"title\"></div>";
      html_header += "<div class=\"tablefy_extra_buttons\"></div><div class=\"tablefy_search\"><input type=\text\"></div>";
      html_header += "<div class=\"tablefy_refresh\"><i class=\"ficon bx bx-refresh\"></i></div>";
      html_header += "</th></tr>";
        html_header += "<tr class=\"header\">";
          if(typeof parametros.draggable !== 'undefined' && parametros.draggable == true) {
            columnsAdditionals++;
            html_header += "<th></th>";
          }
          if(typeof parametros.enumerate !== 'undefined' && parametros.enumerate == true) {
            columnsAdditionals++;
            html_header += "<th tablefy-order=\"int\" style=\"width:30px;max-width:30px;\">#</th>";
          }
          if(!FuncionesUtiles.empty(parametros.selectable)) {
            if(typeof parametros.countSelectable === 'undefined' || parametros.countSelectable > 1) {
              columnsAdditionals++;
              if(typeof parametros.selecterAll === 'undefined' || parametros.selecterAll) {
                html_header += "<th style=\"width:30px;max-width:30px;\"><input type=\"checkbox\" class=\"checkboxSelectedAll\"></th>";
              } else {
                html_header += "<th style=\"width:30px;max-width:30px;\">--</th>";
              }
            }
          }
        html_header += "</tr>";
      html_header += "</thead>";
      var html_body = "<tbody></tbody>";
      var elementosActions = '';
      var context = '';
      if(!FuncionesUtiles.empty(parametros.actions)) {
        for(var index in parametros.actions) {
          if(parametros.actions.hasOwnProperty(index)) {
            if(typeof parametros.actions[index] === 'function') {
              if(index == 'add') {
                context += "<li tablefy-action=\"add\">Agregar Nuevo</li>";
                elementosActions += '<td tablefy-action="add"><span class="ficon bx bx-plus"></span></td>';
              } else if(index == 'delete') {
                context += "<li tablefy-action=\"delete\">Eliminar</li>";
                elementosActions += '<td tablefy-action="delete"><span class="ficon bx bx-trash"></span></td>';
              } else if(index == 'edit') {
                context += "<li tablefy-action=\"edit\">Editar</li>";
                elementosActions += '<td tablefy-action="edit"><span class="ficon bx bx-pencil"></span></td>';
              } else {
                var icon = '';
                var name = '';
                name = index.split(":");
                if(count(name) == 2) {
                  icon = name[0];
                  name = name[1];
                } else {
                  icon = index;
                  name = index;
                }
                context += "<li tablefy-action=\"" + index + "\" title=\"" + name + "\" alt=\"" + name + "\">" + name + "</li>";
                elementosActions += "<td tablefy-action=\"" + index + "\"><span class=\"ui-icon ui-icon-" + icon + "\" title=\"" + name + "\" alt=\"" + name + "\"></span></td>";
              }
            }
          }
        }
      }
      var html_footer = "<tfoot><tr><td><div class=\"tablefy_actions\"><table class=\"tablefy_table_actions\"><tr>";
      html_footer += elementosActions;
      html_footer += "</tr></table></div><div class=\"tablefy_pagination\"><ul><li class=\"prev_page disabled\">Anterior</li><li class=\"current_page\"></li><li class=\"next_page disabled\">Siguiente</li></ul></div><div class=\"tablefy_records\"></div><div class=\"tablefy_execute\"></div><div class=\"tablefy_console\"></div></td></tr></tfoot>";
      elementosTablefy.menu.html(context);
      elementosTablefy.header.html(html_header);
      elementosTablefy.tableBody.html(html_body);
      elementosTablefy.footer.html(html_footer);

      //setTimeout(function() {// TODO
        _instance.privado.inicializarTabla();
        if(!FuncionesUtiles.empty(x)) {
          _instance.privado.refresh();
        }
      //}, 500);
      return _instance.publico;
    },
    inicializarTabla: function() {
      typeof parametros.onInit !== 'undefined' && parametros.onInit(_instance.publico);

      elementosTablefy.search           = elementosTablefy.header.find('.tablefy_search');
      elementosTablefy.extras           = elementosTablefy.header.find('.tablefy_extra_buttons');
      elementosTablefy.refresh          = elementosTablefy.header.find('.tablefy_refresh');
      elementosTablefy.actions          = elementosTablefy.footer.find('.tablefy_table_actions');
      elementosTablefy.tableBodyContent = elementosTablefy.tableBody.find('tbody');
      elementosTablefy.header.find("thead>tr.title>th").attr("colspan", count(parametros.headers) + columnsAdditionals);
      elementosTablefy.footer.find("tfoot>tr>td").attr("colspan", count(parametros.headers) + columnsAdditionals);
      elementosTablefy.header.find("thead>tr.title>th>div.title").text(parametros.title);
      if(typeof parametros.draggable !== 'undefined' && parametros.draggable == true) { //
        elementosTablefy.contenedor.find(".tablefy_xtable").each(function() {
/*          $(this).find("tbody").sortable({
            handle: '.draggable',
            start: function(e, ui) {
              typeof parametros.onBeforeDraggable === 'function' && parametros.onBeforeDraggable(ui,ui.item,_instance.publico);
            },
            update: function(e, ui) {
              typeof parametros.onDraggable === 'function' && parametros.onDraggable(ui,ui.item,_instance.publico);
            }, 
            sort: function(e) {
              var margen = 100;
              var s = 1;
              var f = 0;
              var step = 50;
              if(e.clientY <= margen) {
                f = margen - e.clientY;
                //console.log("Subir a ", window.scrollY - s, f);
                window.scroll(0, window.scrollY - s * f * step / margen);
              } else if(e.clientY >= $(window).height() - margen) {
                f = e.clientY - $(window).height() + margen;
                //console.log("Bajar a ", window.scrollY + s, f);
                window.scroll(0, window.scrollY + s * f * step / margen);
              } else {
                //console.log("scroll", window.scrollY, e.pageY, e.clientY, e.offsetY);
              }
            },
          });*/
        });
      }
      $(window).click(function() {
        elementosTablefy.contenedor.find(".tablefy_block_columns").slideUp();
      });
      elementosTablefy.header.on("contextmenu", "thead>tr>th[data-column-id]", function(e) {
        e.preventDefault();
        elementosTablefy.contenedor.find(".tablefy_block_columns").stop().slideUp();
        let box = this;
        let key = $(box).attr('data-column-key');
        var bloque = elementosTablefy.contenedor.find(".tablefy_block_columns[data-column-key='" + key + "']");
        if(!bloque.length) {
          bloque = $('<ul>').addClass('tablefy_block_columns').attr('data-column-key', key).on('click', function(e) {
            e.stopPropagation();
          });
          elementosTablefy.contenedor.prepend(bloque);
        } else {

          bloque.stop().slideDown();
        }
        bloque.data('visible', true);
        var parentOffset = $(this).closest(".tablefy_table_header").offset();
        var relX = e.pageX - parentOffset.left;
        var relY = e.pageY - parentOffset.top + 10;
        bloque.css({
          left: relX,
          top:  relY,
        });
        bloque.slideDown(50).focus();

        var __filtroTimeOut = null;
        var __seleccionarFiltro = function() {
          var tt = [];
          bloque.find("[name='ff_" + key + "[]']:checked").each(function(){
           tt.push($(this).val());
          });
          _instance.filters_x[key] = tt;
          _instance.filters = JSON.stringify(_instance.filters_x);
          if(__filtroTimeOut !== null) {
            clearTimeout(__filtroTimeOut);
          }
          __filtroTimeOut = setTimeout(function() {
            _instance.current_page = 1;
            _instance.privado.refresh();
            bloque.slideUp();
          }, 1000);
        };
        $.ajax({
        type:    parametros.request.type,
        headers: parametros.request.headers,
        url:     parametros.request.url,
        data: {
          action:  'distinct',
          column:  key,
          page:    _instance.current_page,
          q:       _instance.search,
          filters: _instance.filters
        },
        dataType: 'json',
//        beforeSend: function() {
//          _instance.privado.loading(true);
//        },
        success: function(data) {
          bloque.empty();
          if(typeof data.result == 'undefined') {
            bloque.slideUp();
            return false;
          }
          if(typeof data.result.data !== 'undefined') {
            if(data.result.data.length == 0) {
              bloque.slideUp();
              return false;
            }
            var kk = 0;
            for(var ii in data.result.data) {
              kk ++;
              bloque
                .append($('<li>')
                  .append($('<label>').attr('for', 'ff_' + key + '_' + kk)
                    .append($('<input>').attr('id', 'ff_' + key + '_' + kk).attr('name', 'ff_' + key + '[]').attr('type', 'checkbox')
                      .attr('checked', typeof _instance.filters_x[key] !== 'undefined' && FuncionesUtiles.in_array(ii, _instance.filters_x[key]))
                      .attr('value', ii).on('change', __seleccionarFiltro))
                    .append($('<div>').addClass('txtValue').text(data.result.data[ii].value))
                    .append($('<div>').addClass('txtCantidad').text(data.result.data[ii].cantidad))
              ));
              //
            }
          }
        },
        complete: function() {
//          _instance.privado.loading(false);
//          setTimeout(function() {
//            refreshConflit = true;
//          }, 500);
        }
      });


      });
      if(parametros.sorter) {
        elementosTablefy.header.find("thead>tr.header>th[tablefy-order]").on("click", function() {
          $(this).closest('tr').find('th').removeClass('tablefy_order');
          $(this).addClass('tablefy_order');
          _instance.privado.sorter($(this).index(), $(this).attr('tablefy-order'));
        });
      }
      $(document).on("click", function(e) {
        if(!FuncionesUtiles.empty(elementosTablefy.menu.data('visible'))) {
          elementosTablefy.menu.data('visible', false);
          elementosTablefy.menu.slideUp(50);
        }
      });
      if(!FuncionesUtiles.empty(parametros.contextmenu)) {
      elementosTablefy.tableBody.on("contextmenu", "tbody>tr[data-id]", function(e) {
        e.preventDefault();
        if(FuncionesUtiles.empty(parametros.actions)) {
          return false;
        }
        var tr = $(this);
        _instance.privado.touchTr(tr);
        tr.closest('.tablefy_table_body').find('tbody tr').removeClass('hover');
        tr.addClass('hover');
        elementosTablefy.menu.data('visible', true);
        var parentOffset = $(this).closest(".tablefy_table_body").offset(); 
        var relX = e.pageX - parentOffset.left;
        var relY = e.pageY - parentOffset.top + 80;
        elementosTablefy.menu.css({
          left: relX,
          top:  relY,
        });
        elementosTablefy.menu.slideDown(50).focus();
        return false;
      });
      }
      elementosTablefy.menu.focusout(function(e) {
        elementosTablefy.menu.slideUp();
      });
      elementosTablefy.tableBody.on("click", "tbody>tr>td", function(e) {
        var td = $(this);
        var tr = td.closest('tr');
        if(FuncionesUtiles.empty(tr.attr("data-id"))) {
          return;
        }
        if(typeof parametros.onClick === 'function') {
          var fn = parametros.onClick.call(tr, tr.attr('data-id'), e);
          if(fn === false) {
            return false;
          }
        }
        if(FuncionesUtiles.empty(parametros.selectable)) {
          e.preventDefault();
          return;
        }
        if($(this).hasClass('number')) {
          _instance.privado.touchTr(tr);
          if(!FuncionesUtiles.empty(parametros.countSelectable) && parametros.countSelectable == 1) {
            tr.closest('.tablefy_table_body').find('tbody tr').removeClass('hover');
            tr.addClass('hover');
          }
        } else if($(this).hasClass('box-check') || (!FuncionesUtiles.empty(parametros.countSelectable) && parametros.countSelectable > 1)) {
          if(!trConflict) {
            trConflict = true;
            _instance.privado.touchTr(tr);
            trConflict = false;
          }
        } else {
          if(!FuncionesUtiles.empty(parametros.countSelectable) && parametros.countSelectable == 1) {
            _instance.privado.touchTr(tr);

          } else if(!FuncionesUtiles.empty(parametros.selecterAll)) {
            _instance.privado.touchTr(tr);
          }
        }
      });
      elementosTablefy.tableBody.on("dblclick", "tbody>tr>td[data-xeditable=true]", function(e) {
        let td = $(this);
        let box  = $(td).find('.tablefy-td-content');
        let vlv = td.attr('data-key');
        var row = td.closest('tr').data('row');
        var field = null;
        if(td.hasClass('xedit-open')) {
          return false;
        }
        td.addClass('xedit-open').removeClass('xedit-success').removeClass('xedit-error');
        let anterior = box.text();
        let restaurarInput = function() {
          td.removeClass('xedit-open');
          box.text(anterior);
        };
        let guardarInput = function() {
          if(field.val() == anterior) {
            return restaurarInput();
          }
          $.ajax({
            type:   parametros.request.type,
            headers: parametros.request.headers,
            url:    parametros.request.url,
            data: {
              action: 'save',
              column: $(td).attr('data-key'),
              id: $(td).attr('data-id'),
              value: field.val()
            },
            dataType: 'json',
            success: function(res) {
              td.removeClass('xedit-open');
              if(!res.success) {
                restaurarInput();
                td.addClass('xedit-error');
                return alert(res.message);
              }
              td.closest('tr').data('row', res.row);
              td.addClass('xedit-success');
              console.log('List0', res.row);
              if(typeof res.row._map[vlv] !== 'undefined' && res.row._map[vlv] !== null && typeof res.row._map[vlv].indexOf === 'function' && res.row._map[vlv].indexOf('javascript:') === 0) {
                row = res.row;
                box.html(eval(res.row._map[vlv].substr(11)));
              } else {
                box.text(field.val());
              }
            },
            error: function(res) {
              td.removeClass('xedit-open');
              restaurarInput();
              td.addClass('xedit-error');
            }
          });
        };
        $.ajax({
          type:    parametros.request.type,
          headers: parametros.request.headers,
          url:     parametros.request.url,
          data: {
            action: 'edit',
            column: $(td).attr('data-key'),
            id: $(td).attr('data-id'),
          },
          dataType: 'json',
          success: function(res) {
            console.log('EDIT', res);
            if(!res.success) {
              return restaurarInput();
            }
            let eq = {
              date:    'date',
              decimal: 'number',
              integer: 'number',
              string:  'text',
            };
            if(typeof eq[res.result.type] !== 'undefined') {
              field = $('<input>');
              field.attr('type', eq[res.result.type]);
              if(res.result.type == 'date') {
                field.attr('min', '2000-01-01');
              }
              for(var index in res.result.attrs) {
                field.attr(index, res.result.attrs[index]);
              }
            } else if(res.result.type == 'select') {
              field = $('<select>');
              if(typeof res.result.options !== 'undefined') {
                for(var ii in res.result.options) {
                  field.append($('<option>').attr('value', ii).text(res.result.options[ii]));
                }
              }
              if(typeof row[vlv] !== 'undefined') {
                field.val(row[vlv]);
              }
            }
            if(typeof res.result.attrs !== 'undefined') {
              for(var ii in res.result.attrs) {
                field.attr(ii, res.result.attrs[ii]);
              }
            }
            box.html(field);
            if(!(typeof res.result.attrs !== 'undefined' && typeof res.result.attrs.value !== 'undefined') && field !== null) {
              field.val(anterior);
            }
            td.focus();
            if(typeof res.result.attrs !== 'undefined' && typeof res.result.attrs.multiple !== 'undefined') {
              td.off('focusout').on('focusout', function() {
                guardarInput();
              });
            } else {
              td.off('change').on('change', function() {
                guardarInput();
              });
            }
            if(typeof field[0].select === 'function') {
              field[0].select();
            }
          },
          error: function(res) {
            return restaurarInput();
          }
        });
      });
      elementosTablefy.contenedor.find("[tablefy-action]").on("click", function(e) {
        var func = $(this).attr('tablefy-action');
        if(typeof parametros.actions[func] !== 'undefined') {
          rp = parametros.actions[func](_instance.publico);
          _instance.privado.refreshOptions();
        }
      });
      elementosTablefy.tableBody.on("click", "input[name='idSelected']", function(e) {
        if(typeof parametros.selectable === 'undefined' || parametros.selectable != true) {
          e.preventDefault();
          return;
        }
        if(!trConflict) {
          trConflict = true;
          _instance.privado.touchTr($(this).closest("tr"), $(this).is(':checked'));
          setTimeout(function() {
            trConflict = false;
          }, 20);
        }
      });
      elementosTablefy.header.find(".checkboxSelectedAll").change(function() {
        _instance.privado.setSelectedAll($(this).is(':checked'));
      });
      elementosTablefy.search.find('input').on("change", function(e){
        e.preventDefault();
        var bbb = $(this);
        _instance.privado.searchQuery(bbb.val());
      });
      elementosTablefy.refresh.on("click", function(e){
        e.preventDefault();
        if(typeof parametros.refresh !== 'undefined' && parametros.refresh == false) {
          return;
        }
        _instance.publico.refresh();
      });

      _instance.privado.setWidthColumns(elementosTablefy.header);
      _instance.privado.setWidthColumns(elementosTablefy.tableBody);
      _instance.privado.refreshOptions();
    },
    sorter: function(column, type) {
      if(sorterColumn == column) {
        sorterOrder = !sorterOrder;
      } else {
        sorterColumn = column;
        sorterOrder  = true;
      }
      var tbl = elementosTablefy.tableBody[0].tBodies[0];
      var store = [];
      for(var i=0, len=tbl.rows.length; i<len; i++){
        var row = tbl.rows[i];
        var sortnr;
        if(type == 'int') {
          sortnr = parseFloat(row.cells[column].textContent || row.cells[column].innerText);
        } else {
          sortnr = (row.cells[column].textContent || row.cells[column].innerText) + '';
        }
        //if(!isNaN(sortnr)) {
          store.push([sortnr, row]);
        //}
      }
      store.sort(function(x, y){
        if(x[0] < y[0]) return sorterOrder ? -1 : 1;
        if(x[0] > y[0]) return sorterOrder ? 1 : -1;
        return 0;
      });
      for(var i=0, len=store.length; i<len; i++){
        tbl.appendChild(store[i][1]);
      }
      store = null;
    },
    setWidthColumns: function(table, refresh) {
      if(typeof refresh !== 'undefined' && refresh == true) {
        $.each(table.find('tbody>tr'), function(i, tr) {
          if(typeof parametros.headers !== 'undefined') {
            for(var index in parametros.headers) {
              $(tr).find("td[data-column-id='" + index + "']").css({ width: parametros.headers[index].width, 'max-width': parametros.headers[index].width});
            }
          }
        });
        return;
      }
      if(table.find('thead').length) {
        if(typeof parametros.headers !== 'undefined') {
          for(var index in parametros.headers) {
            table.find("tr.header>th[data-column-id='" + index + "']").css({ width: parametros.headers[index].width, 'max-width': parametros.headers[index].width});
          }
        }
      } else {
        var thead = $('<thead>').css({ height: '0px'});
        thead.append($('<th>').css({ width: 30, 'max-width': 30}));
        thead.append($('<th>').css({ width: 30, 'max-width': 30}));
        if(typeof parametros.headers !== 'undefined') {
          for(var index in parametros.headers) {
            var th = $('<th>').attr('data-column-id', index);
            th.css({ width: parametros.headers[index].width, 'max-width': parametros.headers[index].width});
            thead.append(th);
          }
        }
        table.prepend(thead);
      }
    },
    block: function(option) {
      var load = elementosTablefy.blocking;
      option ? load.fadeIn(100) : load.fadeOut(100);
    },
    loading: function(option) {
      var load = elementosTablefy.loading;
      option ? load.fadeIn(100) : load.fadeOut(700);
    },
    touchTr: function(tr, option, Click, change) {
      console.log('touchTr', tr, option, Click, change);
      var box = tr.find("input[name='idSelected']");
      option = typeof option !== 'undefined' ? option : !box.is(':checked');
      var sc = parametros.countSelectable || false;
      var fn_check = function(tr, status) {
        if(status) {
          tr.find("input[name='idSelected']").prop('checked', option);
          elementosSeleccionados[tr.attr('data-id')] = true;
          tr.addClass('selected').attr('data-selected', 'true');
        } else {
          tr.find("input[name='idSelected']").prop('checked', option);
          delete elementosSeleccionados[tr.attr('data-id')];
          tr.removeClass('selected').attr('data-selected', 'false');
        }
      };
      if(!option) {
        fn_check(tr, false);
      } else {
        if(!FuncionesUtiles.empty(parametros.selectable) && FuncionesUtiles.empty(sc)) {
          //true - 0:undefined || Seleccion multiple
          fn_check(tr, true);
        } else if(!FuncionesUtiles.empty(parametros.selectable) && sc == 1) {
          //true - 1 ||  Seleccion unica
          fn_check(tr.closest('.tablefy_table_body').find("tbody [data-selected='true']"), false);
          fn_check(tr, true);
        } else if(!FuncionesUtiles.empty(parametros.selectable) && !FuncionesUtiles.empty(sc)) {
          //true - number ||  Seleccion particular
          if(_instance.publico.getCountSelecteds() >= sc) {
            return;
          }
          fn_check(tr, true);
        } else if(FuncionesUtiles.empty(parametros.selectable)) {
          //false - *
          return;
        }
      }
      if(typeof Click === 'undefined' || Click) {
        _instance.privado.refreshOptions();
      }
      if(typeof change === 'undefined' || change) {
        typeof parametros.onChangeElement !== 'undefined' && parametros.onChangeElement(tr.attr('data-id'), option);
      }
    },
    /*setMarkerId: function(id, action) {
      action = action || true;
      var tr = _instance.publico.getTrId(id);
      !action ? tr.removeClass('marked') : tr.addClass('marked');
    },
    getMarkerId: function() {
      return elementosTablefy.tableBodyContent.find('tr.hover').attr('data-id');
    },*/
    volcarContenido: function(contenido, append, offReady) {
      if(FuncionesUtiles.isset(offReady) && !offReady) {
        return;
      }
      if(!append) {
        cantidadFilas = 0;
        elementosSeleccionados = {};
        elementosTablefy.tableBodyContent.empty();
      }
      var contenidx = parametros.onProcessRequest(contenido);
      if(typeof parametros.headers !== 'undefined') {
        var th;
        for(index in parametros.headers) {
          if(parametros.headers.hasOwnProperty(index)) {
            if(elementosTablefy.header.find("thead>tr.header").find("th[data-column-id='" + index + "']").length) {
              th = elementosTablefy.header.find("thead>tr.header").find("th[data-column-id='" + index + "']");
              th.text(parametros.headers[index].name);
            } else {
              th = $("<th>").text(parametros.headers[index].name)
              .attr('tablefy-order','string')
              .attr('data-column-id', index)
              .attr('data-column-key', contenidx.result.order_columns[index]);
              elementosTablefy.header.find("thead>tr.header").append(th);
            }
          }
        }
        _instance.privado.setWidthColumns(elementosTablefy.header);
  //      _instance.privado.setWidthColumns(elementosTablefy.tableBody);
//      _instance.privado.refreshOptions();
      }
      if(!FuncionesUtiles.empty(contenido.success)) {
        _instance.last_page = contenido.result.last_page;
        _instance.current_page = contenido.result.page;
        _instance.prev_page = contenido.result.page_prev;
        _instance.next_page = contenido.result.page_next;
        _instance.modifiable_columns = contenido.result.modifiable_columns;
        elementosContent = contenido;
        if(typeof parametros.onMap === 'function') {
          console.log('USANDO MAP DE FRONT');
          contenidx.result.items.map((n) => {
            n._map = parametros.onMap(n);
            delete n._map._map;
            return n;
          });
        }
        $.each(contenidx.result.items, function(k, v) {
          var tr = _instance.privado.volcarTr(v);
          if(!FuncionesUtiles.empty(v.popy_father_id)) {
            var d = elementosTablefy.tableBodyContent.find("tr[data-padre='" + v.popy_father_id + "'] tbody");
            if(!FuncionesUtiles.empty(d)) {
              d.append(tr);
            } else {
              console.log("No existe padre: " . v.popy_father_id);
            }
          } else {
            elementosTablefy.tableBodyContent.append(tr);
            if(!FuncionesUtiles.empty(v.popy_is_father)) {
              var html = "<tr data-padre=\"" + v.popy_id + "\"><td colspan=\"" + (count(parametros.headers) + columnsAdditionals) + "\"><div style=\"margin: -1px -2px;border-left: 1px solid #cab637;margin-left: 15px;padding-left: 15px;margin-right:0px;min-height: 8px;background: #fbec88;\"><table style=\"margin: -1px;\"><tbody></tbody></table></div></td></tr>";
              elementosTablefy.tableBodyContent.append($(html));
            }
          }
          cantidadFilas++;
        });
      }
      _instance.privado.refreshOptions();
      typeof parametros.onComplete === 'function' && parametros.onComplete(contenidx);
    },
    addChild: function(id, v) {
      var tr = _instance.privado.volcarTr(v);
      elementosTablefy.tableBodyContent.find("tr[data-padre='" + id + "'] tbody").append(tr);
    },
    rulerTimeMove: function() {
      if(FuncionesUtiles.empty(parametros.rulertime)) {
        return;
      }
      var d        = new Date;
      var inicio   = timestrToSec(parametros.rulertime);
      var ahora    = (d.getHours() * 60 * 60) + (d.getMinutes() * 60) + d.getSeconds();
      var acumulado = 0;
      var vamos     = 0;
      var detectado = false;
      elementosTablefy.tableBodyContent.find("tr[data-duration]").each(function() {
        var addicional = $(this).attr('data-duration') != '0' ? timestrToSec($(this).attr('data-duration')) : 0;
        if(addicional > 0) {
          acumulado += addicional;
        }
        if(ahora > inicio) {
          if(detectado == false && acumulado >= (ahora - inicio)) {
            detectado = true;
            vamos = acumulado;
            $(this).siblings().removeClass('rulertime');
            $(this).addClass('rulertime');
            elementosTablefy.rulertime.show().animate({
              top: $(this).position().top + 'px',
            }, 800);
          }
        } else {
          elementosTablefy.rulertime.hide();
        }
      });
      if(ahora > inicio && acumulado < ahora - inicio) {
        elementosTablefy.rulertime.hide();
        elementosTablefy.tableBodyContent.find("tr[data-duration]").removeClass('rulertime')
      }
      elementosTablefy.rulertime_end.show();
      var lista = $("<ul>");
      lista.append($("<li>").html("<small>Iniciado: " + formatTime(inicio) + "</small>"));
      lista.append($("<li>").html("<small>Duración: " + formatTime(acumulado) + "</small>"));
      lista.append($("<li>").html("<small>Transmitido: " + formatTime(vamos) + "</small>"));
      lista.append($("<li>").html("<small>Falta: " + formatTime(acumulado - vamos) + "</small>"));
      lista.append($("<li>").html("Finaliza: " + formatTime(inicio + acumulado)));
      elementosTablefy.rulertime_end.html(lista);
    },
    searchQuery: function(q) {
      _instance.search = q;
      _instance.current_page = 1;
      _instance.last_page = 1;
      _instance.privado.refresh();
    },
    refresh: function(xx) {
      var forz = typeof xx !== 'undefined' && typeof xx.force !== 'undefined' ? (xx.force || false) : false;
      if(!forz) {
        if(refreshConflit == false) {
          //console.log("refreshConflit");
          return;
        }
        refreshConflit = false;
      }
      var parame = typeof xx !== 'undefined' ? FuncionesUtiles.mergeParams(parametros,xx) : parametros;
      var url    = typeof parame.url === 'function' ? parame.request.url() : parame.request.url;
      if(url === false) {
        //console.log("refreshConflit1111");
        _instance.privado.volcarContenido(null, parametros.contentAppend !== 'undefined' && parametros.contentAppend == true);
        refreshConflit = true;
        return _instance.publico;
      }
      //console.log("refreshConflit000000");
      $.ajax({
        type:   parame.request.type,
        headers: parame.request.headers,
        url:    url,
        //data:   (typeof parame.request.data === 'function' ? parame.request.data() : parame.request.data),
        data: {
          page: _instance.current_page,
          q:    _instance.search,
          filters: _instance.filters
        },
        dataType: 'json',
        beforeSend: function() {
          _instance.privado.loading(true);
        },
        success: function(data) {
          _instance.privado.volcarContenido(data, parametros.contentAppend !== 'undefined' && parametros.contentAppend == true);
        },
        complete: function() {
          _instance.privado.loading(false);
          setTimeout(function() {
            refreshConflit = true;
          }, 500);
        }
      });
      return _instance.publico;
    },
    empty: function() {
      _instance.privado.volcarContenido(null, false);
    },
    obtenerIndice: function(objecto) {
      return !FuncionesUtiles.empty(objecto) && !FuncionesUtiles.empty(objecto.id) ? objecto.id : cantidadFilas;
    },
    volcarTr: function(objecto) {
      var renombrar_object = JSON.stringify(objecto);
      renombrar_object = JSON.parse(renombrar_object);
      if(FuncionesUtiles.empty(renombrar_object)) {
        return;
      }
      var key    = cantidadFilas + 1;
      var indice = _instance.privado.obtenerIndice(renombrar_object);
      var key_id = typeof renombrar_object['popy_orden'] !== 'undefined' ? renombrar_object['popy_orden'] : key;
      var duration = typeof renombrar_object['popy_duration'] !== 'undefined' ? renombrar_object['popy_duration'] : 0;
      var porcion  = typeof renombrar_object['popy_part'] !== 'undefined' ? renombrar_object['popy_part'] : null;

        delete renombrar_object['popy_id'];
        delete renombrar_object['popy_color'];
        delete renombrar_object['popy_orden'];
        delete renombrar_object['popy_father_id'];
        delete renombrar_object['popy_is_father'];
        delete renombrar_object['popy_duration'];
        delete renombrar_object['popy_part'];

      var indices_td   = FuncionesUtiles.array_keys(renombrar_object._map);
      solo_values = FuncionesUtiles.array_values(renombrar_object._map);
      var tr     = $("<tr>")
        .data('row', renombrar_object)
        .attr("data-id", indice)
        .attr("data-num", key)
        .attr("data-duration", duration);
//      if(porcion !== null) {
//        tr.css({ height: parametros.lineHeight + 'px' });
//      }
        if(typeof parametros.lineHeight !== 'undefined') {
          tr.css({ height: parametros.lineHeight + 'px' });
        }
        if(typeof parametros.draggable !== 'undefined' && parametros.draggable == true) {
          tr.append($("<td>").addClass('draggable').css({'width':'30px','max-width':'30px'}));
        }
        if(typeof parametros.enumerate !== 'undefined' && parametros.enumerate == true) {
          tr.append($("<td>").text(key_id).addClass('number tablefy-td').attr('data-key', 'popy_number').css({'width':'30px','max-width':'30px'}).attr('data-id', indice));
        }
        if(typeof parametros.selectable !== 'undefined' && parametros.selectable == true) {
          if(typeof parametros.countSelectable === 'undefined' || parametros.countSelectable > 1) {
            tr.append($("<td>").html("<input type=\"checkbox\" name=\"idSelected\" value=\"" + indice + "\">").css({'text-align':'center', 'width':'30px','max-width':'30px'}).addClass('box-check'));
          }
        }
        var row = {};
        for(var i = 0; i < count(parametros.headers); i++) {
          row = renombrar_object;
          var em = $("<td>")
                    .addClass('tablefy-td')
                    .attr("data-id", indice)
                    .attr("data-num", key)
                    .attr('data-xeditable', FuncionesUtiles.in_array(indices_td[i], _instance.modifiable_columns) 
                      && (typeof row.__options === 'undefined' || typeof row.__options.denyFill === 'undefined' || !FuncionesUtiles.in_array(indices_td[i], row.__options.denyFill)))
                    .attr('data-column-id', i)
                    .attr("data-key", indices_td[i]);
          if(typeof parametros.styles !== 'undefined' && typeof parametros.styles[i] !== 'undefined') {
              em.css(parametros.styles[i]);
          }
          if(typeof solo_values[i] == 'string' && solo_values[i].indexOf('javascript') === 0) {
            tr.append(em.html($("<div>").addClass('tablefy-td-content').html(eval(solo_values[i].substr(11)))));
          } else {
            tr.append(em.html($("<div>").addClass('tablefy-td-content').html(solo_values[i])));
          }
        }
      return tr;
    },
    shake: function(xx) {
      if(typeof xx === 'undefined') {
        if(waitShake === true) {
          return false;
        }
        waitShake = true;
        elementosTablefy.contenedor.effect("shake", {times:3, distance: 5}, 50);
        setTimeout(function() {
          waitShake = false;
        }, 250);
      } else {
        $(xx).effect("shake", {times:3, distance: 5}, 50);
      }
      return false;
    },
    refreshOptions: function() {
      _instance.privado.setWidthColumns(elementosTablefy.tableBody, true);
      var cantidadSeleccionados = count(elementosSeleccionados);
      var textoFooter = cantidadSeleccionados + " seleccionados de " + cantidadFilas + " filas";
     
      if(typeof elementosContent.result !== 'undefined' && typeof elementosContent.result.total !== 'undefined') {
        elementosTablefy.footer.find("tfoot>tr>td>.tablefy_records").text('Registros Aprox: ' + elementosContent.result.total).slideDown();
      } else {
        elementosTablefy.footer.find("tfoot>tr>td>.tablefy_records").slideUp();
      }

      if(typeof elementosContent.result !== 'undefined' && typeof elementosContent.result.time_total !== 'undefined') {
        elementosTablefy.footer.find("tfoot>tr>td>.tablefy_execute").text('Tiempo de consulta: ' + elementosContent.result.time_total).slideDown();
      } else {
        elementosTablefy.footer.find("tfoot>tr>td>.tablefy_execute").slideUp();
      }

      var footer = elementosTablefy.footer.find("tfoot>tr>td>.tablefy_console");
      if(footer.text() != textoFooter) {
        footer.text(textoFooter);
        typeof parametros.onChange === 'function' && parametros.onChange(_instance.publico);
      }

      elementosTablefy.footer.find("tfoot>tr>td>.tablefy_pagination .current_page").text('Página ' + _instance.current_page);
      if(_instance.current_page > 1) {
        elementosTablefy.footer.find("tfoot>tr>td>.tablefy_pagination .prev_page").addClass('enabled').removeClass('disabled').off('click').on('click', function() {
          _instance.current_page = _instance.prev_page;
          _instance.privado.refresh();
        });;
      } else {
        elementosTablefy.footer.find("tfoot>tr>td>.tablefy_pagination .prev_page").addClass('disabled').removeClass('enabled').off('click');
      }

      if(_instance.current_page < _instance.last_page) {
        elementosTablefy.footer.find("tfoot>tr>td>.tablefy_pagination .next_page").addClass('enabled').removeClass('disabled').off('click').on('click', function() {
          _instance.current_page = _instance.next_page;
          _instance.privado.refresh();
        });
      } else {
        elementosTablefy.footer.find("tfoot>tr>td>.tablefy_pagination .next_page").addClass('disabled').removeClass('enabled').off('click');
      }
    },
    setParametros: function(x) {
      x.sorter     = typeof x.sorter !== 'undefined' ? x.sorter : (typeof parametros.sorter !== 'undefined' ? parametros.sorter : false);
      x.onComplete = typeof x.onComplete === 'function' ? x.onComplete : (typeof parametros.onComplete !== 'undefined' ? parametros.onComplete : function(x) { return x; });
      x.onProcessRequest  = typeof x.onProcessRequest === 'function' ? x.onProcessRequest : (typeof parametros.onProcessRequest !== 'undefined' ? parametros.onProcessRequest : function(x) { return x; });
      x.onMap  = typeof x.onMap === 'function' ? x.onMap : (typeof parametros.onMap !== 'undefined' ? parametros.onMap : null);
      parametros   = FuncionesUtiles.mergeParams(parametros, x);
    },
    setSelectedAll: function(x) {
      x = typeof x === 'undefined' ? true : x;
      $.each(elementosTablefy.tableBodyContent.find("tr:visible"), function() {
        _instance.privado.touchTr($(this), x, false);
      });
      _instance.privado.refreshOptions();
    },
    removeIds: function(ids) {
      if(typeof ids !== 'object') {
        ids = [ids];
      }
      for(var i in ids) {
        if(ids.hasOwnProperty(i)) {
          var tr = elementosTablefy.tableBodyContent.find("tr[data-id='" + ids[i] + "']");
          tr.fadeOut(700, function() {
            $(this).remove();
          });
        }
      }
      _instance.privado.refreshOptions();
    },
    setSelectedId: function(id, option, change) {
      option = typeof option === 'undefined' ? true : option;
      var tr = elementosTablefy.tableBodyContent.find("tr[data-id='" + id + "']");
      _instance.privado.touchTr(tr, option, false, change);
      _instance.privado.refreshOptions();
    },
    getAllItems: function() {
      var ls = [];
      $.each(elementosTablefy.tableBodyContent.find("tr:visible"), function() {
        ls.push($(this).attr('data-id'));
      });
      return ls;
    },
    getAllItemsSerialize: function() {
      rp = _instance.privado.getAllItems();
      rp = !FuncionesUtiles.empty(rp) ? rp.join(',') : '';
      return rp;
    },
    getObjectId: function(x) {
      if(!FuncionesUtiles.empty(elementosContent)) {
        for(var i in elementosContent) {
          if(elementosContent.hasOwnProperty(i)) {
            if(typeof elementosContent[i]['popy_id'] !== 'undefined' && elementosContent[i]['popy_id'] == x) {
                return elementosContent[i];
            }
          }
        }
        for(var i in elementosContent) {
          if(elementosContent.hasOwnProperty(i)) {
            if(i == x) {
              return elementosContent[i];
            }
          }
        }
      }
      return null;
    },
    getSelectedsObject: function() {
      var ls = [];
      rp = _instance.publico.getSelectedId();
      if(!FuncionesUtiles.empty(rp)) {
        for(var i in rp) {
          if(rp.hasOwnProperty(i)) {
            lz = _instance.privado.getObjectId(rp[i]);
            if(!FuncionesUtiles.empty(lz)) {
              ls.push(lz);
            }
          }
        }
      }
      return ls;
    },
    scrollEnd: function() {
      $(elementosTablefy.overflow).stop().animate({
        scrollTop: elementosTablefy.overflow[0].scrollHeight
      }, 500);
    },
  };
  _instance.publico = {
    appendExtra: function(x) {
      elementosTablefy.extras.append(x);
      return _instance.publico;
    },
    init: function(x) { _instance.privado.init(x); return _instance.publico; },
    scrollEnd: function() { _instance.privado.scrollEnd(); return _instance.publico; },
    getSelectedId: function() {
      rp = FuncionesUtiles.array_keys(elementosSeleccionados);
      return rp;
    },
    getSelectedsSerialize: function() {
      rp = _instance.publico.getSelectedId();
      rp = !FuncionesUtiles.empty(rp) ? rp.join(',') : '';
      return rp;
    },
    getCountSelecteds: function() {
      return count(_instance.publico.getSelectedId());
    },
    getObjectId: function(x) { return _instance.privado.getObjectId(x); },
    getAllItems: function() { return _instance.privado.getAllItems(); },
    getAllItemsSerialize: function() { return _instance.privado.getAllItemsSerialize(); },
    setSelectedId: function(x,y,z) { _instance.privado.setSelectedId(x,y,z); return _instance.publico; },
    getSelectedsObject: function() { return _instance.privado.getSelectedsObject(); },
    getTrId: function(id) {
      return elementosTablefy.tableBodyContent.find("tr[data-id='" + id + "']");
    },
    removeIds: function(x) { _instance.privado.removeIds(x); return _instance.publico; },
    refresh: function(x) { _instance.privado.refresh(x); return _instance.publico; },
    edit: function(x) { _instance.privado.setParametros(x); return _instance.publico; },
    setSelectedAll: function(x) { _instance.privado.setSelectedAll(x); return _instance.publico; },
/*    setMarkerId: function(x,z) { _instance.privado.setMarkerId(x,z); return _instance.publico; },
    getMarkerId: function() { return _instance.privado.getMarkerId(); },*/
    shake: function(x) { return _instance.privado.shake(x); },
    block: function(x) { return _instance.privado.block(x); },
    getElement: function() { return elementosTablefy.contenedor; },
    empty: function() { return _instance.privado.empty(); },
    addChild: function(x,y) { return _instance.privado.addChild(x,y); },
  };
  _instance.privado.setParametros(params);
  return _instance.publico;
};
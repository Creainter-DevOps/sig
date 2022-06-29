var requestId = 0;
var timeFetchx = {};
function navigate(href, newTab) {
   var a = document.createElement('a');
   a.href = href;
   if (newTab) {
      a.setAttribute('target', '_blank');
   }
   a.click();
}
function merge(first, second) {
    first = first || second;
    for(var index in second) {
        if(second.hasOwnProperty(index)) {
            first[index] = second[index];
        }
    }
    return first;
}

function Fetchx(params, inmediate) {
    if (
        typeof params.id !== "undefined" &&
        typeof params.delay !== "undefined"
    ) {
        inmediate = inmediate || false;
        if (!inmediate) {
            clearTimeout(timeFetchx[params.id]);
            return (timeFetchx[params.id] = setTimeout(function () {
                Fetchx(params, true);
                timeFetchx[params.id] = null;
            }, params.delay));
        }
    }
    var myId = ++requestId;
    var mostrar = function () {
        if (typeof params.loading !== "undefined") {
            $(params.loading)
                .addClass("request_" + myId)
                .slideDown();
        }
    };
    var ocultar = function () {
        if (typeof params.loading !== "undefined") {
            $(params.loading).removeClass("request_" + myId);
            if ($(params.loading).attr("class") == "") {
                $(params.loading).slideUp();
            }
        }
    };

    if (typeof params.beforeSend !== "undefined") {
        var temp_before = params.beforeSend;
        params.beforeSend = function () {
            mostrar();
            temp_before();
        };
    } else {
        params.beforeSend = function () {
            mostrar();
        };
    }

    if (typeof params.success !== "undefined") {
        var temp_success = params.success;
        params.success = function ($x) {
            ocultar();
            temp_success($x, params);
        };
    } else {
        params.success = function ($x) {
            ocultar($x, params);
        };
    }
    return $.ajax(params);
}

$(".btnDelete").on('click', (event) => {
  event.preventDefault();
  let url = event.target.href;
   dialogDelete().then(result => {
      if(result.isConfirmed){
        peticionDelete( url );   
      } 
   })
})

function peticionDelete(url){
   fetch( url , {
    headers : {
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute("content")
    },
    method: "DELETE",
  }).then(response => response.json())
  .then(data => {
    if(data.status){
      toastSuccessResponse(data.redirect);
    }
  })
} 

function redirect_to(url = null ){
  if(url  != null ){
    window.location = url;
  }else{
    window.location.reload();
  }
}

function FetchxConfirm(params) {
    var n = Swal.mixin({
        buttonsStyling: false,
        customClass: {
            confirmButton: "btn btn-alt-success m-5",
            cancelButton: "btn btn-alt-danger m-5",
            input: "form-control",
        },
    });
    return n.fire({
        title: "Â¿EstÃ¡ seguro de realizar esta acciÃ³n?",
        text: "Si realiza la acciÃ³n, puede que la informaciÃ³n almacenada no pueda recuperarse.",
        icon: "warning",
        showCancelButton: true,
        customClass: {
            confirmButton: "btn btn-alt-danger m-1",
            cancelButton: "btn btn-alt-secondary m-1",
        },
        confirmButtonText: "Efectuar!",
        cancelButtonText: "Cancelar",
        html: false,
    }).then(function (e) {
        if (e.value) {
            Fetchx(merge(params, {
                success: function (data) {
                    if (data.status) {
                        /*n.fire(
                            "Realizado!",
                            data.message,
                            "success"
                        );*/
                        typeof params.success === 'function' && params.success(data);
                        if (typeof data.refresh !== "undefined" && data.refresh) {
                            setTimeout(function () {
                                location.reload();
                            }, 2000);
                        }
                    } else if (data.required_force) {
                        return n.fire({
                            title: "Advertencia de procedimiento",
                            text: data.warning,
                            icon: "warning",
                            showCancelButton: true,
                            customClass: {
                                confirmButton: "btn btn-alt-danger m-1",
                                cancelButton: "btn btn-alt-secondary m-1",
                            },
                            confirmButtonText: "Forzar!",
                            cancelButtonText: "Cancelar",
                            html: false,
                        }).then(function (e) {
                            if (e.value) {
                                Fetchx(merge(params, {
                                    data: merge(params.data, { is_force: 1 }),
                                    success: function (data) {
                                        if (data.status) {
                                            n.fire(
                                                "Realizado!",
                                                data.message,
                                                "success"
                                            );
                                            typeof params.success === 'function' && params.success(data);
                                            if (typeof data.refresh !== "undefined" && data.refresh) {
                                                setTimeout(function () {
                                                    location.reload();
                                                }, 2000);
                                            }
                                        } else {
                                            n.fire("Denegado", data.warning, "error");
                                        }
                                    },
                                }));
                            } else if ("cancel" === e.dismiss) {
                                n.fire(
                                    "Cancelado",
                                    "El proceso ha sido cancelado! :)",
                                    "error"
                                );
                            } else {
                                n.fire(
                                    "Cancelado",
                                    "El proceso ha sido cancelado.",
                                    "error"
                                );
                            }
                        });
                    } else {
                        n.fire("Denegado", data.warning, "error");
                    }
                },
            }));
        } else if ("cancel" === e.dismiss) {
            n.fire(
                "Cancelado",
                "El proceso ha sido cancelado! :)",
                "error"
            );
        } else {
            n.fire(
                "Cancelado",
                "El proceso ha sido cancelado.",
                "error"
            );
        }
    });
};
$(".limit-scroll").each(function() {
  var box = this;
  $(box).addClass('limit-scroll-collapse');
  $(box).on('click', '.limit-scroll-expand', function(e) {
    e.stopPropagation();
    $(box).addClass('limit-scroll-collapse');
    $(box).find('.limit-scroll-expand').remove();
  });
  $(box).on('click', function() {
    if($(box).find('.limit-scroll-expand').length == 0) {
      $(box).removeClass('limit-scroll-collapse');
      $(box).append($('<div>').addClass('limit-scroll-expand'));
    }
  });
});
$("i.bxs-save").on( 'click', function () {
  var element = $(this);
  let url = element.attr("data-url");
  let name = element.attr("data-name");
  let val = $( "#" + name ).text();
  var formData = new FormData();
  formData.append(name, val );

  fetch (url, {
    headers : {
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute("content")
    },
    body:formData,
    method : "post"
  }).then(response => response.json())
  .then(data => {
    toastSuccess(); 
  })  
})

function render_table() {
  $(".dataTable").each(function() {
    $(this).DataTable(
      {
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.11.3/i18n/es_es.json"
        },
        "ordering": false,
      }
    );
  })
}

function render_autocomplete() {
    $(":input.autocomplete").each(function () {
        var box = $(this);
        var rotulo = box.attr("data-value");
        var url = box.attr("data-ajax");
        var form = box.attr("data-register");
        var name = box.attr("name");
        var boxId = $("<input>")
            .attr("type", "text")
            .attr("name", name)
            .attr("value", box.attr("value"))
            .css({
                position: "fixed",
                opacity: 0,
                width: 0,
                height: 0,
                visibility: "collapse", 
                float: "left",
            });
        boxId.attr("required", box.attr("required"));
        boxId.attr("autocomplete", "no");
        box.attr("autocomplete", "no");
        //box.removeAttr("required");
        box.removeAttr("data-ajax");
        box.removeAttr("name")
            .attr("name", name + "_rotulo")
            .attr("value", box.attr("data-value"));
        box.after(boxId);
        box.removeClass("autocomplete");
        if (typeof form !== "undefined") {
            var btn = $("<button>")
                .attr("type", "button")
                .addClass("btn btn-secondary")
                .text("Nuevo")
                .css({
                  "margin-left": "5px"
                });
              
            box.before($("<div>").addClass("input-float-append").html(btn));
            btn.on("click", function () {
                if ($(".modal[data-url='" + form + "']").length && false) { /* TODO:  Quitamos el cachÃ¨ */
                    var modal = $(".modal[data-url='" + form + "']");
                } else {
                    var modal = $("<div>")
                        .addClass("modal fade")
                        .attr("data-url", form)
                        .attr("role", "dialog")
                        .attr("aria-labelledby", "modal-fadein")
                        .attr("aria-hidden", "true");
                    modal.html(
                        '<div class="modal-dialog" role="document"><div class="modal-content">Cargando...</div></div>'
                    );
                    Fetchx({
                        url: form,
                        type: "GET",
                        success: function (data) {
                            console.log("Success");
                            modal.find(".modal-content").html(data);
                            modal
                                .find("form")
                                .off("submit")
                                .on("submit", function (e) {
                                    e.preventDefault();
                                    var formulario = modal.find("form");
                                    return Fetchx({
                                        url: formulario.attr("action"),
                                        type: "POST",
                                        data: formulario.serialize(),
                                        success: function (response) {
                                            if (
                                                typeof response.status ===
                                                "undefined"
                                            ) {
                                                return;
                                            }
                                            console.log(
                                                "response",
                                                response.status
                                            );
                                            if (response.status == "success" || response.status === true) {
                                                modificacion_permitida = true;
                                                box.attr(
                                                    "data-value",
                                                    response.data.value
                                                );
                                                box.val(response.data.value);
                                                boxId.val(response.data.id);
                                                boxId.attr(
                                                    "data-value",
                                                    response.data.value
                                                );
                                                console.log('caja', box);
                                                /*if(typeof  data.precio != 'undefined') {
                                                }*/
                                                boxId.change();
                                                modal.modal("hide");
                                                if (typeof boxId.attr("data-autocomplete-finish") !== "undefined") {
                                                    if (
                                                        typeof window[boxId.attr("data-autocomplete-finish")] !==
                                                        "undefined"
                                                    ) {
                                                        window[boxId.attr("data-autocomplete-finish")].call(
                                                            boxId[0],
                                                            response.data
                                                        );
                                                    } else {
                                                        console.log(
                                                            "FunciÃ³n no existe:" +
                                                            boxId.attr("data-autocomplete-finish")
                                                        );
                                                    }
                                                } else {
                                                    console.log('OJO2: No tiene data-autocomplete-finish', boxId);
                                                }
                                            } else if (
                                                response.status == "error"
                                            ) {
                                                var alerta = $("<div>")
                                                    .addClass(
                                                        "alert alert-danger alert-dismissable"
                                                    )
                                                    .hide();
                                                alerta.text(response.message);
                                                modal
                                                    .find(".modal-content")
                                                    .prepend(alerta);
                                                alerta.slideDown();
                                                setTimeout(function () {
                                                    alerta.slideUp(
                                                        500,
                                                        function () {
                                                            $(this).remove();
                                                        }
                                                    );
                                                }, 2000);
                                            }
                                        },
                                    });
                                });
                        },
                        error: function () {
                            modal.remove();
                            alert("No se ha podido conectar con el servidor");
                        },
                        complete: function () {
                            micro_ready();
                            var formulario = modal.find("form");
                            //modal.hidde();
                        },
                    });
                }
                modal.on("hidden.bs.modal", function () {
                    //setTimeout(function() {
                    //modal.remove();
                    //}, 500);
                });
                $("body").append(modal);
                modal.modal("show");
            });
            /*if(typeof $(this).closest('input-group') !== 'undefined') {
                var topa = $("<div>").addClass('input-group');
                $(this).parent().append(topa);
                $(this).appendTo(topa);
            }*/
        }

        var modificacion_permitida = false;
        var modificaron = function () {
            console.log("Modificaron", box[0]);
            boxId.val("");
            box.attr("data-value", "");
            boxId.attr("data-value", "");
            box[0].value = "";
        };
        const conf = new Bloodhound({
            datumTokenizer: (datum) =>
                Bloodhound.tokenizers.whitespace(datum.value),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            remote: {
                url:
                    url + (url.indexOf("?") == -1 ? "?" : "&") + "query=%QUERY",
            },
        });
        conf.initialize();
        box.typeahead(
            {
                minLength: 1,
                highlight: true,
            },
            {
                displayKey: "value",
                source: conf.ttAdapter(),
            }
        );
        var boxAttr = box[0].attributes;
        for (var index in boxAttr) {
            if (
                typeof boxAttr[index].name !== "undefined" &&
                boxAttr[index].name.startsWith("data-")
            ) {
                if (boxAttr[index].name === "data-disabled") {
                    box.attr("disabled", "true");
                } else {
                    boxId.attr(boxAttr[index].name, boxAttr[index].value);
                }
            }
        }
        box.on("change", function () {
            console.log(
                "change!",
                "Antes",
                box.attr("data-value"),
                "Ahora",
                box.val()
            );
            if (
                !modificacion_permitida &&
                box.attr("data-value") !== box.val()
            ) {
                console.log("change Ok!", this, box);
                setTimeout(modificaron, 100);
            }
            modificacion_permitida = false;
        });
        box.on("typeahead:selected", function (ev, item) {
            console.log("Se escoge el item:", item);
            modificacion_permitida = true;
            if(typeof detalle !== 'undefined' && detalle && typeof item.precio_unidad !== 'undefined') {
              var tr = boxId.closest('tr');
              console.log(tr.children);  
              var index = $("#productos tr").index(tr);
              //  .val( item.precio_unidad );
              console.log(index);
              var precio = document.querySelector(`#productos tr:nth-child(${ index + 1 } )  .precio`)
              var cantidad = document.querySelector(`#productos tr:nth-child(${ index + 1 } )  .cantidad`)
              precio.value = item.precio_unidad;
              cantidad.value = cantidad.value > 0 ? cantidad.value : 1; 
              detalle[index].producto_id = item.id;
              console.log( precio.value );
              var event = new Event('keyup');
              precio.dispatchEvent(event);
              cantidad.dispatchEvent(event);
              detalle[index].monto = item.precio_unidad;
              console.log(detalle);
            }
            console.log("typeahead:selected");
            boxId.attr("value", item.id);
            boxId.val(item.id);
            boxId.attr("data-value", item.value);
            if (typeof item.data !== "undefined") {
                for (var index in item.data) {
                    if (item.data.hasOwnProperty(index)) {
                        if (index === "disabled") {
                            box.attr("disabled", "true");
                        } else {
                            boxId.attr("data-" + index, item.data[index]);
                        }
                    }
                }
            }
            boxId.change();
            if (typeof boxId.attr("data-autocomplete-finish") !== "undefined") {
                if ( typeof window[boxId.attr("data-autocomplete-finish")] !== "undefined") {
                    window[boxId.attr("data-autocomplete-finish")].call(
                        boxId[0],
                        item
                    );
                } else {
                    console.log(
                        "Funcion no existe:" +
                        boxId.attr("data-autocomplete-finish")
                    );
                }
            } else {
                console.log("OJO1: No tiene data-autocomplete-finish", boxId);
            }
        });
    });
}
function render_input_ajax() {
    $(".form-ajax").each(function () {
        var box = $(this);
        box.removeClass("form-ajax");
        var url = box.attr("data-ajax");
        box.on("change", function () {
            Fetchx({
                url: url,
                type: "POST",
                data: {
                    _token: $("[name='_token']").val(),
                    id: box.val(),
                },
                beforeSend: function () { },
                success: function (data) {
                    eval(data);
                },
                error: function (e) {
                    console.log("error", e);
                    alert("Ha ocurrido un problema inesperado.");
                },
            });
        });
    });
}
function form_select_fill(field, data) {
    console.log("form_select_fill", field, data);
    var options = "";
    for (var x = 0; x < data.length; x++) {
        options +=
            '<option value="' +
            data[x]["id"] +
            '">' +
            data[x]["value"] +
            "</option>";
    }
    $("select[name='" + field + "']")
        .html(options)
        .change();
}
function render_select_default() {
    $("select[data-value]").each(function () {
      var vvv = $(this).attr("data-value");
      $(this).removeAttr('data-value');
        if (vvv != "") {
            if (typeof $(this).attr("data-ajax") !== "undefined") {
                $(this).val(vvv);
            } else {
                $(this).val(vvv).change();
            }
        }
    });
}
function time_input_js(time, formato) {
    let dt = "00:00:00";
    if (!time) return dt;
    if (typeof time !== "string" && typeof time !== "number") {
        console.warn("Time in time-input is not a string or a number!");
        return dt;
    }
    let t, l;
    let h = "00";
    let m = "00";
    let s = "00";
    let sep = ":";
    t = time.toString().replace(/[^0-9]/gm, "");
    l = t.length;
    if (!parseInt(t)) return dt;
    function handler(type, value) {
        let r;
        let l = type === "h" ? 23 : 59;
        r = value.length === 1 ? "0" + value : parseInt(value) > l ? h : value;
        return r;
    }
    function fh() {
        return handler("h", t.substr(0, 2));
    }
    function fm() {
        return handler("m", t.substr(2, 2));
    }
    function fs() {
        return handler("s", t.substr(4, 2));
    }
    if (l <= 2) {
        h = fh();
    }
    if (l === 3 || l === 4) {
        h = fh();
        m = fm();
    }
    if (l === 5 || l >= 6) {
        h = fh();
        m = fm();
        s = fs();
    }
    return h + sep + m + sep + s;
}
function render_input_time() {
    $("input[data-format]").each(function () {
        var box = this;
        var format = $(box).attr("data-format");
        $(box).removeClass("data-format");
        if (format == "time") {
            var timeKey = null;
            $(box).on("keypress", function () {
                if (timeKey !== null) {
                    clearTimeout(timeKey);
                }
                timeKey = setTimeout(function () {
                    box.value = time_input_js(box.value, format);
                    timeKey = null;
                }, 1000);
            });
        }
    });
}
function render_confirm_input() {
  $("[data-confirm-input]").each(function () {
    var box = this;
    var text = $(box).attr("data-confirm-input") || "¿Cual fue el motivo?";
    var url  = $(box).attr('href');
    console.log("CONFIRM ", box);
    $(this).on("click", function (e) {
      e.preventDefault();
            var modal = $("<div>")
                .addClass("modal fade")
                .attr("role", "dialog")
                .attr("aria-labelledby", "modal-fadein")
                .attr("aria-hidden", "true");
            modal.html('<div class="modal-dialog"><div class="modal-content" style="box-shadow: none;background-color: transparent;margin-top: 20%;"><div class="modal-body">'+ 
                  '<p class="text-white text-large fw-light mb-1">' + text + '</p>' +
                  '<div class="input-group input-group-lg mb-1">' +
                  '<input type="text" class="form-control bg-white border-0">' +
                  '<button class="btn btn-primary" type="button" id="subscribe">Realizar</button>' +
                  '</div><div class="text-start text-white opacity-50">Debe indicar el motivo de su solicitud</div></div></div></div>');
            $("body").append(modal);
            modal.modal("show");
            modal.find("button.btn-primary").on("click", function () {
              Fetchx({
                url: url,
                type: 'POST',
                headers : {
                  'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                  },
                data: {
                  value: modal.find('input.form-control').val(),
                },
                dataType: 'json',
                success: function(res) {
                  if(!res.status) {
                    modal.find('.text-start').text(res.message);
                  } else {
                    $(box).slideUp();
                    console.log('MODAL', modal);
                    modal.modal("hide");
                    modal.remove();
                    $('body').removeClass('modal-open');
                    $(".modal-backdrop").remove();
                  }
                }
              });
            });
            return false;
    });
  });
}
function render_link_confirm() {
    $("[data-confirm]").each(function () {
        var box = this;
        var text = $(box).attr("data-confirm") || "Realizar";
        console.log("CONFIRM ", box);
        $(this).on("click", function (e) {
            e.preventDefault();
            var modal = $("<div>")
                .addClass("modal fade")
                .attr("role", "dialog")
                .attr("aria-labelledby", "modal-fadein")
                .attr("aria-hidden", "true");
            modal.html(
                '<div class="modal-dialog" role="document"><div class="modal-content"><div class="modal-header"><h5 class="modal-title">ConfirmaciÃ³n</h5></div><div class="modal-body">Es necesaria su aprobaciÃ³n para poder realizar la acciÃ³n en el sistema.</div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button><button class="btn btn-primary">' +
                text +
                "</button></div></div></div>"
            );
            $("body").append(modal);
            modal.find("button.btn-primary").on("click", function () {
                window.location.href = $(box).attr("href");
            });
            modal.modal("show");
            return false;
        });
    });
}
function render_dom_popup() {
    $("[data-popup]").each(function () {
        var box = $(this);
        var form = box.attr("data-popup");
        $(this).attr("data-url", form);
        box.removeAttr("data-popup");
        console.log("POPUP", form, box);
        box.on("click", function () {
            console.log("CLICK", box, form);
            var cache = box.attr("data-popup-cache") || "false";
            cache = cache === "false" ? false : true;
            if ($(".modal[data-url='" + form + "']").length && cache) {
                var modal = $(".modal[data-url='" + form + "']");
            } else {
                var modal = $("<div>")
                    .addClass("modal fade")
                    .attr("data-url", form)
                    .attr("role", "dialog")
                    .attr("aria-labelledby", "modal-fadein")
                    .attr("aria-hidden", "true");
                modal.html(
                    '<div class="modal-dialog" role="document"><div class="modal-content" style="min-width:700px;">Cargando...</div></div>'
                );
                $("body").append(modal);
                Fetchx({
                    url: form,
                    type: "GET",
                    success: function (data) {
                        console.log("Success");
                        modal.find(".modal-content").html(data);
                        modal.find("form").off("submit").on("submit", function (e) {
                            e.preventDefault();
                            var formulario = modal.find("form");
                            return Fetchx({
                                url: formulario.attr("action"),
                                type: "POST",
                                processData: false,
                                contentType: false,
                                data: new FormData( formulario[0] ),
                                success: function (response) {
                                    if (typeof response.status === 'undefined') {
                                        return;
                                    }
                                    console.log("response", response.status);
                                    
                                    if (response.status === true) {
                                        modificacion_permitida = true;
                                        modal.modal("hide");
                                        if (typeof response.eval !== "undefined" && response.eval) {
                                          eval(response.eval)
                                        }

                                        if (typeof response.refresh !== "undefined" && response.refresh) {
                                            location.reload();
                                        }
                                    } else if (response.status === false) {
                                        var alerta = $("<div>").addClass("alert alert-danger alert-dismissable").hide();
                                        alerta.text(response.message);
                                        modal.find(".modal-content").append(alerta);
                                        modal.find(".modal-content").prepend(alerta);
                                        alerta.slideDown();
                                        setTimeout(function () {
                                            alerta.slideUp(500, function () {
                                                $(this).remove();
                                            });
                                        }, 2000);
                                    }
                                },
                            });
                        });
                    },
                    error: function () {
                        modal.remove();
                        alert("No se ha podido conectar con el servidor");
                    },
                    complete: function () {
                        console.log("Complete");
                        micro_ready();
                    },
                });
            }
            modal.modal("show");
        });
    });
}
function render_confirm_remove() {
    $("[data-confirm-remove]").each(function () {
        var box = $(this);
        var url = $(this).attr("data-confirm-remove");
        box.removeAttr("data-confirm-remove");

        var n = Swal.mixin({
            position: 'center',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
        });
        box.on("click", function (e) {
            n.fire({
                title: "¿Esta seguro de eliminar?",
                text:
                    "De realizarse esta accion no podra acceder nuevamente a la informacion.",
                icon: "warning",
                showCancelButton: true,
                customClass: {
                    confirmButton: "btn btn-alt-danger m-1",
                    cancelButton: "btn btn-alt-secondary m-1",
                },
                confirmButtonText: "Si, eliminar!",
                html: false,
            }).then(function (e) {
                if (e.value) {
                    Fetchx({
                        url: url,
                        type: "DELETE",
                        headers : {
                         'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr("content")
                        },
                        success: function (data) {
                            if (data.status) {
                                n.fire(
                                    "Eliminado!",
                                    "El objeto ha sido eliminado de forma correcta.",
                                    "success"
                                );
                            } else {
                                n.fire("Denegado", data.message, "error");
                            }
                            if (typeof data.refresh !== "undefined" && data.refresh) {
                                setTimeout(function () {
                                    location.reload();
                                }, 2000);
                            }
                        },
                    });
                } else if ("cancel" === e.dismiss) {
                    n.fire(
                        "Cancelado",
                        "El proceso ha sido cancelado! :)",
                        "error"
                    );
                } else {
                    n.fire(
                        "Cancelado",
                        "El proceso ha sido cancelado.",
                        "error"
                    );
                }
            });
        });
    });
}
function render_outgoing() {
  $('[data-outgoing]').each(function() {
    var num = $(this).attr('data-outgoing');
    var title = $(this).attr('data-outgoing-title');
    $(this).removeAttr('data-outgoing').attr('data-outgoing-view', 1)
      .html('<i class="bx bx-phone-call"></i>' + num);
    $(this).on('click', function() {
      if(typeof sip !== 'undefined') {
        sip.outgoing(num, title);
      }
    });
  });
}


function combo() {
  let selectEstado = document.getElementById('select-estado');

  selectEstado.addEventListener('change', () => {
  console.log(selectEstado.value);   

    let name = selectEstado.getAttribute('data-name');
    let url  = selectEstado.getAttribute('data-url');
    let data = new FormData();
    data.append( name, selectEstado.value );
    data.append( "field",name );
    fetch( url  , {
        headers : {
           'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute("content")
        },
       method: "post",
       body:data
    }).then( response => response.json() )
      .then( data => {
          if(data.status){
            toastSuccess()
         }
    })
  })
}

function render_editable() {
  $('[data-editable]').each(function(event ) {
    var xhr = $(this).attr('data-editable');
    var box = $(this);
    $(this).removeAttr('data-editable').attr('data-editable-view', 1);
    var focus = false;
    enableImageResizeInDiv(this);
    $(this).attr('contenteditable', true);
    $(this).on('click', function() {
      if(focus) {
        return;
      }
      focus = true;
      if(this.tagName == 'INPUT') {
        if($(this).attr('type') == 'text') {
          document.execCommand('selectAll',false,null);
        }
      }
    });
    var stt = null;
    var is_div = this.tagName == 'DIV';
    var is_html = typeof $(this).attr('data-ishtml') !== 'undefined';
    var selected = is_html ? box.html() : (is_div ? box.text() : box.val());
    var stf = null;
    box.on((is_div ? 'input' : 'change'), function() {
      if(stt !== null) {
        clearTimeout(stt);
      }
      if(stf !== null) {
        box.removeClass('saved');
        clearTimeout(stf);
      }
      stt = setTimeout(function() {
        var tt = is_html ? box.html() : (is_div ? box.text() : box.val());
          Fetchx({
            url: xhr,
            headers : {
               'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute("content")
            },
            dataType: 'json',
            type: 'PUT',
            data: { value: tt },
            complete: function() {
              box.addClass('saved');
              stf = setTimeout(function() {
                box.removeClass('saved');
              }, 1000);
            },
            success: function(data) {
              if(data.status) {
                if(is_html) {
                  box.html(data.value);

                } else if(is_div) {
                  box.text(data.value);
                }
                selected = tt;
                toastSuccess()
              } else {
                if(is_html) {
                  box.html(selected);

                } else if(is_div) {
                  box.text(selected);
                } else {
                  box.val(selected);
                }
                toastError(data.message);
              }
            },
            error: function() {
              if(is_html) {
                  box.html(selected);
                } else if(is_div) {
                  box.text(selected);
                } else {
                  box.val(selected);
                }
              toastError('Error');
            }
          });
      }, 1500);

    });
  });
}
function micro_ready() {
  render_confirm_remove();
  render_link_confirm();
  render_confirm_input();
  render_dom_popup();
  render_input_time();
  render_table();
  render_autocomplete();
  render_input_ajax();
  render_select_default();
  render_outgoing();
  render_editable();
//  combo();
}
$(document).ready(function () {
    micro_ready();
});
        function enableImageResizeInDiv(editor) {
            if (!(/chrome/i.test(navigator.userAgent) && /google/i.test(window.navigator.vendor))) {
                return;
            }
            var resizing = false;
            var currentImage;
            var createDOM = function (elementType, className, styles) {
                let ele = document.createElement(elementType);
                ele.className = className;
                setStyle(ele, styles);
                return ele;
            };
            var setStyle = function (ele, styles) {
                for (key in styles) {
                    ele.style[key] = styles[key];
                }
                return ele;
            };
            var removeResizeFrame = function () {
                document.querySelectorAll(".resize-frame,.resizer").forEach((item) => item.parentNode.removeChild(item));
            };
            var offset = function offset(el) {
                const rect = el.getBoundingClientRect(),
                scrollLeft = window.pageXOffset || document.documentElement.scrollLeft,
                scrollTop = window.pageYOffset || document.documentElement.scrollTop;
                return { top: rect.top + scrollTop, left: rect.left + scrollLeft }
            };
            var clickImage = function (img) {
                removeResizeFrame();
                currentImage = img;
                const imgHeight = img.offsetHeight;
                const imgWidth = img.offsetWidth;
                const imgPosition = { top: img.offsetTop, left: img.offsetLeft };
                const editorScrollTop = editor.scrollTop;
                const editorScrollLeft = editor.scrollLeft;
                const top = imgPosition.top - editorScrollTop - 1;
                const left = imgPosition.left - editorScrollLeft - 1;
    
                editor.append(createDOM('span', 'resize-frame', {
                    margin: '10px',
                    position: 'absolute',
                    top: (top + imgHeight - 10) + 'px',
                    left: (left + imgWidth - 10) + 'px',
                    border: 'solid 3px blue',
                    width: '6px',
                    height: '6px',
                    cursor: 'se-resize',
                    zIndex: 1
                }));
    
                editor.append(createDOM('span', 'resizer top-border', {
                    position: 'absolute',
                    top: (top) + 'px',
                    left: (left) + 'px',
                    border: 'dashed 1px grey',
                    width: imgWidth + 'px',
                    height: '0px'
                }));
    
                editor.append(createDOM('span', 'resizer left-border', {
                    position: 'absolute',
                    top: (top) + 'px',
                    left: (left) + 'px',
                    border: 'dashed 1px grey',
                    width: '0px',
                    height: imgHeight + 'px'
                }));
    
                editor.append(createDOM('span', 'resizer right-border', {
                    position: 'absolute',
                    top: (top) + 'px',
                    left: (left + imgWidth) + 'px',
                    border: 'dashed 1px grey',
                    width: '0px',
                    height: imgHeight + 'px'
                }));
    
                editor.append(createDOM('span', 'resizer bottom-border', {
                    position: 'absolute',
                    top: (top + imgHeight) + 'px',
                    left: (left) + 'px',
                    border: 'dashed 1px grey',
                    width: imgWidth + 'px',
                    height: '0px'
                }));
    
                document.querySelector('.resize-frame').onmousedown = () => {
                    resizing = true;
                    return false;
                };
    
                editor.onmouseup = () => {
                    if (resizing) {
                        currentImage.style.width = document.querySelector('.top-border').offsetWidth + 'px';
                        currentImage.style.height = document.querySelector('.left-border').offsetHeight + 'px';
                        refresh();
                        currentImage.click();
                        resizing = false;
                    }
                };
    
                editor.onmousemove = (e) => {
                    if (currentImage && resizing) {
                        let height = e.pageY - offset(currentImage).top;
                        let width = e.pageX - offset(currentImage).left;
                        height = height < 1 ? 1 : height;
                        width = width < 1 ? 1 : width;
                        const top = imgPosition.top - editorScrollTop - 1;
                        const left = imgPosition.left - editorScrollLeft - 1;
                        setStyle(document.querySelector('.resize-frame'), {
                            top: (top + height - 10) + 'px',
                            left: (left + width - 10) + "px"
                        });
    
                        setStyle(document.querySelector('.top-border'), { width: width + "px" });
                        setStyle(document.querySelector('.left-border'), { height: height + "px" });
                        setStyle(document.querySelector('.right-border'), {
                            left: (left + width) + 'px',
                            height: height + "px"
                        });
                        setStyle(document.querySelector('.bottom-border'), {
                            top: (top + height) + 'px',
                            width: width + "px"
                        });
                    }
                    return false;
                };
            };
            var bindClickListener = function () {
                editor.querySelectorAll('img').forEach((img, i) => {
                    img.onclick = (e) => {
                        if (e.target === img) {
                            clickImage(img);
                        }
                    };
                });
            };
            var refresh = function () {
                bindClickListener();
                removeResizeFrame();
                if (!currentImage) {
                    return;
                }
                var img = currentImage;
                var imgHeight = img.offsetHeight;
                var imgWidth = img.offsetWidth;
                var imgPosition = { top: img.offsetTop, left: img.offsetLeft };
                var editorScrollTop = editor.scrollTop;
                var editorScrollLeft = editor.scrollLeft;
                const top = imgPosition.top - editorScrollTop - 1;
                const left = imgPosition.left - editorScrollLeft - 1;
    
                editor.append(createDOM('span', 'resize-frame', {
                    position: 'absolute',
                    top: (top + imgHeight) + 'px',
                    left: (left + imgWidth) + 'px',
                    border: 'solid 2px red',
                    width: '6px',
                    height: '6px',
                    cursor: 'se-resize',
                    zIndex: 1
                }));
    
                editor.append(createDOM('span', 'resizer', {
                    position: 'absolute',
                    top: (top) + 'px',
                    left: (left) + 'px',
                    border: 'dashed 1px grey',
                    width: imgWidth + 'px',
                    height: '0px'
                }));
    
                editor.append(createDOM('span', 'resizer', {
                    position: 'absolute',
                    top: (top) + 'px',
                    left: (left + imgWidth) + 'px',
                    border: 'dashed 1px grey',
                    width: '0px',
                    height: imgHeight + 'px'
                }));
    
                editor.append(createDOM('span', 'resizer', {
                    position: 'absolute',
                    top: (top + imgHeight) + 'px',
                    left: (left) + 'px',
                    border: 'dashed 1px grey',
                    width: imgWidth + 'px',
                    height: '0px'
                }));
            };
            var reset = function () {
                if (currentImage != null) {
                    currentImage = null;
                    resizing = false;
                    removeResizeFrame();
                }
                bindClickListener();
            };
            editor.addEventListener('scroll', function () {
                reset();
            }, false);
            editor.addEventListener('mouseup', function (e) {
                if (!resizing) {
                    const x = (e.x) ? e.x : e.clientX;
                    const y = (e.y) ? e.y : e.clientY;
                    let mouseUpElement = document.elementFromPoint(x, y);
                    if (mouseUpElement) {
                        let matchingElement = null;
                        if (mouseUpElement.tagName === 'IMG') {
                            matchingElement = mouseUpElement;
                        }
                        if (!matchingElement) {
                            reset();
                        } else {
                            clickImage(matchingElement);
                        }
                    }
                }
            });
        }
function convertirMilisegundos(t, vms) {
  ms = t % 1000;
  t = parseInt((t - ms) / 1000);
  ss = t % 60;
  t = parseInt((t - ss) / 60);
  mm = t % 60;
  hh = parseInt((t - mm) / 60);
  return hh.toString().padStart(2, "0") + ":" + mm.toString().padStart(2, "0") + ":" + ss.toString().padStart(2, "0") + (vms || ms > 0 ? "." + ms.toString().padStart(3, "0") : "");
}

function operarMilisegundos(t1, t2, op) {
  var tt = "";
  var expTiempo = /((\d{1,2})\:)?(\d{1,2})\:(\d{2})(\.(\d{1,3}))?/;

  r1 = t1.match(expTiempo);
  r2 = t2.match(expTiempo);

  if(r1 && r2) {
    hh1 = r1[2] ? parseInt(r1[2]) : 0;
    mm1 = r1[3] ? parseInt(r1[3]) : 0;
    ss1 = r1[4] ? parseInt(r1[4]) : 0;
    ms1 = r1[6] ? parseInt(r1[6].padEnd(3, "0")) : 0;
    tt1 = hh1 * 60 * 60 * 1000 + mm1 * 60 * 1000 + ss1 * 1000 + ms1;

    hh2 = r2[2] ? parseInt(r2[2]) : 0;
    mm2 = r2[3] ? parseInt(r2[3]) : 0;
    ss2 = r2[4] ? parseInt(r2[4]) : 0;
    ms2 = r2[6] ? parseInt(r2[6].padEnd(3, "0")) : 0;
    tt2 = hh2 * 60 * 60 * 1000 + mm2 * 60 * 1000 + ss2 * 1000 + ms2;

    vms = r1[6] || r2[6];
    if(op == '+') {
      tt = convertirMilisegundos(tt1 + tt2, vms);
    }
    else if(op == '-') {
      tt = convertirMilisegundos(tt1 - tt2, vms);
    }
  }

  return tt;
}

(function () {
    var espacio = null;
    var actual = null;
    var saving = false;
    var openModaly = function () {
        if (typeof $(espacio).attr('data-modaly-id') === 'undefined' || $(espacio).attr('data-modaly-id') == "") {
            espacio = null;
            console.log('openModaly NULl');
            return false;
        }
        console.log('openModaly:', espacio);
        actual = $(espacio).html();
        var bloque = $("<div>").addClass('bloqueModificable');
        Fetchx({
            id: 'save-punto',
            delay: 0,
            loading: '#loading_calendar',
            url: $(espacio).attr('data-modaly'),
            type: 'GET',
            data: {
                id: $(espacio).attr('data-modaly-id'),
            },
            success: function (res) {
                $(espacio).html(bloque.html(res));
                if (bloque.find('.combo-extra').length == 0) {
                    bloque.find('.combo').val(actual);
                }
            },
            error: function () {
                alert('Ha ocurrido un problema en el sistema');
                saving = false;
                closeModaly();
            }
        });
    };
    var closeModaly = function () {
        console.log('closeModaly');
        if (!saving) {
            $(espacio).html(actual);
            espacio = null;
        }
    };
    var saveModaly = function () {
        saving = true;
        $(espacio).find('.bloqueModificable').slideUp(400, function () {
            if (saving) {
                $(espacio).html('...');
            }
        });
        var serial = $(espacio).find('.tipFormulario').serialize();
        serial += '&_token=' + $("[name='_token']").val() + '&id=' + $(espacio).attr('data-modaly-id');
        Fetchx({
            id: 'save-punto',
            delay: 0,
            loading: '#loading_calendar',
            url: $(espacio).attr('data-modaly'),
            type: 'POST',
            dataType: 'json',
            data: serial,
            success: function (res) {
                if(res.status) {
                    if(typeof res.data.respuesta !== 'undefined') {
                        $(espacio).text(res.data.respuesta);
                    }
                    saving = false;
                    espacio = null;
                    typeof calcular_costos !== 'undefined' && calcular_costos();
                    if (typeof res.refresh !== "undefined" && res.refresh) {
                        setTimeout(function () {
                            location.reload();
                        }, 2000);
                    }
                } else {
                    alert(res.message);
                }
            },
            error: function () {
                alert('Ha ocurrido un problema en el sistema');
                saving = false;
                closeModaly();
            }
        });
    }
    window.modalyOpen = function(box, url) {
        if (espacio === null) {
            espacio = $(box);
            $(espacio).attr('data-modaly', url);
            openModaly();
        } else {
            closeModaly();
        }
    }
    $(document).on('click', '[data-modaly]', function (e) {
        e.stopPropagation();
        if (espacio === null) {
            espacio = this;
            openModaly();
        } else {
            closeModaly();
        }
    });
    $(document).on('click', '[data-modaly] .bloqueModificable', function (e) {
        e.stopPropagation();
    });
    $(document).on('submit', '[data-modaly] .bloqueModificable .tipFormulario', function (e) {
        e.preventDefault();
        saveModaly();
    });
    $(document).on('click', function () {
        if (espacio !== null) {
            closeModaly();
        }
    });
})();

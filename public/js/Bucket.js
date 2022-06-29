var Bucketjs = (function () {
  var _instance = this;
  var elements = {};
  var requestPull = [];
  var timerPull = null;
  var indexPullFiles = 0;
  var commit = [];

  var validateFile = function (file) {
    var validTypes = [
      "image/jpeg",
      "image/png",
      "image/gif",
      "application/pdf",
      "application/msword",
      "application/vnd.ms-powerpoint",
      "application/vnd.ms-excel",
      "application/vnd.openxmlformats-officedocument.wordprocessingml.document",
      "application/vnd.openxmlformats-officedocument.presentationml.presentation",
      "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
    ];
    if (validTypes.indexOf(file.type) === -1) {
      alert("El archivo tiene un formato no permitido: " + file.name);
      return false;
    }
    var maxSizeInBytes = 10e6; // 10MB
    if (file.size > maxSizeInBytes) {
      alert("El archivo es muy pesado: " + file.name);
      return false;
    }
    return true;
  };
  var handleFiles = function (bucket_id, files) {
    if (files.length === 0) {
      return false;
    }
    for (var i = 0, len = files.length; i < len; i++) {
      if (validateFile(files[i])) {
        commitBucket(files[i]);
      }
    }
    pushBucket(bucket_id);
  };
  var commitBucket = function (file) {
    commit.push(file);
  };
  var pushBucket = function (bucket_id) {
    if (commit.length === 0) {
      return false;
    }
    var formData = new FormData();
    formData.append("id", bucket_id);
    for (var i = 0, len = commit.length; i < len; i++) {
      formData.append("files[]", commit[i]);
    }
    commit = [];
    $(elements[bucket_id])
      .find(".bucket-loading")
      .attr("data-loading", "push")
      .slideDown();
    var ajax = new XMLHttpRequest();
    ajax.onreadystatechange = function (e) {
      if (ajax.readyState === 4) {
        if (ajax.status === 200) {
          pullBucket(bucket_id);
        } else {
          alert("Ha ocurrido un error inesperado");
          pullBucket(bucket_id);
        }
      }
    };
    ajax.upload.onprogress = function (evt) {
      if (evt.lengthComputable) {
        var percentComplete = parseInt((evt.loaded / evt.total) * 100);
        console.log("Upload: " + percentComplete + "% complete");
        $(elements[bucket_id])
        .find(".bucket-avance")
        .animate({
          height: percentComplete + "%",
        }, 50)
        .attr("data-porcen", percentComplete + "%");
      }
    };
    ajax.open("POST", "/bucket/upload", true);
    ajax.send(formData);
  };
  var renderElement = function (box) {
    var bucket_id  = $(box).attr("data-bucket");
    var can_upload = $(box).attr('data-upload') || false;
    can_upload = can_upload === 'true';
    if (typeof elements[bucket_id] !== "undefined") {
      if (!$(elements[bucket_id]).is(":visible")) {
        $(elements[bucket_id]).remove();
      }
    }
    requestPull.push(box);
    $(box).addClass("bucket bucket-initial");
    $(box).append($("<div>").addClass('bucket-button-full').text('Más'));
    $(box).append($("<div>").addClass('bucket-space-upload').text('Subir Archivo'));
    $(box).append($("<ul>"));
    $(box).on("click", '.name', function (e) {
      console.log('Click NAME', this);
      e.stopPropagation();
      window.open('https://storage.googleapis.com/educativa.site/' + $(this).closest('li').attr("data-download"));
    });
    elements[bucket_id] = box;
    box.bucket_id = bucket_id;
    $(box).removeAttr("data-bucket");
    $(box).on('click', '.bucket-button-full', function() {
      $(box).toggleClass('bucket-full');
    });
    if(can_upload) {
      $(box).on('click', ".bucket-space-upload", function (e) {
        if (e.target !== this) {
          return false;
        }
        e.preventDefault();
        if (!$(box).hasClass("bucket-ready")) {
          return false;
        }
        var fakeInput = document.createElement("input");
        fakeInput.type = "file";
        fakeInput.multiple = true;
        fakeInput.click();
        fakeInput.addEventListener("change", function () {
          var files = fakeInput.files;
          console.log("UPLOADES", files);
          handleFiles(bucket_id, files);
        });
        console.log("Subir archivo!");
        return false;
      });
    }
  };
  var fillFiles = function (box, files) {
    var ul = $(box).find("ul");
    ul.empty();
    for (var i in files) {
      ul.append(
        $("<li>")
          .attr("data-id", files[i].id)
          .attr("data-download", files[i].download)
          .append($("<div>").addClass('rotulo')
            .append(
              $("<div>")
                .addClass("name")
                .text(files[i].name)
                .attr("title", "Subido el: " + files[i].uploaded)
            )
            .append($("<span>").addClass("size").text(files[i].size))
            .append($("<span>").addClass("extension").text(files[i].extension)))
          .append($("<div>").addClass('details')
          .append($("<span>").addClass("author").text(files[i].user).attr('title','Subido por:'))
          .append($("<span>").addClass("uploaded").text(files[i].uploaded).attr('title','Subido el:'))
          .append($("<span>").addClass("delete").text('Eliminar').attr('title','Acción no disponible').on('click', function() {
						var li = $(this).closest('li');
						var li_id = li.attr('data-id');
						li.slideUp();
						Fetchx({
      id: "delete" + li_id,
      url: "/bucket/delete",
      type: "POST",
      data: { id: li_id },
      dataType: "json",
      compete: function (data) {
            console.log("Adios");
      },
    });

						console.log('Eliminar', li.attr('data-id'));
					}))
      ));
    }
    //$(box).find('ul').html(ul);
  };
  var pullBucket = function (bucket_id) {
    requestPull.push(elements[bucket_id]);
  };
  var pullFiles = function () {
    if (requestPull.length == 0) {
      return false;
    }
    indexPullFiles++;
    console.log("Bucket-pull", requestPull.length);
    var ids = [];
    for (var index in requestPull) {
      ids.push(requestPull[index].bucket_id);
      $(requestPull[index])
        .removeClass("bucket-initial")
        .addClass("bucket-ready");
      if (!$(requestPull[index]).find(".bucket-loading").length) {
        $(requestPull[index]).prepend(
          $("<div>")
            .addClass("bucket-loading")
            .html(
              '<div class="bucket-barra"><div class="bucket-avance" data-porcen="0%"></div></div>'
            )
        );
      }
      $(requestPull[index])
        .find(".bucket-loading")
        .attr("data-loading", "pull")
        .attr("data-id", indexPullFiles);
    }
    console.log("Bucket-Pull", indexPullFiles, requestPull);
    requestPull = [];
    Fetchx({
      id: "bucket-pull-" + indexPullFiles,
      delay: 50,
      loading: $("[data-loading='pull'][data-id='" + indexPullFiles + "']"),
      url: "/bucket/get",
      type: "POST",
      data: { ids: ids.join(",") },
      dataType: "json",
      success: function (data) {
        $.each(data.buckets, function (k, n) {
          if (typeof elements[k] !== "undefined") {
            fillFiles(elements[k], n);
          } else {
            console.log("No se encuentra Bucket:", k, n);
          }
        });
      },
      complete: function () {
        $("[data-loading='pull'][data-id='" + indexPullFiles + "']")
          .removeAttr("data-id")
          .removeAttr("data-loading");
      },
    });
  };
  return {
    capture: function (box) {
      console.log("Bucketjs-capture", box);
      renderElement(box);
//      clearInterval(timerPull);
//      timerPull = setInterval(pullFiles, 2000);
    },
    getElements: function () {
      return elements;
    },
  };
})();

<style>
  .intLink { cursor: pointer; }
  i.intLink {
      border: 0;
      width: 22px;
      height: 22px;
      text-align: center;
      vertical-align: bottom;
  }

  #toolBar1 select { font-size:10px; }
  #textBox {
    height: 200px;
    border: 1px #000000 solid;
    padding: 12px;
    overflow: scroll;
  }
  #textBox #sourceText {
    padding: 0;
    margin: 0;
    min-width: 498px;
    min-height: 200px;
  }
  #editMode label { cursor: pointer; }
</style>  
<div class="card-body">


    <form class="form" action="/usuarios/perfil" method="post" id="form-data" onsubmit="if (validateMode()) { this.firma.value = doc.innerHTML; return true; } return false;" name="compForm" >
        @csrf
      @include('usuarios.perfil_form')
    </form>
  </div>
<script>


   if (typeof doc !== 'undefined' && typeof defTxt != 'undefined' ) {
         delete window.doc;
         delete window.defTxt;
        let doc, defTxt;
   } else{
        let doc , defTxt  ;
    }  
  // alert("cargando...")
  function initDoc() {

    doc = document.getElementById("textBox");
    var switchMode = document.getElementById("switchBox");      
    defTxt = doc.innerHTML;
    if ( switchMode.checked) { 
      setDocMode(true);
    }
  }

  function formatDoc(cmd, value) {
    if ( validateMode()) { 
      if(cmd == "image" ){
        console.log("cargar Imagen");
        return
      }      
      document.execCommand(cmd, false, value);
      doc.focus();
    }
  }

  function validateMode() {
    var switchMode = document.getElementById("switchBox");
    if (!switchMode.checked) { return true ; }
    alert("Uncheck \"Show HTML\".");
    doc.focus();
    return false;
  }

  function setDocMode(toSource) {
    console.log(toSource)
    let content;
    if (toSource) {
      content = document.createTextNode(doc.innerHTML);
      doc.innerHTML = "";
      const pre = document.createElement("pre");
      doc.contentEditable = false;
      pre.id = "sourceText";
      pre.contentEditable = true;
      pre.appendChild(content);
      doc.appendChild(pre);
      document.execCommand("defaultParagraphSeparator", false, "div");
    } else {
      if (document.all) {
        doc.innerHTML = doc.innerText;
      } else {
        content = document.createRange();
        content.selectNodeContents(doc.firstChild);
        doc.innerHTML = content.toString();
      }
      doc.contentEditable = true;
    }
    doc.focus();
  }

  function printDoc() {
    if (!validateMode()) { return; }
    const printWin = window.open("","_blank","width=450,height=470,left=400,top=100,menubar=yes,toolbar=no,location=no,scrollbars=yes");
    printWin.document.open();
    printWin.document.write("<!doctype html><html><head><title>Print<\/title><\/head><body onload=\"print();\">" + doc.innerHTML + "<\/body><\/html>");
    printWin.document.close();
  }
</script>

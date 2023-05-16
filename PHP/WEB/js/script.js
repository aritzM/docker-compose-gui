$(document).ready(function() {
  inicio();
});

function inicio() {
  $("button.btn.btn-next").click(function(e) {
      console.log(this.id);
      e.preventDefault();
      if (this.id == "1") {
          mostrarTabs('#v-pills-profile-tab',"#v-pills-home","#v-pills-profile");
      }
      if (this.id == "2") {
        var servicios=[];
        var count=0;
        $('#checkbox input:checked').each(function() {
          $("#tabla >thead tr").append("<th scope=\"col\">"+this.name+"</th>")
        })
        mostrarTabs('#v-pills-messages-tab',"#v-pills-profile","#v-pills-messages");
      }
      if (this.id == "3") {
          mostrarTabs('#v-pills-port-tab',"#v-pills-messages","#v-pills-port");
      }
  });

  $("button.btn.btn-primary").click(function(e) {
    console.log("hola"+this.id);
    e.preventDefault();
    if (this.id == "volver-1") {
      mostrarTabs("#v-pills-home-tab", "#v-pills-profile", "#v-pills-home");
    }
    if (this.id == "volver-2") {
      $("#tabla thead th").each(function(){
        if(this.innerHTML !== "Nº Volumen"){
          this.remove();
        }
      })
      mostrarTabs("#v-pills-profile-tab", "#v-pills-messages", "#v-pills-profile");
    }
    if (this.id == "volver-3") {
      mostrarTabs("#v-pills-messages-tab", "#v-pills-port", "#v-pills-messages");
    }
  });
}

function mostrarTabs(idTabMostrar, idTabContenidoOcultar, idTabContenidoMostrar) {
  var sel = document.querySelector(idTabMostrar);
  bootstrap.Tab.getOrCreateInstance(sel).show();

  $(idTabContenidoOcultar).removeClass("active");
  $(idTabContenidoOcultar).removeClass("show");

  $(idTabContenidoMostrar).addClass("active");
  $(idTabContenidoMostrar).addClass("show");
}

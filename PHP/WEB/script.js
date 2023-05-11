$(document).ready(function() {
  inicio();
  retroceso();
});

function inicio() {
  $("button.btn.btn-next").click(function(e) {
      console.log(this.id);
      e.preventDefault();
      if (this.id == "1") {
          mostrarTabs('#v-pills-profile-tab',"#v-pills-home","#v-pills-profile");
      }
      if (this.id == "2") {
          $( "input:checked" ).each(function(){
              /* preparar volumen y puertos */
          });
          mostrarTabs('#v-pills-messages-tab',"#v-pills-profile","#v-pills-messages");
      }
      if (this.id == "3") {
          mostrarTabs('#v-pills-port-tab',"#v-pills-messages","#v-pills-port");
      }
  });

}

function retroceso() {
  $("button.btn.btn-primary").click(function(e) {
      console.log("hola"+this.id);
      e.preventDefault();
      if (this.id == "volver-1") {
        mostrarTabs("#v-pills-home-tab", "#v-pills-profile", "#v-pills-home");
      }
      if (this.id == "volver-2") {
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

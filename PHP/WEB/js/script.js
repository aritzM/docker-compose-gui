$(document).ready(function() {
  inicio();
});

function inicio() {
  var numeroVolumen = 1;
  var apache = false;
  var mysql = false;
  var mongo = false;
  var nginx = false;
  $("button.btn.btn-next").click(function(e) {
      console.log(this.id);
      e.preventDefault();
      if (this.id == "1") {
          mostrarTabs('#v-pills-profile-tab',"#v-pills-home","#v-pills-profile");
      }
      if (this.id == "2") {
        var endpoint = "comunes/ajax/mostrar.php?";
        $("#idInput").val(numeroVolumen);
        if(actualizar){
          $('#checkbox input:checked').each(function() {
            if(this.name == "apache2"){
              apache = true;
              $("#tabla >thead tr").append("<th scope=\"col\">Apache</th>");            
            }
            if(this.name == "mysql"){
              mysql = true;
              $("#tabla >thead tr").append("<th scope=\"col\">Mysql</th>");
            }
            if(this.name == "mongo"){
              mongo = true;
              $("#tabla >thead tr").append("<th scope=\"col\">Mongo</th>");
            }
            if(this.name == "nginx"){
              nginx = true;
              $("#tabla >thead tr").append("<th scope=\"col\">Nginx</th>");
            }
          });
          endpoint += "cargar=true&usuario="+usuario+"&numeroContenedor="+numeroContenedor+"&";
          $("#tabla > tbody").load(endpoint+"volumenes=true");
          $("#tablaPuertos > tbody").load(endpoint+"puertos=true");
        } else {
          var htmlFilas="";
          $('#checkbox input:checked').each(function() {
            if(this.name == "apache2"){
              apache = true;
              endpoint += "apache2=true&";
              $("#tabla >thead tr").append("<th scope=\"col\">Apache</th>");
              htmlFilas += crearFilaVolumen("Apache",numeroVolumen);            
            }
            if(this.name == "mysql"){
              mysql = true;
              endpoint += "mysql=true&";
              $("#tabla >thead tr").append("<th scope=\"col\">Mysql</th>");
              htmlFilas+= crearFilaVolumen("Mysql",numeroVolumen);
            }
            if(this.name == "mongo"){
              mongo = true;
              endpoint += "mongo=true&";
              $("#tabla >thead tr").append("<th scope=\"col\">Mongo</th>");
              htmlFilas+= crearFilaVolumen("Mongo",numeroVolumen);
            }
            if(this.name == "nginx"){
              nginx = true;
              endpoint += "nginx=true&";
              $("#tabla >thead tr").append("<th scope=\"col\">Nginx</th>");
              htmlFilas+= crearFilaVolumen("Nginx",numeroVolumen);  
            }  
          });
          $("#tablaPuertos > tbody").load(endpoint);
          crearFilaVolumenes(numeroVolumen,htmlFilas);
        }
        mostrarTabs('#v-pills-messages-tab',"#v-pills-profile","#v-pills-messages");
      }
      if (this.id == "3") {
          mostrarTabs('#v-pills-port-tab',"#v-pills-messages","#v-pills-port");
      }
  });

  $("button.btn.btn-primary").click(function(e) {
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
      $("#tabla tbody tr").each(function(){
          this.remove();
      })
      mostrarTabs("#v-pills-profile-tab", "#v-pills-messages", "#v-pills-profile");
    }
    if (this.id == "volver-3") {
      mostrarTabs("#v-pills-messages-tab", "#v-pills-port", "#v-pills-messages");
    }
    if(this.id == "anadirVolumen"){
      var htmlFilas = "";
      if(actualizar){
        numeroVolumen = parseInt($("#tabla > tbody tr:last th").text());
      }
      numeroVolumen++;
      $("#idInput").val(numeroVolumen);
      if(apache){
        htmlFilas += crearFilaVolumen("Apache",numeroVolumen);
      }
      if(mysql){
        htmlFilas += crearFilaVolumen("Mysql",numeroVolumen);
      }
      if(mongo){
        htmlFilas += crearFilaVolumen("Mongo",numeroVolumen);
      }
      if(nginx){
        htmlFilas += crearFilaVolumen("Nginx",numeroVolumen);
      }
      crearFilaVolumenes(numeroVolumen,htmlFilas);
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

function crearFilaVolumen(nombreServicio,numeroVolumen) {
  var html="<td><input type=\"text\" name=\"volumen"+nombreServicio+""+numeroVolumen+"\" class=\"form-control\" placeholder=\"volumen1:volumenDocker\"></td>";
  return html;
}

function crearFilaVolumenes(numeroVolumen,htmlFilas){
  var html="<tr>"+ "<th scope=\"row\">"+ numeroVolumen +"</th>"+htmlFilas + "</tr>";
  $("#tabla > tbody").append(html);
}

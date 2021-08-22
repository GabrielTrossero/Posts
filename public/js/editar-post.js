'use strict'

if ($("#deleteImagen option:selected").val() === undefined) {
      $('#imagen').css("display", "block");
}

//capto cuando el select cambia
$("#deleteImagen").change(function(){
    var deleteImagen = $("#deleteImagen");
    var accion = $("#deleteImagen option:selected").val();
  
    cambiarEstados(accion);
});

function cambiarEstados(accion) {
  if (accion == 'true') {
        $('#imagen').css("display", "block");
  } else if (accion == 'false') {
        $('#imagen').css("display", "none");
  }
}
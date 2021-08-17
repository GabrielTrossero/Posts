$(document).ready(function() {
    //para ordenar correctamente por fecha dependiendo del formato
    $.fn.dataTable.moment('DD/MM/YYYY HH:mm:ss');

    //para mostrar solo una parte del texto en la columna descripcion
    $('#idDataTable').DataTable({
        columnDefs: [ {
            targets: 2,
            render: function ( data, type, row ) {
                return data.length > 280 ?
                    data.substr( 0, 280 ) +'…' :
                    data;
            }
        } ]
    });
} );
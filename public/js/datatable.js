$(document).ready(function() {
    //para ordenar correctamente por fecha dependiendo del formato
    $.fn.dataTable.moment('DD/MM/YYYY HH:mm:ss');

    $('#idDataTable').DataTable({
        columnDefs: [ {
            targets: 2,
            render: function ( data, type, row ) {
                return data.length > 10 ?
                    data.substr( 0, 300 ) +'…' :
                    data;
            }
        } ]
    });
} );
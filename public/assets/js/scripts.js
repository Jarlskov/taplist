$(document).ready(function($) {
    $('#listings').DataTable({
        paging: false,
        initComplete: function() {
            var table = this.api();
            $('#barlist').on( 'change', function() {
                table.column(0).search($(this).val()).draw();
            });
        }
    });

});

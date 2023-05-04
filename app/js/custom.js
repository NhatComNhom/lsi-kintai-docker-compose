$(document).ready(function() {
    var table = $('#example').DataTable({
        buttons: ['csv', 'excel', 'pdf', 'print'],
        searching: false, // tắt tính năng search
        lengthChange: false, // tắt tính năng show entries
        pageLength: 10 // thiết lập số entries mặc định là 10
    });

    table.buttons().container()
        .appendTo('#example_wrapper .col-md-6:eq(0)');
});

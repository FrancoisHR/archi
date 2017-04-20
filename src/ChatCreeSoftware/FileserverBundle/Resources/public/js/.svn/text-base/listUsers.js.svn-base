var oTable;

$(document).ready(function() {
    oTable = $('#userlist').DataTable({
        columns: [
            { orderable: false},
            null,
            null,
            null,
            null,
            null,
            { orderable: false}
        ],
        dom: '<"pull-left"l>ftp',
        language: {
            lengthMenu: "Afficher _MENU_ lignes par page",
            zeroRecords: "Aucun utilisateur",
            infoEmpty: "Aucun utilisateur",
            loadingRecords: "Chargement...",
            search: "Recherche:",
            paginate: {
                first: " ",
                last: " ",
                next: " ",
                previous: " "
            }
        },
        order: [[1, 'asc']]
    });
});
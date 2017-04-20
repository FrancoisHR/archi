/* global urls, pageData */

var oTable, detailTable;

$(document).ready(function () {
    oTable = $('#bordereaux').DataTable({
        ajax: urls.ajaxListBordereaux,
        autoWidth: false,
        buttons: [
            {text: '<span class="glyphicon glyphicon-plus"></span>Ajouter', className: 'New', action: function () {
                    if ($('tr.new').length > 0) {
                        alert("Une nouvelle ligne est déjà en cours d'édition");
                    } else {
                        var today = new Date();
                        var dd = today.getDate();
                        var mm = today.getMonth() + 1; //January is 0!
                        var yyyy = today.getFullYear();

                        if (dd < 10) {
                            dd = '0' + dd;
                        }
                        if (mm < 10) {
                            mm = '0' + mm;
                        }
                        today = dd + '/' + mm + '/' + yyyy;

                        var nRow = oTable.row.add({date: today, type: '', titre: '', lot: '', indice: '', description: '', devis: 0}).draw(false).node();
                        $(nRow).addClass('new');
                        oTable.select.style("api");
                        oTable.row(".selected").deselect();
                        oTable.row(nRow).select(  );
                        editRow(nRow);
                        nEditing = nRow;
                    }
                }},
            {text: '<span class="glyphicon glyphicon-pencil"></span>Editer', className: 'Edit selectionRequired disabled', action: function ( ) {
                    var row = this.row({selected: true}).node();

                    if ($('tr.new').length > 0) {
                        alert("Une nouvelle ligne est déjà en cours d'édition");
                    } else {
                        oTable.select.style("api");
                        editRow(row);
                        nEditing = row;
                    }

                }},
            {text: '<span class="glyphicon glyphicon-duplicate"></span>Copier', className: 'Copy selectionRequired disabled', action: function ( ) {
                    var row = this.row({selected: true}).node();

                    $("#titre").val("");
                    $("#lot").val("");
                    $("#indice").val("");
                    $("#descriptionManuelle").val("");

                    $("#duplicate").modal("show");
                }},
            {text: '<span class="glyphicon glyphicon-file"></span>Bordereau', className: 'Bordereau selectionRequired disabled', action: function () {
                    var row = this.row({selected: true});
                    var selected = row.data();
                    var bordereauId = selected['id'];

                    var url = urls.ajaxBordereau + "/" + bordereauId;

                    var myWindow = window.open(url, selected['titre'], "width=1024, height=768");
                }},
            {
                extend: 'collection',
                text: '<span class="glyphicon glyphicon-print"></span>PDF <span class="caret"></span>',
                className: "Pdf selectionRequired disabled",
                buttons: [
                    {
                        text: '<span class="glyphicon glyphicon-eye-open"></span>Afficher PDF', action: function () {
                            var row = this.row({selected: true});
                            var selected = row.data();
                            var bordereauId = selected['id'];

                            var url = urls.ajaxBordereauPdf + "/" + bordereauId;

                            var myWindow = window.open(url, selected['titre'], "width=1024, height=768");
                        }
                    },
                    {
                        text: '<span class="glyphicon glyphicon-save-file"></span>Déposer le PDF dans le projet', action: function () {
                            $("#inProject").modal("show");
                        }
                    }
                ]
            },
            {text: '<span class="glyphicon glyphicon-remove"></span>Supprimer', className: 'Delete selectionRequired disabled', action: function ( ) {
                    var row = this.row({selected: true});
                    var selected = row.data();
                    var bordereauId = selected['id'];

                    if ($(row.node()).hasClass('new')) {
                        oTable.rows(row).remove().draw(false);
                        $("a.btn.btn-default.selectionRequired").addClass("disabled");
                        ;
                    } else {
                        $("#dialog").dialog({
                            autoOpen: false,
                            modal: true,
                            buttons: {
                                "Confirmer": {
                                    text: "Confirmer",
                                    class: "btn-primary",
                                    click: function () {
                                        $(this).dialog("close");

                                        var url = urls.ajaxBordereauDelete + "/" + bordereauId;

                                        $.ajax({
                                            type: "POST",
                                            url: url,
                                            dataType: "json",
                                            success: function (data) {
                                                if (data.response === 200) {
                                                    oTable.rows(row).remove().draw(false);
                                                    $("a.btn.btn-default.selectionRequired").addClass("disabled");
                                                    ;
                                                } else {
                                                    alert("Erreur lors de la suppression");
                                                }
                                            },
                                            error: function (jqXHR, textStatus, errorThrown) {
                                                alert(textStatus);
                                            }
                                        });
                                    }
                                },
                                "Annuler": function () {
                                    $(this).dialog("close");
                                }
                            },
                            title: "Confirmation de suppression"
                        });
                        $("#dialog").dialog("open");
                    }

                }},
            {text: '<span class="glyphicon glyphicon-remove-circle"></span>Annuler', className: 'Cancel', action: function ( ) {
                    if (nEditing) {
                        if ($(nEditing).hasClass('new')) {
                            oTable.rows(nEditing).remove().draw(false);
                            oTable.select.style('single');
                            $("a.btn.btn-default.New").removeClass("disabled");
                            $("a.btn.btn-default.Cancel, a.btn.btn-default.Save").hide();
                        } else {
                            restoreRow(nEditing, oTable);
                        }
                        nEditing = null;
                    }
                }},
            {text: '<span class="glyphicon glyphicon-floppy-disk"></span>Enregistrer', className: 'Save', action: function ( ) {
                    saveRow(nEditing);
                    nEditing = null;
                }}
        ],
        columns: [
            {data: 'date', width: "100px", type: "date-euro"},
            {data: 'type', width: "140px"},
            {data: 'titre', class: "titre", width: "280px"},
            {data: 'indice', width: "120px"},
            {data: 'lot', width: "120px"},
            {data: 'description', width: "580px"},
            {data: 'devis', className: "details-devis", width: "60px"}
        ],
        columnDefs: [
            {
                render: function (data, type, row) {
                    return "<span class='glyphicon glyphicon-triangle-top'></span>" + data;
                },
                targets: 6
            }
        ],
        dom: 'l<"clear">Bfrtp',
        fixedHeader: true,
        language: {
            "lengthMenu": "Afficher _MENU_ lignes par page",
            "zeroRecords": "Aucun bordereau",
            "info": "Page _PAGE_ de _PAGES_",
            "infoEmpty": "Aucun bordereau",
            "infoFiltered": "(filtr&eacute; de _MAX_ journal)",
            "loadingRecords": "Chargement...",
            "search": "Recherche:",
            "paginate": {
                first: " ",
                last: " ",
                next: " ",
                previous: " "
            }
        },
        order: [[0, 'desc']],
        ordering: true,
        rowId: 'id',
        select: {
            style: 'single'
        },
        colReorder: true

    });
    nEditing = null;

    function devisDetail(id) {
        return '<table id="detail_' + id + '" data-bordereau-id="' + id + '" class="table table-striped table-bordered dataTable no-footer subtable">' +
                '<thead><tr><th>Soumissionaire</th><th>Version</th><th>Etat</th><th>Date envoi</th><th>Date dépot</th><th>Date cloture</th><th>Commentaire</th></tr></thead>' +
                '<tbody></tbody></table>';
    }

    $('#bordereaux tbody').on("click", "td.details-devis", function () {
        var tr = $(this).closest('tr');
        var row = oTable.row(tr);

        if (row.child.isShown()) {
            // This row is already open - close it
            row.child.hide();
            $("span", this).toggleClass("glyphicon-triangle-top").toggleClass("glyphicon-triangle-bottom");
        } else {
            // close previously opened row(s)...
            oTable.rows().every(function (idx, tableLoop, rowLoop) {
                if (this.child && this.child.isShown()) {
                    this.child.hide();
                    $("span", this).toggleClass("glyphicon-triangle-top").toggleClass("glyphicon-triangle-bottom");
                }
            });

            // Open this row
            var id = row.data().id;
            row.child(devisDetail(id)).show();
            $("span", this).toggleClass("glyphicon-triangle-top").toggleClass("glyphicon-triangle-bottom");
            $(row.child()).addClass("child-selected");
            var url = urls.ajaxListQuotes + "/" + id;
            var tableId = "#detail_" + id;
            detailTable = $(tableId).DataTable({
                ajax: url,
                buttons: [
                    {text: '<span class="glyphicon glyphicon-plus"></span>Ajouter', className: 'New', action: function () {
                            if (nEditing) {
                                alert("Une nouvelle ligne est déjà en cours d'édition");
                            } else {
                                var nRow = detailTable.row.add({user: '', etat: pageData.defaultStatus, version: 1, depot: '', envoi: '', cloture: '', commentaire: ''}).draw(false).node();
                                $(nRow).addClass('new');
                                detailTable.select.style("api");
                                detailTable.row(".selected").deselect();
                                detailTable.row(nRow).select(  );
                                editRowDevis(nRow);
                                nEditing = nRow;
                            }
                        }},
                    {text: '<span class="glyphicon glyphicon-list-alt "></span>Offre',
                        className: "devis devisSelectionRequired singleSelection disabled",
                        action: function ( ) {
                            var row = this.row({selected: true});
                            var selected = row.data();
                            var devisId = selected['id'];

                            url = urls.devisEdit + "/" + devisId;
                            var myWindow = window.open(url, selected['titre'], "width=1024, height=768");
                        }
                    },
                    {text: '<span class="glyphicon glyphicon-stats"></span>Comparatif',
                        className: "devis devisSelectionRequired disabled",
                        action: function ( ) {
                            var row = oTable.row($("#bordereaux tr.selected"));
                            var selected = row.data();
                            var bordereauId = selected['id'];

                            var devis = $(tableId + " tr.selected");
                            var devisString = "";
                            if ($(devis).length) {
                                var devisId = [];
                                $.each(devis, function (index, value) {
                                    devisId[index] = $(value).attr('id');
                                });
                                var devisString = "/" + devisId.join("-");
                            }
                            var url = urls.ajaxDevisComparatif + "/" + bordereauId + devisString;

                            var myWindow = window.open(url, selected['titre'], "width=1024, height=768");
                        }
                    },
                    {text: '<span class="glyphicon glyphicon-envelope"></span>Envoyer',
                        className: "Request devisSelectionRequired disabled",
                        action: function ( ) {
                            var rows = this.rows({selected: true});
                            var selected = rows.data();

                            $('#destinataires > tbody').empty();
                            $("#commentaire").val("");
                            $("#attachment-files").val([]);
                            rows.every(function (idx, table, row) {
                                var data = this.data();
                                $('#destinataires > tbody:last-child').append('<tr id="' + data.id + '"><td>' + data.user + '</td><td>' + data.mail + '</td></tr>');
                            });

                            $("#mail-modal").modal("show");
                        }
                    },
                    {text: '<span class="glyphicon glyphicon-remove-circle"></span>Annuler', className: 'Cancel', action: function ( ) {
                            if (nEditing) {
                                var wrapper = $(tableId + "_wrapper");
                                if ($(nEditing).hasClass('new')) {
                                    detailTable.rows(nEditing).remove().draw(false);
                                    detailTable.select.style('single');
                                    $("a.btn.btn-default.New", wrapper).removeClass("disabled");
                                    $("a.btn.btn-default.Cancel, a.btn.btn-default.Save", wrapper).hide();
                                } else {
                                    restoreRow(nEditing, detailTable);
                                }
                                nEditing = null;
                            }
                        }},
                    {text: '<span class="glyphicon glyphicon-floppy-disk"></span>Enregistrer', className: 'Save', action: function ( ) {
                            saveRowDevis(nEditing);
                            nEditing = null;
                        }}
                ],
                columns: [
                    {data: 'user', width: "250px", type: "date-euro"},
                    {data: 'version', width: "80px"},
                    {data: 'etat', width: "110px"},
                    {data: 'envoi', width: "110px", type: "date-euro"},
                    {data: 'depot', width: "110px", type: "date-euro"},
                    {data: 'cloture', width: "110px", type: "date-euro"},
                    {data: 'commentaire', width: "510px"}
                ],
                dom: 'Bt',
                rowId: 'id',
                select: {
                    style: 'multiple'
                }
            });

            $(tableId + " tbody").on('click', 'tr', function () {
                if ($(this).hasClass('selected')) {
                    if ($(tableId + " tr.selected").length > 1) {
                        $("a.btn.btn-default.devisSelectionRequired.singleSelection").addClass("disabled");
                    } else {
                        $("a.btn.btn-default.devisSelectionRequired").removeClass("disabled");
                    }
                } else {
                    if ($(tableId + " tr.selected").length === 1) {
                        $("a.btn.btn-default.devisSelectionRequired.singleSelection").removeClass("disabled");
                    } else if ($("#detail_" + id + " tr.selected").length === 0) {
                        $("a.btn.btn-default.devisSelectionRequired").addClass("disabled");
                    }
                }
            });

            var wrapper = $(tableId + "_wrapper");
            $("a.btn.btn-default.Cancel, a.btn.btn-default.Save", wrapper).hide();
        }
    });

    $("#attachment-files").treeMultiselect();

    $('#bordereaux tbody').on('click', 'tr', function () {
        if (nEditing === null) {
            var row = oTable.row($(this));
            if ($(this).hasClass('selected')) {
                $("a.btn.btn-default.selectionRequired").removeClass("disabled");
            } else {
                $("a.btn.btn-default.selectionRequired").addClass("disabled");
            }
        }
    });

    $("#dialog").dialog({
        autoOpen: false,
        modal: true,
        buttons: {
            "Confirmer": {
                text: "Confirmer",
                class: "btn-primary",
                click: function () {
                    $(this).dialog("close");
                }
            },
            "Annuler": function () {
                $(this).dialog("close");
            }
        },
        title: "Confirmation de suppression"
    });

    $('#duplicate').on('show.bs.modal', function (event) {
        $.ajax({
            type: "POST",
            url: urls.ajaxListProject,
            dataType: "json",
            success: function (data) {
                $("#destination option").remove();

                $.each(data.data, function (i, item) {
                    $option = $('<option>', {
                        value: item.id,
                        text: item.name});
                    if (item.id === pageData.project) {
                        $($option).attr('selected', 'selected');
                    }
                    $("#destination").append($option);

                });
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert(textStatus);
            }
        });
    });

    $('.modal-footer .btn[data-dismiss="modal"]').on('click', function () {
        var target = this;
        $(target).closest('.modal')
                .bindOneFirst('hide.bs.modal hidden.bs.modal', function (event) {
                    event.relatedTarget = target;
                });
    });

    $('#duplicate').on('hide.bs.modal', function (event) {
        if ($(event.relatedTarget).text() === "Copier") {
            var destinationId = $("#destination option:selected").val();

            var row = oTable.row({selected: true});
            var selected = row.data();
            var bordereauId = selected['id'];

            var titre = $("#titre").val();
            var lot = $("#lot").val();
            var indice = $("#indice").val();
            var description = encodeURIComponent($("#descriptionManuelle").val());

            var params = "projectId=" + destinationId + "&titre=" + titre + "&lot=" + lot + "&indice=" + indice + "&description=" + description;
            var url = urls.ajaxBordereauCopy + "/" + bordereauId;

            $.ajax({
                type: "POST",
                url: url,
                data: params,
                dataType: "json",
                success: function (data) {
                    oTable.ajax.reload();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(textStatus);
                }
            });
        }
    });

    $('#inProject').on('hide.bs.modal', function (event) {
        if ($(event.relatedTarget).text() === "Déposer") {
            var filename = $('#filename').val() + ".pdf";
            var destination = $("input[name=folderselect]:checked").val();

            var row = oTable.row({selected: true});
            var selected = row.data();
            var bordereauId = selected['id'];

            var url = urls.ajaxBordereauPdf + "/" + bordereauId;
            var params = "filename=" + filename + "&path=" + destination;
            $.ajax({
                type: "POST",
                url: url,
                data: params,
                dataType: "json",
                success: function (data) {
                    alert("PDF enregistré dans le projet.");
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(textStatus);
                }
            });
        }
    });

    $('#mail-modal').on('hide.bs.modal', function (event) {
        if ($(event.relatedTarget).text() === "Envoyer") {
            var commentaire = encodeURIComponent($("#commentaire").val());
            var params = "commentaire=" + commentaire;

            var fileNumber=0;
            $("#attachment-files option:selected").each( function(){
                var path = [""];
                var folder = $(this).data("section");
                if( folder ){
                    path.push( folder );
                }
                path.push( $(this).val() );
                params += "&file_" + fileNumber++ +"=" + encodeURIComponent(path.join("/"));
            });

            $("#destinataires tr[id]").each(function () {
                var url = urls.devisNotify + "/" + this.id;

                $.ajax({
                    type: "POST",
                    url: url,
                    data: params,
                    dataType: "json",
                    success: function (data) {
                        oTable.ajax.reload();
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        alert(textStatus);
                    }
                });
            });
        }
    });


    $("#bordereaux").keydown(function (event) {
        switch (event.which) {
            case 13:    // Return = Save
                var focused = $(document.activeElement);
                if (focused[0]['type'] !== 'textarea') {
                    saveRow(nEditing);
                    nEditing = null;
                }
                break;
            case 27:    // Escape = Cancel
                if (nEditing) {
                    if ($(nEditing).hasClass('new')) {
                        oTable.rows(nEditing).remove().draw(false);
                        $("a.btn.btn-default.New").removeClass("disabled");
                        $("a.btn.btn-default.Cancel, a.btn.btn-default.Save").hide();
                    } else {
                        restoreRow(nEditing, oTable);
                    }
                    nEditing = null;
                }
                break;
        }
    });

    $("a.btn.btn-default.Cancel, a.btn.btn-default.Save").hide();
});

function editRow(nRow) {
    var data = oTable.row(nRow).data();
    var jqTds = $('>td', nRow);
    jqTds[0].innerHTML = '<input value="' + data['date'] + '" type="text" class="form-control datepicker">';
    jqTds[1].innerHTML = '<input value="' + data['type'] + '" type="text" class="form-control">';
    jqTds[2].innerHTML = '<input value="' + data['titre'] + '" type="text" class="form-control">';
    jqTds[3].innerHTML = '<input value="' + data['indice'] + '" type="text" class="form-control">';
    jqTds[4].innerHTML = '<input value="' + data['lot'] + '" type="text" class="form-control">';
    jqTds[5].innerHTML = '<textarea rows="2" class="form-control">' + data['description'] + '</textarea>';


    $("input.datepicker").datepicker({dateFormat: "dd/mm/yy"});
    $("input[type=text]:visible:first", nRow).focus();
    $("a.btn.btn-default.New, a.btn.btn-default.selectionRequired").addClass("disabled");
    $("a.btn.btn-default.Cancel, a.btn.btn-default.Save").show();
}

function editRowDevis(nRow) {
    var data = detailTable.row(nRow).data();
    var wrapper = $("#" + $(nRow).closest('table').attr('id') + "_wrapper");
    var jqTds = $('>td', nRow);

    jqTds[0].innerHTML = '<select id="providers" class="form-control">' + pageData.providers + '</select>';
    jqTds[1].innerHTML = '<input value="' + data['version'] + '" type="text"  class="form-control" >';
    jqTds[2].innerHTML = '<select id="status" class="form-control">' + pageData.status + '</select>';
    jqTds[3].innerHTML = '<input value="' + data['envoi'] + '" type="text" class="form-control datepicker">';
    jqTds[4].innerHTML = '<input value="' + data['depot'] + '" type="text" class="form-control datepicker">';
    jqTds[5].innerHTML = '<input value="' + data['cloture'] + '" type="text" class="form-control datepicker">';
    jqTds[6].innerHTML = '<textarea rows="2" class="form-control">' + data['commentaire'] + '</textarea>';

    $("#providers").val(data['user']);
    $("#status").val(data['etat']);
    $("input.datepicker", wrapper).datepicker({dateFormat: "dd/mm/yy"});
    $("a.btn.btn-default.New, a.btn.btn-default.selectionRequired", wrapper).addClass("disabled");
    $("a.btn.btn-default.Cancel, a.btn.btn-default.Save", wrapper).show();
    $("input[type=text]:visible:first", nRow).focus();
}

function saveRow(nRow) {
    var jqInputs = $('input', nRow);
    var jqTextAreas = $('textarea', nRow);

    var url = urls.ajaxBordereauUpdate;
    if ($(nRow).hasClass('new')) {
        $(nRow).removeClass('new');
    } else {
        var rowId = $(nRow).attr('id');
        url += "/" + rowId;
    }

    var params = "pid=" + pageData.project + "&date=" + jqInputs[0].value + "&type=" + jqInputs[1].value +
            "&titre=" + jqInputs[2].value + "&lot=" + jqInputs[3].value + "&indice=" + jqInputs[4].value + "&description=" + encodeURIComponent(jqTextAreas[0].value);

    $.ajax({
        type: "POST",
        url: url,
        data: params,
        dataType: "json",
        success: function (data) {
            if (data.response === 200) {
                oTable.cell(nRow, 0).data(jqInputs[0].value);
                oTable.cell(nRow, 1).data(jqInputs[1].value);
                oTable.cell(nRow, 2).data(jqInputs[2].value);
                oTable.cell(nRow, 3).data(jqInputs[3].value);
                oTable.cell(nRow, 4).data(jqInputs[4].value);
                oTable.cell(nRow, 5).data(jqTextAreas[0].value);
                $(nRow).attr("id", data.id);
                oTable.row(nRow).draw();
                oTable.select.style("single");
                $("a.btn.btn-default.New, a.btn.btn-default.selectionRequired").removeClass("disabled");
                $("a.btn.btn-default.Cancel, a.btn.btn-default.Save").hide();
            } else {
                alert("Erreur lors de la mise à jour");
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert(textStatus);
            restoreRow(nRow, oTable);
        }
    });
}

function saveRowDevis(nRow) {
    var wrapper = $("#" + $(nRow).closest('table').attr('id') + "_wrapper");
    var bordereauId = $(nRow).closest('table').data("bordereauId");

    var jqInputs = $('input', nRow);
    var jqSelects = $('select', nRow);
    var jqTextAreas = $('textarea', nRow);

    var url = urls.ajaxDevisUpdate;
    if ($(nRow).hasClass('new')) {
        $(nRow).removeClass('new');
    } else {
        var rowId = $(nRow).attr('id');
        url += "/" + rowId;
    }

    var params = "bid=" + bordereauId + "&providerId=" + jqSelects[0].value + "&statusId=" + jqSelects[1].value + "&version=" + jqInputs[0].value +
            "&envoi=" + jqInputs[1].value + "&depot=" + jqInputs[2].value + "&cloture=" + jqInputs[3].value + "&commentaire=" + encodeURIComponent(jqTextAreas[0].value);

    $.ajax({
        type: "POST",
        url: url,
        data: params,
        dataType: "json",
        success: function (data) {
            if (data.response === 200) {
                /* rowData = detailTable.row(nRow).data();
                rowData["user"] = $(":selected", jqSelects[0]).text();
                rowData["etat"] = $(":selected", jqSelects[1]).text();
                rowData["version"] = jqInputs[0].value;
                rowData["envoi"] = jqInputs[1].value;
                rowData["depot"] = jqInputs[2].value;
                rowData["cloture"] = jqInputs[3].value;
                rowData["commentaire"] = jqTextAreas[0].value;
                rowData["id"] = data.id;
                detailTable.row(nRow).data(rowData);
                detailTable.row(nRow).draw(); */
                detailTable.ajax.reload();
                detailTable.select.style("multiple");
                $("a.btn.btn-default.New, a.btn.btn-default.selectionRequired", wrapper).removeClass("disabled");
                $("a.btn.btn-default.Cancel, a.btn.btn-default.Save", wrapper).hide();
            } else {
                alert("Erreur lors de la mise à jour");
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert(textStatus);
            restoreRow(nRow, detailTable);
        }
    });


}
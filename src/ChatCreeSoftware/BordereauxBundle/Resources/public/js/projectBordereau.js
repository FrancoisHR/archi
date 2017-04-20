/* global urls */

var oTable;
var addHierarchy;

$(document).ready(function () {

    oTable = $("#lignes").DataTable({
        ajax: urls.ajaxLines,
        autoWidth: false,
        buttons: {
            buttons: [
                {text: "<span class='glyphicon glyphicon-plus'></span>Ajouter après", className: "New", action: function () {
                        if ($("tr.new").length > 0) {
                            alert("Une nouvelle ligne est déjà en cours d'édition");
                        } else {
                            var nRow = oTable.row.add({numero: "", type: "", unite: "", quantite: "", description: ""}).draw(false).node();
                            $(nRow).addClass("new");
                            clearFields();
                            $("#ajouter h4.modal-title").text("Ajouter une ligne après...");
                            $("#ajouterValider").text("Ajouter");
                            $("input[name='inputMode']").attr("disabled",false);
                            $("#ajouter").modal("show");
                            nEditing = nRow;
                            addHierarchy = "next";
                        }
                    }
                },
                {text: '<span class="glyphicon glyphicon-plus"></span>Ajouter sous', className: 'Newbelow selectionRequired disabled', action: function () {
                        if ($('tr.new').length > 0) {
                            alert("Une nouvelle ligne est déjà en cours d'édition");
                        } else {
                            var nRow = oTable.row.add({numero: '', type: '', unite: '', quantite: '', description: ''}).draw(false).node();
                            $(nRow).addClass('new');
                            clearFields();
                            $("#ajouter h4.modal-title").text("Editer une ligne sous...");
                            $("#ajouterValider").text("Ajouter");
                            $('input[name="inputMode"]').attr('disabled',false);
                            $('#ajouter').modal('show');
                            nEditing = nRow;
                            addHierarchy = "below";
                        }
                    }
                },
                {text: '<span class="glyphicon glyphicon-random"></span>Alternative', className: 'Alternate selectionRequired disabled', action: function () {
                        if ($('tr.new').length > 0) {
                            alert("Une nouvelle ligne est déjà en cours d'édition");
                        } else {
                            var nRow = oTable.row.add({numero: '', type: '', unite: '', quantite: '', description: ''}).draw(false).node();
                            $(nRow).addClass('new');
                            clearFields();
                            $("#ajouter h4.modal-title").text("Alternative...");
                            $("#ajouterValider").text("Ajouter");
                            $('input[name="inputMode"]').attr('disabled',false);
                            $('#ajouter').modal('show');
                            nEditing = nRow;
                            addHierarchy = "alternate";
                        }
                    }
                },
                {text: '<span class="glyphicon glyphicon-pencil"></span>Editer', className: 'Edit selectionRequired disabled', action: function ( ) {
                        var row = this.row({selected: true}).node();

                        if ($('tr.new').length > 0) {
                            alert("Une nouvelle ligne est déjà en cours d'édition");
                        } else {
                            var row = this.row({selected: true});
                            var selected = row.data();
                            var ligneId = selected['id'];

                            $("#ajouter h4.modal-title").text("Editer une ligne");
                            $("#ajouterValider").text("Editer");
                            $('input[name="inputMode"]').attr('disabled',true);
                            rowEdit(ligneId);
                            $('#ajouter').modal('show');
                            nEditing = row;
                        }
                    }
                },
                {text: '<span class="glyphicon glyphicon-remove"></span>Supprimer', className: 'Delete selectionRequired disabled', action: function ( ) {
                        var row = this.row({selected: true});
                        var selected = row.data();
                        var lineId = selected['id'];

                        if ($(row.node()).hasClass('new')) {
                            oTable.rows(row).remove().draw(false);
                            $("a.btn.btn-default.Edit, a.btn.btn-default.Delete").addClass("disabled");
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

                                            var url = urls.ajaxLineDelete + lineId;

                                            $.ajax({
                                                type: "POST",
                                                url: url,
                                                dataType: "json",
                                                success: function (data) {
                                                    if (data.response === 200) {
                                                        oTable.ajax.reload();
                                                        $("a.btn.btn-default.Edit, a.btn.btn-default.Delete").addClass("disabled");
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
                    }
                },
                {text: '<span class="glyphicon glyphicon-file"></span>Fichiers', className: 'Join', action: function ( ) {
                        $('#fichiers').modal('show');
                    }
                }
            ],
            dom: {
                container: {
                    className: "dt-buttons btn-group sticky"
                }
            }
        },
        columns: [
            {data: 'numero', width: "70px", type: "num-list"},
            {data: 'type', width: "70px"},
            {data: 'description', width: "700px"},
            {data: 'unite', width: "60px"},
            {data: 'quantite', width: "60px"}
        ],
        columnDefs: [
            {
                render: function (data, type, row ) {
                    var numero="";
                    if( row.quantite==="" && row.unite===""){
                        numero = "<strong>" + row.numero + "</strong>";
                    } else {
                        numero = row.numero;
                    }
                    return numero;
                },
                targets: 0
            },
            {
                render: function (data, type, row ) {
                    var type="";
                    if( row.quantite==="" && row.unite===""){
                        type = "<strong>" + row.type + "</strong>";
                    } else {
                        type = row.type;
                    }
                    return type;
                },
                targets: 1
            },
            {
                render: function (data, type, row) {
                    var itemId = "description"+row.id;
                    
                    var titre="";
                    if( row.quantite==="" && row.unite===""){
                        titre = "<strong>" + row.titre + "</strong>";
                    } else {
                        titre = row.titre;
                    }
                    
                    var content = '<div><div class="panel-heading"><a href="#' + itemId + '" data-toggle="collapse"><span id="icone' + row.id + '" class="glyphicon glyphicon-triangle-bottom"></span>' + titre + ' </a></div>';
                    content += '<div id="' + itemId + '" class="panel-collapse collapse"><div class="panel-body"><div class="row">' + data + '</div>';
                    if( row.photo ){
                        content += '<div class="row" style="padding-top: 10px;"><img class="img-responsive center-block img-thumbnail" src="' + pageData.baseUrl + pageData.projectPath + "/" + pageData.bordereaux_dir + "/"+ pageData.bordereau + "/" + encodeURI( row.photo ) + '"></div>';
                    }
                    content += '</div></div>';
                    
                    var paramId=0;
                    var paramKey="parametre"+paramId;
                    if( paramKey in row ) {
                        content += '<div class="panel-footer listeparametre">';
                        while( paramKey in row ){
                            content += '<div><span class="glyphicon glyphicon glyphicon-list"></span>' + row[paramKey] + '</div>';
                            paramId++;
                            paramKey="parametre"+paramId;
                        }   
                        content += '</div>';
                    }
                    content += '</div>';
                    
                    var questionId=0;
                    var questionKey="question"+questionId;
                    if( questionKey in row ) {
                        content += '<div class="panel-footer listequestion">';
                        while( questionKey in row ){
                            content += '<div><span class="glyphicon glyphicon-question-sign"></span>' + row[questionKey] + '</div>';
                            questionId++;
                            questionKey="question"+questionId;
                        }   
                        content += '</div>';
                    }
                    content += '</div>';
                    
                    return content;
                },
                targets: 2
            }
        ],
        dom: 'Bfrt',
        language: {
            "lengthMenu": "Afficher _MENU_ lignes par page",
            "zeroRecords": "Aucune ligne",
            "info": "Page _PAGE_ de _PAGES_",
            "infoEmpty": "Aucune ligne",
            "infoFiltered": "(filtr&eacute; de _MAX_ lignes)",
            "loadingRecords": "Chargement...",
            "search": "Recherche:",
            "paginate": {
                first: " ",
                last: " ",
                next: " ",
                previous: " "
            }
        },
        order: [[0, 'asc']],
        ordering: true,
        paging: false,
        rowCallback: function( row, data, index ) {
            $('#description'+data.id,row).on('show.bs.collapse', function () {
                $('#icone'+data.id,row ).removeClass('glyphicon-triangle-bottom').addClass('glyphicon-triangle-top');
            });
            $('#description'+data.id,row).on('hide.bs.collapse', function () {
                $('#icone'+data.id,row ).removeClass('glyphicon-triangle-top').addClass('glyphicon-triangle-bottom');
            });
        },
        rowId: 'id',
        select: {
            style: 'single'
        }
    });

    // Calculate trigger including allowance for 5px top padding
    var stickyOffset = $('.sticky').offset().top - 5;

    $(window).scroll(function () {
        var sticky = $('.sticky'),
                scroll = $(window).scrollTop();

        if (scroll >= stickyOffset) {
            sticky.addClass('fixed');
        } else {
            sticky.removeClass('fixed');
        }
    });

    nEditing = null;

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

    $('#lignes tbody').on('click', 'tr', function () {
        if (nEditing === null) {
            if ($(this).hasClass('selected')) {
                $("a.btn.btn-default.selectionRequired").removeClass("disabled");
            } else {
                $("a.btn.btn-default.selectionRequired").addClass("disabled");
                ;
            }
        }
    });

    $('input[name="inputMode"]').on('click', function( event){
            var collapseTarget = event.target.dataset.target;
            if( collapseTarget === "#collapseOne"){
                $("#collapseOne").collapse("show");
                $("#collapseTwo").collapse("hide");
            } else {
                $("#collapseTwo").collapse("show");
                $("#collapseOne").collapse("hide");
            }
    });

    $('.modal-footer .btn[data-dismiss="modal"]').on('click', function () {
        var target = this;
        $(target).closest('.modal')
                .bindOneFirst('hide.bs.modal hidden.bs.modal', function (event) {
                    event.relatedTarget = target;
                });
    });

    $("#file").fileinput(   {
            allowedFileTypes: ['image'],
            allowedFileExtensions: ['jpg','png','gif'],
            language: "fr",
            maxFileCount: 1,
            uploadAsync: true,
            uploadUrl: urls.ajaxFileUpload,
            uploadExtraData: {
                projectId:  pageData.projectId,
                bordereauId: pageData.bordereau,
                uploadEntity: "Bordereau"
            }
    });
   
    $('#file').on('fileuploaded', function(event, data, previewId, index) {
        var form = data.form, files = data.files, extra = data.extra,
            response = data.response, reader = data.reader;
        $("#sent-file").val( data.filenames[0]);
    });
    
    $("#file").on('filedeleted', function(event, key) {
        $("#sent-file").val( "" );
    });

    $('#ajouter').on('show.bs.modal', function (event) {
        var editData;

        $("#file").fileinput("refresh", { initialPreview: [ "" ], initialCaption: " " } );
        if ($('#editData').val()) {
            editData = JSON.parse($('#editData').val()).data;
            $("input[name=inputMode]").val([editData.mode]);
            $("#optionel").prop( 'checked', editData.optionel );
            if( editData.mode === 1 ){
                $("#collapseOne").collapse("show");
                $("#collapseTwo").collapse("hide");
                $("#quantite").val( editData.quantite );
            }
            if( editData.mode === 2 ){
                $("#collapseTwo").collapse("show");
                $("#collapseOne").collapse("hide");
                
                $("#titre").val( editData.titre );
                $("#descriptionManuelle").val( editData.description );
                $("#quantiteManuelle").val( editData.quantite );
                if( editData.unite ){
                    $("#unitButton").val( editData.unite );
                    $("#unitButton").html( editData.unite + ' <span class="caret"></span>');
                } else {
                    $("#unitButton").html('Unité <span class="caret"></span>');
                    $("#unitButton").val( "" );
                }
            }
            if( editData.photo ){
                var filename = editData.photo.split("/").slice(-1)[0];
                $("#file").fileinput("refresh", {
                    initialPreview: [ "<img src='" + pageData.baseUrl + pageData.projectPath + "/" + pageData.bordereaux_dir + "/"+ pageData.bordereau + "/" + encodeURI( editData.photo ) + "' class='file-preview-image' height='160'>"],
                    initialPreviewConfig: [
                        {
                            url: urls.ajaxFileDelete,
                            key: filename,
                            extra: {
                                projectId:  pageData.projectId,
                                bordereauId: pageData.bordereau,
                                uploadEntity: "Bordereau"
                            }
                        }
                    ],
                    initialCaption: filename
                });
                $(".kv-file-upload").hide();
                $("#rapportPhoto").val( editData.rapportPhoto );
                $("#sent-file").val( filename );
            }
        }
        
        $.ajax({
            type: "POST",
            url: urls.ajaxLibraries,
            dataType: "json",
            success: function (data) {
                $("#library option").remove();
                $("#corps option").remove();
                $("#section option").remove();
                $("#prestation option").remove();
                $("#description").val("");
                $.each(data.data, function (i, item) {
                    $("#library").append($('<option>', {
                        value: item.id,
                        text: item.titre}));
                });
                if ( editData ) {
                    $('#library').val([editData.librairie]).change();
                } else {
                    $('#library option:first').attr('selected', 'selected').change();
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert(textStatus);
            }
        });
    });

    $('#ajouter').on('hide.bs.modal', function (event) {
        if (nEditing) {
            var relatedTarget = $(event.relatedTarget).text();
            if ( relatedTarget === "Ajouter" || relatedTarget === "Editer" ) {
                saveRow(nEditing);
            } else {
                if ($(nEditing).hasClass('new')) {
                    oTable.rows(nEditing).remove().draw(false);
                }
            }
            nEditing = null;
        }
    });

    $('#fichiers').on('show.bs.modal', function (event) {
        $("#fichiers input[type=checkbox]").prop("checked",false);
        $.ajax({
            type: "POST",
            url: urls.ajaxBordereauFichiers,
            dataType: "json",
            success: function (data) {
                $.each(data.data, function (i, item) {
                    $("#fichiers #"+item).prop("checked", true);
                });
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert(textStatus);
            }
        });    
    });
    
    $('#fichiers').on('hide.bs.modal', function (event) {
        var relatedTarget = $(event.relatedTarget).text();
        if( relatedTarget === "Enregistrer"){ 
            var idSelector = function() { return this.id; };
            var selected = $("#fichiers :checkbox:checked").map(idSelector).get();
            var params = "fichiers="+selected.join("-");

            $.ajax({
                type: "POST",
                url: urls.ajaxBordereauUpdateFichiers,
                data: params,
                dataType: "json",
                success: function (data) {

                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(textStatus);
                }
            });            
        }
    });
    

    $('#library').on('change', function (event) {
        var libraryId = $("#library option:selected").val();

        $('#corps').hide();
        $('#pgCorps').removeClass('hidden');
        $.ajax({
            type: "POST",
            url: urls.ajaxCorpsMetiers + libraryId,
            dataType: "json",
            success: function (data) {
                $("#corps option").remove();
                $("#section option").remove();
                $("#prestation option").remove();
                $("#description").val("");
                $(".parametre").not(".template").remove();
                $.each(data.data, function (i, item) {
                    $("#corps").append($('<option>', {
                        value: item.id,
                        text: item.titre}));
                });
                if ($('#editData').val()) {
                    var editData = JSON.parse($('#editData').val()).data;
                    $('#corps').val([editData.corpsId]).change();
                } else {
                    $('#corps option:first').attr('selected', 'selected').change();
                }
                $('#pgCorps').addClass('hidden');
                $('#corps').show();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert(textStatus);
            }
        });

    });

    $('#corps').on('change', function (event) {
        var corpsId = $("#corps option:selected").val();

        $('#section').hide();
        $('#pgSection').removeClass('hidden');
        $.ajax({
            type: "POST",
            url: urls.ajaxSections + corpsId,
            dataType: "json",
            success: function (data) {
                $("#section option").remove();
                $("#prestation option").remove();
                $("#description").val("");
                $(".parametre").not(".template").remove();
                $.each(data.data, function (i, item) {
                    $("#section").append($('<option>', {
                        value: item.id,
                        text: item.titre}));
                });
                if ($('#editData').val()) {
                    var editData = JSON.parse($('#editData').val()).data;
                    $('#section').val([editData.sectionId]).change();
                } else {
                    $('#section option:first').attr('selected', 'selected').change();
                }
                $('#pgSection').addClass('hidden');
                $('#section').show();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert(textStatus);
            }
        });
    });

    $('#section').on('change', function (event) {
        var sectionId = $("#section option:selected").val();

        $('#prestation').hide();
        $('#pgPrestation').removeClass('hidden');
        $.ajax({
            type: "POST",
            url: urls.ajaxPrestations + sectionId,
            dataType: "json",
            success: function (data) {
                $("#prestation option").remove();
                $("#description").val("");
                $(".parametre").not(".template").remove();
                $.each(data.data, function (i, item) {
                    $("#prestation").append($('<option>', {
                        value: item.id,
                        text: item.titre}));
                });
                if ($('#editData').val()) {
                    var editData = JSON.parse($('#editData').val()).data;
                    $('#prestation').val([editData.prestationId]).change();
                } else {
                    $('#prestation option:first').attr('selected', 'selected').change();
                }
                
                $('#unit').text(data.data.unite);
                $('#pgPrestation').addClass('hidden');
                $('#prestation').show();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert(textStatus);
            }
        });
    });

    $('#prestation').on('change', function (event) {
        var prestationId = $("#prestation option:selected").val();
        var editData;
        
        if (prestationId > 0) {
            if( $('#editData').val() ) {
                editData = JSON.parse($('#editData').val()).data;
            }
            $.ajax({
                type: "POST",
                url: urls.ajaxPrestation + prestationId,
                dataType: "json",
                success: function (data) {
                    var prestation = data.data;
                    $("#description").val(prestation.description);
                    $('#unit').text(prestation.unite);
                    $(".parametre").not(".template").remove();

                    if (prestation.parametres) {
                        $.each(prestation.parametres, function (n, param) {
                            var paramBloc = $('#parametres').clone();
                            var blocId = 'parametres_' + n;
                            var paramId = 'parametre_' + n;
                            $(paramBloc).prop('id', 'parametres_' + n).removeClass("template");
                            $('select', paramBloc).prop('id', paramId);
                            if( editData && paramId in editData ){ 
                                $.each(param, function (i, item) {
                                    $("#" + paramId, paramBloc).append($('<option>', {
                                        value: item.id,
                                        text: item.titre,
                                        selected: (editData[paramId]===item.id) }));
                                });
                            } else {
                                $.each(param, function (i, item) {
                                    $("#" + paramId, paramBloc).append($('<option>', {
                                        value: item.id,
                                        text: item.titre }));
                                });                            }
                            if ( ! editData) {
                                $("#" + paramId + ' option:first').attr('selected', 'selected').change();
                            }            

                            $('.parametre:last').after(paramBloc);
                            $("#" + blocId).removeClass("hidden");
                        });
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(textStatus);
                }
            });
        }
    });

    $(".dropdown-menu li a").click(function () {
        $(this).parents(".dropdown").find('.btn').html($(this).text() + ' <span class="caret"></span>');
        $(this).parents(".dropdown").find('.btn').val($(this).data('value'));
    });

    $('#accordion .collapse').on('hide.bs.collapse', function (e) {
        var collapse = $(e.target).data('bs.collapse');
        return typeof collapse !== 'undefined' && !collapse.$trigger.is(':checked');
    });

});

function clearFields() {
    $("#editData").val("");
    $('#ajouter input[type="text"]').val("");
    $('#ajouter input[type="number"]').val("");
    $("#ajouter textarea").val("");
    $("#unitButton").html('Unité <span class="caret"></span>');
    $("#unitButton").val("");
    $("#optionel").prop('checked', false);
    $("#sent-file").val("")
}

function rowEdit(ligneId) {
    if (ligneId > 0) {
        var line;
        $.ajax({
            async: false,
            type: "POST",
            url: urls.ajaxLine + ligneId,
            dataType: "text",
            success: function (data) {
                $("#editData").val(data);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert(textStatus);
            }
        });
    }
}

function saveRow(nRow) {
    var rowInputMode = $("input[name=inputMode]:checked").val();
    var siblingRowId = $("#lignes tr.selected").attr('id');
    var option = $("#optionel").prop('checked');
    var optionel = 0;
    if( option ) optionel = 1 ;
        

    var params;
    if( $('#editData').val() ) {
        var editData = JSON.parse($('#editData').val()).data;
        params="update=U&ligneId="+editData.id;
    } else {
        params= "update=C";
    }

    if( $("#sent-file").val() ) {
        params += "&file=" + encodeURIComponent( $("#sent-file").val() );
        params += "&rapport=" + $("#rapportPhoto").val();
    }

    params += "&mode=" + rowInputMode + "&addHierarchy=" + this.addHierarchy + "&sibling=" + siblingRowId + "&option=" + optionel;
    switch (rowInputMode) {
        case "1":
            var prestationId = $("#prestation option:selected").val();
            params += "&prestation=" + prestationId;
            var quantite = $("#quantite").val();
            params += "&quantite=" + quantite;
            var paramSections = $(".parametre").not(".template");
            $.each($("option:selected", paramSections), function (i, val) {
                params += "&param" + i + "=" + $(val).val();
            });
            break;
        case "2":
            var titre = $("#titre").val();
            params += "&titre=" + titre;
            var description = encodeURIComponent($("#descriptionManuelle").val());
            params += "&description=" + description;
            var quantite = $("#quantiteManuelle").val();
            params += "&quantite=" + quantite;
            var unite = $("#unitButton").val();
            params += "&unite=" + unite;
            break;
    }

    var url = urls.ajaxUpdate + "/" + pageData.bordereau;
    $.ajax({
        type: "POST",
        url: url,
        data: params,
        dataType: "json",
        success: function (data) {
            if (data.response === 200) {
                oTable.ajax.reload();
                $("a.btn.btn-default.New").removeClass("disabled");
                $("a.btn.btn-default.Cancel, a.btn.btn-default.Save").hide();
            } else {
                alert("Erreur lors de la mise à jour");
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert(textStatus);
        }
    });
}
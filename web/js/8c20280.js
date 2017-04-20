/* global urls */

var oTable;
var addHierarchy;

$(document).ready(function () {

    $("#dialog-save").dialog({
        autoOpen: false
    });
    
    $("#dialog-send").dialog({
        autoOpen: false
    });
    
    oTable = $("#lignes").DataTable({
        ajax: urls.ajaxLines,
        autoWidth: false,
        buttons: {
            buttons: [
                {text: '<span class="glyphicon glyphicon-floppy-disk"></span>Enregistrer', className: 'Save', action: function ( ) {
                        $("#dialog-save").dialog({
                            autoOpen: true,
                            modal: true,
                            buttons: {
                                "Confirmer" : {
                                    text: "Confirmer", 
                                    class: "btn-primary",
                                    click: function() {
                                        $(this).dialog("close");
                                        saveDevis( "QUOTE_SAVE" );
                                    }
                                },
                                "Annuler": function() {
                                    $(this).dialog("close");
                                }
                            },
                            title: "Enregistrement du devis"
                        }); 
                    }
                },
                {text: '<span class="glyphicon glyphicon-send"></span>Soumettre', className: 'Submit', action: function ( ) {
                        $("#dialog-send").dialog({
                            autoOpen: true,
                            modal: true,
                            buttons: {
                                "Confirmer" : {
                                    text: "Confirmer", 
                                    class: "btn-primary",
                                    click: function() {
                                        $(this).dialog("close");
                                        saveDevis( "QUOTE_SUBMIT" );
                                        if( ! pageData.employeeRole ){
                                            oTable.button(1).remove();
                                            oTable.button(0).remove();        
                                        }
                                    }
                                },
                                "Annuler": function() {
                                    $(this).dialog("close");
                                }
                            },
                            title: "Soumission du devis"
                        }); 
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
            {data: 'quantite', width: "60px"},
            {data: 'prixUnitaire', width: "100px",defaultContent:""},
            {data: null, width: "100px",defaultContent:"" },
            {data: 'commentaire', width: "200px",defaultContent:""}
            
        ],
        columnDefs: [
            {
                render: function (data, type, row) {
                    var itemId = "description"+row.id;
                    var content = '<div><div class="panel-heading"><a href="#' + itemId + '" data-toggle="collapse"><span id="icone' + row.id + '" class="glyphicon glyphicon-triangle-bottom"></span>' + row.titre + ' </a></div>';
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
            },
            {
                render: function (data,type,row){
                    error="";
                    feedback="";
                    helpblock="";
                    if( row.ligneDevisId ){
                        if( data && ! $.isNumeric( data ) ){
                            error=" has-error";
                            feedback="<span class='glyphicon glyphicon-warning-sign form-control-feedback'></span>";
                            helpblock="<span class='help-block'>Veuillez saisir un montant</span>";
                        }
                        if( data === null ){
                            data="";
                        }
                        if( ! pageData.employeeRole && pageData.etatDevis === "QUOTE_SUBMIT"){
                            if( data && $.isNumeric( data ) ){
                                return sprintf("%.2f", data);
                            } else {
                                return "";
                            }
                        }
                        return "<div class='form-group has-feedback" + error + "'>"+ feedback + "<input id='prixUnitaire_" + row.ligneDevisId + "' class='form-control text-right prixUnitaire' type='text' value='" + data + "'>" + helpblock + "</div>";
                    }
                },
                targets: 5
            },
            {
                className: "text-right",
                render: function (data,type,row){
                    if( row.ligneDevisId ){
                        if( $.isNumeric( row.prixUnitaire ) ){
                            if( row.option )
                                return sprintf("(%.2f)", row.quantite * row.prixUnitaire );
                            else {
                                row.total = row.quantite * row.prixUnitaire;
                                return sprintf("%.2f",row.total);
                            }
                        } else {
                            if( row.prixUnitaire ){
                                return "####";
                            } else {
                                return "";
                            }
                        }
                    }
                },
                targets: 6
            },            
            {
                render: function (data,type,row){
                    if( row.ligneDevisId ){
                        if( data === null ){
                            data="";
                        }
                        if( ! pageData.employeeRole && pageData.etatDevis === "QUOTE_SUBMIT"){
                            return data;
                        } else {
                            return "<textarea id='commentaire_" + row.ligneDevisId +"' class='form-control' >" + data + "</textarea>";
                        }
                    }
                },
                targets: 7
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
    });
    
    if( ! pageData.employeeRole && pageData.etatDevis === "QUOTE_SUBMIT"){
        oTable.button(1).remove();
        oTable.button(0).remove();        
    }
    
    
    $('#lignes').on('draw.dt', function (){
        oTable.columns( '.total' ).every( function () {            
            var sum = this
                .data()
                .reduce( function (a,b) {
                    return price(a) + price(b);
                } );
 
            $( this.footer() ).html( sprintf("%.2f",sum) );
        } );
        
        $(".prixUnitaire").on("change", function(){
            val = $(this).val().replace(",",".");
            row = oTable.row( $( this ).parent().parent() );
            data = row.data();
            if( $.isNumeric( val ) ){
                data.prixUnitaire = parseFloat( val );
                data.total = data.quantite * data.prixUnitaire;
            } else {
                data.prixUnitaire = val;
            }
            row.data( data );
            oTable.draw();
        });
    });
});

function price( value ){
    var price = 0;
    if( typeof value === 'number'){
        price=value;
    } else {
        if( !value.option && value.total ){
            price=value.total;
        }        
    }
    return price;
}

function saveDevis( action ){   
    params = "action="+action;
    $('#lignes input').each( function( ){
        if( $(this).val()) {
            params +=  "&" + $(this).attr("id") + "=" + $(this).val();
        }
    });
    $('#lignes textarea').each( function( ){
        if( $(this).val()) {
            params +=  "&" + $(this).attr("id") + "=" + $(this).val();
        }
    });

    $.ajax( {
        type: "POST",
        url: urls.ajaxSave,
        data: params,
        dataType: "json",
        success: function( data ) {
            if( action === "QUOTE_SUBMIT") {
                window.close();
            } else {
                $("span.badge").text( data.data.statut );
            }
        },
        error: function( jqXHR, textStatus, errorThrown ) {
            alert( textStatus );
        }
    });
}
$.fn.bindOneFirst = function (name, fn) {
    // bind as you normally would
    // don't want to miss out on any jQuery magic
    this.one(name, fn);

    // Thanks to a comment by @Martin, adding support for
    // namespaced events too.
    this.each(function () {
        var handlers = $._data(this, 'events')[name.split('.')[0]];
        // take out the handler we just inserted from the end
        var handler = handlers.pop();
        // move it at the beginning
        handlers.splice(0, 0, handler);
    });
};

function restoreRow( nRow, table ) {
    var data = table.row(nRow).data();
    var columns = table.settings().init().columns;
    var jqTds = $('>td', nRow);

    for( var i=0, iLen=jqTds.length; i<iLen; i++ ) {
        table.cell( nRow, i ).data( data[columns[i].data] );
    }
    table.row( nRow ).draw();
    table.select.style( "single" );
    $("a.btn.btn-default.New, a.btn.btn-default.selectionRequired").removeClass("disabled");
    $("a.btn.btn-default.Cancel, a.btn.btn-default.Save").hide();
}

function today() {
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth()+1; //January is 0!
    var yyyy = today.getFullYear();

    if(dd<10) { dd='0'+dd; } 
    if(mm<10) { mm='0'+mm; } 
    return dd+'/'+mm+'/'+yyyy;
}
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
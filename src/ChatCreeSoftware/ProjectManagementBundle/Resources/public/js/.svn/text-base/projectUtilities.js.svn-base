/* global oTable */

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


var projectUtilities = {
    cancelEdit: function() {
        if( nEditing ) {
            if( $(nEditing).hasClass( 'new' ) ) {
                oTable.rows( nEditing ).remove().draw(false);
                oTable.select.style('single');
                $("a.btn.btn-default.New").removeClass("disabled");
                $("a.btn.btn-default.Cancel, a.btn.btn-default.Save").hide();
            } else {
                this.restoreRow( nEditing );
            }
            nEditing = null;
        }
    },
    restoreRow: function ( nRow ) {
        var data = oTable.row(nRow).data();
        var columns = oTable.settings().init().columns;
        var jqTds = $(">td", nRow);

        if( columns && columns[0].data ){
            for( var i=0, iLen=jqTds.length; i<iLen; i++ ) {
                oTable.cell( nRow, i ).data( data[columns[i].data] );
            }
        } else {
            for( var i=0, iLen=jqTds.length; i<iLen; i++ ) {
                oTable.cell( nRow, i ).data( data[i] );
            }
        }
        
        oTable.row( nRow ).draw();
        oTable.select.style("single");
        $("a.btn.btn-default.New,a.btn.btn-default.selectionRequired").removeClass("disabled");
        $("a.btn.btn-default.Cancel, a.btn.btn-default.Save").hide();
    },
    keydown: function( event ) {
        switch( event.which ) {
            case 13:    // Return = Save
                var focused = $( document.activeElement );
                if( focused[0]['type'] !== 'textarea' ) {
                    saveRow( nEditing );
                    nEditing = null;
                }
                break;
            case 27:    // Escape = Cancel
                if( nEditing ) {
                    if( $(nEditing).hasClass( 'new' ) ) {
                        oTable.rows( nEditing ).remove().draw(false);
                        oTable.select.style('single');
                        $("a.btn.btn-default.New").removeClass("disabled");
                        $("a.btn.btn-default.Cancel, a.btn.btn-default.Save").hide();
                    } else {
                        this.restoreRow( nEditing );
                    }
                    nEditing = null;
                }
                break;
        }
    }
};
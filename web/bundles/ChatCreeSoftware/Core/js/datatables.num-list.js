jQuery.extend( jQuery.fn.dataTableExt.oSort, {
    "num-list-pre": function ( a ) {
       var number = 0;
       var pow=100000000;
       if (typeof a === 'string' || a instanceof String){
           var nums = a.split(".");
           for( n=0; n<nums.length; n++ ){
               number += nums[n]*pow;
               pow /= 100;
           }
        } else {
            number = a * pow;
        }
        return number;
    },
 
    "num-list-asc": function ( a, b ) {
        return a - b;
    },
 
    "num-list-desc": function ( a, b ) {
        return b - a;
    }
} );
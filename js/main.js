(function($) {
    'use strict';
    $( document ).ready( function() {
        $( '#circle' ).click( function( e ) {
            e.preventDefault();
            $( '.list' ).slideToggle(300);
        });
    });
})(jQuery);
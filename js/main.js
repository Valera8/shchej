(function($) {
    'use strict';
    $( document ).ready( function() {
        $( '#circle' ).click( function( e ) {
            e.preventDefault();
            $( 'nav' ).slideToggle(300);
        });
    });
})(jQuery);
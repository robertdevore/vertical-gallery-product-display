jQuery( document ).ready( function ( $ ) {
    // Get the gallery position from the localized settings
    const position = vgpdSettings.position;

    // Apply the appropriate class based on the position setting
    if ( position === 'left' ) {
        $( 'div.product div.images' ).addClass( 'vgpd-left' );
    }
} );

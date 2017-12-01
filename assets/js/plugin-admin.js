( function( $ ) {
	'use strict';

	/**
	 * Binder Type
	 *
	 * Options to extend the type of Binder Entry.
	 */
	$( 'input[name=mkdo_binder_entry_type]' ).change( function() {
		var option = $(this).val();
		if ( '' !== option && null !== option && undefined !== option ) {
			if ( 'external' === option ) {
				$( '#mkdo_binder_draft' ).removeAttr( 'disabled' );
				$( '.meta-box__item:not(.meta-box__item--version-select) #mkdo_binder_version' ).removeAttr( 'disabled' );
				$( '.meta-box__item--file' ).hide();
				$( '.meta-box__region--external-document' ).show();
				$( '.meta-box__item--external-document-type select' ).removeAttr('disabled');
				$( '.meta-box__item--external-document-type select' ).removeAttr('readonly');
				$( '.meta-box__item--external-document-size input' ).removeAttr('disabled');
				$( '.meta-box__item--external-document-size input' ).removeAttr('readonly');
				$( '.meta-box__item--external-document-url input' ).removeAttr('disabled');
				$( '.meta-box__item--external-document-url input' ).removeAttr('readonly');
			} else {
				$( '#mkdo_binder_draft' ).attr( 'disabled', 'disabled' );
				$( '.meta-box__item:not(.meta-box__item--version-select) #mkdo_binder_version' ).attr( 'disabled', 'disabled' );
				$( '.meta-box__region--external-document' ).hide();
				$( '.meta-box__item--external-document-type select' ).attr('disabled');
				$( '.meta-box__item--external-document-type select' ).attr('readonly');
				$( '.meta-box__item--external-document-size input' ).attr('disabled');
				$( '.meta-box__item--external-document-size input' ).attr('readonly');
				$( '.meta-box__item--external-document-url input' ).attr('disabled');
				$( '.meta-box__item--external-document-url input' ).attr('readonly');
			}
		}
	} );

} )( jQuery );

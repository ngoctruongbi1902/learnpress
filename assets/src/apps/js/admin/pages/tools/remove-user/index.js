import handleAjax from '../../../../utils/handle-ajax-api';
const $ = jQuery;

const removeUsers = () => {
	const elemRemoveUsers = document.querySelector( '.lp-remove-users-courses' );
	if ( ! elemRemoveUsers ) {
		return;
	}

	//select-2
	$( 'select#list-users' ).select2( { width: '320px', placeholder: 'Search users', multiple: true } );
	$( 'select#list-courses' ).select2( { width: '320px', placeholder: 'Search courses', multiple: true } );

	$( '.lp-select-2 select' ).on( 'change.select2', function( e ) {
		$( '.select2-selection__choice' ).each( function( i, obj ) {
			const attr = $( this ).attr( 'title' );
			if ( typeof attr === 'undefined' || attr === false ) {
				$( this ).hide();
			}
		} );
	} );

	const btnAssign = elemRemoveUsers.querySelector( '.lp-remove-users-courses__button-remove' );
	if ( ! btnAssign ) {
		return;
	}
	btnAssign.addEventListener( 'click', ( event ) => {
		event.preventDefault();
		btnAssign.classList.add( 'loading' );
		const url = '/lp/v1/admin/tools/remove-order-users-courses';
		const listUsers = $( 'select#list-users' ).val();
		const listCourses = $( 'select#list-courses' ).val();
		const params = {
			listUsers,
			listCourses,
		};

		const functions = {
			success: ( res ) => {
				const { status, message } = res;

				const eleNoitce = elemRemoveUsers.querySelector( '.lp-remove-users-courses__result' );
				if ( eleNoitce != null ) {
					eleNoitce.innerHTML = message;
					if ( status == 'success' ) {
						eleNoitce.classList.remove( 'fail' );
						eleNoitce.classList.add( 'success' );
					} else {
						eleNoitce.classList.add( 'fail' );
						eleNoitce.classList.remove( 'success' );
					}
				}
			},
			error: ( err ) => {
				console.log( err );
			},
			completed: () => {
				btnAssign.classList.remove( 'loading' );
			},
		};

		handleAjax( url, params, functions );
	} );
};

export default removeUsers;

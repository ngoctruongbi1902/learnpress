import handleAjax from "../../../../utils/handle-ajax-api";
const $ = jQuery;

const AssignCourse = () => {
	let typeAssign = '';
	const elemAssignCourse = document.querySelector( '.lp-assign-courses' );
	if ( ! elemAssignCourse ) {
		return;
	}

	const inputType = elemAssignCourse.querySelectorAll( 'input[name="type-assign"]' );
	if ( ! inputType.length ) {
		return;
	}

	$('select#course-assign').select2({ width: "320px", allowClear: true, placeholder: "Search only a course" });
	//select-2
	inputType.forEach( ( item ) => {
		item.addEventListener( 'change', ( event ) => {
			const type = event.target.value;
			if ( 'type-users' === type ) {
				typeAssign = 'users';
				$('select#type-users').select2({ width: "320px", allowClear: true, placeholder: "Search users", multiple: true }).next().show();
				$('select#type-roles').select2({ width: "320px", allowClear: true, placeholder: "Search roles", multiple: true }).next().hide();
			} else {
				typeAssign = 'roles';
				$('select#type-users').select2({ width: "320px", allowClear: true, placeholder: "Search users", multiple: true }).next().hide();
				$('select#type-roles').select2({ width: "320px", allowClear: true, placeholder: "Search roles", multiple: true }).next().show();
			}
		} );
	});

	const btnAssign = elemAssignCourse.querySelector( '.lp-assign-courses__button-assign' );
	if ( ! btnAssign ) {
		return;
	}
	btnAssign.addEventListener( 'click', ( event ) => {
		event.preventDefault();
		btnAssign.classList.add('loading');
		const url = '/lp/v1/admin/tools/assign-course';
		const courseID = $('select#course-assign').val();
		const listUsers = $('select#type-users').val();
		const listRoles = $('select#type-roles').val();
		const params = {
			courseID: courseID,
			listUsers: listUsers,
			listRoles: listRoles,
			type: typeAssign,
		};
		const functions = {
			success: (res) => {
				const {status,message} = res;
				const eleNoitce = elemAssignCourse.querySelector('.lp-assign-courses__result');
				if ( eleNoitce != null ) {
					eleNoitce.innerHTML = message;
					if ( status == 'success' ) {
						eleNoitce.classList.remove('fail');
						eleNoitce.classList.add('success');
					} else {
						eleNoitce.classList.add('fail');
						eleNoitce.classList.remove('success');
					}
				}

			},
			error: ( err ) => {
				console.log( err );
			},
			completed: () => {
				btnAssign.classList.remove('loading');
			},
		};

		handleAjax( url, params, functions );
	});
}

export default AssignCourse;

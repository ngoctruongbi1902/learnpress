import API from './api';

const jsHandlePageCourses = () => {
	if ( undefined === lpGlobalSettings ) {
		console.log( 'lpGlobalSettings is undefined' );
		return;
	}

	const urlQueryString = window.location.search;
	const urlSearchParams = new URLSearchParams( urlQueryString );
	let filterCourses = {};
	let skeleton;
	let skeletonClone;
	let isLoading = false;
	let firstLoad = 1;
	let elNoLoadAjaxFirst;
	let elArchive;
	let elListCourse;
	let dataHtml;
	let paginationHtml;
	let loadMoreBtnHtml;
	let isFetching = false;
	let lastPage = false;

	const paginationType = lpGlobalSettings.pagination_type || '';

	const urlParams = {};
	for ( const [ key, val ] of urlSearchParams.entries() ) {
		urlParams[ key ] = val;
	}
	window.localStorage.setItem( 'lp_filter_courses', JSON.stringify( urlParams ) );

	if ( ! lpGlobalSettings.lpArchiveLoadAjax ) {
		console.log( 'Option load courses ajax is disabled' );
		return;
	}

	const lpArchiveAddQueryArgs = ( endpoint, args ) => {
		const url = new URL( endpoint );

		Object.keys( args ).forEach( ( arg ) => {
			url.searchParams.set( arg, args[ arg ] );
		} );

		return url;
	};

	// Add events when load done.
	const lpArchiveCourse = () => {
		// Case load ajax when reload enable.
		if ( ! lpGlobalSettings.lpArchiveNoLoadAjaxFirst ) {
			elListCourse.innerHTML = dataHtml;

			const pagination = paginationHtml;
			const paginationEle = document.querySelector( '.learn-press-pagination' );
			if ( paginationEle ) {
				paginationEle.remove();
			}

			if ( typeof pagination !== 'undefined' ) {
				const paginationHTML = new DOMParser().parseFromString( pagination, 'text/html' );
				const paginationNewNode = paginationHTML.querySelector( '.learn-press-pagination' );

				if ( paginationNewNode ) {
					elListCourse.after( paginationNewNode );
				}
			}
		}

		lpArchivePaginationCourse();
		lpLoadMore();
		lpInfiniteScroll();
		lpArchiveSearchCourse();
	};

	// Call API load courses.
	window.lpArchiveRequestCourse = ( args, callBackSuccess ) => {
		if ( isLoading ) {
			return;
		}
		isLoading = true;

		// Append skeleton to list.
		if ( skeletonClone ) {
			elListCourse.append( skeletonClone );
		}

		const urlCourseArchive = lpArchiveAddQueryArgs( API.apiCourses, { ...lpGlobalSettings.lpArchiveSkeleton, ...args } );
		const url = API.apiCourses + urlCourseArchive.search;
		let paramsFetch = {
			method: 'GET',
		};

		if ( 0 !== lpGlobalSettings.user_id ) {
			paramsFetch = {
				...paramsFetch,
				headers: {
					'X-WP-Nonce': lpGlobalSettings.nonce,
				},
			};
		}

		fetch( url, paramsFetch )
			.then( ( response ) => response.json() )
			.then( ( response ) => {
				dataHtml = response.data.content || '';
				paginationHtml = response.data.pagination || '';

				if ( ! skeletonClone && skeleton ) {
					skeletonClone = skeleton.cloneNode( true );
				}

				if ( ! firstLoad ) {
					if ( paginationType === 'standard' ) {
						elListCourse.innerHTML = dataHtml;

						const pagination = paginationHtml;
						const paginationEle = document.querySelector( '.learn-press-pagination' );
						if ( paginationEle ) {
							paginationEle.remove();
						}

						if ( typeof pagination !== 'undefined' ) {
							const paginationHTML = new DOMParser().parseFromString( pagination, 'text/html' );
							const paginationNewNode = paginationHTML.querySelector( '.learn-press-pagination' );

							if ( paginationNewNode ) {
								elListCourse.after( paginationNewNode );
								lpArchivePaginationCourse();
							}
						}
					} else if ( paginationType === 'loadmore' ) {
						const paged = args?.paged || 1;

						if ( paged === 1 ) {
							elListCourse.innerHTML = dataHtml;
						} else {
							elListCourse.insertAdjacentHTML( 'beforeend', dataHtml );
						}

						const loadMoreNode = document.querySelector( '.lp-archive-courses .lp-load-more' );

						if ( loadMoreNode ) {
							const loadingIconNode = loadMoreNode.querySelector( '.lp-loading-display' );
							const loadMoreBtnNode = loadMoreNode.querySelector( '.lp-load-more-btn' );

							if ( loadingIconNode ) {
								loadingIconNode.style.display = 'none';
							}

							if ( paged !== response.data.total_pages && ! loadMoreBtnNode ) {
								loadMoreNode.insertAdjacentHTML( 'beforeend', `<div class="lp-load-more-btn">${ loadMoreBtnHtml }</div>` );
							}
						}
					} else if ( paginationType === 'infinite_scroll' ) { //infinite-scroll
						const paged = args?.paged || 1;

						if ( paged === 1 ) {
							elListCourse.innerHTML = dataHtml;
						} else {
							elListCourse.insertAdjacentHTML( 'beforeend', dataHtml );
						}
						isFetching = false;
						const infiniteScrollNode = document.querySelector( '.lp-archive-courses .lp-infinite-scroll' );

						if ( infiniteScrollNode ) {
							const loadingIconNode = infiniteScrollNode.querySelector( '.lp-loading-display' );

							if ( loadingIconNode ) {
								loadingIconNode.style.display = 'none';
							}

							if ( paged === response.data.total_pages ) {
								lastPage = true;
							} else {
								lastPage = false;
							}
						}
					}
				}

				wp.hooks.doAction( 'lp-js-get-courses', response );

				if ( typeof callBackSuccess === 'function' ) {
					callBackSuccess( response );
				}
			} ).catch( ( error ) => {
				elListCourse.innerHTML += `<div class="lp-ajax-message error" style="display:block">${ error.message || 'Error: Query lp/v1/courses/archive-course' }</div>`;
			} )
			.finally( () => {
				isLoading = false;
				const btnSearchCourses = document.querySelector( 'form.search-courses button' );
				if ( btnSearchCourses ) {
					btnSearchCourses.classList.remove( 'loading' );
				}

				if ( ! firstLoad ) {
					// Scroll to archive element
					if ( paginationType === 'standard' ) {
						const optionScroll = { behavior: 'smooth' };
						elArchive.scrollIntoView( optionScroll );
					}
				} else {
					firstLoad = 0;
				}

				// Save filter courses to Storage
				window.localStorage.setItem( 'lp_filter_courses', JSON.stringify( args ) );
				// Change url by params filter courses
				if ( paginationType === 'standard' ) {
					const urlPush = lpArchiveAddQueryArgs( document.location, args );
					window.history.pushState( '', '', urlPush );
				}
			} );
	};

	// Call API load courses when js loaded.
	if ( ! lpGlobalSettings.lpArchiveNoLoadAjaxFirst ) {
		lpArchiveRequestCourse( filterCourses );
	} else {
		firstLoad = 0;
	}

	const lpArchiveSearchCourse = () => {
		const searchForm = document.querySelectorAll( 'form.search-courses' );
		filterCourses = JSON.parse( window.localStorage.getItem( 'lp_filter_courses' ) ) || {};

		searchForm.forEach( ( s ) => {
			const search = s.querySelector( 'input[name="c_search"]' );
			const btn = s.querySelector( '[type="submit"]' );
			let timeOutSearch;

			search.addEventListener( 'keyup', ( event ) => {
				if ( skeleton ) {
					skeleton.style.display = 'block';
				}
				event.preventDefault();

				const s = event.target.value.trim();

				if ( ! s || ( s && s.length > 2 ) ) {
					if ( undefined !== timeOutSearch ) {
						clearTimeout( timeOutSearch );
					}

					timeOutSearch = setTimeout( function() {
						btn.classList.add( 'loading' );

						filterCourses.c_search = s;
						filterCourses.paged = 1;

						lpArchiveRequestCourse( { ...filterCourses } );
					}, 800 );
				}
			} );

			s.addEventListener( 'submit', ( e ) => {
				e.preventDefault();

				const eleSearch = s.querySelector( 'input[name="c_search"]' );
				eleSearch && eleSearch.dispatchEvent( new Event( 'keyup' ) );
			} );
		} );
	};

	const lpArchivePaginationCourse = () => {
		if ( paginationType !== 'standard' ) {
			return;
		}

		const paginationEle = document.querySelectorAll( '.lp-archive-courses .learn-press-pagination .page-numbers' );

		paginationEle.length > 0 && paginationEle.forEach( ( ele ) => ele.addEventListener( 'click', ( event ) => {
			event.preventDefault();
			event.stopPropagation();

			if ( ! elArchive ) {
				return;
			}

			if ( skeleton ) {
				skeleton.style.display = 'block';
			}

			// Scroll to archive element
			elArchive.scrollIntoView( { behavior: 'smooth' } );

			filterCourses = JSON.parse( window.localStorage.getItem( 'lp_filter_courses' ) ) || {};

			const urlString = event.currentTarget.getAttribute( 'href' );

			if ( urlString ) {
				const current = [ ...paginationEle ].filter( ( el ) => el.classList.contains( 'current' ) );
				filterCourses.paged = event.currentTarget.textContent || ( ele.classList.contains( 'next' ) && parseInt( current[ 0 ].textContent ) + 1 ) || ( ele.classList.contains( 'prev' ) && parseInt( current[ 0 ].textContent ) - 1 );
				lpArchiveRequestCourse( { ...filterCourses } );
			}
		} ) );
	};

	const lpArchiveGridListCourse = () => {
		const layout = LP.Cookies.get( 'courses-layout' );

		const switches = document.querySelectorAll( '.lp-courses-bar .switch-layout [name="lp-switch-layout-btn"]' );

		switches.length > 0 && [ ...switches ].map( ( ele ) => ele.value === layout && ( ele.checked = true ) );
	};

	const lpArchiveGridListCourseHandle = () => {
		const gridList = document.querySelectorAll( '.lp-archive-courses input[name="lp-switch-layout-btn"]' );

		gridList.length > 0 && gridList.forEach( ( element ) => element.addEventListener( 'change', ( e ) => {
			e.preventDefault();

			const layout = e.target.value;

			if ( layout ) {
				const dataLayout = document.querySelector( '.lp-archive-courses .learn-press-courses[data-layout]' );

				dataLayout && ( dataLayout.dataset.layout = layout );
				LP.Cookies.set( 'courses-layout', layout );
			}
		} ) );
	};

	const LPArchiveCourseInit = () => {
		lpArchiveCourse();
		lpArchiveGridListCourseHandle();
		lpArchiveGridListCourse();
	};

	// document.addEventListener( 'DOMContentLoaded', function( event ) {
	// 	LPArchiveCourseInit();
	// } );

	const detectedElArchive = setInterval( function() {
		skeleton = document.querySelector( '.lp-archive-course-skeleton' );
		elArchive = document.querySelector( '.lp-archive-courses' );
		if ( elArchive ) {
			elListCourse = elArchive.querySelector( 'ul.learn-press-courses' );
		}
		let canLoad = false;

		if ( elListCourse && skeleton ) {
			if ( lpGlobalSettings.lpArchiveNoLoadAjaxFirst ) {
				canLoad = true;
			} else if ( dataHtml ) {
				canLoad = true;
			}

			if ( canLoad ) {
				LPArchiveCourseInit();
				clearInterval( detectedElArchive );
			}
		}
	}, 1 );

	const lpLoadMore = () => {
		if ( paginationType !== 'loadmore' ) {
			return;
		}

		document.addEventListener( 'click', function( event ) {
			const loadMoreBtnNode = event.target;

			if ( ! loadMoreBtnNode.classList.contains( 'lp-load-more-btn' ) ) {
				return;
			}

			event.preventDefault();

			const loadMoreNode = loadMoreBtnNode.closest( '.lp-load-more' );
			const loadingIconNode = loadMoreNode.querySelector( '.lp-loading-display' );
			loadMoreBtnHtml = loadMoreBtnNode.innerHTML;
			loadMoreBtnNode.remove();
			loadingIconNode.style.display = 'block';
			filterCourses = JSON.parse( window.localStorage.getItem( 'lp_filter_courses' ) ) || {};
			const currentPage = filterCourses?.paged || 1;
			filterCourses.paged = parseInt( currentPage ) + 1;
			lpArchiveRequestCourse( { ...filterCourses } );
		} );
	};

	const lpInfiniteScroll = () => {
		if ( paginationType === 'infinite_scroll' ) { //infinite-scroll
			window.addEventListener( 'scroll', ( event ) => {
				getScrollData();
			} );
		}
	};

	const getScrollData = () => {
		const infiniteScrollNode = document.querySelector( '.lp-infinite-scroll' );

		if ( ! infiniteScrollNode ) {
			return;
		}

		const distance = infiniteScrollNode.getBoundingClientRect().top - window.innerHeight;

		if ( isFetching === false && distance < 0 && lastPage === false ) {
			isFetching = true;
			const infiniteLoadingNode = infiniteScrollNode.querySelector( '.lp-loading-display' );
			infiniteLoadingNode.style.display = 'block';
			filterCourses = JSON.parse( window.localStorage.getItem( 'lp_filter_courses' ) ) || {};
			const currentPage = filterCourses?.paged || 1;
			filterCourses.paged = parseInt( currentPage ) + 1;
			lpArchiveRequestCourse( { ...filterCourses } );
		}
	};
};
jsHandlePageCourses();

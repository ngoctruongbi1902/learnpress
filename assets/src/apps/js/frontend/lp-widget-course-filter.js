
const classCourseFilterLP = 'lp-form-course-filter-elementor';
const searchInput = document.querySelector('.lp-course-filter-search');
const filterForm = document.querySelector(`.${classCourseFilterLP}`);
const searchResult = document.querySelector('.lp-course-filter-search-result');

let timeoutSearch;
let controller;
let signal;

if (!searchInput || !filterForm || !searchResult ) {
  console.log('Không tìm thấy các phần tử có lớp lp-course-filter-search, lp-form-course-filter-elementor hoặc lp-course-filter-search-result');
}

// Search course suggest
if (searchInput) {
  searchInput.addEventListener('keyup', function (e) {
    e.preventDefault();
    const keyword = searchInput.value.trim();

    if (keyword && keyword.length > 2) {
      clearTimeout(timeoutSearch);
      timeoutSearch = setTimeout(function () {
        showLoadingSpinner(true);

        callAPICourseSuggest(keyword)
          .then(response => {
            showSearchResult(response.data.content);
          })
          .catch(error => {
            console.log(error);
            showSearchResult('');
          })
          .finally(() => {
            showLoadingSpinner(false);
          });
      }, 500);
    } else {
      showSearchResult('');
    }
  });
}

// Click field
if (filterForm) {
  filterForm.addEventListener('click', function (e) {
    const target = e.target;
    if (target.tagName === 'INPUT') {
      filterCourses();
    } else if (target.classList.contains('course-filter-reset')) {
      e.preventDefault();
      resetFilter();
    } else if (target.classList.contains('course-filter-submit')) {
      e.preventDefault();
      filterCourses();
    }
  });
}

function callAPICourseSuggest(keyword) {
  if (controller) {
    controller.abort();
  }
  controller = new AbortController();
  signal = controller.signal;

  const url = `/api/courses?c_search=${keyword}&c_suggest=1`;
  let paramsFetch = {
    method: 'GET',
  };

  return fetch(url, { ...paramsFetch, signal })
    .then(response => response.json())
    .catch(error => {
      console.log(error);
      return { data: { content: '' } };
    });
}

function showSearchResult(content) {
  if (searchResult) {
    searchResult.innerHTML = content;
  }
}

function showLoadingSpinner(show) {
  const loadingSpinner = document.querySelector('.lp-loading-circle');
  if (loadingSpinner) {
    loadingSpinner.classList.toggle('hide', !show);
  }
}

function filterCourses() {
  if (!filterForm) return;
  const formData = new FormData(filterForm); // Create a FormData object from the form
  const filterCourses = { paged: 1 };

  for (const pair of formData.entries()) {
    const key = pair[0];
    const value = formData.getAll(key);
    if (!filterCourses.hasOwnProperty(key)) {
      filterCourses[key] = value;
    }
  }

  if (lpGlobalSettings.is_course_archive && lpGlobalSettings.lpArchiveLoadAjax && elListCourse && skeleton) {
	lpArchiveRequestCourse(filterCourses);
  } else {
	const courseUrl = lpGlobalSettings.courses_url || '';
	const url = new URL(courseUrl);
	Object.keys(filterCourses).forEach(arg => {
	  url.searchParams.set(arg, filterCourses[arg]);
	});
	document.location.href = url.href;
  }
}

function resetFilter() {
  if (!filterForm) return;
  filterForm.reset();
  if (searchResult) {
    searchResult.innerHTML = '';
  }
  if (searchInput) {
    searchInput.value = '';
  }

  // Uncheck value with case set default from params url.
  const checkboxes = filterForm.querySelectorAll('input[type="checkbox"]');
  checkboxes.forEach(checkbox => checkbox.removeAttribute('checked'));

  filterCourses();
}
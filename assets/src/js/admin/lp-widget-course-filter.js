
const dropDownFilter = function() {
    // Javascript accordion
  const accordionTitles = document.querySelectorAll('.lp-form-course-filter-wrapper.accordion .lp-form-course-filter__title');
  accordionTitles.forEach(function(title) {
    title.addEventListener('click', function() {
      this.classList.toggle('active');
      const content = this.nextElementSibling;
      const isOpen = content.classList.contains('show');

      if (isOpen) {
        content.classList.remove('show');
        content.style.maxHeight = 0;
      } else {
        content.classList.add('show');
        const contentHeight = content.scrollHeight;
        content.style.maxHeight = contentHeight + 'px';
      }
    });
  });
  

    // Javascript dropdown
  const dropdownTitles = document.querySelectorAll('.lp-form-course-filter-wrapper.dropdown .lp-form-course-filter__title');
  dropdownTitles.forEach(function(title) {
    title.addEventListener('click', function() {
      const parentWrapper = this.closest('.lp-form-course-filter-wrapper.dropdown');
      const isActive = parentWrapper.classList.contains('active');
      
      // Close all other dropdowns before opening the clicked one
      const allDropdowns = document.querySelectorAll('.lp-form-course-filter-wrapper.dropdown');
      allDropdowns.forEach(function(dropdown) {
        if (dropdown !== parentWrapper) {
          dropdown.classList.remove('active');
        }
      });

      // Toggle active class for the clicked dropdown
      parentWrapper.classList.toggle('active', !isActive);
    });
  });


  // The function calculates the number of checkboxes selected in a lp-form-course-filter-wrapper
  function updateSelectedCount(wrapper) {
    const checkboxes = wrapper.querySelectorAll('input[type="checkbox"]');
    let count = 0;
    checkboxes.forEach((checkbox) => {
      if (checkbox.checked) {
        count++;
      }
    });

    const selectedCountElement = wrapper.querySelector('.selectedCount');
    if (selectedCountElement) {
      selectedCountElement.textContent = count > 0 ? `(${count})` : ''; 
    }
  }

  // Listen for event when checkbox is selected in one lp-form-course-filter-wrapper
  const filterWrappers = document.querySelectorAll('.lp-form-course-filter-wrapper');
  filterWrappers.forEach((wrapper) => {
    const checkboxes = wrapper.querySelectorAll('input[type="checkbox"]');
    checkboxes.forEach((checkbox) => {
      checkbox.addEventListener('change', () => {
        updateSelectedCount(wrapper);
      });
    });

    // Show initial count when page uploads
    updateSelectedCount(wrapper);
  });


};
  
  const onReady = function() {
    dropDownFilter();
  };
  
  document.addEventListener('DOMContentLoaded', onReady);

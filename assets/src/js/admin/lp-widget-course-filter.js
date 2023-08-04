
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
  const allDropdowns = document.querySelectorAll('.lp-form-course-filter-wrapper.dropdown');    
  
  // Function to close all open dropdowns
  function closeAllDropdowns() {
    allDropdowns.forEach(function(dropdown) {
      dropdown.classList.remove('active');
    });
  }

  
  // Toggle the dropdown when the title is clicked
  dropdownTitles.forEach(function(title) {
    title.addEventListener('click', function(event) {
      const parentWrapper = this.closest('.lp-form-course-filter-wrapper.dropdown');
      const isActive = parentWrapper.classList.contains('active');

      closeAllDropdowns(); 

      // Toggle active class for the clicked dropdown
      parentWrapper.classList.toggle('active', !isActive);
      event.stopPropagation();
    });
  });

  // Close all dropdowns when clicking outside
  document.addEventListener('click', function(event) {
    const isDropdownClick = event.target.closest('.lp-form-course-filter-wrapper.dropdown');
    if (!isDropdownClick) {
      closeAllDropdowns();
    }
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

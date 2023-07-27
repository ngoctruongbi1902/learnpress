const $ = jQuery;


const dropDownFilter = function dropDownFilter() {
    $('.lp-form-course-filter-wrapper.accordion .lp-form-course-filter__title').click(function() {
        $(this).toggleClass('active');
        const content = $(this).next('.lp-form-course-filter-wrapper.accordion .lp-form-course-filter__item');
        const isOpen = content.hasClass('show');

        if (isOpen) {

            content.removeClass('show');
            content.css('max-height', 0);
        } else {

            content.addClass('show');
            const contentHeight = content.prop('scrollHeight');
            content.css('max-height', contentHeight + 'px');
        }
    });
}

const onReady = function onReady() {
	dropDownFilter();

};

$( document ).ready( onReady );

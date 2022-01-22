$(document).ready(function() {
    $('input[name=all_element_id]').on('click', function () {
        let link = $(this).parents('[data-link]'), checked;
        if ($(this).prop('checked')) {
            checked = true;
        }
        else {
            checked = false;
        }
        link.find('input[name=element_id]').prop('checked', checked);
        button_logic(link);
        select_row(link);
    });

    $('input[name=element_id]').on('click' ,function () {
        let link = $(this).parents('[data-link]');
        button_logic(link);
        select_row(link);
        if (link.find('input[name=element_id]').length === link.find('input[name=element_id]:checked').length) {
            link.find('input[name=all_element_id]').prop('checked', true);
        }
        else {
            link.find('input[name=all_element_id]').prop('checked', false);
        }
    });
});

function select_row(link) {
    link.find('input[name=element_id]').parents('.table-row').each(function(i,e) {
        e.classList.remove('active')
    });
    link.find('input[name=element_id]:checked').parents('.table-row').each(function(i,e) {
        e.classList.add('active')
    });
}

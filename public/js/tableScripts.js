import {table_events} from './TableDeleteController.js';
$(document).ready(function(){
    $(document).on('click', '.pagination a', function(event){
        event.preventDefault();
        let page = $(this).attr('href').split('page=')[1],
            link = $(this).parents('[data-link]');
        fetch_data(page, link);
    });

    function fetch_data(page, link)
    {

        let option = link.find('select[id=pagination-select]').val();
        let search_attribute = link.find('input[type=search]').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: link.data('link')+"/update_table?page="+page,
            type: "POST",
            data: {option, search_attribute},
            success:function(data)
            {
                $('#table_data').html(data);
                table_events();
            }
        })
    }
});

$(document).ready(function(){

    $('select[id=pagination-select]').on('change', function () {
        let option = $(this).val(),
            link = $(this).parents('[data-link]'),
            search_attribute = link.find('input[type=search]').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: link.data('link')+"/update_table",
            type: "POST",
            data: {option, search_attribute},
            success: function (result) {

                $('#table_data').html(result);
                table_events();

            },
        });
    });

});

// $('#show-franchise').on('click', function () {
//     $.ajaxSetup({
//         headers: {
//             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//         }
//     });
//     $.ajax({
//         url: "show_franchises",
//         type: "POST",
//         success: function (result) {
//             $('#select-franchise').html(result);
//         }
//     });
// });


$(document).ready(function() {
    let search_attr = { timeout: null, link: '', search_str: '', table: null};

    $('#search-franchises').on('keydown', function () {
        search_attr.link = 'show_franchises';
        search(search_attr);
    });
    $('#table-search').on('keydown', function () {
        search_attr.table = $(this).parents('[data-link]');
        search_attr.link = search_attr.table.data('link') + "/update_table";
        search()
    });


    function search() {
        if (search_attr.timeout) {
            clearTimeout(search_attr.timeout);
        }
        search_attr.timeout = setTimeout( function() {
            if (search_attr.link == 'show_franchises') {
                search_attr.search_str = $('#search-franchises').val();
                send_search_request();
            }
            else {
                search_attr.search_str = search_attr.table.find('input[type=search]').val();
                send_search_request();
            }
        } ,100);
    }

    function send_search_request(){
        let data;
        if (search_attr.link == 'show_franchises') {
            data = {search_attribute: search_attr.search_str};
        }
        else {
            let option = search_attr.table.find('select[id=pagination-select]').val();
            data = {search_attribute: search_attr.search_str, option};
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: search_attr.link,
            type: "POST",
            data: data,
            success:function(data)
            {
                if (search_attr.link == 'show_franchises') {
                    $('#select-franchise').html(data);
                }
                else {
                    $('#table_data').html(data);
                    table_events();
                }

            }
        });

    }
});


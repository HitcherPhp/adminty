
class ShowPopup {
    constructor(popup_massages , display_styles){
        this.mustache_popups = document.getElementById('mustache_popups').innerHTML;
        this.add_modal_window = document.getElementById('add_modal_window');

        this.mustache_data = {
            sa_error__add: display_styles.sa_error__add,
            sa_warning__add: display_styles.sa_warning__add,
            sa_success__add: display_styles.sa_success__add,
            header_title__add: popup_massages.header_title__add,
            content_title__add: popup_massages.content_title__add,
            cancel__add: display_styles.cancel__add,
            confirm__add: display_styles.confirm__add,
            ok__add: display_styles.ok__add,
        };
    }

    show_popup(){
        var rendered = Mustache.render(this.mustache_popups, this.mustache_data);
        this.add_modal_window.insertAdjacentHTML('afterEnd', rendered);
    }

}

var link = $('.table-responsive').attr('data-link');
// localStorage.clear();
if (link){
    if(link != 'franchises'){
        $.get(link + '/check_franchise_id', function(data){
            // console.log('data: ', data);
            if(data != -1){
                localStorage.setItem('franchise_id', JSON.stringify({data: data[0]}))
            }else{
                localStorage.setItem('franchise_id', JSON.stringify(data));
            }
        });
    }
}


var link = window.location.pathname;
// console.log('link: ', link);
var franchise_data = [];
var franchiseName = "";
var coordValidate = /^-?[\d]{1,}\.[\d]{1,},[\s]{1}-?[\d]{1,}\.[\d]{1,}$/;
var numericValidate = /^[\d]{6,20}$/;
var key_franchise_id = '';
var dataForSend = '';
var warning_popup = {
    sa_error__add: 'none',
    sa_warning__add: 'block',
    sa_success__add: 'none',
    cancel__add: 'none',
    confirm__add: 'none',
    ok__add: 'inline-block',
};
var asking_popup = {
    sa_error__add: 'none',
    sa_warning__add: 'block',
    sa_success__add: 'none',
    cancel__add: 'inline-block',
    confirm__add: 'inline-block',
    ok__add: 'none',
};
var success_popup = {
    sa_error__add: 'none',
    sa_warning__add: 'none',
    sa_success__add: 'block',
    cancel__add: 'none',
    confirm__add: 'none',
    ok__add: 'inline-block',
};


var popup_messages = new Map([
    [
        '/staff', {
            add_modal_header: 'Добавление сотрудника',
            header_title: {
                asking: 'Вы уверены, что хотите добавить новые данные к франшизе ?',
                confirm: 'Сотрудник успешно добавлен',
                warning: 'Вы не можете добавить новые данные, не выбрав франшизу',
                database_error: 'Произошла ошибка добавления. Проверьте корректность введенных данных и попробуйте еще раз'
            },
            content_title: {
                asking: '',
                confirm: 'На почту новому сотруднику отправлено письмо с паролем'
            }
        }
    ],
    [
        '/factories', {
            add_modal_header: 'Добавление завода',
            header_title: {
                asking: 'Вы уверены, что хотите добавить новые данные к франшизе ?',
                confirm: 'Новый завод успешно добавлен',
                warning: 'Вы не можете добавить новые данные, не выбрав франшизу',
                database_error: 'Произошла ошибка добавления. Проверьте корректность введенных данных и попробуйте еще раз'
            },
            content_title: {
                asking: '',
                confirm: ''
            }
        }
    ],
    [
        '/receptions', {
            add_modal_header: 'Добавление приемного пункта',
            header_title: {
                asking: 'Вы уверены, что хотите добавить новые данные к франшизе ?',
                confirm: 'Новый приемный пункт успешно добавлен',
                warning: 'Вы не можете добавить новые данные, не выбрав франшизу',
                database_error: 'Произошла ошибка добавления. Проверьте корректность введенных данных и попробуйте еще раз'
            },
            content_title: {
                asking: '',
                confirm: ''
            }
        }
    ],
    [
        '/franchises', {
            add_modal_header: 'Добавление франшизы',
            header_title: {
                asking: 'Вы уверены?',
                confirm: 'Новая франшиза успешно создана',
                warning: 'Вы не можете добавить новые данные, не выбрав франшизу',
                database_error: 'Произошла ошибка добавления. Проверьте корректность введенных данных и попробуйте еще раз'
            },
            content_title: {
                asking: '',
                confirm: ''
            }

        }
    ],

]);


if(link == '/factories' || link == '/receptions'){
    var schedule_wrapper = $('#pcoded').data('vue').$refs.schedule_wrapper;
}
// var select_franchise_list = $('#pcoded').data('vue').$refs.select_franchise_list;


document.addEventListener('DOMContentLoaded', function() {


    $('#add-row').on('click', function(){
        // select_franchise_list.destroy();
        $('.add-modal_window').fadeIn();
        if(schedule_wrapper){
            schedule_wrapper.enable();
        }
        start_add_modal();
    });
    $(document).keydown(function(e) {
        if (e.keyCode === 27) {
            e.stopPropagation();
            $('.add-modal_window').fadeOut();
            $('#modal_inputs')[0].reset();
            $('.select2-selection__rendered').attr('title', 'Выберите город').text('Выберите город');
            if(schedule_wrapper){
                schedule_wrapper.disable();
            }

        }
    });
    $('#close_add_modal').on('click', function(){
        $('.add-modal_window').fadeOut();
        $('#modal_inputs')[0].reset();
        $('.select2-selection__rendered').attr('title', 'Выберите город').text('Выберите город');
        if(schedule_wrapper){
            schedule_wrapper.disable();
        }

    });
    $(document).click(function (e) {
        if ($(e.target).is('.add-modal_window')) {
            $('.add-modal_window').fadeOut();
            $('#modal_inputs')[0].reset();
            $('.select2-selection__rendered').attr('title', 'Выберите город').text('Выберите город');
            if(schedule_wrapper){
                schedule_wrapper.disable();
            }

        }
    });
});


function start_add_modal(){
    $('#add_modal_header').text(popup_messages.get(link).add_modal_header);
    switch (link) {
        case '/franchises':
        // console.log('you are in franchises');
        form_validation();

        break;
        default:
        // key_franchise_id = JSON.parse(localStorage.getItem('franchise_id'));
        /*
        *   симулирую получение данных из locStor:
        *
        */
        key_franchise_id = 1;

        if(key_franchise_id != -1){
            franchise_data =
            {
                name: "franchise_id",
                // value: key_franchise_id.data.id
                value: 2
            };
            // franchiseName = key_franchise_id.data.name;
            franchiseName = `ООО "Leda"`;
            popup_messages.get(link).header_title.asking = 'Вы уверены, что хотите добавить новые данные к франшизе ' + franchiseName + '?'
            /*
            *   записать данные в скрытый инпут
            */
            $('#franchise_id').val(JSON.stringify(franchise_data.value));
            form_validation();

        }else{
            show_warning_popup(popup_messages.get(link).header_title.warning);

        }
    }
}




function form_validation(){


    $.validator.setDefaults({
        ignore: ".validation_ignore, .for_ignore .edit_schedule_input",
        errorPlacement: function(error, element){
            error.insertAfter(element.parent());
        },
        highlight: function(element){
            $(element)
            .addClass('form-control-danger');
            $(element)
            .closest('.input-group')
            .addClass('validation_error_div');
        },
        unhighlight: function(element){
            $(element)
            .removeClass('form-control-danger');
            $(element)
            .closest('.input-group')
            .removeClass('validation_error_div');
        }
    });

    $.validator.addMethod("chooseGroup", function(value, element, arg){
        if($('#group_select_val').val() == 8){
            $('#select_reception').removeClass('validation_ignore');
            $('#reception_select_val').removeClass('validation_ignore');
        }
        else{
            $('#select_reception').addClass('validation_ignore');
            $('#reception_select_val').addClass('validation_ignore');
        }
        return arg !== value;
    }, "Необходимо выбрать группу");

    $.validator.addMethod("chooseReception", function(value, element, arg){
        return arg !== value;
    }, "Необходимо выбрать приемный пункт");

    $.validator.addMethod("chooseFactory", function(value, element, arg){
        return arg !== value;
    }, "Необходимо выбрать завод");

    $.validator.addMethod("checkEmail", function(value, element, arg){
        var createData;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: link + '/create',
            data: {email: value},
            type: 'POST',
            async: false, // нежелательное использование
            dateType: 'json',
            success: function (data) {
                createData = data;
            }
        });
        return arg == createData;
    }, "Пользователь с данной почтой уже существует");

    $.validator.addMethod("enterCoords", function(value, element, arg){
        if(value.search(coordValidate) == 0){
            return true;
        }
        else{
            return false;
        }
    }, "Неверный формат координат");

    $.validator.addMethod("enterNumbers", function(value, element, arg){
        if(value.search(numericValidate) == 0){
            return true;
        }
        else{
            return false;
        }
    }, "Допустимо только числовое значение от 6 до 20 знаков");

    $.validator.messages.required = 'Поле обязательно для заполнения';
    $.validator.messages.number = 'Допустимо только числовое значение';
    $.validator.messages.email = 'Ваша почта должна быть формата name@domain.com';

    $('#modal_inputs').validate({
        rules: {
            name:'required',
            surname:'required',
            patronymic:'required',
            staff_reception_select: {
                chooseReception: '0'
            },
            staff_phone:'required',
            group: {
                chooseGroup: "0",
            },
            staff_email:{
                checkEmail: true,
                required: true,
                email: true
            },

            rec_address:'required',
            additional_rec_address:'required',
            rec_coords:'required',
            rec_contacts:'required',
            reception_factory_select: {
                chooseFactory: '0'
            },
            rec_weight:'required',
            rec_height:'required',
            rec_width:'required',
            rec_length:'required',

            fact_address:'required',
            additional_fact_address:'required',
            fact_contacts:'required',
            fact_coords:{
                enterCoords: true
            },

            org_name:'required',
            full_org_name:'required',
            short_name_prop_form:'required',
            pos_head:'required',
            name_head:'required',
            regulation:'required',
            org_bank:'required',
            org_bic:{
                required: true,
                enterNumbers: true
            },
            org_ca:{
                required: true,
                enterNumbers: true
            },
            org_pa:{
                required: true,
                enterNumbers: true
            },
            org_inn:{
                required: true,
                enterNumbers: true
            },
            org_coords:{
                required: true,
                enterCoords: true
            },
            org_kpp:'required',
            org_index:{
                required: true,
                enterNumbers: true
            },
            org_city:'required',
            org_address:'required',

        },

        submitHandler: function(){
            dataForSend = $('#modal_inputs').serializeArray();
            show_asking_popup();
            console.log('in form validator submitHandler', dataForSend);


            // ниже - удалить
            // sendAjax(dataForSend);


        }
    });

}


function sendAjax(dataForSend){
    // console.log('sendAjax');
    show_success_popup();

    var route = $('#modal_inputs').attr('data');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: route,
        data: dataForSend,
        type: 'POST',
        dateType: 'json',
        // async: false,
        success: function (data) {
            if(data == 'Database error'){
                console.log('Database error');
                show_warning_popup(popup_messages.get(link).header_title.database_error);

            }else{
                show_success_popup();
            }
            // update_table();
        }
    });
};

function show_warning_popup(popup_message){
    let to_mustache = {
        header_title__add: popup_message,
        content_title__add: popup_messages.get(link).content_title.asking
    };
    let SP = new ShowPopup(to_mustache, warning_popup);
    SP.show_popup();

    $('#ok__add').on('click', function(){
        close_all();
    });
}

function show_asking_popup(){
    let to_mustache = {
        header_title__add: popup_messages.get(link).header_title.asking,
        content_title__add: popup_messages.get(link).content_title.asking
    };
    let SP = new ShowPopup(to_mustache, asking_popup);
    SP.show_popup();

    $('#confirm__add').on('click', function(){
        sendAjax(dataForSend);
    });
    $('#cancel__add').on('click', function(){
        $('#mustache_popups_container').remove();

    });
}

function show_success_popup(){
    $('#mustache_popups_container').remove();

    let to_mustache = {
        header_title__add: popup_messages.get(link).header_title.confirm,
        content_title__add: popup_messages.get(link).content_title.confirm
    };
    let SP = new ShowPopup(to_mustache, success_popup);
    SP.show_popup();

    $('#ok__add').on('click', function(){
        close_all();
    });
}

function close_all(){
    $('#mustache_popups_container').remove();
    $('.add-modal_window').fadeOut();

    $('#modal_inputs')[0].reset();
    $('#select_reception').addClass('validation_ignore');
    $('#reception_select_val').addClass('validation_ignore');
    if(schedule_wrapper){
        schedule_wrapper.disable();
    }
}

function update_table() {
    option = $('select[id=pagination-select]').val(),
    search_attribute = $('input[type=search]').val();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        data: {option, search_attribute},
        type: 'POST',
        url: link + "/update_table",
        dateType: 'json',
        success:function(data)
        {
            $('#table_data').html(data);
        }
    });
};


class AddPopupsClass {
    constructor(data) {
        this.popup_messages = data
        // this.link = $('.table-responsive').attr('data-link');
    }

    test_m(){
        console.log('test_m worked');
    }

    show_asking_popup(){
        console.log('in show_asking_popup this.popup_messages: ', this.popup_messages);

        // var testbtn = $('button[name=confirm__add]');
        // $('#sweet_overlay__add').fadeIn().css('display', 'block');
        // $('#sweet_alert__add').css({
        //   'display': 'block'
        // }).animate({opacity: 1}, '198');
        //
        // $('#sa_error__add').css('display', 'none');
        // $('#sa_warning__add').css('display', 'block');
        // $('#sa_success__add').css('display', 'none');
        // testbtn.css('display', 'inline-block');
        // $('button[name=cancel__add]').css('display', 'inline-block');
        // $('button[name=ok__add]').css('display', 'none');
        //
        // $('#header_title__add').text(this.popup_messages.header_title.asking);
        // $('#content_title__add').text(this.popup_messages.content_title.asking);
        // // console.log('show_asking_popup', this);
        // var confirm__add = document.getElementById('confirm__add');
        // console.log('confirm__add ', confirm__add);
        // console.log('document ', document);
        // confirm__add.addEventListener('click', this.get_form_data);
        // testbtn.on('click', this.get_form_data);

    }
}



class AddBaseClass {
    constructor(data, link) {
        this.popup_messages = data
        this.franchise_data = '';
        this.link = link;
        this.form_data = '';

        this.modal_window_content = document.getElementById('modal_window_content');
        this.add_button = document.getElementById('add-row');
        this.close_add_modal = this.modal_window_content.querySelector('#close_add_modal');
        this.save_new_data = this.modal_window_content.querySelector('#save_new_data');
        // this.ok__add = this.modal_window_content.querySelector('#ok__add');
        // this.confirm__add = this.modal_window_content.querySelector('#confirm__add');
        // this.cancel__add = this.modal_window_content.querySelector('#cancel__add');

        // console.log('this.modal_window_content ', this.modal_window_content);
        // console.log('this.save_new_data ', this.save_new_data);
    }





    set_current_franchise_data(){
        $.get(this.link + '/check_franchise_id', function(data){
            if(data != -1){
                localStorage.setItem('franchise_id', JSON.stringify({data: data[0]}))
            }else{
                localStorage.setItem('franchise_id', JSON.stringify(data));
            }
        });
    }

    get_current_franchise_data(){
        this.franchise_data = JSON.parse(localStorage.getItem('franchise_id'));
        /*
        *   this.popup_messages.header_title.asking =
        *   = 'Вы уверены, что хотите добавить новые данные к франшизе ' + { установить имя франшизы} + '?'
        *   и внести данные о франшизе в скрытый инпут (возможно не в этом методе)
        */

    }

    open_add_modal(){
        $('.add-modal_window').fadeIn();
    }
    close_add_modal(){
        $('.add-modal_window').fadeOut();
    }

    form_validation(){
        // var coordValidate = /^-?[\d]{2,3}\.[\d]{6},[\s]{1}-?[\d]{2,3}\.[\d]{6}$/;
        // var numericValidate = /^[\d]{6,20}$/;
        // var form = $('#modal_inputs');
        //
        // console.log('in form_validation this: ', this);
        // console.log('in form_validation this.popup_messages: ', this.popup_messages);
        // console.log('in form_validation event: ', event);
        //
        //
        // $.validator.setDefaults({
        //     ignore: ".validation_ignore, .for_ignore .edit_schedule_input",
        //     errorPlacement: function(error, element){
        //         error.insertAfter(element.parent());
        //     },
        //     highlight: function(element){
        //         $(element)
        //         .addClass('form-control-danger');
        //         $(element)
        //         .closest('.input-group')
        //         .addClass('validation_error_div');
        //     },
        //     unhighlight: function(element){
        //         $(element)
        //         .removeClass('form-control-danger');
        //         $(element)
        //         .closest('.input-group')
        //         .removeClass('validation_error_div');
        //     }
        // });
        //
        // $.validator.addMethod("chooseGroup", function(value, element, arg){
        //     if($('#group_select_val').val() == 8){
        //         $('#select_reception').removeClass('validation_ignore');
        //         $('#reception_select_val').removeClass('validation_ignore');
        //     }
        //     else{
        //         $('#select_reception').addClass('validation_ignore');
        //         $('#reception_select_val').addClass('validation_ignore');
        //     }
        //     return arg !== value;
        // }, "Необходимо выбрать группу");
        //
        // $.validator.addMethod("chooseCity", function(value, element, arg){
        //     if(value){
        //         $('.select2-selection__rendered').css('border', '1px solid rgb(204, 204, 204, 1)');
        //     }else{
        //         $('.select2-selection__rendered').css('border', '1px solid rgb(255, 0, 0, 1)');
        //     }
        //     return arg !== value;
        // }, "Необходимо выбрать город");
        //
        // $.validator.addMethod("chooseReception", function(value, element, arg){
        //     return arg !== value;
        // }, "Необходимо выбрать приемный пункт");
        //
        // $.validator.addMethod("chooseFactory", function(value, element, arg){
        //     return arg !== value;
        // }, "Необходимо выбрать завод");
        //
        // $.validator.addMethod("checkEmail", function(value, element, arg){
        //     var createData;
        //     $.ajaxSetup({
        //         headers: {
        //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //         }
        //     });
        //     $.ajax({
        //         url: link + '/create',
        //         data: {email: value},
        //         type: 'POST',
        //         async: false, // нежелательное использование
        //         dateType: 'json',
        //         success: function (data) {
        //             createData = data;
        //         }
        //     });
        //     return arg == createData;
        // }, "Пользователь с данной почтой уже существует");
        //
        // $.validator.addMethod("enterCoords", function(value, element, arg){
        //     if(value.search(coordValidate) == 0){
        //         return true;
        //     }
        //     else{
        //         return false;
        //     }
        // }, "Неверный формат координат");
        //
        // $.validator.addMethod("enterNumbers", function(value, element, arg){
        //     if(value.search(numericValidate) == 0){
        //         return true;
        //     }
        //     else{
        //         return false;
        //     }
        // }, "Допустимо только числовое значение от 6 до 20 знаков");
        //
        // $.validator.messages.required = 'Поле обязательно для заполнения';
        // $.validator.messages.number = 'Допустимо только числовое значение';
        // $.validator.messages.email = 'Ваша почта должна быть формата name@domain.com';
        //
        // form.validate({
        //     debug: false,
        //     success: "valid",
        //     rules: {
        //         name:'required',
        //         surname:'required',
        //         patronymic:'required',
        //         staff_reception_select: {
        //             chooseReception: '0'
        //         },
        //         staff_phone:'required',
        //         group: {
        //             chooseGroup: "0",
        //         },
        //         staff_email:{
        //             checkEmail: true,
        //             required: true,
        //             email: true
        //         },
        //
        //         rec_address:'required',
        //         additional_rec_address:'required',
        //         rec_coords:'required',
        //         rec_contacts:'required',
        //         reception_factory_select: {
        //             chooseFactory: '0'
        //         },
        //         rec_max_weight:'required',
        //         rec_max_height:'required',
        //         rec_max_width:'required',
        //         rec_max_thick:'required',
        //
        //         fact_address:'required',
        //         // additional_fact_address:'required',
        //         // fact_contacts:'required',
        //         // fact_coords:{
        //         //     enterCoords: true
        //         // },
        //
        //         org_name:'required',
        //         full_org_name:'required',
        //         short_name_prop_form:'required',
        //         pos_head:'required',
        //         name_head:'required',
        //         regulation:'required',
        //         org_bank:'required',
        //         org_bic:{
        //             enterNumbers: true
        //         },
        //         org_ca:{
        //             enterNumbers: true
        //         },
        //         org_pa:{
        //             enterNumbers: true
        //         },
        //         org_inn:{
        //             enterNumbers: true
        //         },
        //         org_coords:{
        //             enterCoords: true
        //         },
        //         org_kpp:'required',
        //         org_index:{
        //             enterNumbers: true
        //         },
        //         org_city_select:{
        //             chooseCity: "0"
        //         },
        //         org_address:'required',
        //
        //     },
        //
        //     // submitHandler: function(){
        //     //     /*
        //     //         создавать объект класса отвечающего за попапы?
        //     //     */
        //     //     console.log('submitHandler', this);
        //     // }
        //
        // });
        // if(form.valid()){
        //     console.log('in form_validation this.popup_messages: ', this.popup_messages);
        //     this.show_asking_popup() // необходимо запускать sweet_alert (это временное решение)
        //     var confirm__add = document.getElementById('confirm__add');
        //     confirm__add.addEventListener('click', this.get_form_data);
        //
        // }else{
        //     console.log('form not valid');
        // }
        this.show_asking_popup();
        // var testclass = new AddPopupsClass(this.popup_messages);
        // testclass.show_asking_popup();

    }

    // form_pre_validation(){
    //
    //     console.log('this.save_new_data ', this.save_new_data);
    //     this.save_new_data.addEventListener('click', this.form_validation.bind(this));
    //
    // }

    sweet_alert(){
        if(this.link == 'franchises'){
            this.show_asking_popup();
        }else{
            if(key_franchise_id == -1){
                this.show_warning_popup(this.popup_messages.header_title.warning);
            }else{
                this.show_asking_popup();
            }
        }
    }

    show_asking_popup(){
        // console.log('sadcaervaerververvrwbtvjkwrbwrbtniwtniprwtn');
        var testbtn = $('button[name=confirm__add]');
        $('#sweet_overlay__add').fadeIn().css('display', 'block');
        $('#sweet_alert__add').css({
          'display': 'block'
        }).animate({opacity: 1}, '198');

        $('#sa_error__add').css('display', 'none');
        $('#sa_warning__add').css('display', 'block');
        $('#sa_success__add').css('display', 'none');
        testbtn.css('display', 'inline-block');
        $('button[name=cancel__add]').css('display', 'inline-block');
        $('button[name=ok__add]').css('display', 'none');

        $('#header_title__add').text(this.popup_messages.header_title.asking);
        $('#content_title__add').text(this.popup_messages.content_title.asking);
        // console.log('show_asking_popup', this);
        var confirm__add = document.getElementById('confirm__add');
        console.log('confirm__add ', confirm__add);
        // console.log('document ', document);
        confirm__add.addEventListener('click', this.get_form_data);
        // testbtn.on('click', this.get_form_data);

    }

    show_warning_popup(message){
        $('#sweet_overlay__add').fadeIn().css('display', 'block');
        $('#sweet_alert__add').css({
          'display': 'block'
        }).animate({opacity: 1}, '198');

        $('#sa_warning__add').css('display', 'none');
        $('#sa_success__add').css('display', 'none');
        $('#sa_error__add').css('display', 'block');

        $('#header_title__add').text(message);
        $('#content_title__add').text(this.popup_messages.content_title.asking);

        $('button[name=confirm__add]').css('display', 'none');
        $('button[name=cancel__add]').css('display', 'none');
        $('button[name=ok__add]').css('display', 'inline-block');
    }

    get_form_data(){
        console.log('get_form_data', this);
        // this.form_data = $('#modal_inputs').serializeArray();
    }



}


class AddFactoryClass extends AddBaseClass{
    constructor() {
        super({
            add_modal_header: 'Добавление завода',
            header_title: {
                asking: 'Вы уверены, что хотите добавить новые данные к франшизе ' + "franchiseName" + '?',
                confirm: 'Новый завод успешно добавлен',
                warning: 'Вы не можете добавить новые данные, не выбрав франшизу',
                database_error: 'Произошла ошибка добавления. Проверьте корректность введенных данных и попробуйте еще раз'
            },
            content_title: {
                asking: '',
                confirm: ''
            }
        }, 'factories');
        this.modal = document.getElementById('modal_window_content');

    }

    start(){
        /*
        *   вызвать родительский метод get_current_franchise_data, чтобы установить имя франшизы
        */

        this.add_button.addEventListener('click', this.handleEvent.bind(this));
        this.close_add_modal.addEventListener('click', this.handleEvent.bind(this));
        this.save_new_data.addEventListener('click', this.handleEvent.bind(this));

        // this.add_button.addEventListener('click', this.handleEvent.bind(this));

        // this.add_button.addEventListener('click', this.handleEvent);
        // this.close_add_modal.addEventListener('click', this.handleEvent);
        // this.save_new_data.addEventListener('click', this.handleEvent);
    }

    handleEvent(event){

        var schedule_wrapper = $('#pcoded').data('vue').$refs.schedule_wrapper;
        var method = '';
        switch (event.currentTarget.getAttribute('id')) {
            case 'add-row':
                super.open_add_modal(event);
                // super.form_pre_validation.call(this, event);

                schedule_wrapper.enable();
                // this.fill_franchise_data();
                break;
            case 'close_add_modal':
                super.close_add_modal(event);
                schedule_wrapper.disable();
                break;
            case 'save_new_data':
                super.form_validation.call(this, event);

                break;
            // case 'ok__add':
            //     method = 'form_validation';
            //     super[method](event);
            //     break;
            // case 'confirm__add':
            //     method = 'form_validation';
            //     super[method](event);
            //     break;
            // case 'cancel__add':
            //     method = 'form_validation';
            //     super[method](event);
            //     break;
            default:

        }

    }

}

var path = window.location.pathname;
// var new_path = path.split('/').join('');
// console.log('path ',path);


document.addEventListener('DOMContentLoaded', function() {
    var current_class = '';
    // var modal_window_content = document.getElementById('modal_window_content');
    // var add_button = document.getElementById('add-row');
    // var close_add_modal = modal_window_content.querySelector('#close_add_modal');
    // var save_new_data = modal_window_content.querySelector('#save_new_data');
    // var ok__add = modal_window_content.querySelector('#ok__add');
    // var confirm__add = modal_window_content.querySelector('#confirm__add');
    // var cancel__add = modal_window_content.querySelector('#cancel__add');
    switch (path) {
        case '/factories':
            current_class = new AddFactoryClass;
            // add_button.addEventListener('click', current_class);
            // close_add_modal.addEventListener('click', current_class);
            // save_new_data.addEventListener('click', current_class);
            // ok__add.addEventListener('click', current_class);
            // confirm__add.addEventListener('click', current_class);
            // cancel__add.addEventListener('click', current_class);

            // document.addEventListener('keypress', current_class)
            // add_button.addEventListener('open_add_modal', current_class);

            break;
        default:
            console.log('switch default');
    }
    current_class.start();
});














// console.log(path_classname.get(path).classname)
// var testClass = new path_classname.get(path).classname;

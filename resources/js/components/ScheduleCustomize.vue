<template>
    <div id="schedule_total" >
        <div class="schedule_block" v-for="(attribute, attr) in attributes" :key="'attributes_' + attr" >

            <div class="timeman-schedule-form-worktime-inner" >
                <div class="timeman-schedule-form-worktime-item">
                    <div class="timeman-schedule-form-worktime-title">Рабочее время</div>
                    <div class="timeman-schedule-form-worktime-value">
                        <span v-for="(workday, wrkd) in attribute.workday_time" :key="'workday_' + wrkd" class="timeman-schedule-form-worktime-value-text" @click="open_edited_time(attr, $event, 'workday_time')">
                            <span v-if="workday.text" class="timeman-schedule-form-worktime-input-value-text">{{workday.text}}</span>
                            <input v-else-if="workday.value"  autocomplete="off" type="hidden" :value="workday.value">
                            {{workday.dash}}
                        </span>
                    </div>
                </div>
                <div class="timeman-schedule-form-worktime-item">
                    <div class="timeman-schedule-form-worktime-title">Перерыв</div>
                    <div class="timeman-schedule-form-worktime-value">
                        <span v-for="(Break, brk) in attribute.break_time" :key="'break_' + brk" class="timeman-schedule-form-worktime-value-text" @click="open_edited_time(attr, $event, 'break_time')">
                            <span v-if="Break.text" class="timeman-schedule-form-worktime-input-value-text">{{Break.text}}</span>
                            <input v-else-if="Break.value"  autocomplete="off" type="hidden" :value="Break.value">
                            {{Break.dash}}
                        </span>
                    </div>
                </div>

                <div class="timeman-schedule-form-worktime-delete" @click="delete_schedule_block(attr)">
                    <span class="timeman-schedule-form-worktime-delete-icon"></span>
                </div>

                <div class="timeman-schedule-form-worktime-days" >
                    <span class="timeman-schedule-form-worktime-days-inner">
                        <span v-for="(checkbox, chkbx) in attribute.checkboxes" :key="'checkbox_' + chkbx">
                            <span class="timeman-schedule-form-worktime-day" >
                                <input v-model="checkbox.checked" v-on:change="checkbox_change(attr, chkbx)" class="timeman-schedule-form-worktime-day-check" type="checkbox" :value="checkbox.count">
                                <label class="timeman-schedule-form-worktime-day-label">{{checkbox.text}}</label>
                            </span>
                        </span>
                    </span>
                </div>


                <div id="edit_schedule_popup" v-if="attribute.edit_popup && attribute.attr == attr">
                    <div class="show-notification notification-view dropdown-menu show edit_schedule_popup_div" >
                        <div class="stuffing_edit_schedule_popup">
                            <div class="edit_schedule_popup_title">
                                <span>{{edit_popup_attributes[0].title}}</span>
                            </div>
                            <div class="before_inputs">
                                <span class="start_time_span">Начало</span>
                                <span class="end_time_span">Конец</span>
                                <div id="edit_schedule_delete" class="timeman-schedule-form-worktime-delete" @click="close_edited_time(attr)" >
                                    <span class="timeman-schedule-form-worktime-delete-icon"></span>
                                </div>
                            </div>



                            <div id="edit_schedule_inputs" >
                                <span v-for="(input, ipt) in edit_inputs" :key="'input_' + ipt">
                                    <input v-if="!input.colon"  v-model="input.value"  class="edit_schedule_input"  type="number">
                                    {{input.colon}}
                                </span>
                            </div>
                            <div class="sa-button-container">
                                <div class="sa-confirm-button-container">
                                    <button @click="set_edited_time(attr, $event)" class="for_ignore " tabindex="1" style="display: block; background-color: rgb(140, 212, 245); box-shadow: rgba(140, 212, 245, 0.8) 0px 0px 2px, rgba(0, 0, 0, 0.05) 0px 0px 0px 1px inset;">Сохранить</button>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div  @click="add_schedule_block()" class="timeman-schedule-form-worktime-add">
            <span class="timeman-schedule-form-worktime-add-plus">+</span>
            <span class="timeman-schedule-form-worktime-add-link" data-role="timeman-schedule-form-shift-add">добавить время</span>
        </div>
        <input type="text" name="schedule_data" hidden :value="schedule_data[0]">
    </div>
</template>


<script>


export default {
    name: 'ScheduleCustomize',
    data() {
        return {
            attributes: [
                {
                    edit_popup: false,
                    attr: '',
                    workday_time:[
                        {text:'03:05'},
                        {value: '03:05'},
                        {dash: '-'},
                        {text:' 09:00'},
                        {value: '09:00'},
                    ],
                    break_time:[
                        {text:'04:00'},
                        {value: '04:00'},
                        {dash: '-'},
                        {text:' 05:00'},
                        {value: '05:00'},
                    ],
                    // workday_time:[
                    //     {text:'09:00'},
                    //     {value: '09:00'},
                    //     {dash: '-'},
                    //     {text:' 18:00'},
                    //     {value: '18:00'},
                    // ],
                    // break_time:[
                    //     {text:'12:00'},
                    //     {value: '12:00'},
                    //     {dash: '-'},
                    //     {text:' 13:00'},
                    //     {value: '13:00'},
                    // ],

                    checkboxes:[
                        {count: 1, text: 'Пн', checked: true,},
                        {count: 2, text: 'Вт', checked: true,},
                        {count: 3, text: 'Ср', checked: true,},
                        {count: 4, text: 'Чт', checked: true,},
                        {count: 5, text: 'Пт', checked: true,},
                        {count: 6, text: 'Сб', checked: false,},
                        {count: 7, text: 'Вс', checked: false,},
                    ],
                },
            ],

            schedule_data: [
                // `[{"workday":[{"value":"09:00"},{"value":"18:00"}],"break":[{"value":"12:00"},{"value":"13:00"}],"checkbox":[{"count":1,"checked":true},{"count":2,"checked":true},{"count":3,"checked":true},{"count":4,"checked":true},{"count":5,"checked":true}]}]`
                `[{"workday":[{"value":"03:05"},{"value":"09:00"}],"break":[{"value":"04:00"},{"value":"05:00"}],"checkbox":[{"count":1,"text":"Пн","checked":true},{"count":2,"text":"Вт","checked":true},{"count":3,"text":"Ср","checked":true},{"count":4,"text":"Чт","checked":true},{"count":5,"text":"Пт","checked":true}]}]`
            ],

            attributes_for_send: [],

            edit_popup_attributes: [],

            popup_title:{
                workday_time: 'Рабочее время',
                break_time: 'Перерыв'
            },

            edit_inputs:[
                {value: ''},
                {colon: ':'},
                {value: ''},
                {value: ''},
                {colon: ':'},
                {value: ''},
            ],

            temp_edit_inputs:[],
        }
    },
    computed:{
        get_edit_input_value(New, Old){
            return this.edit_inputs.map( i => {
                return i.value
            })
        },

    },

    watch: {

        get_edit_input_value(New, Old){
            for (let i = 0; i < this.edit_inputs.length; i+=3) {
                if(this.edit_inputs[i].value > 23 || this.edit_inputs[i].value < 0 || this.edit_inputs[i].value.lenght > 2){
                    this.edit_inputs[i].value = ''
                }
            }
            for (let i = 2; i < this.edit_inputs.length; i+=3) {
                if(this.edit_inputs[i].value > 55 || this.edit_inputs[i].value < 0  || this.edit_inputs[i].value.length > 2){
                    this.edit_inputs[i].value = ''
                }
            }
        },

        'attributes':{
            handler: 'convert_attributes_array',
            deep: true
        },



    },

    created(){
        console.log('ScheduleCustomize_created')
    },

    mounted(){
        // console.log('ScheduleCustomize_mounted', this.attributes)
    },

    beforeDestroy(){
        // console.log('ScheduleCustomize_beforeDestroy ', this.attributes)
    },

    destroyed(){
        console.log('ScheduleCustomize_destroyed')
    },



    methods: {

        checkbox_change(idx, jdx){
            if(this.attributes[idx].checkboxes[jdx].checked){
                for (let i = 0; i < this.attributes.length; i++) {
                    if(i == idx){
                        continue
                    }else{
                        this.attributes[i].checkboxes[jdx].checked = false
                    }
                }
            }else{
                for (let i = 0; i < this.attributes.length; i++) {
                    if(i == idx){
                        continue
                    }else{
                        this.attributes[i].checkboxes[jdx].checked = true
                    }
                }
            }
        },

        push_attributes(){
            this.attributes.push({
                edit_popup: false,
                attr: '',
                workday_time:[
                    {text:'09:00 '},
                    {value: '09:00'},
                    {dash: '-'},
                    {text:' 18:00'},
                    {value: '18:00'},
                ],
                break_time:[
                    {text:'12:00 '},
                    {value: '12:00'},
                    {dash: '-'},
                    {text:' 13:00'},
                    {value: '13:00'},
                ],

                checkboxes:[
                    {count: 1, text: 'Пн', checked: false,},
                    {count: 2, text: 'Вт', checked: false,},
                    {count: 3, text: 'Ср', checked: false,},
                    {count: 4, text: 'Чт', checked: false,},
                    {count: 5, text: 'Пт', checked: false,},
                    {count: 6, text: 'Сб', checked: false,},
                    {count: 7, text: 'Вс', checked: false,},
                ],
            })
        },

        add_schedule_block() {
            if (this.attributes.length < 3){
                this.push_attributes()
            }
        },

        delete_schedule_block(index) {
            if(!(this.attributes.length < 2)){
                this.attributes.splice(index, 1);
                this.edit_popup_attributes.splice(0, 1);
            }
            this.clear_edit_inputs()
            // this.attributes_for_send.splice(0, 1)
        },

        open_edited_time(i, e, time_period) {
            if (!this.edit_popup_attributes.length){
                let data = {};
                for (let key in this.popup_title){
                    if(key = time_period){
                        data = {
                            time_period: time_period,
                            title: this.popup_title[key]
                        }
                    }
                }

                this.attributes[i].attr = i;
                this.attributes[i].edit_popup = true;

                this.edit_popup_attributes.push(data);
            }
        },

        close_edited_time(i){
            this.attributes[i].edit_popup = false;
            this.attributes[i].attr = '';
            this.edit_popup_attributes.splice(0, 1);
            this.clear_edit_inputs()
        },

        set_edited_time(i, e){

            this.edit_schedule_popup_math()
            let time_period = this.edit_popup_attributes[0].time_period

            let time_from = this.temp_edit_inputs[0].count + ':' + this.temp_edit_inputs[1].count
            let time_to = this.temp_edit_inputs[2].count + ':' + this.temp_edit_inputs[3].count

            for(let key in this.attributes[i]){
                if(key == time_period){
                    this.attributes[i][key][0].text = time_from
                    this.attributes[i][key][1].value = time_from
                    this.attributes[i][key][3].text = time_to
                    this.attributes[i][key][4].value = time_to
                }
            }

            this.attributes[i].edit_popup = false
            this.edit_popup_attributes.splice(0, 1)
            this.clear_edit_inputs()

        },

        clear_schedule(){
            this.attributes.splice(0, this.attributes.length);
            this.edit_popup_attributes.splice(0, 1);
            this.clear_edit_inputs()
        },

        clear_edit_inputs(){
            for (let input of this.edit_inputs) {
                if(input.value == undefined){
                    continue;
                }
                input.value = ''
            }
        },


        edit_schedule_popup_math(){

            this.temp_edit_inputs = []
            for (let input of this.edit_inputs) {
                if(input.value == undefined){
                    continue;
                }
                let len = this.temp_edit_inputs.length
                this.temp_edit_inputs.push({count:input.value})

                if(len == 1 || len == 3){
                    if(this.temp_edit_inputs[len].count != 0){
                        if(this.temp_edit_inputs[len].count % 5 == 3 || this.temp_edit_inputs[len].count % 5 == 4){
                            this.temp_edit_inputs[len].count = this.temp_edit_inputs[len].count - this.temp_edit_inputs[len].count % 5 + 5;
                        }else{
                            this.temp_edit_inputs[len].count = this.temp_edit_inputs[len].count - this.temp_edit_inputs[len].count % 5;
                        }
                    }
                }

                if(this.temp_edit_inputs[len].count.toString().length == 1){
                    this.temp_edit_inputs[len].count = '0' + this.temp_edit_inputs[len].count
                }
                if(this.temp_edit_inputs[len].count.toString().length == 0){
                    this.temp_edit_inputs[len].count = '00'
                }
            }

        },

        convert_attributes_array(val){

            for (let k = 0; k < val.length; k++) {
                this.attributes_for_send.push({})
                this.attributes_for_send[k].workday = val[k].workday_time.filter(i => {
                    if(i.value){
                        return i
                    }
                })
                this.attributes_for_send[k].break = val[k].break_time.filter(i => {
                    if(i.value){
                        return i
                    }
                })
                this.attributes_for_send[k].checkbox = val[k].checkboxes.filter(i => {
                    if(i.checked){
                        return i
                    }
                })
            }

            let without_observer = JSON.parse(JSON.stringify(this.attributes_for_send))
            // попробовать map вместо filter
            let without_empty_obj = without_observer.filter(i => {
                if (Object.keys(i).length){
                    return i
                }
            })
            this.schedule_data.splice(0, 1)
            this.schedule_data.push(JSON.stringify(without_empty_obj))
            console.log(this.schedule_data)

        },

    },








}
</script>

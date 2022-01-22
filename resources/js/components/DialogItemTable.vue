<template>
    <v-dialog
        v-model="dialogItem"
        scrollable
        fullscreen
        hide-overlay
        transition="dialog-bottom-transition"
    >
        <v-card style="height: 100%;display:flex; flex-direction: column">
            <v-toolbar
                dark
                color="primary"
                style="flex: 0 0 64px"
            >
            <v-btn
                icon
                dark
                @click="closeDialog"
            >
            <v-icon>mdi-close</v-icon>
            </v-btn>
        <v-toolbar-title>{{ item.id ? `${title} ${item.name}` : 'News item' }}</v-toolbar-title>

        <v-spacer></v-spacer>
        <v-toolbar-items>
            <v-btn
                v-if="item.id"
                dark
                text
                @click="closeDialog"
            >
                <v-icon>mdi-delete</v-icon>
                <span class="textDefault">Архивировать</span>
            </v-btn>
        </v-toolbar-items>
        <v-toolbar-items>
            <v-btn
                dark
                text
                @click="closeDialog"
                >
                <v-icon>mdi-content-save</v-icon>
                <span class="textDefault">Сохранить</span>
            </v-btn>
        </v-toolbar-items>
    </v-toolbar>
    <v-card-text style="flex: 1 1 auto">
        <div class="itemCenter" v-if="load">
            <v-progress-circular
            indeterminate
            color="primary"
            ></v-progress-circular>
        </div>
        <v-row v-else>
            <v-col cols="8">
                <v-card>
                    <v-tabs
                    v-model="tab"
                    background-color="primary"
                    dark
                    >
                    <v-tab>Детали</v-tab>
                    <v-tab v-if="data.addresses !== false">Адреса</v-tab>
                    <v-tab>Пункт приема</v-tab>
                    <v-tab>Услуги</v-tab>
                </v-tabs>
                <v-tabs-items v-model="tab">
                    <v-tab-item>
                        <v-card flat>
                            <v-card-text>
                                <div v-for="(details,i) in data.details" :key="details.text">
                                    <v-autocomplete
                                    v-if="details.type === 'autocomplete'"
                                    v-model="details.data"
                                    :items="details.items"
                                    item-text="name"
                                    item-value="id"
                                    :label="details.text"
                                    :search-input.sync="details.search"
                                    @update:search-input="searchAutocompleteDetails(details.column,details.search,details)"
                                    ></v-autocomplete>
                                    <v-select
                                    v-if="details.type === 'select'"
                                    :items="getItemsSelect(details.key)"
                                    :label="details.text"
                                    item-text="name"
                                    item-value="id"
                                    v-model="getItemsSelect(details.key).filter(el=>el.name == details.data)[0]"
                                    ></v-select>
                                    <v-text-field
                                    v-if="details.type === 'inputReedOnly'"
                                    readonly
                                    :label="details.text"
                                    v-model="details.data"
                                    >
                                    <!-- иконка не вставляется -->
                                    <v-icon
                                    v-if="details.icon"
                                    >{{ details.icon }}</v-icon>

                                    </v-text-field>
                                    <v-textarea
                                    v-if="details.type === 'textArea'"
                                    :label="details.text"
                                    v-model="details.data"
                                    ></v-textarea>
                                </div>
                            </v-card-text>
                        </v-card>
                    </v-tab-item>
                    <v-tab-item v-if="data.addresses !== false">
                        <v-card flat>
                            <v-card-text>
                                <v-list
                                subheader
                                >
                                <v-subheader>Откуда:</v-subheader>
                                <v-list-item v-for="(address_take, i) in data.addresses[0]"
                                :key="Date.now()*Math.random() + i">
                                <v-text-field
                                v-if="address_take.type === 'inputReedOnly'"
                                readonly
                                :label="address_take.text"
                                v-model="address_take.data"
                                ></v-text-field>
                                <v-text-field
                                v-if="address_take.type === 'input'"
                                :label="address_take.text"
                                v-model="address_take.data"
                                ></v-text-field>
                                <div v-if="address_take.type === 'datePicker'">
                                    <div>
                                        <span>день:</span>
                                        <date-picker
                                        v-model="address_take.data"
                                        :placeholder="address_take.text"
                                        type="date"
                                        value-type="format"
                                        format="YYYY-MM-DD"
                                        ></date-picker>
                                    </div>
                                    <div>
                                        <span>от:</span>
                                        <date-picker
                                        v-model="address_take.dataTime[0]"
                                        :minute-step="30"
                                        :hour-options="hours"
                                        format="HH:mm"
                                        value-type="format"
                                        type="time"
                                        placeholder="HH:mm"
                                        ></date-picker>
                                    </div>
                                    <div>
                                        <span>до:</span>
                                        <date-picker
                                        v-model="address_take.dataTime[1]"
                                        :minute-step="30"
                                        :hour-options="hours"
                                        format="HH:mm"
                                        value-type="format"
                                        type="time"
                                        placeholder="HH:mm"
                                        ></date-picker>
                                    </div>
                                </div>
                            </v-list-item>
                            <v-divider></v-divider>
                            <v-subheader>Куда:</v-subheader>
                            <v-list-item v-for="(address_return, i) in data.addresses[1]"
                            :key="Date.now()*Math.random() + i">
                            <v-text-field
                            v-if="address_return.type === 'inputReedOnly'"
                            readonly
                            :label="address_return.text"
                            v-model="address_return.data"
                            ></v-text-field>
                            <v-text-field
                            v-if="address_return.type === 'input'"
                            :label="address_return.text"
                            v-model="address_return.data"
                            ></v-text-field>
                            <div v-if="address_return.type === 'datePicker'">
                                <div>
                                    <span>день:</span>
                                    <date-picker
                                    v-model="address_return.data"
                                    :placeholder="address_return.text"
                                    type="date"
                                    value-type="format"
                                    format="YYYY-MM-DD"
                                    ></date-picker>
                                </div>
                                <div>
                                    <span>от:</span>
                                    <date-picker
                                    v-model="address_return.dataTime[0]"
                                    :minute-step="30"
                                    :hour-options="hours"
                                    format="HH:mm"
                                    value-type="format"
                                    type="time"
                                    placeholder="HH:mm"
                                    ></date-picker>
                                </div>
                                <div>
                                    <span>до:</span>
                                    <date-picker
                                    v-model="address_return.dataTime[1]"
                                    :minute-step="30"
                                    :hour-options="hours"
                                    format="HH:mm"
                                    value-type="format"
                                    type="time"
                                    placeholder="HH:mm"
                                    ></date-picker>
                                </div>
                            </div>
                        </v-list-item>
                    </v-list>
                </v-card-text>
            </v-card>
        </v-tab-item>
        <v-tab-item>
            <v-card flat>
                <v-card-text>
                    <div v-for="reception in data.reception_data" :key="reception.text">
                        <v-text-field
                        readonly
                        :label="reception.text"
                        v-model="reception.data"
                        ></v-text-field>
                    </div>
                </v-card-text>
            </v-card>
        </v-tab-item>
        <v-tab-item>
            <v-card flat>
                <v-card-text>
                    <v-data-table
                    v-model="selected"
                    show-select
                    :headers="serviceHeaders"
                    :items="data.service"
                    item-key="product_id"
                    hide-default-footer>
                    <template v-slot:top>

                        <v-toolbar
                        flat
                        >
                        <v-toolbar-title>Услуги</v-toolbar-title>
                        <v-divider
                        class="mx-4"
                        inset
                        vertical
                        ></v-divider>
                        <v-row justify="end">
                            <v-btn class="ma-2"><span
                                class="textDefault">Фильтр</span></v-btn>
                                <v-spacer></v-spacer>
                                <v-btn class="ma-2" @click="deleteProduct()"><span class="textDefault">Удалить</span>
                                </v-btn>
                                <v-btn class="ma-2" @click="openAddProductPopup()"><span class="textDefault">Добавить</span>
                                </v-btn>
                            </v-row>
                        </v-toolbar>
                    </template>

                    <template v-slot:item.discount="{item}">
                        <span>{{item.discount}}
                            <v-icon dense>
                                {{item.discount_icon}}
                            </v-icon>
                        </span>
                    </template>

                    <template v-slot:item.count="{item}">
                        <v-text-field
                        dense
                        solo
                        style="max-width: 40px;min-height: 10px"
                        hide-details
                        @change="productCountChanged()"
                        v-model="item.count">
                    </v-text-field>
                </template>
            </v-data-table>
        </v-card-text>
    </v-card>

    <template >
      <v-card
        class="mx-auto"
        max-width="400"
        tile
        v-for="(estimate, e) in estimate_data"
        :key="e"
      >
        <v-list-item >
                <v-list-item align="left">{{estimate.header}}</v-list-item>
                <v-list-item class="d-flex flex-row-reverse">{{ estimate.data }}</v-list-item>
        </v-list-item>


      </v-card>
    </template>

    </v-tab-item>
    </v-tabs-items>

    </v-card>
    </v-col>
    <v-col cols="4">Feeds</v-col>
    </v-row>
    </v-card-text>
    </v-card>

    <v-dialog
      v-model="add_product_popup"
      max-width="500px"
    >
      <v-card>
        <v-card-title>
          <span>Добавить товар</span>
        </v-card-title>
            <v-select
              v-model="service_type_selected"
              :items="data.service_types"
              item-text="service_type"
              item-value="service_type_id"

              label="Тип услуги"
              outlined
            ></v-select>

        <v-autocomplete
          v-model="product_autocomplete.data"
          :items="product_autocomplete.items"
          item-text="name"
          item-value="id"
          :label="product_autocomplete.text"
          :search-input.sync="product_autocomplete.search"
          @update:search-input="searchAutocompleteDetails(product_autocomplete.column,product_autocomplete.search,product_autocomplete)"
          outlined
          filled
        ></v-autocomplete>

        <v-text-field
            v-model="add_popup_product_count"
            label="Количество"
            outlined
          ></v-text-field>

        <v-card-actions>
          <v-btn
            color="primary"
            text
            @click="add_product_popup = false"
          >
            Close
          </v-btn>
          <v-btn
            color="primary"
            text
            @click="setNewProduct()"
          >
            Save
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>




    </v-dialog>
</template>

<script>
import DatePicker from 'vue2-datepicker';
import 'vue2-datepicker/index.css';
import {createItemTable, editItemDataTable, getDatAutocomplete, getAddedProductData, getBasketEstimatePrice} from "../api";

export default {
    name: "DialogItemTable",
    props: ["item", "allData"],
    components: {DatePicker},
    data: () => ({
        selected: [],

        service_type_selected: 1,
        add_product_popup: false,
        add_popup_product_count: 1,
        product_autocomplete: [],

        load: false,
        date: ['сегодня', 'завтра', 'выбрать другую дату'],
        country: null,
        countries: ['Дмитрий', 'Павел', 'Артем'],
        tab: null,
        time: null,
        data: {},
        const_data: {},
        hours: Array.from({length: 18}).map((_, i) => i + 6),
        loadingSearch: false,
        services: null,

        need_service_headers: true,
        need_estimate_headers: true,
        tamp: null,
        estimate_data: [],


    }),
    computed: {
        serviceHeaders(){
            return this.$store.getters.getServiceHeaders
        },

        estimateHeaders(){
            return this.$store.getters.getEstimateHeaders
        },


        dialogItem: {
            get() {
                return this.$store.state.dialogItemTable
            },
            set(val) {
                this.$store.commit('setDialogItemTable', val)
            }
        },
        title() {
            let title = ''
            let newTitle = this.allData.headers.filter(el => el.value === 'name')[0].text
            if (newTitle) {
                title = `${newTitle} :`
            }
            return title
        }
    },
    watch: {

        add_product_popup(){
            if(this.add_product_popup == false){
                this.add_popup_product_count = 1
                this.service_type_selected = 1
            }
        },
        service_type_selected(){
            // обнулить значение поля товара при добавлении, если поменялся тип услуги
            this.product_autocomplete.data = null
            this.product_autocomplete.search = null
            this.product_autocomplete.items[0].id = 0
            this.product_autocomplete.items[0].name = ''
            this.product_autocomplete.items[0].price = null

        },


    },

    created() {
        this.tamp = this.$route.path

        if(this.$store.state.service_headers.length == 0){
            this.need_service_headers = true
        }else{
            this.need_service_headers = false
        }

        if(this.$store.state.estimate_headers.length == 0){
            this.need_estimate_headers = true
        }else{
            this.need_estimate_headers = false
        }

    },

    beforeMount() {
        // console.log('this.allData: ', this.allData)
        // console.log('estimateHeaders: ', this.estimateHeaders)
        this.load = true
        const tamp = this.$route.path

        if (this.item.id) {
            editItemDataTable(tamp, this.item.id, this.need_service_headers, this.need_estimate_headers).then(r => {
                let data = r.data
                try {
                    for (let key in data.addresses) {
                        let newAddress = data.addresses[key].filter(el => el.type == 'datePicker')[0]
                        newAddress.dataTime = data.addresses[key].filter(el => el.type == 'datePicker').map(e => e.data.split(' ', 2)[1])
                        newAddress.data = newAddress.data.split(' ', 2)[0]
                        data.addresses[key] = data.addresses[key].filter(el => el.type !== 'datePicker')
                        data.addresses[key].push(newAddress)
                    }
                } catch (e) {
                    console.log("error", e)
                }
                // console.log("data in beforeMount", data)
                this.const_data = data
                this.data = data

                if(data.service_headers){
                    this.$store.commit('setServiceHeaders', data.service_headers)
                }

                if(data.estimate_headers){
                    this.$store.commit('setEstimateHeaders', data.estimate_headers)
                }



                console.log('DATA in beforeMount', data)

                for (var i = 0; i < data.estimate_data.length; i++) {
                    this.estimate_data.push({
                        key: data.estimate_data[i].key,
                        data: data.estimate_data[i].data,
                        header: this.estimateHeaders[i].header,
                    })
                }


                console.log('this.estimate_data in beforeMount', this.estimate_data)

            }).finally(() => {
                this.load = false
            })
        } else {
            createItemTable(tamp).then(r => {
                this.data = r.data
            }).finally(() => {
                this.load = false
            })
        }
    },

    beforeDestroy(){
        // console.log('beforeDestroy this.const_data: ', this.const_data)

        console.log('beforeDestroy this.data: ', this.data)
    },

    methods: {
        getItemsSelect(keyName) {
            for (let key in this.allData) {
                if (key == keyName) {
                    return this.allData[key]
                }
            }
        },

        closeDialog() {
            this.$store.commit('setDialogItemTable', false)
        },

        searchAutocompleteDetails(column, word, element) {
            if (this.loadingSearch) return

            if (!word || word == null) return


            this.loadingSearch = true
            const tamp = this.$route.path

            let data = {
                column,
                word,
            }


            if(column === 'product'){
                data.service_type_id = this.service_type_selected
                data.order_id = this.item.id
            }

            getDatAutocomplete(tamp, data).then(r => {

                if(Array.isArray(r.data)){
                    let res = r.data
                    if (JSON.stringify(element.items) !== JSON.stringify(res)) {
                        element.items = res
                    }
                }

            }).finally(() => {
                this.loadingSearch = false
            })
        },

        deleteProduct(){
            if(this.selected.length > 0){
                this.selected.forEach(s => {
                    this.data.service = this.data.service.filter(function(p, i){
                        return p.basket_id != s.basket_id
                    })
                });
            }
        },

        openAddProductPopup(){

            this.product_autocomplete = {
                basket_id: 0,
                column: 'product',
                data: null,
                items: [{
                    id: 0,
                    name: '',
                    price: null
                }],
                search: null,
                text: 'Товар'
            }
            this.add_product_popup = !this.add_product_popup
        },


        setNewProduct(){

            let service_data = this.data.service_types_select.filter(s => {
                return s.service_type_id == this.service_type_selected
            })

            let product_data = this.product_autocomplete.items.filter(s => {
                return s.id == this.product_autocomplete.data
            })


            let product_row = {
                basket_id: 0,
                category_id: null,
                category_name: "",
                count: this.add_popup_product_count,
                estimate_price: 0,
                price: product_data[0].price,
                product_id: product_data[0].id,
                product_name: product_data[0].name,
                service_type: service_data[0].service_type,
                service_type_id: service_data[0].service_type_id,
                discount: null,
                discount_icon: null
            }


            this.data.service.push(product_row)
            let pr_idx = this.data.service.indexOf(product_row)


            getAddedProductData(this.tamp, product_row.product_id, product_row.count).then(r => {
                if(Array.isArray(r.data)){
                    // console.log('GET PRODUCT DATA', r.data)
                    // console.log('PRODUCT_ROW', product_row)

                    this.data.service[pr_idx].category_id = r.data[0].categoty_id
                    this.data.service[pr_idx].category_name = r.data[0].categoty_name
                    this.data.service[pr_idx].discount = r.data[0].discount
                    this.data.service[pr_idx].discount_icon = r.data[0].discount_icon
                    this.data.service[pr_idx].estimate_price = r.data[0].estimate_price
                    /*
                    * this.productCountChanged()
                    */
                }
            })

            // getBasketEstimatePrice(this.data.service[pr_idx].product_id, this.data.service[pr_idx].count).then(r =>{
            //     if(Array.isArray(r.data)){
            //         this.data.service[pr_idx].estimate_price = r.data[0].estimate_price
            //     }
            // })
            this.add_product_popup = false
        },


        productCountChanged(){
            // let pr_idx = this.data.service.indexOf(item)

            // if(this.data.service[pr_idx].count != item.count){
                console.log('this.data.service', this.data.service)
                console.log(' this.item.id', this.item.id)
            // }
            let data = []

            this.data.service.forEach((item, i) => {
                data.push({
                    basket_id: item.basket_id,
                    product_id: item.product_id,
                    count: item.count
                })
            })

            getBasketEstimatePrice(this.item.id, data).then(d => {
                let response = d.data
                // console.log('getBasketEstimatePrice response: ', response)

            })

        },









    },


}
</script>

<style scoped>

</style>

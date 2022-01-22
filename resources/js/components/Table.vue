<template>
  <div>
    <v-data-table
        v-model="selected"
        hide-default-footer
        :headers="headers"
        :items="desserts"
        item-key="name"
        :show-select="inputData.selected"
        :loading="loadTable"
        loading-text="Загрузка... Пожалуйста подождите"
        class="elevation-1"
    >
      <template v-slot:top>
        <v-toolbar
            flat
        >
          <v-toolbar-title>My CRUD</v-toolbar-title>
          <v-divider
              class="mx-4"
              inset
              vertical
          ></v-divider>
          <v-btn class="ma-2" v-if="inputData.archive" @click="archive"><span class="textDefault">Архивировать</span>
          </v-btn>
          <v-btn class="ma-2" v-if="inputData.changeStatus"><span class="textDefault">Изменить статус</span></v-btn>
          <v-btn class="ma-2" v-if="inputData.filter" @click="modalFilter = true"><span
              class="textDefault">Фильтр</span></v-btn>
          <v-spacer></v-spacer>
          <v-btn class="ma-2" color="primary" @click="openDialogItem({id:null})">
            <span class="textDefault">Создать</span>
          </v-btn>
          <v-dialog v-model="dialogDelete" max-width="500px">
            <v-card>
              <v-card-title class="headline">Are you sure you want to delete this item?</v-card-title>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" text @click="closeDelete">Cancel</v-btn>
                <v-btn color="blue darken-1" text @click="deleteItemConfirm">OK</v-btn>
                <v-spacer></v-spacer>
              </v-card-actions>
            </v-card>
          </v-dialog>
        </v-toolbar>
      </template>
      <template v-slot:item.name="{item}">
        <span class="linkApp" @click="openDialogItem(item)">{{ item.name }}</span>
      </template>
      <template v-slot:item.actions="{ item }">
        <v-icon
            class="ml-2"
            small
            @click="deleteItem(item)"
        >
          mdi-delete
        </v-icon>
      </template>
      <template v-slot:no-data>
        <v-btn
            color="primary"
            @click="initialize"
        >
          Перезагрузить
        </v-btn>
      </template>
    </v-data-table>
    <v-row justify="space-between" style="padding-top: 28px">
      <v-col cols="auto" style="display: flex; align-items: center;">
        Всего: {{ dataCunt }}
      </v-col>

      <v-col cols="auto">
        <v-btn icon color="orangeColor">
          <v-icon>mdi-chevron-left</v-icon>
        </v-btn>
        Страница: {{ pageActive }} из {{ count_pages }}
        <v-btn icon color="orangeColor">
          <v-icon>mdi-chevron-right</v-icon>
        </v-btn>
      </v-col>

      <v-col cols="auto" style="display: flex; align-items: center;">
        Отображать по:
        <v-btn color="black" icon v-bind:class=" count_items === 10 ? 'active' : '' "
               @click="changePortion(10)">10
        </v-btn>
        <v-btn color="black" icon v-bind:class=" count_items === 20 ? 'active' : '' "
               @click="changePortion(20)">20
        </v-btn>
        <v-btn color="black" icon v-bind:class="  count_items === 50 ? 'active' : '' "
               @click="changePortion(50)">50
        </v-btn>
      </v-col>
    </v-row>

    <v-dialog v-model="modalFilter" max-width="400px">
      <v-card>
        <v-card-title>Фильтр</v-card-title>
        <v-card-text>
          <v-autocomplete
              v-model="country"
              :rules="[() => !!country || 'This field is required']"
              :items="countries"
              label="Country"
              placeholder="Select..."
          ></v-autocomplete>
          <v-btn><span class="textDefault">Применить</span></v-btn>
        </v-card-text>
      </v-card>
    </v-dialog>
    <DialogItemTable v-if="dialogItemTable" :item="dialogItemActive" :allData="allData"/>
  </div>

</template>

<script>
import {getDataTable,} from "../api";
import DialogItemTable from "./DialogItemTable";

export default {
  name: "Table",
  components: {DialogItemTable,},
  props: ["inputData"],
  data: () => ({
    loadTable: false,
    allData: [],
    dataCunt: null,
    pageActive: 1,
    count_pages: null,
    count_items: 10,
    dialogItemActive: {},
    modalFilter: false,
    formFilter: {},
    country: null,
    countries: ['Дмитрий', 'Павел', 'Артем'],
    selected: [],
    dialog: false,
    dialogDelete: false,
    headers: [],
    desserts: [],
    editedIndex: -1,
    editedItem: {
      name: '',
      calories: 0,
      fat: 0,
      carbs: 0,
      protein: 0,
    },
    defaultItem: {
      name: '',
      calories: 0,
      fat: 0,
      carbs: 0,
      protein: 0,
    },
  }),

  computed: {
    formTitle() {
      return this.editedIndex === -1 ? 'New Item' : 'Edit Item'
    },
    dialogItemTable() {
      return this.$store.state.dialogItemTable
    }
  },

  watch: {
    dialog(val) {
      val || this.close()
    },
    dialogDelete(val) {
      val || this.closeDelete()
    },
    dateActive(val) {
      if (val === 'выбрать другую дату') {
        this.datePickerActive = true
      }
    }
  },
  methods: {
    openDialogItem(item) {
      this.dialogItemActive = item
      this.$store.commit('setDialogItemTable', true)
    },
    initialize() {
      this.loadTable = true
      const tamp = this.$route.path
      getDataTable(tamp).then(r => {
        if (r.status == 200) {
          this.headers = r.data.headers
          this.headers.push({text: 'Действия', value: 'actions', sortable: false})
          this.desserts = r.data.table
          this.allData = r.data
          // console.log('this.headers', this.headers)
          // console.log('this.desserts', this.desserts)
        }
        this.loadTable = false
      })
    },

    editItem(item) {
      this.editedIndex = this.desserts.indexOf(item)
      this.editedItem = Object.assign({}, item)
      this.dialog = true
    },

    deleteItem(item) {
      this.editedIndex = this.desserts.indexOf(item)
      this.editedItem = Object.assign({}, item)
      this.dialogDelete = true
    },

    deleteItemConfirm() {
      this.desserts.splice(this.editedIndex, 1)
      this.closeDelete()
    },

    close() {
      this.dialog = false
      this.$nextTick(() => {
        this.editedItem = Object.assign({}, this.defaultItem)
        this.editedIndex = -1
      })
    },

    closeDelete() {
      this.dialogDelete = false
      this.$nextTick(() => {
        this.editedItem = Object.assign({}, this.defaultItem)
        this.editedIndex = -1
      })
    },

    save() {
      if (this.editedIndex > -1) {
        Object.assign(this.desserts[this.editedIndex], this.editedItem)
      } else {
        this.desserts.push(this.editedItem)
      }
      this.close()
    },
    archive() {
      console.log("archive", this.selected)
      this.selected = []
    },
    changePortion(val) {
      this.count_items = val
    }
  },
  created() {
    this.initialize()
  },
  beforeDestroy() {
      console.log('this.inputData.selected: ', this.inputData.selected)
  }
}
</script>

<style scoped>
.active {
  color: #1976d2 !important;
}
</style>

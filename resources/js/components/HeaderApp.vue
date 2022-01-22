<template>
  <header class="header">
    <div class="logo" @click="$router.push('/')">
      <!-- <img src="../../../public/img/logo.png" alt="logo"> -->
    </div>
    <v-row justify="end" align="center">
      <v-col cols="auto" v-if="itemsFranchises !== false">
       <span
           class="textDefault">{{ activeFranchises ? activeFranchises : 'Все франшизы' }}</span>
      </v-col>
      <v-col cols="auto">
        <v-menu offset-y max-width="400px">
          <template v-slot:activator="{ on, attrs }">
            <v-btn
                icon
                small
                v-bind="attrs"
                v-on="on"
            >
              <v-icon small>{{ mdiBell }}</v-icon>
            </v-btn>
          </template>
          <div>
            <v-list three-line>
              <template v-for="(item, index) in items">
                <v-subheader
                    v-if="item.header"
                    :key="item.header"
                    v-text="item.header"
                ></v-subheader>

                <v-divider
                    v-else-if="item.divider"
                    :key="index"
                    :inset="item.inset"
                ></v-divider>

                <v-list-item
                    v-else
                    :key="item.title"
                >
                  <v-list-item-avatar>
                    <v-img :src="item.avatar"></v-img>
                  </v-list-item-avatar>

                  <v-list-item-content>
                    <v-list-item-title v-html="item.title"></v-list-item-title>
                    <v-list-item-subtitle v-html="item.subtitle"></v-list-item-subtitle>
                  </v-list-item-content>
                </v-list-item>
              </template>
            </v-list>
          </div>
        </v-menu>
      </v-col>
      <v-col cols="auto" style="display: flex;align-items: center;justify-content: flex-end">
        <v-menu
            bottom
            left
            offset-y>
          <template v-slot:activator="{ on, attrs }">
            <v-btn text v-on="on" v-bind="attrs">
              <span class="textDefault">{{ name }}</span>
              <v-icon
                  right
              >
                {{ mdiChevronDown }}
              </v-icon>
            </v-btn>
          </template>
          <v-list dense>
            <v-list-item
                link
                v-for="(item, index) in menuHeader"
                :key="index"
                v-if="item.title !== 'Выбрать франшизу'? true :(itemsFranchises !== false ? true : false)"
            >
              <v-list-item-title v-on:click="clickMenu(item.title)">{{ item.title }}</v-list-item-title>
            </v-list-item>
          </v-list>
        </v-menu>
      </v-col>
    </v-row>
    <v-dialog v-model="modal" max-width="280px">
      <v-card>
        <v-card-title>
          Вы точно хотите выйти?
        </v-card-title>
        <v-card-text>
          <v-btn class="ma-2"><span class="textDefault" @click="modal = false">Нет</span></v-btn>
          <v-btn class="ma-2"><span class="textDefault" @click="logOut">Да</span></v-btn>
        </v-card-text>
      </v-card>
    </v-dialog>
  </header>
</template>

<script>
import {mdiChevronDown} from '@mdi/js';
import {mdiBell} from '@mdi/js';
import {logOut} from "../api";

export default {
  name: "HeaderApp",
  data: () => ({
    mdiChevronDown,
    mdiBell,
    modal: false,
    menuHeader: [{title: 'Выбрать франшизу'}, {title: 'Настройки'}, {title: 'Выйти'},],
    items: [
      { header: 'Уведомления' },
      {
        avatar: 'https://cdn.vuetifyjs.com/images/lists/1.jpg',
        title: 'Brunch this weekend?',
        subtitle: `<span class="text--primary">Ali Connors</span> &mdash; I'll be in your neighborhood doing errands this weekend. Do you want to hang out?`,
      },
      { divider: true, inset: true },
      {
        avatar: 'https://cdn.vuetifyjs.com/images/lists/2.jpg',
        title: 'Summer BBQ <span class="grey--text text--lighten-1">4</span>',
        subtitle: `<span class="text--primary">to Alex, Scott, Jennifer</span> &mdash; Wish I could come, but I'm out of town this weekend.`,
      },
      { divider: true, inset: true },
      {
        avatar: 'https://cdn.vuetifyjs.com/images/lists/3.jpg',
        title: 'Oui oui',
        subtitle: '<span class="text--primary">Sandra Adams</span> &mdash; Do you have Paris recommendations? Have you ever been?',
      },
      { divider: true, inset: true },
      {
        avatar: 'https://cdn.vuetifyjs.com/images/lists/4.jpg',
        title: 'Birthday gift',
        subtitle: '<span class="text--primary">Trevor Hansen</span> &mdash; Have any ideas about what we should get Heidi for her birthday?',
      },
      { divider: true, inset: true },
      {
        avatar: 'https://cdn.vuetifyjs.com/images/lists/5.jpg',
        title: 'Recipe to try',
        subtitle: '<span class="text--primary">Britta Holt</span> &mdash; We should eat this: Grate, Squash, Corn, and tomatillo Tacos.',
      },
    ],
  }),
  computed: {
    name(){
      return  this.$store.state.currentUser.name
    },
    activeFranchises() {
      return this.$store.state.activeItemsFranchises
    },
    itemsFranchises() {
      return this.$store.state.itemsFranchises
    }
  },
  methods: {
    openDrawer() {
      this.$store.commit('setDrawer', true)
    },
    clickMenu(title) {
      switch (title) {
        case 'Настройки':
          this.$router.push('/settings')
          break;
        case 'Выйти':
          this.modal = true
          break;
        case 'Выбрать франшизу':
          this.openDrawer()
          break;
        default:
          break;
      }

    },
    logOut() {
      let token = document.getElementsByName("_token")[0].value
      console.log("token", token)
      logOut(token).then(r => {
      })
    }
  },
}
</script>

<style scoped lang="scss">
.header {
  box-shadow: 0 0 11px rgb(0 0 0 / 13%);
  position: relative;
  z-index: 10;
  display: flex;
  padding-right: 10px;
}

.logo {
  width: 240px;
  height: 56px;
  background: #404e67;
  position: relative;
  cursor: pointer;
  img{
    width: 100%;
    height: 100%;
  }
}
</style>

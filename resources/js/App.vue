<template>
  <div id="app">
    <v-app>
      <div class="itemCenter" v-if="loadingApp">
        <v-progress-circular
            indeterminate
            color="primary"
        ></v-progress-circular>
      </div>
      <component :is="layout" v-else>
        <router-view :layout.sync="layout"/>
      </component>
      <v-snackbar
          v-model="snackbar"
          :timeout="timeout"
          top
      >
        {{ snackbarText }}
        <template v-slot:action="{ attrs }">
          <v-btn
              color="blue"
              text
              v-bind="attrs"
              @click="snackbar = false"
          >
            <span class="textDefault">Закрыть</span>
          </v-btn>
        </template>
      </v-snackbar>
    </v-app>
  </div>
</template>

<script>
import {getCurrentUser, getFranchises, getNavBarList} from "./api";
import LayoutApp from "./Layout/LayoutApp";

export default {
  name: `App`,
  data() {
    return {
      layout: LayoutApp,
      timeout: 2000,
    };
  },
  computed: {
    snackbar: {
      get() {
        return this.$store.state.snackbar
      },
      set(val) {
        this.$store.commit('setSnackbar', val)
      }
    },
    snackbarText() {
      return this.$store.state.snackbarText
    },
    loadingApp() {
      return this.$store.state.loadingApp
    }
  },
  created() {
    if (this.$route.path !== '/login'){
      this.$store.commit('setLoadingApp', true)
      axios.all([getNavBarList(), getFranchises(), getCurrentUser()])
          .then(axios.spread((getNavBarList, getFranchises,getCurrentUser) => {
            if (getNavBarList.status == 200){
              this.$store.commit('setNavBar', getNavBarList.data)
            }
            if (getFranchises.status == 200) {
              this.$store.commit('setItemsFranchises', getFranchises.data)
            }
            if (getCurrentUser.status == 200) {
              this.$store.commit('setCurrentUser', getCurrentUser.data)
            }
            this.$store.commit('setLoadingApp', false)
          }))
    }
  }
};
</script>

<style lang="scss">
.itemCenter {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 100%;
  height: 100%;
}

.textDefault {
  text-transform: none;
}

.linkApp {
  transition: all 0.3s;
  color: #1976d2;
  cursor: pointer;

  &:hover {
    color: rgba(25, 118, 210, 0.8);
  }
}

.containerFull {
  width: 100%;
  height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
}

#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
}

#nav {
  padding: 30px;

  a {
    font-weight: bold;
    color: #2c3e50;

    &.router-link-exact-active {
      color: #42b983;
    }
  }
}
</style>

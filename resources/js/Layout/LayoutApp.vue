<template>
  <div class="LayoutDefault">
    <HeaderApp/>
    <main class="LayoutDefault__main">
      <div class="navBar">
        <v-list
            dense
            dark
            nav
            style="background-color: transparent"
        >
          <v-list-item
              v-for="item in navBar"
              :key="item.name"
              :to="`/${item.link}`"
          >
            <v-list-item-icon>
              <v-icon>{{ item.icon }}</v-icon>
            </v-list-item-icon>

            <v-list-item-content>
              <v-list-item-title>{{ item.name }}</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </v-list>
      </div>
      <div class="mainContent">
          <slot/>
      </div>
    </main>
    <footer class="LayoutDefault__footer">
      &copy; Awesome Company
    </footer>
    <Franchises/>
  </div>
</template>

<script>
import HeaderApp from "../components/HeaderApp";
import {getNavBarList} from "../api";
import Franchises from "../components/Franchises";

export default {
  name: `LayoutApp`,
  components: {Franchises, HeaderApp},
  data() {
    return {
    };
  },
  computed:{
    navBar(){
      return this.$store.state.navBar
    }
  },
  created() {
  }

};
</script>

<style lang="scss">


.LayoutDefault {
  min-height: 100vh;
  width: 100%;
  display: flex;
  flex-direction: column;

  &__main {
    display: grid;
    grid-template-columns: 240px 1fr;
    grid-template-rows: 100%;
    flex: 1 1 auto;
  }

  &__footer {
    padding-top: 1em;
    padding-bottom: 1em;
    border-top: 1px solid #c0c0c0;
  }

  .navBar {
    background: #404e67;
    height: 100%;
  }

  .mainContent {
    padding: 20px 0;
  }

}
</style>

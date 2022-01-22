<template>
  <v-navigation-drawer
      v-model="drawer"
      class="drawerFranchises"
      fixed
      right
      temporary
      v-if="items !== false"
  >
    <div class="contentDrawer">
      <div class="containerDrawer">
        <v-text-field

            hide-details
            label="Search"
            single-line
            solo
            :append-icon="mdiMagnify"
        ></v-text-field>
      </div>
      <v-divider></v-divider>
      <div class="containerDrawer" v-if="activeFranchises !== false">
        <v-btn ><span class="textDefault" @click="setAllFranchises">Выбрать все франшизы</span></v-btn>
      </div>
      <div class="containerDrawerContent" >
        <v-list
            dense
            nav
            subheader
            class="containerList"
        >
          <v-subheader>Мои франшизы:</v-subheader>
          <v-list-item
              :disabled="item.name == activeFranchises"
              v-for="(item, i) in items.filter(e=>e.mine == 1)"
              :key="i"
              link
              @click="selectedFranchises(item.name,item.id)"
          >
            <v-list-item-content>
              <v-list-item-title>{{ item.name }}</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </v-list>
        <v-divider></v-divider>
        <v-list
            class="containerList"
            dense
            subheader
            nav
            v-if="items.filter(e=>e.mine == 0).length"
        >
          <v-subheader>Все франшизы:</v-subheader>
          <v-list-item

              v-for="(item, i) in items.filter(e=>e.mine == 0)"
              :key="i"
              link
          >
            <v-list-item-content>
              <v-list-item-title>{{ item.name }}</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </v-list>
      </div>
    </div>

  </v-navigation-drawer>
</template>

<script>
import {mdiMagnify} from "@mdi/js";
import {getFranchises, updateFranchises} from "../api";

export default {
  name: "Franchises",
  data:()=>({
    mdiMagnify,
  }),
  computed: {
    drawer: {
      get() {
        return this.$store.state.drawer
      },
      set(val) {
        this.$store.commit('setDrawer', val)
      }
    },
    items(){
      return this.$store.state.itemsFranchises
    },
    activeFranchises(){
      return this.$store.state.activeItemsFranchises
    }
  },
  methods:{
    selectedFranchises(name,id){
      updateFranchises(id).then(r=>{
        if (r.status == 200){
          this.$store.commit('setActiveItemsFranchises',name)
          this.$store.commit('setDrawer',false)
        }
      })
    },
    setAllFranchises(){
      this.$store.commit('setActiveItemsFranchises',false)
      this.$store.commit('setDrawer',false)
    },
  },
  created() {

  }
}
</script>

<style scoped lang="scss">
.drawerFranchises{
  z-index: 15;
  width: 300px!important;
}
.contentDrawer{
  display: flex;
  flex-direction: column;
  height: 100vh!important;
  z-index: 15;
  width: 100%;
  overflow: hidden;
  position: relative;
}
.containerDrawer {
  width: 100%;
  padding: 20px;
  text-align: left;
}
.containerDrawerContent{
  width: 100%;
  padding: 20px;
  text-align: left;
  flex: 1 1 auto;
  display: flex;
  flex-direction: column;
  overflow-y: hidden;
  .containerList{
    background-color: transparent;
    overflow-y: auto;
    flex: 1 1 auto;
    &:first-child{
      max-height: 50%;
      flex: 0 0 auto;
    }
  }
}
</style>

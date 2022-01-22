<template>
  <div>
    <Table v-bind:inputData="inputData"/>
  </div>
</template>

<script>
import Table from "../components/Table";
import LayoutApp from "../Layout/LayoutApp.vue";

export default {
  name: "Orders",
  components: {Table},
  data:() => ({
    inputData:{
      archive:true,
      changeStatus:true,
      filter:true,
      selected:true,
    }
  }),
  created() {
  },
}
</script>

<style scoped>

</style>

<template>
  <div>
    <Table v-bind:inputData="inputData"/>
  </div>
</template>

<script>
import Table from "../components/Table";

export default {
  name: "Factories",
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
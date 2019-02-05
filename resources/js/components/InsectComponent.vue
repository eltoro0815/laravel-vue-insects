<template>
  <div class="col d-flex">
    <div class="row border align-items-end mt-4 ml-0 mr-0">
      <img
        :src="image"
        :alt="name | properCase"
        style="width:100%;max-width:400px;"
        class="p-2 mx-auto d-block"
      >

      <h3 class="pl-2 container-fluid text-center">
        <span>{{ name | properCase }}</span>
      </h3>

      <select class="custom-select m-2" @change="update">
        <option
          v-for="typ in [
            'ant',
            'bee',
            'bug',
            'butterfly', 
            'dragonfly', 
            'fly', 
            'grasshopper', 
            'ladybug',
            'mantis',
            'mosquito',
            'roach',
            'tick' 
            ]"
          :value="typ"
          :key="typ"
          :selected="typ === type ? 'selected' : ''"
        >{{ typ | properCase }}</option>
      </select>
      <button type="button" class="btn btn-primary btn-block m-2" @click="fn_delete">Delete</button>
    </div>
  </div>
</template>
<script>
export default {
  computed: {
    image() {
      return `/images/insects/${this.type}_400x400.png`;
    }
  },
  methods: {
    update(val) {
      this.$emit("update", this.id, val.target.selectedOptions[0].value);
    },
    fn_delete() {
      this.$emit("delete", this.id);
    }
  },
  props: ["id", "type", "name", "position"],
  filters: {
    properCase(string) {
      return string.charAt(0).toUpperCase() + string.slice(1);
    }
  }
};
</script>

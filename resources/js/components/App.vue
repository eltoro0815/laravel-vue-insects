<template>
  <div>
    <div class="container mt-4">
      <h2>You find {{insects.length | insects_unit}} in this spot.</h2>
    </div>
    <div class="container">
      <div class="row">
        <div class="col d-flex">
          <div class="row border align-items-end mt-4 ml-0 mr-0">
            <img src="images/random_400x400.png" alt="random" style="width:100%;max-width:400px;" class="p-2 mx-auto d-block">
            <button type="button" class="btn btn-primary btn-block m-2" @click="create">Add a random insect</button>
          </div>
        </div>

        <insect-component
          v-for="insect in insects"
          v-bind="insect"
          :key="insect.id"
          @update="update"
          @delete="del"
        ></insect-component>
      </div>
    </div>
  </div>
</template>

<script>
function Insect({ id, type, name }) {
  this.id = id;
  this.type = type;
  this.name = name;
}
import InsectComponent from "./InsectComponent.vue";
export default {
  data() {
    return {
      insects: [],
      mute: false
    };
  },

  filters: {
    insects_unit(value) {
      switch (value) {
        case 0:
          return "no insects";
          break;
        case 1:
          return "1 insect";
          break;
        default:
          return value + " insects";
          break;
      }
    }
  },

  methods: {

    create() {
      this.mute = true;
      window.axios.get("/api/insects/create").then(({ data }) => {
        this.insects.push(new Insect(data));
        this.mute = false;
      });
    },
    read() {
      this.mute = true;
      window.axios.get("/api/insects").then(({ data }) => {
        data.forEach(insect => {
          this.insects.push(new Insect(insect));
        });
        this.mute = false;
      });
    },
    update(id, color) {
      this.mute = true;
      window.axios.put(`/api/insects/${id}`, { type }).then(() => {
        this.insects.find(crud => crud.id === id).type = type;
        this.mute = false;
      });
    },
    del(id) {
      this.mute = true;
      window.axios.delete(`/api/insects/${id}`).then(() => {
        let index = this.insects.findIndex(insect => insect.id === id);
        this.insects.splice(index, 1);
        this.mute = false;
      });
    }
  },
  watch: {
    mute(value) {
      // %todo%
    }
  },
  components: {
    InsectComponent: InsectComponent
  },
  created() {
    this.read();
  }
};
</script>


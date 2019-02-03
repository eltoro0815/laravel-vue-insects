<template>
  <div>
    <div class="container mt-4">
      <h2>You find {{cruds.length | insects_unit}} in this spot.</h2>
    </div>
    <div class="container">
      <div class="row">
        <div class="col d-flex">
          <div class="row border align-items-end mt-4 ml-0 mr-0">
            <img src="images/random_400x400.png" alt="random" style="width:100%;max-width:400px;" class="p-2 mx-auto d-block">
            <button type="button" class="btn btn-primary btn-block m-2" @click="create">Add a random insect</button>
          </div>
        </div>

        <crud-component
          v-for="crud in cruds"
          v-bind="crud"
          :key="crud.id"
          @update="update"
          @delete="del"
        ></crud-component>
      </div>
    </div>
  </div>
</template>

<script>
function Crud({ id, color, name }) {
  this.id = id;
  this.color = color;
  this.name = name;
}
import CrudComponent from "./CrudComponent.vue";
export default {
  data() {
    return {
      cruds: [],
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
    test() {
      alert("test");
    },
    create() {
      this.mute = true;
      window.axios.get("/api/cruds/create").then(({ data }) => {
        this.cruds.push(new Crud(data));
        this.mute = false;
      });
    },
    read() {
      this.mute = true;
      window.axios.get("/api/cruds").then(({ data }) => {
        data.forEach(crud => {
          this.cruds.push(new Crud(crud));
        });
        this.mute = false;
      });
    },
    update(id, color) {
      this.mute = true;
      window.axios.put(`/api/cruds/${id}`, { color }).then(() => {
        this.cruds.find(crud => crud.id === id).color = color;
        this.mute = false;
      });
    },
    del(id) {
      this.mute = true;
      window.axios.delete(`/api/cruds/${id}`).then(() => {
        let index = this.cruds.findIndex(crud => crud.id === id);
        this.cruds.splice(index, 1);
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
    CrudComponent
  },
  created() {
    this.read();
  }
};
</script>


<template>
  <div class="vld-parent">
    <loading
      :active.sync="isLoading"
      :canCancel="canCancel"
      :is-full-page="fullPage"
      :height="height"
      :width="width"
      :color="color"
      :loader="loader"
      :background-color="bgColor"
    ></loading>
      <div class="container mt-4">
        <h2>You find {{insects.length | insects_unit}} in this spot.</h2>
        <button @click="create_insect" class="btn btn-primary" type="button">Add a random insect</button>
      </div>
      <div class="container">
        <draggable
          v-model="insects"
          :options="{draggable:'.item', animation:200, handle:'.my-handle'}"
          class="row"
          @change="update_insect_position"
        >
          <insect-component
            class="item"
            v-for="insect in insects"
            v-bind="insect"
            :key="insect.id"
            @update_insect_type="update_insect_type"
            @delete_insect="delete_insect"
          ></insect-component>
        </draggable>
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
import draggable from "vuedraggable";

// Import component
import Loading from "vue-loading-overlay";
// Import stylesheet
import "vue-loading-overlay/dist/vue-loading.css";

export default {
  components: {
    InsectComponent,
    draggable,
    Loading
  },

  data() {
    return {
      insects: [],
      isLoading: false,
      fullPage: true,
      canCancel: false,
      useSlot: false,
      loader: "spinner",
      color: "#007bff",
      bgColor: "#ffffff",
      height: 128,
      width: 128
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
          return `${value} insects`;
          break;
      }
    }
  },

  methods: {
    create_insect() {
      this.isLoading = true;
      window.axios.post("/api/insects").then(({ data }) => {
        this.insects.push(new Insect(data));
        this.isLoading = false;
      });
    },

    read() {
      this.isLoading = true;
      window.axios.get("/api/insects").then(({ data }) => {
        data.forEach(insect => {
          this.insects.push(new Insect(insect));
        });
        this.isLoading = false;
      });
    },

    update_insect_type(id, type) {
      this.isLoading = true;
      window.axios
        .patch(`/api/insects/${id}`, { type: type })
        .then(({ data }) => {
          this.insects.find(insect => insect.id === id).type = data.type;
          this.isLoading = false;
        });
    },

    update_insect_position(params) {
      this.isLoading = true;

      let insect_id = params.moved.element.id;

      if (params.moved.newIndex == 0) {
        // we will put the element to the front
        window.axios
          .patch(`/api/insects/${insect_id}`, { op: "move_to_first_position" })
          .then(() => {
            this.isLoading = false;
          });
      } else {
        // we get the new predecessor (newIndex-1) and put it just after it
        let new_predecessor_id = this.insects[params.moved.newIndex - 1].id;

        window.axios
          .patch(`/api/insects/${insect_id}`, {
            op: "move_after_element",
            predecessor_id: new_predecessor_id
          })
          .then(() => {
            this.isLoading = false;
          });
      }
    },

    delete_insect(id) {
      this.isLoading = true;
      window.axios.delete(`/api/insects/${id}`).then(() => {
        let index = this.insects.findIndex(insect => insect.id === id);
        this.insects.splice(index, 1);
        this.isLoading = false;
      });
    }
  },

  created() {
    this.read();
  }
};
</script>


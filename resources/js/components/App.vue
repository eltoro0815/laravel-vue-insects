<template>
    <div>
        <div class="container mt-4">
            <h2>You find {{insects.length | insects_unit}} in this spot.</h2>
            <button @click="create_insect" class="btn btn-primary" type="button">Add a random insect</button>
        </div>
        <div class="container">
            <draggable :list="insects" :options="{draggable:'.item', animation:200, handle:'.my-handle'}" class="row">
                <insect-component
                        class="item"
                        v-for="insect in insects"
                        v-bind="insect"
                        :key="insect.id"
                        @update_insect="update_insect"
                        @delete_insect="delete_insect"
                ></insect-component>
            </draggable>
        </div>
    </div>
</template>

<script>
    function Insect({id, type, name, position}) {
        this.id = id;
        this.type = type;
        this.name = name;
        this.position = position;
    }

    import InsectComponent from "./InsectComponent.vue";
    import draggable from 'vuedraggable'

    export default {
        components: {
            InsectComponent,
            draggable
        },

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

            create_insect() {
                this.mute = true;
                window.axios.get("/api/insects/create").then(({data}) => {
                    this.insects.push(new Insect(data));
                    this.mute = false;
                });
            },
            read() {
                this.mute = true;
                window.axios.get("/api/insects").then(({data}) => {
                    data.forEach(insect => {
                        this.insects.push(new Insect(insect));
                    });
                    this.mute = false;
                });
            },
            update_insect(id, type) {
                this.mute = true;
                window.axios.put(`/api/insects/${id}`, {type}).then(() => {
                    this.insects.find(insect => insect.id === id).type = type;
                    this.mute = false;
                });
            },
            delete_insect(id) {
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

        created() {
            this.read();
        }
    };
</script>


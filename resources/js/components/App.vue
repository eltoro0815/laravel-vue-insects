<template>
    <div>
        <div class="container mt-4">
            <h2>You find {{insects.length | insects_unit}} in this spot.</h2>
            <button @click="create_insect" class="btn btn-primary" type="button">Add a random insect</button>
        </div>
        <div class="container">
            <draggable v-model="insects" :options="{draggable:'.item', animation:200, handle:'.my-handle'}" class="row"
                       @change="update_insect_position">
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
    function Insect({id, type, name}) {
        this.id = id;
        this.type = type;
        this.name = name;
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
                        return `${value} insects`;
                        break;
                }
            }
        },

        methods: {

            create_insect() {
                this.mute = true;
                window.axios.post("/api/insects").then(({data}) => {
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

            update_insect_type(id, type) {
                this.mute = true;
                window.axios.patch(`/api/insects/${id}`, {"type": type})
                    .then(({data}) => {
                        this.insects.find(insect => insect.id === id).type = data.type;
                        this.mute = false;
                    });
            },

            update_insect_position(params) {
                this.mute = true;

                let insect_id = params.moved.element.id;

                if (params.moved.newIndex == 0) {
                    // we will put the element to the front
                    window.axios.patch(`/api/insects/${insect_id}`, {"op": "move_to_first_position"})
                        .then(() => {
                            this.mute = false;
                        });


                } else {
                    // we get the new predecessor (newIndex-1) and put it just after it
                    let new_predecessor_id = this.insects[params.moved.newIndex - 1].id;

                    window.axios.patch(`/api/insects/${insect_id}`, {
                        "op": "move_after_element",
                        "predecessor_id": new_predecessor_id
                    })
                        .then(() => {
                            this.mute = false;
                        });

                }
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
        }
        ,

        created() {
            this.read();
        }
    }
    ;
</script>


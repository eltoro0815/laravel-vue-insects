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
                <i class="fa fa-arrows my-handle"></i>
            </h3>

            <select class="custom-select m-2" @change="update_insect">
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
                >{{ typ | properCase }}
                </option>
            </select>
            <button type="button" class="btn btn-primary btn-block m-2" @click="delete_insect">Delete</button>
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
            update_insect(val) {
                this.$emit("update_insect", this.id, val.target.selectedOptions[0].value);
            },
            delete_insect() {
                this.$emit("delete_insect", this.id);
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

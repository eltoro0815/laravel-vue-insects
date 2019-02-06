<template>
    <div class="col d-flex">
        <div class="row border align-items-baseline mt-4 ml-0 mr-0">
            <img
                    :src="image"
                    :alt="name | properCase"
                    style="width:100%;max-width:400px;"
                    class="mx-auto d-block my-handle align-self-baseline"
            >

            <h3 class="container-fluid text-center align-self-baseline">
                <span>{{ name | properCase }}</span>
            </h3>
            <div class="align-self-end container-fluid">
                <select class="custom-select mb-1" @change="update_insect_type">
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
                <button type="button" class="mb-1 btn btn-primary btn-block" @click="delete_insect">Delete</button>
            </div>
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
            update_insect_type(val) {
                this.$emit("update_insect_type", this.id, val.target.selectedOptions[0].value);
            },
            delete_insect() {
                this.$emit("delete_insect", this.id);
            }
        },
        props: ["id", "type", "name"],
        filters: {
            properCase(string) {
                return string.charAt(0).toUpperCase() + string.slice(1);
            }
        }
    };
</script>

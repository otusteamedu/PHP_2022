<template>
    <div>
        <h2>Event list</h2>
        <template>
            <v-data-table
                :headers="headers"
                :items="items"
                :items-per-page="5"
                class="elevation-1"
            >
                <template v-slot:item.conditions="{item}">
                    <div :key="key" v-for="(item, key ) in item.conditions">
                        {{ item.name }} - {{ item.value }}
                    </div>
                </template>
                <template v-slot:item.action="{item}">
                    <div class="d-flex">
                        <v-btn @click="onRemoveItemById(item.id)" class="ml-auto">
                            <v-icon>mdi-trash-can-outline</v-icon>
                        </v-btn>
                    </div>
                </template>
            </v-data-table>
        </template>
    </div>
</template>

<script>

export default {
    name: "EventList",
    props: {
        items: {type: Array},
    },
    computed: {
        headers() {
            return [
                {text: 'name', value: 'name'},
                {text: 'priority', value: 'priority'},
                {text: 'conditions', value: 'conditions'},
                {text: '', value: 'action'},
            ]
        }
    },
    methods: {
        onRemoveItemById(id) {
            this.$emit('onDeleteEventById', id)
        }
    }
}
</script>

<style scoped>

</style>
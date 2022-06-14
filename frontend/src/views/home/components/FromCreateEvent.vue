<template>
    <div>
        <h2>Create event</h2>
        <v-form @submit.prevent="onSubmit">
            <v-row>
                <v-col cols="12">
                    <v-text-field label="Name"
                                  v-model="name"
                                  :error="errors.hasOwnProperty('name')"
                                  :error-messages="errors.hasOwnProperty('name') ? errors.name : ''"
                    ></v-text-field>
                </v-col>
                <v-col cols="12">
                    <v-text-field
                        type="number"
                        label="Priority"
                        v-model="priority"
                        :error="errors.hasOwnProperty('priority')"
                        :error-messages="errors.hasOwnProperty('priority') ? errors.priority : ''"
                    ></v-text-field>
                </v-col>
                <v-col cols="12">
                    <v-select
                        :items="events"
                        label="Event"
                        item-text="text"
                        item-value="value"
                        v-model="event"
                        :error="errors.hasOwnProperty('event')"
                        :error-messages="errors.hasOwnProperty('event') ? errors.event : ''"
                    ></v-select>
                </v-col>
                <v-col cols="12">
                    <h4>Conditions</h4>
                </v-col>
                <v-col cols="12">
                    <v-row class="pb-0">
                        <template v-for="(condition, index) in conditions">
                            <v-col cols="5" class="">
                                <v-text-field
                                    label="Name"
                                    v-model="condition.name"
                                    :error="errors.hasOwnProperty(`conditions.${index}.name`)"
                                    :error-messages="errors[`conditions.${index}.name`] ? errors[`conditions.${index}.name`] : ''"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="5" class="">
                                <v-text-field
                                    label="value"
                                    type="number"
                                    v-model="condition.value"
                                    :error="errors.hasOwnProperty(`conditions.${index}.value`)"
                                    :error-messages="errors[`conditions.${index}.value`] ? errors[`conditions.${index}.value`] : ''"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="2" class="pt-4 d-flex">
                                <v-btn @click="onRemoveConditionItem(index)" class="ml-auto">
                                    <v-icon>mdi-trash-can-outline</v-icon>
                                </v-btn>
                            </v-col>
                        </template>
                        <v-col cols="12" class="mb-4 d-flex" v-if="errors.hasOwnProperty('conditions')">
                            <span class="red--text">{{ errors.conditions }}</span>
                        </v-col>
                        <v-col cols="12" class="mb-4 d-flex" @click="onAddConditionItem">
                            <v-btn color="primary" class="ml-auto">Add</v-btn>
                        </v-col>
                        <v-col cols="12" class="mb-4 d-flex" v-if="errors.hasOwnProperty('other')">
                            <span class="red--text">{{ errors.other }}</span>
                        </v-col>
                    </v-row>
                </v-col>
            </v-row>
            <v-btn block color="success" type="submit">create</v-btn>
        </v-form>
    </div>
</template>

<script>
export default {
    name: "FromCreateEvent",
    props: {
        errors: {type: Object}
    },
    data() {
        return {
            events: [
                {text: 'send email notification', value: 1},
                {text: 'send telegram notification', value: 2},
                {text: 'send phone notification', value: 3},
                {text: 'send push notification', value: 4},
            ],
            name: '',
            priority: '',
            event: 0,
            conditions: [],
            condition: {name: '', value: ''},
        }
    },
    methods: {
        onSubmit() {
            this.$emit('submit', {
                data: {
                    'name': this.name,
                    'event': this.event,
                    'priority': this.priority,
                    'conditions': this.conditions,
                },
                clear: this.clear
            })
        },
        onAddConditionItem() {
            this.conditions.push({...this.condition})
        },
        onRemoveConditionItem(index) {
            this.conditions.splice(index, 1)
        },
        clear() {
            this.name = ''
            this.priority = ''
            this.event = 0
            this.conditions = []
        },
    },
    created() {
        this.conditions.push({...this.condition})
    }
}
</script>

<style scoped>

</style>
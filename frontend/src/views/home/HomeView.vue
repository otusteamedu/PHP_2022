<template>
    <simple-layout>
        <v-row>
            <v-col md="7">
                <event-list
                    :items="events"
                    @onDeleteEventById="onDeleteEventById"
                />
            </v-col>
            <v-col md="5">
                <from-create-event
                    :errors="formErrors"
                    @submit="createEventOnSubmit"
                />
            </v-col>
        </v-row>
    </simple-layout>
</template>

<script>
import {createEvent, deleteEventById, fetchEvents} from "@/api/apiEvents";
import SimpleLayout from "@/layouts/SimpleLayout";
import EventList from "@/views/home/components/EventList";
import FromCreateEvent from "@/views/home/components/FromCreateEvent";

export default {
    name: 'Home',
    components: {
        FromCreateEvent,
        EventList,
        SimpleLayout,
    },
    data() {
        return {
            events: [],
            formErrors: {},
        }
    },
    computed: {
        otherError() {
            return {'other': 'Something went wrong'}
        },
    },
    methods: {
        fetchEvents() {
            fetchEvents()
                .then(({data}) => {
                    this.events = data
                })
                .catch(e => {
                    console.log(e)
                })
        },
        onDeleteEventById(id) {
            deleteEventById({id})
                .then(res => {
                    if (res.code === 200) {
                        this.fetchEvents()
                        return
                    }
                })
                .catch(e => {

                })
        },
        createEventOnSubmit({data, clear}) {
            createEvent({data})
                .then(res => {
                    if (res.code === 422) {
                        this.formErrors = res.errors
                        return
                    }
                    if (res.code === 201) {
                        this.fetchEvents()
                        this.formErrors = {}
                        clear()
                        return
                    }
                    this.formErrors = this.otherError
                })
                .catch(e => {
                    this.formErrors = this.otherError
                })
        }
    },
    created() {
        this.fetchEvents()
    }
}
</script>

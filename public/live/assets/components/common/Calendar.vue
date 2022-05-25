<template>
    <div :class="classes">
        <full-calendar :options="calendarOptions" />
    </div>
</template>

<script>
/*eslint no-undef: 2*/
/* eslint-disable vue/no-unused-components */
import "@fullcalendar/core/vdom"; // solves problem with Vite
import FullCalendar from "@fullcalendar/vue3";
import dayGridPlugin from "@fullcalendar/daygrid";
import interactionPlugin from "@fullcalendar/interaction";

export default {
    components: {
    FullCalendar // make the <FullCalendar> tag available
  },
    props: {
        title: String,
        no_redirect: { type: Boolean, default: false },
        events: { type: Array, default: () => [] },
    },
    data() {
        return {
            calendarOptions: {
                plugins: [dayGridPlugin, interactionPlugin],
                initialView: "dayGridMonth",
                dateClick: this.handleDateClick,
                events: [
                    { title: "event 1", date: "2022-04-01" },
                    { title: "event 2", date: "2022-05-02" },
                ],
            },
        };
    },
    methods: {
        handleDateClick: function (arg) {
            alert("date click! " + arg.dateStr);
        },
    },
};
</script>

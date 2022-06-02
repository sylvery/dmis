// import "@fullcalendar/daygrid/main.min.css";
// import "@fullcalendar/list/main.min.css";
// import { FullCalendar } from '@fullcalendar/core';
// import "@fullcalendar/list";
// import "@fullcalendar/daygrid";
// import "@fullcalendar/timegrid";
// import "@fullcalendar/scrollgrid";
// import '@fullcalendar/google-calendar';
document.addEventListener('DOMContentLoaded', () => {
    var calendarEl = document.getElementById('calendar-holder');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        // plugins: [ googleCalendarPlugin ],
        googleCalendarApiKey: 'AIzaSyBg_VzVTjFbtj_HOR0gD4ezwauecDzPRz0',
        events: {
          googleCalendarId: 'ambuturup1987@gmail.com'
        },
        // eventSources: [
        //     {
        //         googleCalendarId: 'abcd1234@group.calendar.google.com'
        //     },
        //     {
        //         googleCalendarId: 'efgh5678@group.calendar.google.com',
        //         className: 'nice-event'
        //     }
        // ],
        // defaultView: 'timeGridWeek',
        // editable: false,
        // eventSources: [
        //     {
        //         url: "/fc-load-events",
        //         method: "POST",
        //         extraParams: {
        //             filters: JSON.stringify({})
        //         },
        //         failure: () => {
        //             // alert("There was an error while fetching FullCalendar!");
        //         },
        //     },
        // ],
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay',
        },
        plugins: [ googleCalendarPlugin, 'interaction', 'dayGrid', 'timeGrid' ], // https://fullcalendar.io/docs/plugin-index
        timeZone: 'UTC+10',
    });
    calendar.render();
});
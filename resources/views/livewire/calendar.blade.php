<div class="w-full">
    {{-- Changed overflow-hidden to overflow-x-auto so it can scroll sideways if needed --}}
    <div id='calendar-container' class="bg-white p-3 sm:p-6 shadow-sm border border-slate-200 mt-8 rounded-2xl w-full max-w-full overflow-x-auto">
        <div id='calendar' class="min-w-full"></div>
    </div>
</div>

@push('scripts')
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.3.1/main.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.3.1/locales-all.min.js'></script>

    <script>
        document.addEventListener('livewire:load', function() {
            var Calendar = FullCalendar.Calendar;
            var calendarEl = document.getElementById('calendar');
            var data = @this.events;

            var calendarOptions = {
                headerToolbar: {
                    left: 'prev,next',
                    center: 'title',
                    right: 'today'
                },
                initialView: 'dayGridMonth',
                locale: '{{ App::getLocale() }}',
                events: JSON.parse(data),
                height: 'auto',
                contentHeight: 'auto',
                expandRows: true,

                dateClick: function(info) {
                    if (!isUserAdmin()) return;
                    var title = prompt('Enter Event Title');
                    var start = new Date(info.dateStr);

                    if (title != null && title != '') {
                        var endTimeString = prompt('Enter Event End Time (HH:mm)');
                        var endTime;
                        if (endTimeString) {
                            endTime = new Date(start.toDateString() + ' ' + endTimeString);
                        } else {
                            start.setHours(0, 0, 0, 0);
                            endTime = new Date(start.getFullYear(), start.getMonth(), start.getDate(), 23, 59, 59);
                        }

                        if (!isNaN(endTime.getTime())) {
                            calendar.addEvent({
                                title: title,
                                start: start,
                                end: endTime,
                            });
                            @this.addevent({ title: title, start: start , end: endTime});
                        } else {
                            alert('Invalid End Time');
                        }
                    }
                },
                editable: isUserAdmin(),
                selectable: isUserAdmin(),
                displayEventTime: false,
                eventDrop: info => @this.eventDrop(info.event, info.oldEvent),
                eventClick: function(info) {
                    if (!isUserAdmin()) return;
                    if (confirm("Are you sure you want to delete this event?")) {
                        @this.deleteEvent(info.event.id);
                    }
                }
            };

            var calendar = new Calendar(calendarEl, calendarOptions);
            calendar.render();

            @this.on(`refreshCalendar`, () => {
                calendar.refetchEvents();
            });

            function isUserAdmin() {
                @if(auth()->user()->isAdmin() || auth()->user()->isTeacher())
                    return true;
                @else
                    return false;
                @endif
            }
        });
    </script>
@endpush

<style>
    /* =========================================
       FORCE FULLCALENDAR TO BE RESPONSIVE
       ========================================= */

    /* 1. Force all tables to fit 100% of the screen */
    .fc table {
        width: 100% !important;
        table-layout: fixed !important;
        min-width: 0 !important;
    }

    /* 2. Remove thick borders */
    .fc-scrollgrid {
        border: none !important;
    }
    .fc-theme-standard td, .fc-theme-standard th {
        border-color: #f1f5f9 !important;
    }

    /* 3. Toolbar Styling */
    .fc .fc-toolbar.fc-header-toolbar {
        margin-bottom: 1rem !important;
        display: flex !important;
        flex-wrap: wrap !important;
        gap: 10px;
    }
    .fc .fc-toolbar-title {
        font-size: 1.2rem !important;
        font-weight: 800 !important;
        color: #0f172a;
    }
    .fc .fc-button {
        background-color: #0f172a !important;
        border: none !important;
        border-radius: 8px !important;
        padding: 6px 12px !important;
        font-size: 0.8rem !important;
        font-weight: 600 !important;
        text-transform: capitalize !important;
    }
    .fc .fc-button:hover {
        background-color: #334155 !important;
    }

    /* 4. Fix Header Text Overflow (This fixes the Bengali text getting cut off) */
    .fc .fc-col-header-cell-cushion {
        display: block !important;
        white-space: normal !important;
        word-break: break-word !important; /* Allows text to wrap */
        font-size: 0.75rem !important;
        font-weight: 700;
        color: #475569;
        padding: 4px !important;
    }

    /* 5. Mobile Specific Overrides */
    @media (max-width: 767.98px) {
        /* Shrink the grid and numbers so they fit */
        .fc .fc-daygrid-day-number {
            font-size: 0.75rem !important;
            padding: 4px !important;
        }
        .fc .fc-daygrid-day-frame {
            min-height: 50px !important; /* Keeps cells compact */
        }
        .fc .fc-daygrid-event {
            font-size: 0.65rem !important;
            padding: 1px 2px !important;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    }
</style>

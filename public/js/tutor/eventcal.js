const prevMonthYear = document.getElementById("prev-month-year");
const currentMonthYear = document.getElementById("current-month-year");
const nextMonthYear = document.getElementById("next-month-year");

const prevDaysContainer = document.getElementById("prev-days");
const currentDaysContainer = document.getElementById("current-days");
const nextDaysContainer = document.getElementById("next-days");

const prevButton = document.getElementById("prev");
const nextButton = document.getElementById("next");

let currentDate = new Date();

function renderCalendar(calendarId, monthYearId, date) {
    const month = date.getMonth();
    const year = date.getFullYear();

    // Set month and year in header
    monthYearId.textContent = `${date.toLocaleString('default', { month: 'long' })} ${year}`;

    // Get the first day of the month
    const firstDay = new Date(year, month, 1).getDay();
    const lastDate = new Date(year, month + 1, 0).getDate();

    // Clear previous dates
    calendarId.innerHTML = "";

    // Add empty slots for days of previous month
    for (let i = 0; i < firstDay; i++) {
        const emptyCell = document.createElement("div");
        emptyCell.classList.add("empty");
        calendarId.appendChild(emptyCell);
    }

    // Add day cells for current month
    for (let day = 1; day <= lastDate; day++) {
        const dayCell = document.createElement("div");
        dayCell.classList.add("day");
        dayCell.textContent = day;

        // Highlight today's date and add a special class
        if (
            day === currentDate.getDate() &&
            month === new Date().getMonth() &&
            year === new Date().getFullYear()
        ) {
            dayCell.classList.add("selected", "current-date");
        }

        dayCell.addEventListener("click", () => selectDate(dayCell));
        calendarId.appendChild(dayCell);
    }
}

function updateCalendars() {
    const prevMonthDate = new Date(currentDate);
    prevMonthDate.setMonth(currentDate.getMonth() - 1);

    const nextMonthDate = new Date(currentDate);
    nextMonthDate.setMonth(currentDate.getMonth() + 1);

    renderCalendar(prevDaysContainer, prevMonthYear, prevMonthDate);
    renderCalendar(currentDaysContainer, currentMonthYear, currentDate);
    renderCalendar(nextDaysContainer, nextMonthYear, nextMonthDate);

    fetchAndMarkEvents(prevDaysContainer, prevMonthDate.getMonth() + 1, prevMonthDate.getFullYear());
    fetchAndMarkEvents(currentDaysContainer, currentDate.getMonth() + 1, currentDate.getFullYear());
    fetchAndMarkEvents(nextDaysContainer, nextMonthDate.getMonth() + 1, nextMonthDate.getFullYear());

    // Add click listeners to marked dates
    addClickListenersToMarkedDates();
}

function selectDate(dayCell) {
    // Check if the day has events (if it has upcoming-event or previous-event class)
    if (dayCell.classList.contains("upcoming-event") || dayCell.classList.contains("previous-event")) {
        const selectedDate = dayCell.dataset.date;
        if (selectedDate) {
            highlightRowsForDate(selectedDate);
        }
    }
}

prevButton.addEventListener("click", () => {
    currentDate.setMonth(currentDate.getMonth() - 1);
    updateCalendars();
});

nextButton.addEventListener("click", () => {
    currentDate.setMonth(currentDate.getMonth() + 1);
    updateCalendars();
});

// Initial render
updateCalendars();

function fetchAndMarkEvents(calendarId, month, year) {
    fetch(`/tutor-event/get-event-dates-in-month?month=${month}&year=${year}`)
        .then(response => response.json())
        .then(data => {
            markEventDates(calendarId, data);
        })
        .catch(error => console.error('Error fetching event dates:', error));
}

function markEventDates(calendarId, dates) {
    const calendarDays = calendarId.querySelectorAll('.day');
    dates.forEach(event => {
        const eventDate = new Date(event.scheduled_date);
        const day = eventDate.getDate();

        calendarDays.forEach(dayElement => {
            if (parseInt(dayElement.textContent) === day) {
                dayElement.dataset.date = eventDate.toISOString().split('T')[0]; // Add data-date attribute
                if (event.session_status === 'scheduled') {
                    dayElement.classList.add('upcoming-event');
                } else if (event.session_status === 'completed') {
                    dayElement.classList.add('previous-event');
                }
            }
        });
    });
}

function addClickListenersToMarkedDates() {
    const markedDays = document.querySelectorAll('.day.upcoming-event, .day.previous-event');
    markedDays.forEach(day => {
        day.addEventListener('click', () => {
            const selectedDate = day.dataset.date;
            highlightRowsForDate(selectedDate);
        });
    });
}

function highlightRowsForDate(selectedDate) {
    // Remove existing highlights
    document.querySelectorAll('.event-row').forEach(row => row.classList.remove('highlight'));

    // Format the selected date for comparison
    const formattedSelectedDate = formatDate(selectedDate);
    console.log('Selected Date:', formattedSelectedDate);

    // Check upcoming events first
    const upcomingRows = document.querySelectorAll('#upcoming-events tbody tr');
    let upcomingFound = false;
    upcomingRows.forEach(row => {
        const eventDate = row.querySelector('td:nth-child(4)').textContent.trim();
        console.log('Upcoming Event Date:', eventDate);
        if (eventDate === formattedSelectedDate) {
            row.classList.add('highlight');
            upcomingFound = true;
        }
    });

    // Then check previous events
    const previousRows = document.querySelectorAll('#previous-events tbody tr');
    let previousFound = false;
    previousRows.forEach(row => {
        const eventDate = row.querySelector('td:nth-child(4)').textContent.trim();
        console.log('Previous Event Date:', eventDate);
        if (eventDate === formattedSelectedDate) {
            row.classList.add('highlight');
            previousFound = true;
        }
    });

    // Switch to the appropriate tab and scroll to the highlighted row
    if (upcomingFound) {
        showUpcoming();
        setTimeout(() => {
            document.querySelector('#upcoming-events tbody tr.highlight').scrollIntoView({ 
                behavior: 'smooth', 
                block: 'center' 
            });
        }, 100);
    } else if (previousFound) {
        showPrevious();
        setTimeout(() => {
            document.querySelector('#previous-events tbody tr.highlight').scrollIntoView({ 
                behavior: 'smooth', 
                block: 'center' 
            });
        }, 100);
    }
}

// Replace only this function in your code
function formatDate(dateString) {
    const date = new Date(dateString);
    
    // Format the day with leading zero if needed
    const day = date.getDate().toString().padStart(2, '0');
    
    // Get month abbreviation (Jan, Feb, etc.)
    const monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    const month = monthNames[date.getMonth()];
    
    const year = date.getFullYear();
    
    // Format as "DD MMM YYYY" (e.g., "26 Apr 2025")
    return `${day} ${month} ${year}`;
}
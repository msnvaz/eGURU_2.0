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

    
    monthYearId.textContent = `${date.toLocaleString('default', { month: 'long' })} ${year}`;

    
    const firstDay = new Date(year, month, 1).getDay();
    const lastDate = new Date(year, month + 1, 0).getDate();

    
    calendarId.innerHTML = "";

    
    for (let i = 0; i < firstDay; i++) {
        const emptyCell = document.createElement("div");
        emptyCell.classList.add("empty");
        calendarId.appendChild(emptyCell);
    }

    
    for (let day = 1; day <= lastDate; day++) {
        const dayCell = document.createElement("div");
        dayCell.classList.add("day");
        dayCell.textContent = day;

        
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

    
    addClickListenersToMarkedDates();
}

function selectDate(dayCell) {
    
    const today = new Date();
    const isToday =
        parseInt(dayCell.textContent) === today.getDate() &&
        currentDate.getMonth() === today.getMonth() &&
        currentDate.getFullYear() === today.getFullYear();

    
    if (!isToday) {
        return;
    }

    
    document.querySelectorAll(".day").forEach(day => {
        if (day.classList.contains("current-date")) {
            day.classList.add("selected");
        } else {
            day.classList.remove("selected");
        }
    });
}

prevButton.addEventListener("click", () => {
    currentDate.setMonth(currentDate.getMonth() - 1);
    updateCalendars();
});

nextButton.addEventListener("click", () => {
    currentDate.setMonth(currentDate.getMonth() + 1);
    updateCalendars();
});


updateCalendars();

function toggleDetails(row) {
    const detailsRow = row.nextElementSibling;
    if (detailsRow && detailsRow.classList.contains('details-row')) {
        detailsRow.style.display = detailsRow.style.display === 'table-row' ? 'none' : 'table-row';
    }
}

function showUpcoming() {
    document.getElementById('upcoming-events').style.display = 'block';
    document.getElementById('previous-events').style.display = 'none';
    document.getElementById('upcoming-tab').classList.add('active');
    document.getElementById('previous-tab').classList.remove('active');
}

function showPrevious() {
    document.getElementById('upcoming-events').style.display = 'none';
    document.getElementById('previous-events').style.display = 'block';
    document.getElementById('upcoming-tab').classList.remove('active');
    document.getElementById('previous-tab').classList.add('active');
}

function viewEventDetails(event) {
    const detailsContent = document.getElementById('event-details-content');

    let tutorPhotoHtml = '';
    if (event.tutor_profile_photo) {
        tutorPhotoHtml = `<img src="/images/tutor_uploads//tutor_profile_photos/${event.tutor_profile_photo}" alt="${event.tutor_name}" class="tutor-photo">`;
    }

    let meetingLinkHtml = '';
    if (event.meeting_link) {
        meetingLinkHtml = `<p><strong>Meeting Link:</strong> <a href="${event.meeting_link}" target="_blank" class="meeting-link">Join Meeting</a></p>`;
    }

    detailsContent.innerHTML = `
    ${tutorPhotoHtml}
        <p><strong>Session ID:</strong> ${event.session_id}</p> <!-- Display Session ID -->
        <p><strong>Subject:</strong> ${event.subject_name}</p>
        <p><strong>Instructor:</strong> ${event.tutor_name}</p>
        <p><strong>Grade:</strong> ${event.grade || 'N/A'}</p>
        <p><strong>Date:</strong> ${new Date(event.scheduled_date).toLocaleDateString()}</p>
        <p><strong>Time:</strong> ${event.schedule_time}</p>
        ${meetingLinkHtml}
    `;

    document.getElementById('event-details-modal').style.display = 'block';
}

function closeEventDetails() {
    document.getElementById('event-details-modal').style.display = 'none';
}

window.onclick = function(event) {
    const modal = document.getElementById('event-details-modal');
    if (event.target === modal) {
        closeEventDetails();
    }
}

function fetchAndMarkEvents(calendarId, month, year) {
    fetch(`/student-events/get-event-dates-in-month?month=${month}&year=${year}`)
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
                dayElement.dataset.date = eventDate.toISOString().split('T')[0]; 
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
    
    document.querySelectorAll('.event-row').forEach(row => row.classList.remove('highlight'));

    
    const formattedSelectedDate = formatDate(selectedDate);
    console.log('Selected Date:', formattedSelectedDate);

    
    const upcomingRows = document.querySelectorAll('#upcoming-events tbody tr');
    let rowFound = false;
    upcomingRows.forEach(row => {
        const eventDate = row.querySelector('td:nth-child(3)').textContent.trim();
        console.log('Upcoming Event Date:', eventDate);
        if (eventDate === formattedSelectedDate) {
            row.classList.add('highlight');
            row.scrollIntoView({ behavior: 'smooth', block: 'center' });
            rowFound = true;
        }
    });

    
    if (!rowFound) {
        const previousRows = document.querySelectorAll('#previous-events tbody tr');
        previousRows.forEach(row => {
            const eventDate = row.querySelector('td:nth-child(4)').textContent.trim();
            console.log('Previous Event Date:', eventDate);
            if (eventDate === formattedSelectedDate) {
                row.classList.add('highlight');
                row.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        });
    }
}

  
function formatDate(dateString) {
    const options = { day: '2-digit', month: 'short', year: 'numeric' };
    return new Date(dateString).toLocaleDateString('en-US', options);
}
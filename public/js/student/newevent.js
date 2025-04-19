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
        dayCell.addEventListener("click", () => selectDate(dayCell));

        // Highlight today's date
        if (
            day === currentDate.getDate() &&
            month === new Date().getMonth() &&
            year === new Date().getFullYear()
        ) {
            dayCell.classList.add("selected");
        }

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
}

function selectDate(dayCell) {
    // Remove 'selected' class from previously selected date
    document.querySelectorAll(".day").forEach(day => day.classList.remove("selected"));
    // Add 'selected' class to clicked date
    dayCell.classList.add("selected");
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


  // JavaScript to toggle event details
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
        tutorPhotoHtml = `<img src=\"images/student-uploads/${event.tutor_profile_photo}" alt="${event.tutor_name}" class="tutor-photo">`;
    }

    let meetingLinkHtml = '';
    if (event.meeting_link) {
        meetingLinkHtml = `<p><strong>Meeting Link:</strong> <a href="${event.meeting_link}" target="_blank" class="meeting-link">Join Meeting</a></p>`;
    }

    detailsContent.innerHTML = `
        ${tutorPhotoHtml}
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
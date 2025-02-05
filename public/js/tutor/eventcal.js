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



function toggleContent(contentType) {
    const upcomingTab = document.getElementById('upcoming-tab');
    const previousTab = document.getElementById('previous-tab');
    const upcomingContent = document.getElementById('upcoming-content');
    const previousContent = document.getElementById('previous-content');

    if (contentType === 'upcoming') {
        upcomingTab.classList.add('active');
        previousTab.classList.remove('active');
        upcomingContent.classList.add('active');
        previousContent.classList.remove('active');
    } else {
        previousTab.classList.add('active');
        upcomingTab.classList.remove('active');
        previousContent.classList.add('active');
        upcomingContent.classList.remove('active');
    }
}


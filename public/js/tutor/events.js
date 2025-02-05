function generateCalendar(calendarId, monthYearId, year, month) {
    const daysContainer = document.getElementById(calendarId);
    const monthYearContainer = document.getElementById(monthYearId);
    daysContainer.innerHTML = ""; // Clear existing days

    const monthNames = [
        "January", "February", "March", "April", "May", "June",
        "July", "August", "September", "October", "November", "December"
    ];

    // Set month and year in the header
    monthYearContainer.innerText = `${monthNames[month]} ${year}`;

    // Get first day and total days in the month
    const firstDay = new Date(year, month, 1).getDay();
    const totalDays = new Date(year, month + 1, 0).getDate();

    // Add blank days for days before the first day of the month
    for (let i = 0; i < firstDay; i++) {
        const emptyCell = document.createElement("div");
        emptyCell.className = "empty";
        daysContainer.appendChild(emptyCell);
    }

    // Add days of the month
    for (let day = 1; day <= totalDays; day++) {
        const dayCell = document.createElement("div");
        dayCell.className = "day";
        dayCell.innerText = day;
        daysContainer.appendChild(dayCell);
    }
}

function initializeCalendars() {
    const currentDate = new Date();
    const currentYear = currentDate.getFullYear();
    const currentMonth = currentDate.getMonth();

    // Previous month
    const prevMonthDate = new Date(currentYear, currentMonth - 1);
    generateCalendar(
        "prevDays",
        "prevMonthYear",
        prevMonthDate.getFullYear(),
        prevMonthDate.getMonth()
    );

    // Current month
    generateCalendar(
        "currentDays",
        "currentMonthYear",
        currentYear,
        currentMonth
    );

    // Next month
    const nextMonthDate = new Date(currentYear, currentMonth + 1);
    generateCalendar(
        "nextDays",
        "nextMonthYear",
        nextMonthDate.getFullYear(),
        nextMonthDate.getMonth()
    );
}

// Initialize calendars on page load
window.onload = initializeCalendars;

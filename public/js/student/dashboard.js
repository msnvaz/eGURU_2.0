// Variables for Calendar
const monthYear = document.getElementById("monthYear");
const daysContainer = document.getElementById("days");
const prevButton = document.getElementById("prev");
const nextButton = document.getElementById("next");

let currentDate = new Date();

function renderCalendar() {
    const month = currentDate.getMonth();
    const year = currentDate.getFullYear();

    // Set month and year in header
    monthYear.textContent = `${currentDate.toLocaleString('default', { month: 'long' })} ${year}`;

    // Get the first day of the month
    const firstDay = new Date(year, month, 1).getDay();
    const lastDate = new Date(year, month + 1, 0).getDate();

    // Clear previous dates
    daysContainer.innerHTML = "";

    // Add empty slots for days of previous month
    for (let i = 0; i < firstDay; i++) {
        const emptyCell = document.createElement("div");
        emptyCell.classList.add("day");
        daysContainer.appendChild(emptyCell);
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
        
        daysContainer.appendChild(dayCell);
    }
}

function selectDate(dayCell) {
    // Remove 'selected' class from previously selected date
    document.querySelectorAll(".day").forEach(day => day.classList.remove("selected"));
    // Add 'selected' class to clicked date
    dayCell.classList.add("selected");
}

prevButton.addEventListener("click", () => {
    currentDate.setMonth(currentDate.getMonth() - 1);
    renderCalendar();
});

nextButton.addEventListener("click", () => {
    currentDate.setMonth(currentDate.getMonth() + 1);
    renderCalendar();
});

// Initial render
renderCalendar();







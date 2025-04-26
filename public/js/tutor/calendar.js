const monthYear = document.getElementById("monthYear");
const daysContainer = document.getElementById("days");
const prevButton = document.getElementById("prev");
const nextButton = document.getElementById("next");

class Calendar {
    constructor() {
        this.currentDate = new Date();
        this.selectedDate = null;
        this.monthNames = [
            'January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'October', 'November', 'December'
        ];
        this.init();
    }

    init() {
        this.renderCalendar();
        this.fetchEventDates();

        prevButton.addEventListener("click", () => {
            this.currentDate.setMonth(this.currentDate.getMonth() - 1);
            this.renderCalendar();
            this.fetchEventDates();
        });

        nextButton.addEventListener("click", () => {
            this.currentDate.setMonth(this.currentDate.getMonth() + 1);
            this.renderCalendar();
            this.fetchEventDates();
        });
    }

    renderCalendar() {
        const month = this.currentDate.getMonth();
        const year = this.currentDate.getFullYear();
        
        // Set month and year in header
        monthYear.textContent = `${this.monthNames[month]} ${year}`;
        
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
        const today = new Date();
        for (let day = 1; day <= lastDate; day++) {
            const dayCell = document.createElement("div");
            dayCell.classList.add("day");
            dayCell.textContent = day;
            
            // Add data attribute for easier date comparison
            dayCell.dataset.day = day;
            dayCell.dataset.month = month + 1;
            dayCell.dataset.year = year;
            
            // Event listener for day selection
            dayCell.addEventListener("click", () => this.selectDate(dayCell, day));
            
            // Highlight today's date - check both "today" and "selected" classes
            if (
                day === today.getDate() &&
                month === today.getMonth() &&
                year === today.getFullYear()
            ) {
                dayCell.classList.add("today");
                dayCell.classList.add("selected"); // Also add selected to today by default
                this.selectedDate = new Date(year, month, day);
            }
            
            daysContainer.appendChild(dayCell);
        }
        
        // Debug output to ensure the function is running
        console.log("Calendar rendered for", month + 1, year);
    }

    selectDate(dayCell, day) {
        // Remove 'selected' class from previously selected date
        document.querySelectorAll(".day.selected").forEach(cell => cell.classList.remove("selected"));
        
        // Add 'selected' class to clicked date
        dayCell.classList.add("selected");
        
        // Store the selected date
        this.selectedDate = new Date(this.currentDate.getFullYear(), this.currentDate.getMonth(), day);
        
        // Show events for the selected date
        this.showEventsForDate(this.selectedDate);
    }

    fetchEventDates() {
        const month = this.currentDate.getMonth() + 1;
        const year = this.currentDate.getFullYear();

        // Debug output to confirm fetch is being called
        console.log("Fetching events for", month, year);

        fetch(`/tutor-event/get-event-dates-in-month?month=${month}&year=${year}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log("Event data received:", data);
                this.markEventDates(data);
            })
            .catch(error => {
                console.error('Error fetching event dates:', error);
                
            });
    }

    

    markEventDates(dates) {
        if (!Array.isArray(dates) || dates.length === 0) {
            console.log("No event dates to mark or invalid data format");
            return;
        }

        const dayCells = document.querySelectorAll('.day');
        
        dates.forEach(event => {
            try {
                const eventDate = new Date(event.scheduled_date);
                if (isNaN(eventDate.getTime())) {
                    console.error("Invalid date format:", event.scheduled_date);
                    return;
                }
                
                const day = eventDate.getDate();
                
                dayCells.forEach(dayCell => {
                    if (dayCell.textContent && parseInt(dayCell.textContent) === day) {
                        console.log(`Marking day ${day} as event day`);
                        
                        // Add the appropriate class for upcoming or previous events
                        const eventClass = event.session_status === 'scheduled' ? 'upcoming-event' : 'previous-event';
                        dayCell.classList.add(eventClass);
                        
                        // Add a visual indicator for events
                        if (!dayCell.querySelector('.event-indicator')) {
                            const indicator = document.createElement('div');
                            indicator.className = 'event-indicator';
                            dayCell.appendChild(indicator);
                        }
                    }
                });
            } catch (error) {
                console.error("Error processing event date:", error, event);
            }
        });
    }

    showEventsForDate(date) {
        const formattedDate = date.toISOString().split('T')[0];
        window.location.href = `/tutor-event?date=${formattedDate}`;
    }
}

// Initialize calendar when the page loads
document.addEventListener('DOMContentLoaded', () => {
    const calendar = new Calendar();
    
    // Add some CSS for event indicators if not already in your stylesheet
    const style = document.createElement('style');
    style.textContent = `
        .day.today {
            background-color: #e6f7ff;
            font-weight: bold;
        }
        .day.selected {
            background-color: #1890ff;
            color: white;
        }
        .day.upcoming-event {
            position: relative;
        }
        .day.previous-event {
            position: relative;
        }
        .event-indicator {
            position: absolute;
            bottom: 2px;
            left: 50%;
            transform: translateX(-50%);
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background-color: #1890ff;
        }
        .upcoming-event .event-indicator {
            background-color: #003399;
        }
        .previous-event .event-indicator {
            background-color: #faad14;
        }
    `;
    document.head.appendChild(style);
});
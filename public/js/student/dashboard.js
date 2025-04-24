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
        this.updateMonthDisplay();
        this.renderCalendar();
        this.fetchEventDates();

        document.getElementById('prevMonth').addEventListener('click', () => {
            this.currentDate.setMonth(this.currentDate.getMonth() - 1);
            this.updateMonthDisplay();
            this.renderCalendar();
            this.fetchEventDates();
        });

        document.getElementById('nextMonth').addEventListener('click', () => {
            this.currentDate.setMonth(this.currentDate.getMonth() + 1);
            this.updateMonthDisplay();
            this.renderCalendar();
            this.fetchEventDates();
        });
    }

    updateMonthDisplay() {
        const monthYear = `${this.monthNames[this.currentDate.getMonth()]} ${this.currentDate.getFullYear()}`;
        document.getElementById('currentMonth').textContent = monthYear;
    }

    renderCalendar() {
        const calendarDays = document.getElementById('calendarDays');
        const firstDay = new Date(this.currentDate.getFullYear(), this.currentDate.getMonth(), 1);
        const lastDay = new Date(this.currentDate.getFullYear(), this.currentDate.getMonth() + 1, 0);
    
        // Clear existing calendar days except day names
        while (calendarDays.children.length > 7) {
            calendarDays.removeChild(calendarDays.lastChild);
        }
    
        // Add empty cells for days before the first day of the month
        for (let i = 0; i < firstDay.getDay(); i++) {
            const emptyDay = document.createElement('div');
            emptyDay.className = 'calendar-day';
            calendarDays.appendChild(emptyDay);
        }
    
        // Add days of the month
        for (let day = 1; day <= lastDay.getDate(); day++) {
            const dayElement = document.createElement('div');
            dayElement.className = 'calendar-day';
            dayElement.textContent = day;
    
            // Check if this is today's date
            const today = new Date();
            if (day === today.getDate() &&
                this.currentDate.getMonth() === today.getMonth() &&
                this.currentDate.getFullYear() === today.getFullYear()) {
                dayElement.classList.add('selected');
            }
    
            calendarDays.appendChild(dayElement);
        }
    }

    fetchEventDates() {
        const month = this.currentDate.getMonth() + 1;
        const year = this.currentDate.getFullYear();

        fetch(`/student-events/get-event-dates-in-month?month=${month}&year=${year}`)
            .then(response => response.json())
            .then(data => {
                this.markEventDates(data);
            })
            .catch(error => console.error('Error fetching event dates:', error));
    }

    markEventDates(dates) {
        const calendarDays = document.querySelectorAll('.calendar-day');
        dates.forEach(event => {
            const eventDate = new Date(event.scheduled_date);
            const day = eventDate.getDate();
    
            calendarDays.forEach(dayElement => {
                if (parseInt(dayElement.textContent) === day) {
                    // Add the appropriate class for upcoming or previous events
                    dayElement.classList.add(event.session_status === 'scheduled' ? 'upcoming-event' : 'previous-event');
    
                    // Add click event to redirect to newevent.php with the selected date
                    dayElement.addEventListener('click', () => {
                        const formattedDate = eventDate.toISOString().split('T')[0];
                        window.location.href = `/student-events?date=${formattedDate}`;
                    });
                }
            });
        });
    }

    showEventsForDate(date) {
        const formattedDate = date.toISOString().split('T')[0];
        window.location.href = `/student-events?date=${formattedDate}`;
    }
}

// Initialize calendar when the page loads
document.addEventListener('DOMContentLoaded', () => {
    new Calendar();
});
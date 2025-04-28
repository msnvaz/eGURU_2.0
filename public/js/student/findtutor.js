
let currentTutorId = null;
let currentSubjectId = null;
let availableSlots = [];


function showRequestModal(tutorId, tutorName) {
    currentTutorId = tutorId;
    
   
    const tutorCard = document.querySelector(`.tutor-card[data-tutor-id="${tutorId}"]`);
    currentSubjectId = tutorCard.dataset.subjectId;
    
    
    document.getElementById('tutorName').textContent = tutorName;
    document.getElementById('requestModal').classList.add('active');
    
    
    fetchAvailableTimeSlots(tutorId);
}


function fetchAvailableTimeSlots(tutorId) {
    console.log('Fetching slots for tutor ID:', tutorId);
    
    fetch('/student-available-slots', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ tutorId: tutorId })
    })
    .then(response => {
        console.log('Response status:', response.status);
        return response.json();
    })
    .then(data => {
        console.log('Response data:', data);
        if (data.error) {
            showError(data.error);
            return;
        }
        
        
        availableSlots = data.availableSlots;
        displayAvailableSlots(data.availableSlots);
    })
    .catch(error => {
        console.error('Error fetching time slots:', error);
        showError('Failed to fetch available time slots');
    });
}


function displayAvailableSlots(slots) {
    const modalContent = document.querySelector('.modal-content');
    
    if (!slots || slots.length === 0) {
        modalContent.innerHTML = `
            <h2>No Available Time Slots</h2>
            <p>No matching time slots were found. Please try another tutor or adjust your availability.</p>
            <div class="modal-buttons">
                <button class="modal-cancel" onclick="hideRequestModal()">Close</button>
            </div>
        `;
        return;
    }
    
    
    const slotsByDay = {};
    slots.forEach(slot => {
        if (!slotsByDay[slot.day]) {
            slotsByDay[slot.day] = [];
        }
        slotsByDay[slot.day].push(slot);
    });
    
    
    let slotsHtml = '<h2>Select a Time Slot</h2>';
    slotsHtml += '<div class="time-slots-container">';
    
    for (const day in slotsByDay) {
        slotsHtml += `<div class="day-group">`;
        slotsHtml += `<h3>${day}</h3>`;
        
        slotsByDay[day].forEach(slot => {
            const timeText = `${convertTime(slot.startTime)} - ${convertTime(slot.endTime)}`;
            slotsHtml += `
                <div class="time-slot-item" data-date="${slot.date}" data-time="${slot.startTime}">
                    <span class="time-slot-time">${timeText}</span>
                    <span class="time-slot-date">${formatDate(slot.date)}</span>
                    <button class="select-slot-btn" onclick="selectTimeSlot('${slot.date}', '${slot.startTime}')">Select</button>
                </div>
            `;
        });
        
        slotsHtml += `</div>`;
    }
    
    slotsHtml += '</div>';
    slotsHtml += `
        <div class="modal-buttons">
            <button class="modal-cancel" onclick="hideRequestModal()">Cancel</button>
            <button class="request-without-slot" onclick="confirmRequest()">Request Without Specific Time</button>
        </div>
    `;
    
    modalContent.innerHTML = slotsHtml;
}


function selectTimeSlot(date, time) {
    sendRequest(currentTutorId, currentSubjectId, date, time);
}


function sendRequest(tutorId, subjectId, scheduledDate = null, scheduleTime = null) {
    const requestData = {
        tutorId: tutorId,
        subjectId: subjectId
    };
    
    
    if (scheduledDate && scheduleTime) {
        requestData.scheduledDate = scheduledDate;
        requestData.scheduleTime = scheduleTime;
    }
    
    fetch('/student-request-tutor', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(requestData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            hideRequestModal();
            showSuccessMessage();
        } else if (data.error) {
            showError(data.error);
        }
    })
    .catch(error => {
        console.error('Error sending request:', error);
        showError('Failed to send request');
    });
}


function confirmRequest() {
    if (!currentTutorId || !currentSubjectId) {
        showError('Missing tutor or subject information');
        return;
    }
    
    sendRequest(currentTutorId, currentSubjectId);
}


function hideRequestModal() {
    document.getElementById('requestModal').classList.remove('active');
    currentTutorId = null;
    currentSubjectId = null;
    availableSlots = [];
}


function showSuccessMessage() {
    const successMessage = document.getElementById('successMessage');
    successMessage.classList.add('active');
    setTimeout(() => {
        successMessage.classList.remove('active');
    }, 3000);
}


function showError(message) {
    const errorMessage = document.getElementById('errorMessage');
    errorMessage.textContent = message;
    errorMessage.classList.add('active');
    setTimeout(() => {
        errorMessage.classList.remove('active');
    }, 3000);
}


function convertTime(time) {
    const [hours, minutes] = time.split(':');
    const hour = parseInt(hours, 10);
    const period = hour >= 12 ? 'PM' : 'AM';
    const hour12 = hour % 12 || 12;
    return `${hour12}:${minutes} ${period}`;
}


function formatDate(dateStr) {
    const date = new Date(dateStr);
    const options = { weekday: 'short', month: 'short', day: 'numeric' };
    return date.toLocaleDateString('en-US', options);
}


document.addEventListener('DOMContentLoaded', () => {
    
    document.querySelectorAll('.tutor-card').forEach(card => {
        const tutorSubjects = card.querySelector('.tutor-details p:nth-child(2)').textContent;
        const firstSubject = tutorSubjects.split(':')[1].trim().split(',')[0].trim();
        
        
        const subjectSelect = document.getElementById('subject');
        let subjectId = 1; 
        
        if (subjectSelect) {
            Array.from(subjectSelect.options).forEach(option => {
                if (option.text.toLowerCase() === firstSubject.toLowerCase()) {
                    subjectId = option.value;
                }
            });
        }
        
        
        card.dataset.subjectId = subjectId;
    });
    
    
    window.addEventListener('click', (event) => {
        const modal = document.getElementById('requestModal');
        if (event.target === modal) {
            hideRequestModal();
        }
    });
});
let activeTab = 'pending';

        function toggleRequests(tab) {
            document.querySelectorAll('.tableheader div').forEach(el => {
                el.classList.remove('active');
            });
            document.getElementById(`${tab}-tab`).classList.add('active');
            
            document.querySelectorAll('.table-container').forEach(el => {
                el.style.display = 'none';
            });
            
            const containerId = `${tab}-${tab === 'pending' ? 'requests' : 'sessions'}`;
            document.getElementById(containerId).style.display = 'block';
            
            activeTab = tab;
            loadRequests();
        }

        function loadRequests() {
            const container = document.getElementById(`${activeTab}-${activeTab === 'pending' ? 'requests' : 'sessions'}-body`);
            
            const colSpan = '4';
            container.innerHTML = `<tr><td colspan="${colSpan}" style="text-align: center;">Loading...</td></tr>`;
            
            const endpoint = activeTab === 'pending' ? '/student-pending-requests' : '/student-request-results';
            
            fetch(endpoint)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! Status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Data received:', data);
                    
                    container.innerHTML = '';
                    
                    if (!data.success) {
                        throw new Error(data.error || 'Unknown error');
                    }
                    
                    const filteredRequests = data.requests.filter(request => {
                        if (activeTab === 'pending') return request.session_status === 'requested';
                        if (activeTab === 'rejected') return request.session_status === 'rejected';
                        if (activeTab === 'cancelled') return request.session_status === 'cancelled';
                        return false;
                    });
                    
                    if (filteredRequests.length === 0) {
                        container.innerHTML = `<tr><td colspan="${colSpan}" class="no-data">No ${activeTab} ${activeTab === 'pending' ? 'requests' : 'sessions'} found</td></tr>`;
                        return;
                    }
                    
                    filteredRequests.forEach(request => {
                        const row = document.createElement('tr');
                        const actionButton = request.session_status === 'requested' 
                            ? `<button onclick="cancelRequest(${request.session_id})" class="cancel-btn">Cancel</button>`
                            : `<button onclick="viewSessionDetails(${request.session_id})" class="view-btn">View</button>`;
                            
                        row.innerHTML = `
                            <td>${request.tutor_name}</td>
                            <td>${request.subject}</td>
                            <td><span class="status-badge ${request.session_status}">${request.session_status}</span></td>
                            <td>${actionButton}</td>
                        `;
                        container.appendChild(row);
                    });
                })
                .catch(error => {
                    console.error('Error loading requests:', error);
                    container.innerHTML = `<tr><td colspan="${colSpan}" class="error">Error loading data: ${error.message}. Please try again.</td></tr>`;
                });
        }

        function cancelRequest(sessionId) {
            if (!confirm('Are you sure you want to cancel this session request?')) {
                return;
            }

            fetch('/student-cancel-request', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ sessionId }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Request cancelled successfully.');
                    loadRequests();
                } else {
                    alert('Failed to cancel request: ' + (data.error || 'Unknown error'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            });
        }

        function viewSessionDetails(sessionId) {
            fetch(`/student-session-details/${sessionId}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! Status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Session details:', data);
                    
                    const detailsContent = document.getElementById('session-details-content');
                    
                    if (data.error) {
                        detailsContent.innerHTML = `<p class="error">${data.error}</p>`;
                        document.getElementById('session-details-modal').style.display = 'block';
                        return;
                    }

                    let tutorPhotoHtml = '';
                    if (data.tutor_profile_photo) {
                        tutorPhotoHtml = `<img src=\"images/student-uploads/${data.tutor_profile_photo}\" alt=\"${data.tutor_name}\" class=\"tutor-photo\">`;
                     }

                    let dateTimeInfo = '';
                    
                    if (data.session_status === 'cancelled') {
                        const cancelDate = data.cancelled_at ? new Date(data.cancelled_at) : new Date();
                        dateTimeInfo = `
                            <p><strong>Cancelled on:</strong> ${cancelDate.toLocaleDateString()} at ${cancelDate.toLocaleTimeString()}</p>
                        `;
                    }
                    
                    detailsContent.innerHTML = `
                        ${tutorPhotoHtml}
                        <p><strong>Tutor:</strong> ${data.tutor_name}</p>
                        <p><strong>Subject:</strong> ${data.subject}</p>
                        <p><strong>Status:</strong> <span class="status-badge ${data.session_status}">${data.session_status}</span></p>
                        ${dateTimeInfo}
                    `;
                    document.getElementById('session-details-modal').style.display = 'block';
                })
                .catch(error => {
                    console.error('Error loading session details:', error);
                    const detailsContent = document.getElementById('session-details-content');
                    detailsContent.innerHTML = `<p class="error">Error loading session details: ${error.message}</p>`;
                    document.getElementById('session-details-modal').style.display = 'block';
                });
        }

        function closeSessionDetails() {
            document.getElementById('session-details-modal').style.display = 'none';
        }

        document.addEventListener('DOMContentLoaded', loadRequests);

        window.onclick = function(event) {
            const modal = document.getElementById('session-details-modal');
            if (event.target === modal) {
                closeSessionDetails();
            }
        }
    

                   
                    
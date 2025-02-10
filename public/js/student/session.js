function toggleRequests(tab) {
    const pendingTab = document.getElementById("pending-tab");
    const resultsTab = document.getElementById("results-tab");
    const pendingRequests = document.getElementById("pending-requests");
    const requestResults = document.getElementById("request-results");

    if (tab === "pending") {
      pendingTab.classList.add("active");
      resultsTab.classList.remove("active");
      pendingRequests.classList.remove("hidden");
      requestResults.classList.add("hidden");
    } else if (tab === "results") {
      resultsTab.classList.add("active");
      pendingTab.classList.remove("active");
      requestResults.classList.remove("hidden");
      pendingRequests.classList.add("hidden");
    }
  }

  function cancelRequest(button) {
    button.textContent = "Cancelled";
    button.classList.remove("btn-pending");
    button.classList.add("btn-declined");
  }



/*approved popup*/
  
function showApprovedPopup(tutor, time, subject, meetingId, password) {
  document.getElementById("approved_popup-tutor").textContent = tutor;
  document.getElementById("approved_popup-time").textContent = time;
  document.getElementById("approved_popup-meeting-id").textContent = meetingId;
  document.getElementById("approved_popup-password").textContent = password;
  document.getElementById("approved_popup").style.display = "flex";
}

function closeApprovedPopup() {
  document.getElementById("approved_popup").style.display = "none";
}

//pending requests
document.addEventListener('DOMContentLoaded', function () {
  loadPendingRequests();
});

function loadPendingRequests() {
  fetch('/student-session/pending-requests')
  .then(response => response.json())
  .then(data => {
      if (data.success) {
          updatePendingRequestsTable(data.requests);
      } else {
          document.querySelector("#pending-requests tbody").innerHTML = "<tr><td colspan='5'>No pending requests</td></tr>";
      }
  })
  .catch(error => console.error('Fetch error:', error));
}

function updatePendingRequestsTable(requests) {
    
    const tableBody = document.querySelector("#pending-requests tbody");
    tableBody.innerHTML = '';

    if (requests.length === 0) {
        tableBody.innerHTML = '<tr><td colspan="5">No pending requests</td></tr>';
        return;
    }


    requests.forEach(request => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${request.tutor_name}</td>
            <td>${request.subject}</td>
            <td>${request.grade}</td>
            <td>${request.requested_date}</td>
            <td>${request.status}</td>
        `;
        tableBody.appendChild(row);
    });
}

function getStatusBadge(status) {
    const statusClasses = {
        'Pending': 'badge-pending',
        'Accepted': 'badge-accepted',
        'Rejected': 'badge-rejected',
        'Cancelled': 'badge-cancelled'
    };
    return `<span class="badge ${statusClasses[status] || ''}">${status}</span>`;
}

function formatDate(dateString) {
    return new Date(dateString).toLocaleString();
}

function cancelRequest(requestId) {
  fetch('/student-session/cancel-request', {
      method: 'POST',
      headers: {
          'Content-Type': 'application/x-www-form-urlencoded',
      },
      body: 'request_id=' + requestId
  })
  .then(response => response.json())
  .then(data => {
      if (data.success) {
          // Remove the row from the table
          const row = document.querySelector(`tr[data-request-id="${requestId}"]`);
          if (row) {
              row.remove();
          }
          // Optionally show a success message
          alert('Request cancelled successfully');
      } else {
          alert('Failed to cancel request: ' + data.message);
      }
  })
  .catch(error => {
      console.error('Error:', error);
      alert('An error occurred while cancelling the request');
  });
}

function loadPendingRequests() {
  fetch('/student-session/pending-requests')
  .then(response => response.json())
  .then(data => {
      const tableBody = document.querySelector('#pending-requests tbody');
      tableBody.innerHTML = '';

      if (data.success && data.requests.length > 0) {
          data.requests.forEach(request => {
              const row = document.createElement('tr');
              row.setAttribute('data-request-id', request.request_id);
              row.innerHTML = `
                  <td>${request.tutor_name}</td>
                  <td>${request.subject}</td>
                  <td>${request.grade}</td>
                  <td>${request.created_at}</td>
                  <td>${request.status}</td>
                  <td>
                      <button onclick="cancelRequest(${request.request_id})">Cancel</button>
                  </td>
              `;
              tableBody.appendChild(row);
          });
      } else {
          const row = document.createElement('tr');
          row.innerHTML = '<td colspan="6">No pending requests</td>';
          tableBody.appendChild(row);
      }
  })
  .catch(error => {
      console.error('Error:', error);
  });
}

function cancelRequest(requestId) {
  fetch('/student-session/cancel-request', {
      method: 'POST',
      headers: {
          'Content-Type': 'application/x-www-form-urlencoded',
      },
      body: 'request_id=' + requestId
  })
  .then(response => response.json())
  .then(data => {
      if (data.success) {
          const row = document.querySelector(`tr[data-request-id="${requestId}"]`);
          if (row) {
              row.remove();
          }
      } else {
          alert('Failed to cancel request: ' + data.message);
      }
  })
  .catch(error => {
      console.error('Error:', error);
      alert('An error occurred while cancelling the request');
  });
}

document.addEventListener('DOMContentLoaded', loadPendingRequests);
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
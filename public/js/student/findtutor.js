document.querySelector("button").addEventListener("click", () => {
    let grade = document.getElementById("grade").value;
    let subject = document.getElementById("subject").value;
    let experience = document.getElementById("experience").value;

    // Debug log
    console.log("Sending search request with:", { grade, subject, experience });

    let formData = new FormData();
    formData.append("grade", grade);
    formData.append("subject", subject);
    formData.append("experience", experience);

    fetch("/student-search-tutor", {
        method: "POST",
        body: formData
    })
    .then(res => {
        if (!res.ok) {
            throw new Error(`HTTP error! status: ${res.status}`);
        }
        return res.json();
    })
    .then(data => {
        console.log("Received response:", data);
        
        let results = document.getElementById("results");
        results.innerHTML = "";
        
        if (!Array.isArray(data)) {
            results.innerHTML = "<p>Error: Unexpected response format</p>";
            return;
        }

        if (data.length === 0) {
            results.innerHTML = "<p>No tutors found matching your criteria</p>";
            return;
        }

        data.forEach(tutor => {
            let card = `<div class="tutor-card" onclick="showPopup(${tutor.tutor_id})">
                            <h3>${tutor.name}</h3>
                            <p>${tutor.subject} | ${tutor.grade} | ${tutor.tutor_level}</p>
                        </div>`;
            results.innerHTML += card;
        });
    })
    .catch(err => {
        console.error("Search error:", err);
        document.getElementById("results").innerHTML = 
            `<p>Error searching for tutors: ${err.message}</p>`;
    });
});
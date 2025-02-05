const tutors = [
    { name: "John Doe", grade: "Grade 10", subject: "Math", experience: "2 Years", qualification: "MSc in Mathematics", rating: "⭐⭐⭐⭐", availability: "Available" },
    { name: "Jane Smith", grade: "Grade 11", subject: "Science", experience: "1 Year", qualification: "BSc in Physics", rating: "⭐⭐⭐", availability: "Unavailable" },
    { name: "Mark Taylor", grade: "Grade 10", subject: "Math", experience: "1 Year", qualification: "BEd in Math Education", rating: "⭐⭐⭐⭐⭐", availability: "Available" }
    
];

function searchTutors() {
    const grade = document.querySelector('select:nth-of-type(1)').value;
    const subject = document.querySelector('select:nth-of-type(2)').value;
    const experience = document.querySelector('select:nth-of-type(3)').value;

    const filteredTutors = tutors.filter((tutor) => {
        return (
            (grade === "" || tutor.grade === grade) &&
            (subject === "" || tutor.subject === subject) &&
            (experience === "" || tutor.experience === experience)
        );
    });

    const resultsContainer = document.getElementById("results");
    resultsContainer.innerHTML = "";

    if (filteredTutors.length === 0) {
        resultsContainer.innerHTML = "<p>No tutors found matching your criteria.</p>";
    } else {
        filteredTutors.forEach((tutor, index) => {
            const tutorCard = `
                <div class="findtutor-card" onclick="showPopup(${index})">
                    <img src="https://via.placeholder.com/80" alt="Tutor">
                    <div class="findtutor-details">
                        <h3>${tutor.name}</h3>
                        <p>${tutor.qualification}</p>
                        <div class="rating">${tutor.rating}</div>
                    </div>
                    <div class="availability ${tutor.availability.toLowerCase().replace(" ", "-")}">
                        ${tutor.availability}
                    </div>
                </div>
            `;
            resultsContainer.innerHTML += tutorCard;
        });
    }
}

function showPopup(index) {
    const tutor = tutors[index];
    document.getElementById("findtutorpopup-name").textContent = tutor.name;
    document.getElementById("findtutorpopup-qualification").textContent = `Qualification: ${tutor.qualification}`;
    document.getElementById("findtutorpopup-experience").textContent = `Experience: ${tutor.experience}`;
    document.getElementById("findtutorpopup").style.display = "flex";
}

function closePopup() {
    document.getElementById("findtutorpopup").style.display = "none";
}

function requestTutor() {
    alert("Tutor request sent successfully!");
    closePopup();
}
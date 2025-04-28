
function loadReviews() {
    const reviews = JSON.parse(localStorage.getItem("reviewsData")) || [];
    const reviewList = document.getElementById("review-list");
    reviewList.innerHTML = ""; 
    reviews.forEach((review, index) => {
        addReviewToList(review.tutor, review.rating, review.comment, index);
    });
    updateAverageRating(reviews);
}


function saveReviews(reviews) {
    localStorage.setItem("reviewsData", JSON.stringify(reviews));
}


function addReview() {
    const rating = parseInt(document.getElementById("rating").value);
    const comment = document.getElementById("comment").value;
    const selectedTutor = document.querySelector(".tutor-card.selected")?.getAttribute("data-tutor");

    if (!selectedTutor || !rating || !comment) {
        alert("Please select a tutor, rate, and write a review.");
        return;
    }

    const reviews = JSON.parse(localStorage.getItem("reviewsData")) || [];
    const newReview = { tutor: selectedTutor, rating, comment };
    reviews.push(newReview);
    saveReviews(reviews);

    addReviewToList(selectedTutor, rating, comment, reviews.length - 1);
    updateAverageRating(reviews);

    document.getElementById("review-form").reset();
}


function addReviewToList(tutor, rating, comment, index) {
    const reviewList = document.getElementById("review-list");
    const reviewDiv = document.createElement("div");
    reviewDiv.classList.add("review");
    reviewDiv.innerHTML = `
        <div class="reviewer">${tutor}</div>
        <div class="rating">${"★".repeat(rating)}</div>
        <div class="comment">${comment}</div>
    `;
    reviewList.appendChild(reviewDiv);
}


function updateAverageRating(reviews) {
    const totalReviews = reviews.length;
    if (totalReviews === 0) {
        document.getElementById("average-rating").textContent = "Average Rating: 0.0 (0 Reviews)";
        return;
    }
    const totalRating = reviews.reduce((sum, review) => sum + review.rating, 0);
    const averageRating = (totalRating / totalReviews).toFixed(1);
    document.getElementById("average-rating").textContent = `Average Rating: ${averageRating} (${totalReviews} Reviews)`;
}


function clearHistory() {
    if (confirm("Are you sure you want to clear all review history?")) {
        localStorage.removeItem("reviewsData");
        document.getElementById("review-list").innerHTML = ""; // Clear the UI
        updateAverageRating([]);
    }
}


function selectTutor(tutorCard) {
    const tutorCards = document.querySelectorAll(".tutor-card");
    tutorCards.forEach(card => card.classList.remove("selected"));
    tutorCard.classList.add("selected");
}


function scrollTutorCards(direction) {
    const container = document.querySelector(".tutor-cards-container");
    const scrollAmount = direction === "left" ? -200 : 200;
    container.scrollLeft += scrollAmount;
}


loadReviews();
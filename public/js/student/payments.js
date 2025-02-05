function showStep(step) {
    document.querySelectorAll(".form-section").forEach(section => section.classList.add("hidden"));
    document.getElementById(`form-step-${step}`).classList.remove("hidden");

    document.querySelectorAll('.step-header div').forEach(header => header.classList.remove('active'));
    document.getElementById(`step-${step}`).classList.add('active');

    if (step === 3) {
        document.getElementById("review-name").innerText = document.getElementById("name").value;
        document.getElementById("review-email").innerText = document.getElementById("email").value;
        document.getElementById("review-card-number").innerText = maskCardNumber(document.getElementById("card-number").value);
        document.getElementById("review-expiry-date").innerText = document.getElementById("expiry-date").value;
        document.getElementById("review-amount").innerText = document.getElementById("amount").value;
    }
}

function confirmPayment() {
    const paymentAmount = parseInt(document.getElementById("amount").value, 10);
    document.getElementById("modal-earned-points").innerText = paymentAmount;
    openModal();
}

function openModal() {
    const modal = document.getElementById("confirmation-modal");
    const overlay = document.getElementById("modal-overlay");

    modal.classList.remove("hidden");
    overlay.style.display = "block"; // Show the overlay
    document.body.classList.add("modal-open");
}

function closeModal() {
    const modal = document.getElementById("confirmation-modal");
    const overlay = document.getElementById("modal-overlay");

    modal.classList.add("hidden");
    overlay.style.display = "none"; // Hide the overlay
    document.body.classList.remove("modal-open");
}


function maskCardNumber(cardNumber) {
    return "**** **** **** " + cardNumber.slice(-4);
}

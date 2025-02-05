// Handle profile picture change
const profilePictureUpload = document.getElementById("profilePictureUpload");
const profilePic = document.getElementById("profilePic");

profilePictureUpload.addEventListener("change", function() {
    const file = this.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            profilePic.src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
});

// Handle profile form submission (for updating account details)
const profileForm = document.getElementById("profileForm");

profileForm.addEventListener("submit", function(event) {
    event.preventDefault();

    // Get the form data
    const name = document.getElementById("name").value;
    const email = document.getElementById("email").value;
    const password = document.getElementById("password").value;
    const bio = document.getElementById("bio").value;

    // For demo purposes, we'll just log the data (you can handle the data on your server)
    console.log({
        name: name,
        email: email,
        password: password,
        bio: bio
    });

    alert("Profile Updated Successfully!");
});

// Handle profile deletion
const deleteProfileBtn = document.getElementById("deleteProfile");

deleteProfileBtn.addEventListener("click", function() {
    const confirmation = confirm("Are you sure you want to delete your profile?");
    if (confirmation) {
        // Add deletion logic here (e.g., send a request to the server)
        alert("Profile Deleted Successfully!");
        console.log("Profile has been deleted");
    }
});

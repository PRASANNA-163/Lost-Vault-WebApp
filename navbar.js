document.addEventListener("DOMContentLoaded", function () {
    // Simulating user data (Replace this with actual user data from backend)
    let userName = "Lost Vault"; // Example name, replace with dynamic user data

    // Extract initials from the user name
    let initials = userName.split(" ").map(n => n[0]).join("").toUpperCase();

    // Set the initials in the profile section
    document.querySelector(".profile-initials").textContent = initials;
});

document.addEventListener("DOMContentLoaded", function () {
    const themeToggle = document.getElementById("theme-toggle");
    const body = document.body;

    themeToggle.addEventListener("click", function () {
        body.classList.toggle("light-mode");

        // Toggle between sun and moon icon
        if (body.classList.contains("light-mode")) {
            themeToggle.textContent = "dark_mode"; // Moon icon
        } else {
            themeToggle.textContent = "wb_sunny"; // Sun icon
        }
    });
});



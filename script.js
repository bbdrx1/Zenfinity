document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector(".login-form form");
    const overlay = document.querySelector(".overlay");
    const successPopup = document.getElementById("successPopup");
    const errorPopup = document.getElementById("errorPopup");
    const closeButtons = document.querySelectorAll(".close-button");

    form.addEventListener("submit", function (event) {
        event.preventDefault();

        // For simplicity, let's use the Fetch API to send a POST request to process.php
        fetch(form.action, {
            method: "POST",
            body: new FormData(form),
        })
            .then(response => response.json())
            .then(result => {
                console.log("Fetch result:", result); // Add this line for logging

                if (result.status === "success") {
                    showPopup(successPopup);

                    // Check the account type (result.type) and redirect accordingly
                    if (result.type === "Admin") {
                        // Redirect to admin page
                        window.location.href = "Admin/HomePage.php";
                    } else if (result.type === "User") {
                        // Redirect to user page
                        window.location.href = "User/HomePage.php";
                    } else {
                        // Handle unknown account type
                        console.error("Unknown account type");
                    }
                } else {
                    showPopup(errorPopup);
                }
            })
            .catch(error => {
                console.error("Error:", error);
            });
    });

    closeButtons.forEach(button => {
        button.addEventListener("click", function () {
            hidePopups();
        });
    });

    function showPopup(popup) {
        overlay.style.display = "block";
        popup.style.display = "block";
    }

    function hidePopups() {
        overlay.style.display = "none";
        successPopup.style.display = "none";
        errorPopup.style.display = "none";
    }
});

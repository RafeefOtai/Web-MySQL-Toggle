document.addEventListener("DOMContentLoaded", function () {
    const toggles = document.querySelectorAll(".toggle-input");

    toggles.forEach(function (toggle) {
        toggle.addEventListener("change", function () {
            const id = toggle.getAttribute("data-id");
            const row = document.getElementById("row-" + id);
            const pill = row.querySelector(".status-pill");
            const pillText = row.querySelector(".status-text");

            fetch("toggle.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: "id=" + id
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const isActive = data.status == 1;
                    toggle.checked = isActive;
                    pill.classList.toggle("is-active", isActive);
                    pill.classList.toggle("is-inactive", !isActive);
                    pillText.textContent = isActive ? "Active" : "Inactive";
                } else {
                    // Revert the switch if the request failed
                    toggle.checked = !toggle.checked;
                }
            })
            .catch(function (error) {
                console.error("Toggle failed:", error);
                toggle.checked = !toggle.checked;
            });
        });
    });
});

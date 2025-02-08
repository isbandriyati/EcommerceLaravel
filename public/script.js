const countdownDate = new Date("Feb 15, 2025 00:00:00").getTime();

function updateCountdown() {
    const now = new Date().getTime();
    const distance = countdownDate - now;

    // Calculate time components
    const days = Math.floor(distance / (1000 * 60 * 60 * 24));
    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    const seconds = Math.floor((distance % (1000 * 60)) / 1000);

    // Display the results
    document.getElementById("days").textContent = days;
    document.getElementById("hours").textContent = hours;
    document.getElementById("minutes").textContent = minutes;
    document.getElementById("seconds").textContent = seconds;

    // If countdown is finished, stop the timer
    if (distance < 0) {
        clearInterval(timer);
        document.querySelector(".timer").innerHTML = "Expired";
    }
}

// Update countdown every second
const timer = setInterval(updateCountdown, 1000);

// Initialize countdown immediately
updateCountdown();
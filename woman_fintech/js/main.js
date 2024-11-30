document.addEventListener('DOMContentLoaded', function () {
    // Validare formular
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function (e) {
            const email = document.querySelector('input[type="email"]');
            const linkedin = document.querySelector('input[name="linkedin_profile"]');

            if (email && !validateEmail(email.value)) {
                e.preventDefault();
                alert('Please enter a valid email address');
            }

            if (linkedin && !validateLinkedIn(linkedin.value)) {
                e.preventDefault();
                alert('Please enter a valid LinkedIn URL');
            }
        });
    }
});
function validateEmail(email) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
}
function validateLinkedIn(url) {
    return url.includes('linkedin.com/');
}

document.getElementById('dark-mode-toggle').onclick = function() {
    document.body.classList.toggle('dark-mode');
    const cards = document.querySelectorAll('.member-card');
    cards.forEach(card => {
        card.classList.toggle('dark-mode');
    });

    const jumbotron = document.querySelector('.jumbotron');
    if (jumbotron) {
        jumbotron.classList.toggle('dark-mode');
    }
    const navbar = document.querySelector('.navbar');
    const logo = document.getElementById('logo');
    navbar.classList.toggle('dark-mode');
    if (navbar.classList.contains('dark-mode')) {
        logo.src = 'logo-dark.png'; 
    } else {
        logo.src = 'logo.png';
    }
};
document.addEventListener('DOMContentLoaded', function () {
    const loadingScreen = document.getElementById('loading-screen');

    document.getElementById('register-form').addEventListener('submit', function () {
        loadingScreen.style.display = 'flex';
    });

    window.addEventListener('load', function () {
        loadingScreen.style.display = 'none';
    });
});

// Login, Create B Team 
document.addEventListener('DOMContentLoaded', function () {
    const loadingScreen = document.getElementById('loading-screen');

    document.getElementById('form').addEventListener('submit', function () {
        loadingScreen.style.display = 'flex';
    });

    window.addEventListener('load', function () {
        loadingScreen.style.display = 'none';
    });
});
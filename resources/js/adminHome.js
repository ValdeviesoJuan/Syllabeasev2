document.getElementById('submit-button').addEventListener('click', function(event) {
    if (!document.getElementById('customFile').value) {
        event.preventDefault();
        alert('Please choose a file to import.');
    }
});
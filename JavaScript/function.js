function removeClassRow(button) {
    const row = button.parentNode.parentNode;
    row.parentNode.removeChild(row);
}

function submitFormData(event) {
    event.preventDefault(); // Prevent the default form submission

    const formData = new FormData(event.target);

    fetch('insertModal.php', {
        method: 'POST',
        body: formData,
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Data inserted successfully');
            // Optionally, you can redirect or refresh the page here
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        alert('An error occurred: ' + error.message);
    });
}

function updateData() {
    const form = document.getElementById('classForm');
    const formData = new FormData(form);

    fetch('updateform.php', { // Update the URL to point to your PHP script
        method: 'POST',
        body: formData,
    })
    .then(response => {
        if (response.ok) {
            alert('Data updated successfully');
            window.location.reload; // Redirect to the desired page
        } else {
            alert('Error: ' + response.status + ' ' + response.statusText);
        }
        // window.location.reload; // Redirect to the desired page
    })
    .catch(error => {
        alert('An error occurred: ' + error.message);
    });
}

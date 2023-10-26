document.getElementById('addClassForm').addEventListener('submit', submitFormData);
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
            window.location.reload();

            // Optionally, you can redirect or refresh the page here
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        alert('An error occurred: ' + error.message);
    });
}

// document.getElementById('updateButton').addEventListener('click', function() {
//     updateData();
// });
// function updateData() {
//     const formData = new FormData(document.getElementById('classForm'));

//     fetch('updateform.php', {
//         method: 'POST',
//         body: formData,
//     })
//     .then(response => {
//         if (!response.ok) {
//             throw new Error('Response was not successful');
//         }

//         return response.json();
//     })
//     .then(data => {
//         if (data.success) {
//             alert('Data updated successfully');
//             window.location.reload();
//         } else {
//             alert('Update failed: ' + data.message);
//         }
//     })
//     .catch(error => alert('An error occurred: ' + error.message));
// }

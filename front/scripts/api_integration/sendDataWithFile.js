function sendDataWithFile(elementID) {
    var formData = new FormData();
    var fileInput = document.getElementById(elementID);
    var file = fileInput.files[0];
    formData.append('pdfFile', file);


    var apiUrl = 'http://localhost:8082/index.php/volunteers/register';
    var options = {
        method: 'POST',
        body: formData
    };

    fetch(apiUrl, options)
        .then(response => response.json())
        .then(data => {
            console.log('Réponse de l\'API :', data);
            alert(JSON.stringify(data));
        })
        .catch(error => {
            console.error('Erreur lors de l\'envoi des fichiers à l\'API :', error);
            alert('Erreur lors de l\'envoi des fichiers à l\'API.');
        });
}

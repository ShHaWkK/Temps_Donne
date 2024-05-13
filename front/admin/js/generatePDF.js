function generatePDF(){
    //nom du fichier | file name
    var nom_fichier = prompt("Nom du fichier PDF :");

    var element = document.getElementById('collectionTab').innerHTML;

    var opt = {
        margin:  0.5,
        filename:     `${nom_fichier}.pdf`,
        image:        { type: 'jpeg', quality: 1 },
        html2canvas:  { scale: 1 },
        jsPDF:        { unit: 'in', format: 'letter', orientation: 'portrait' },
        pagebreak: { mode: 'avoid-all' }
    };

    if(nom_fichier != null){
        html2pdf().set(opt).from(element).save();
    } else {
        alert("Veuillez choisir un nom ");
    }
}

function sendPDFFile(PDFfile) {
    const apiUrl='http://localhost:8082/index.php/circuits/pdf';

    var dateDuJour = new Date().toISOString().split('T')[0];
    var file_name = 'circuit_' + dateDuJour + '.pdf';

    // Créer un objet FormData pour le fichier PDF
    var formData = new FormData();
    formData.append('circuit_file', PDFfile, file_name);

    // Options de la requête HTTP
    var options = {
        method: 'POST',
        body: formData
    };

    fetch(apiUrl, options)
        .then(response => {
            if (!response.ok) {
                return response.text().then(errorMessage => {
                    throw new Error(errorMessage || 'Erreur inattendue.');
                });
            }
            return response.json(); // Analyser la réponse JSON
        })
        .then(data => {
            console.log(JSON.stringify(data));

            if (data && data.status === "success") {
                alert("Fichier PDF envoyé avec succès à l'API.");
            } else {
                throw new Error(data.message || "Erreur lors de l'envoi du fichier PDF à l'API.");
            }
        })
        .catch(error => {
            console.error('Erreur lors de l\'envoi du fichier PDF à l\'API :', error.message);
            alert('Erreur lors de l\'envoi du fichier PDF à l\'API :', error.message);
        });
}
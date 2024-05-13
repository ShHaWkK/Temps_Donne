function generatePDF() {
    //nom du fichier | file name
    var element = document.getElementById('collectionTab').innerHTML;
    // var element = document.body;
    console.log(element);

    var opt = {
        margin: 0.5,
        image: {type: 'jpeg', quality: 1},
        html2canvas: {scale: 1},
        jsPDF: {unit: 'in', format: 'letter', orientation: 'portrait'},
        pagebreak: {mode: 'avoid-all'}
    };

    window.scrollTo(0, 0);
    html2pdf().set(opt).from(element).toPdf().get('pdf').then(function (pdf) {
        var dateDuJour = new Date().toISOString().split('T')[0];
        var file_name = 'circuit_' + dateDuJour + '.pdf';

        // Enregistrer le fichier PDF localement
        pdf.save(file_name);

        //Envoyer le fichier à l'API
        sendPDFFile(pdf.output('blob', {type: 'application/pdf'}));
    }).catch(function (error) {
        console.error("Erreur lors de la conversion :", error);
    });
}

function sendPDFFile(PDFfile) {
    console.log("On est dans sendPDFFile");
    const apiUrl='http://localhost:8082/index.php/circuits/pdf';

    if(PDFfile){
        console.log("pdf",PDFfile);
    }

    // Créer un objet FormData pour le fichier PDF
    var formData = new FormData();
    formData.append('circuit_pdf', PDFfile, 'circuit_pdf');

    console.log(formData);

    // Options de la requête HTTP
    var options = {
        method: 'POST',
        body: formData,
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
                alert("Fichier PDF efanvoyé avec succès à l'API.");
            } else {
                throw new Error(data.message || "Erreur lors de l'envoi du fichier PDF à l'API.");
            }
        })
}
function initMap() {
    // Coordonnées de Saint-Quentin
    var saintQuentin = { lat: 49.8530, lng: 3.2878 };

    // Options de la carte
    var mapOptions = {
        zoom: 12, // Zoom par défaut
        center: saintQuentin // Centrer la carte sur Saint-Quentin
    };

    // Création de la carte
    var map = new google.maps.Map(document.getElementById('map'), mapOptions);
}

function generateRouteRequest(startAddress, endAddress, waypoints) {
    // Initialisation de la requête
    var request = {
        origin: startAddress, // Adresse de départ
        destination: endAddress, // Adresse d'arrivée
        travelMode: 'DRIVING', // Mode de déplacement
        optimizeWaypoints: true, // Optimiser les points de passage pour le trajet le plus court
        waypoints: waypoints, // Liste des points de passage
        provideRouteAlternatives: true, // Fournir des alternatives de route
        avoidFerries: true, // Éviter les ferries
        avoidHighways: false, // Ne pas éviter les autoroutes
        avoidTolls: false // Ne pas éviter les péages
    };

    return request;
}

function displayRouteOnMap(map, request) {
    // Créer un objet DirectionsService
    var directionsService = new google.maps.DirectionsService();

    // Envoyer une requête au service Directions
    directionsService.route(request, function(response, status) {
        if (status === 'OK') {
            // Afficher l'itinéraire sur la carte
            var directionsRenderer = new google.maps.DirectionsRenderer();
            directionsRenderer.setMap(map);
            directionsRenderer.setDirections(response);
        } else {
            // Gérer les erreurs
            alert('Impossible de calculer l\'itinéraire : ' + status);
        }
    });
}
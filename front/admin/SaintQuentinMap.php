<!DOCTYPE html>
<html>
<head>
    <title>Itinéraire avec Google Maps JavaScript API</title>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDRnUwwESRTk-EVVhTJEwjWz3CpiRnhScQ&libraries=places"></script>
    <script>
        function initMap() {
            // Coordonnées du point de départ (entrepôt)
            var startPoint = { lat: 49.8530, lng: 3.2878 }; // Par exemple, coordonnées de Saint-Quentin

            // Coordonnées du point d'arrivée (distributeur)
            var endPoint = { lat: 49.8486, lng: 3.2874 }; // Par exemple, coordonnées de Saint-Quentin

            // Options de trajet
            var request = {
                origin: startPoint,
                destination: endPoint,
                travelMode: 'DRIVING', // Mode de déplacement (DRIVING pour conduite)
                optimizeWaypoints: true, // Optimiser les points de passage pour le trajet le plus court
                provideRouteAlternatives: true, // Fournir des alternatives de route
                avoidFerries: true, // Éviter les ferries
                avoidHighways: false, // Ne pas éviter les autoroutes
                avoidTolls: false // Ne pas éviter les péages
            };

            // Créer un objet DirectionsService
            var directionsService = new google.maps.DirectionsService();

            // Envoyer une requête au service Directions
            directionsService.route(request, function(response, status) {
                if (status === 'OK') {
                    // Afficher l'itinéraire sur la carte
                    var map = new google.maps.Map(document.getElementById('map'), {
                        zoom: 10, // Zoom de la carte
                        center: startPoint // Centrer la carte sur le point de départ
                    });
                    var directionsRenderer = new google.maps.DirectionsRenderer();
                    directionsRenderer.setMap(map);
                    directionsRenderer.setDirections(response);
                } else {
                    // Gérer les erreurs
                    alert('Impossible de calculer l\'itinéraire : ' + status);
                }
            });
        }
    </script>
</head>
<body>
<!-- Div pour afficher la carte -->
<div id="map" style="height: 400px; width: 100%;"></div>

<!-- Appeler la fonction d'initialisation de la carte au chargement de la page -->
<script>
    initMap();
</script>
</body>
</html>

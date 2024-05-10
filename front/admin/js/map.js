let map;

function initMap(latLong) {
    // Options de la carte
    var mapOptions = {
        zoom: 12, // Zoom par défaut
        center: latLong // Centrer la carte sur Saint-Quentin
    };

    // Création de la carte
    map = new google.maps.Map(document.getElementById('map'), mapOptions);
}

async function generateWaypoints(commercantTable) {
    const waypoints = [];

    // Parcourir les lignes du tableau des commerçants
    commercantTable.querySelectorAll('tbody tr').forEach(row => {
        // Récupérer la cellule contenant l'adresse
        const addressCell = row.querySelector('[name="commercant-address"]');
        if (addressCell) {
            // Extraire l'adresse depuis la cellule
            const address = addressCell.innerText;
            if (address) {
                // Ajouter l'adresse à la liste des waypoints
                waypoints.push({
                    location: address,
                    stopover: true // Indique que c'est un point d'arrêt
                });
            }
        }
    });

    return waypoints; // Retourne la liste des waypoints
}

function getWaypointsOrder(response) {
    // Vérifier si la réponse est valide
    if (response.status !== 'OK') {
        console.error('Erreur lors de la récupération de l\'itinéraire :', response.status);
        return [];
    }

    // Extraire les waypoints de la réponse
    const waypoints = response.waypoints || [];
    const waypointsOrder = [];

    // Parcourir les waypoints pour récupérer les coordonnées
    waypoints.forEach(waypoint => {
        const location = waypoint.location;
        const lat = location.lat();
        const lng = location.lng();

        // Ajouter les coordonnées au tableau des points de passage
        waypointsOrder.push({ lat: lat, lng: lng });
    });

    return waypointsOrder;
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
    var directionsRenderer = new google.maps.DirectionsRenderer();

    // Envoyer une requête au service Directions
    directionsService.route(request, function(response, status) {
        if (status === 'OK') {
            // Afficher l'itinéraire sur la carte
            directionsRenderer.setMap(map);
            directionsRenderer.setDirections(response);
            document.getElementById('generateCircuitButton')
        } else {
            // Gérer les erreurs
            alert('Impossible de calculer l\'itinéraire : ' + status);
        }
    });
}

// Fonction pour géocoder une adresse et retourner les coordonnées sous forme de promesse
function geocodeAddress(address) {
    return new Promise((resolve, reject) => {
        var geocoder = new google.maps.Geocoder();
        geocoder.geocode({ 'address': address }, function(results, status) {
            if (status === 'OK') {
                var location = results[0].geometry.location;
                var latitude = location.lat();
                var longitude = location.lng();
                resolve({ lat: latitude, lng: longitude });
            } else {
                reject(new Error('Geocode was not successful for the following reason: ' + status));
            }
        });
    });
}

// Fonction pour vérifier si l'utilisateur habite dans un rayon de 100 km autour de l'entrepôt
async function checkUserInRadius(userAddress, warehouseAddress, maxDistance) {
    try {
        var userLatLng = await geocodeAddress(userAddress);
        var warehouseLatLng = await geocodeAddress(warehouseAddress);
        var distance = calculateDistance(userLatLng.lat, userLatLng.lng, warehouseLatLng.lat, warehouseLatLng.lng);
        return distance <= maxDistance;
    } catch (error) {
        console.error(error);
        return false;
    }
}

// Fonction pour calculer la distance entre deux points géographiques en kilomètres
function calculateDistance(lat1, lon1, lat2, lon2) {
    const R = 6371; // Rayon de la Terre en km
    const dLat = deg2rad(lat2 - lat1);
    const dLon = deg2rad(lon2 - lon1);
    const a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
        Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) *
        Math.sin(dLon / 2) * Math.sin(dLon / 2);
    const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
    const distance = R * c; // Distance en km
    return distance;
}

// Fonction pour convertir degrés en radians
function deg2rad(deg) {
    return deg * (Math.PI / 180);
}

// Fonction pour convertir degrés en radians
function deg2rad(deg) {
    return deg * (Math.PI / 180);
}

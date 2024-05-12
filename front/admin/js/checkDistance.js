// Exemple d'utilisation
console.log("On teste checkUserInRadius");
const userAddress = "42 rue des frères Belhocine, Tizi-Ouzou, Algérie";
const warehouseAddress = "6 boulevard Gambetta, Saint Quentin, France";

checkUserInRadius(userAddress, warehouseAddress);
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

// Fonction pour vérifier si le volontaire habite dans un périmètre de 200 km autour de l'entrepôt
function checkUserInRadius(userAddress, warehouseAddress) {
    // Geocode l'adresse de l'utilisateur
    geocodeAddress(userAddress, function(userLat, userLng) {
        // Geocode l'adresse de l'entrepôt
        geocodeAddress(warehouseAddress, function(warehouseLat, warehouseLng) {
            // Calcule la distance entre l'utilisateur et l'entrepôt en kilomètres
            var distance = calculateDistance(userLat, userLng, warehouseLat, warehouseLng);

            // Vérifie si la distance est inférieure à 200 km
            if (distance <= 200) {
                console.log("L'utilisateur habite dans un périmètre de 200 km autour de l'entrepôt.");
            } else {
                console.log("L'utilisateur n'habite pas dans un périmètre de 200 km autour de l'entrepôt.");
            }
        });
    });
}

function geocodeAddress(address, callback) {
    // Créer une instance du géocodeur
    var geocoder = new google.maps.Geocoder();
    console.log("On est dans geocodeAddres");
    // Effectuer la géocodage de l'adresse
    geocoder.geocode({ 'address': address }, function(results, status) {
        if (status === 'OK') {
            // Récupérer les coordonnées de la première correspondance trouvée
            var location = results[0].geometry.location;
            var latitude = location.lat();
            var longitude = location.lng();

            // Appeler la fonction de rappel avec les coordonnées
            callback(latitude, longitude);
        } else {
            console.log("addresse",address);
            console.log('Geocode was not successful for the following reason: ' + status);
            // Gérer les erreurs ici, par exemple en affichant un message à l'utilisateur
        }
    });
}

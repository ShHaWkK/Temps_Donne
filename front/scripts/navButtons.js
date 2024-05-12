document.addEventListener("DOMContentLoaded", function() {
    // Sélectionnez tous les éléments de navigation
    var navItems = document.querySelectorAll('.navigation-menu .nav-item');

    // Parcourez chaque élément de navigation
    navItems.forEach(function(navItem) {
        // Ajoutez un écouteur d'événements clic à chaque élément de navigation
        navItem.addEventListener('click', function(event) {
            // Supprimez la classe "active" de tous les éléments de navigation
            navItems.forEach(function(item) {
                item.classList.remove('active');
            });

            // Ajoutez la classe "active" à l'élément de navigation cliqué
            navItem.classList.add('active');
        });
    });
});

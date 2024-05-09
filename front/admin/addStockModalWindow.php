<?php ?>
<div id="addStockModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Ajouter un stock</h2>
        <form id="entrepotForm" action="#" method="post">

            <label for="entrepotSelector">Entrepot:</label>
            <select id="entrepotSelector" name="entrepotSelector">
            </select><br><br>

            <label for="productSelector">Produit:</label>
            <select id="productSelector" name="productSelector">
            </select><br><br>

            <label for="quantity">Quantité:</label>
            <input type="number" id="quantity" name="quantity" required><br><br>

            <label for="status">Statut :</label>
            <select id="status" name="status">
                <option value="en_stock">En stock</option>
                <option value="en_route">En route</option>
            </select><br><br>

            <label for="datePeremption">Date de péremption:</label>
            <input type="date" id="datePeremption" name="datePeremption" value="2024-10-10"> <br><br>

            <input class="confirm-button" id="confirm-button-addStock" type="submit" value="Ajouter">
        </form>
    </div>
</div>


<script>
    console.log("On est dans stockModal");
    // Fonction pour ouvrir la fenêtre modale
    function openAddStockModal() {
        document.getElementById('addStockModal').style.display = 'block';
    }

    // Fermer la fenêtre modale lorsque l'utilisateur clique en dehors de celle-ci
    window.onclick = function(event) {
        var modal = document.getElementById('addStockModal');
        if (event.target === modal) {
            modal.style.display = "none";
        }
    }

    // Écouter les messages envoyés par l'iframe parent
    window.addEventListener('message', function(event) {
        if (event.data === 'openAddStockModal') {
            openAddStockModal();
        }
    });

    // Fermer la fenêtre modale lorsqu'on clique sur la croix
    document.querySelector('.close').addEventListener('click', function() {
        const modal = document.getElementById('addStockModal');
        modal.style.display = 'none';
    });
</script>

<script src="./js/addUser.js"></script>

</body>
</html>
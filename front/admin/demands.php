<?php
include_once('../includes/lang.php');
include_once('../includes/head.php');
include_once('./header.php');
echo "<title>Espace Administrateur - Demandes</title>";
?>

<head>
    <link rel="stylesheet" href="./css/table.css">
    <script src="./js/checkSessionAdmin.js"></script>
</head>

<body>

<h1 style="text-align: center;">Gestion des demandes</h1>

<center>
    <div class="main-container-tabs">
        <div class="line filters">

            <form action="#" method="post">
                <label for="statusFilter">Filtrer par statut :</label>
                <select id="statusFilter">
                    <option value="all">Tous</option>
                    <option value="Pending">En attente</option>
                    <option value="Granted">Validés</option>
                    <option value="Denied">Refusés</option>
                </select>
            </form>
        </div>

        <div class="line actions">

            <button class="tabButton addButton" id="approveDemand"> Approuver une demande </button>
            <script>
                document.getElementById('approveDemand').addEventListener('click', function() {
                    // Diviser la valeur sélectionnée en deux parties pour différencier l'id utilisateur de l'id service
                    const [userId, serviceId] = selectedDemand.split('-');
                    console.log("selectedDemand",selectedDemand);
                    console.log("User ID: ", userId);
                    console.log("Service ID: ", serviceId);

                    // Appeler la fonction approveDemand avec userId et serviceId
                    approveDemand(userId, serviceId);
                });
            </script>
            <button class="tabButton holdButton" id="holdDemand"> Mettre une demande en attente</button>
            <script>
                document.getElementById('holdDemand').addEventListener('click', function() {
                    // Diviser la valeur sélectionnée en deux parties pour différencier l'id utilisateur de l'id service
                    const [userId, serviceId] = selectedDemand.split('-');
                    console.log("User ID: ", userId);
                    console.log("Service ID: ", serviceId);

                    // Appeler la fonction approveDemand avec userId et serviceId
                    putOnHoldDemand(userId, serviceId);
                });
            </script>
            <button class="tabButton deleteButton" id="rejectDemand"> Refuser une demande</button>
            <script>
                document.getElementById('rejectDemand').addEventListener('click', function() {
                    // Diviser la valeur sélectionnée en deux parties pour différencier l'id utilisateur de l'id service
                    const [userId, serviceId] = selectedDemand.split('-');
                    console.log("User ID: ", userId);
                    console.log("Service ID: ", serviceId);

                    rejectUser(userId,serviceId)
                        .then(() => {
                            openDeleteModal();
                        })
                });
            </script>
        </div>
        <table id="demandsTable"></table>
    </div>
</center>

<script src="../scripts/getCookie.js"></script>
<script src="./js/filtersUsers.js"></script>
<script src="./js/users.js"></script>
<script src="./js/demandPageExecutionOrder.js"></script>
<script src="./js/demands.js"></script>

</body>

<?php
include_once('../includes/footer.php');
?>
</html>
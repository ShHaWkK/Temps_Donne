<?php
session_start();
include_once('../includes/lang.php');
include_once('../includes/head.php');
include_once('./header.php');
echo "<title>Espace bénévole - Planning</title>";
?>

<head>
    <link rel="stylesheet" href="./css/planning.css">
</head>

<script src="./js/planning.js"> </script>

<body>
<h2 style="text-align: center;">Planning</h2>
<center>
    <div id="calendar_content">
        <span id="calendar_messages"></span>
        <table>
            <tbody>
            <tr class="information-tab">
                <td><button id="previousMonth" name="previousMonth" class="direction-button" onclick="displayPreviousWeek()" type="button" role="button" aria-disabled="false"><span class="ui-button-text ui-c">◄</span></button></td>
                <td><label id="currentWeek" class="ui-outputlabel ui-widget" style="font-weight: bold"></label></td>
                <td><button id="nextMonth" name="nextMonth" class="direction-button" onclick="displayNextWeek()" type="button" role="button" aria-disabled="false"><span class="ui-button-text ui-c">►</span></button></td>
            </tr>
            </tbody>
        </table>

    </div>
    <center><button class="now-button" onclick="displayCurrentWeek()">Now</button></center>
    <table id="planningTable">
    </table>
</center>

<div id="eventModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <!-- Contenu de l'événement -->
        <p><strong>Evénement :</strong> <span id="eventName"></span></p>
        <p><strong>Description:</strong> <span id="eventDescription"></span></p>
        <p><strong>Date:</strong> <span id="eventDate"></span></p>
        <p><strong>Heure de début:</strong> <span id="eventStartTime"></span></p>
        <p><strong>Heure de fin:</strong> <span id="eventEndTime"></span></p>
    </div>
</div>


<script src="./js/eventDetails.js"></script>

</body>
</html>
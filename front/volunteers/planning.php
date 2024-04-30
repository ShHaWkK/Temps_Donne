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
</body>
</html>
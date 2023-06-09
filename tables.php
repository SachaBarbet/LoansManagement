<?php require 'init.php';
if (!$_SESSION['isAdmin']) {
    header('location: ./index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/tables.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />

        <link rel="apple-touch-icon" sizes="180x180" href="assets/images/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="assets/images/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicon-16x16.png">
        <link rel="manifest" href="assets/site.webmanifest">
        <noscript>Javascript isn't supported by your browser !</noscript>

        <title>LoanIT</title>
    </head>

    <?php
        // Définit la balise body (pour le chargement automatique d'une table au chargement de la page)
        $htmlAttributes = "";
        if(isset($_GET["table"]) && isset($tablesStruct[ucfirst($_GET['table'])])) {
            $lowerTable = ucfirst(strtolower($_GET['table']));
            $htmlAttributes= " onload=\"switchTable('{$lowerTable}');\"";
        }
        echo "<body{$htmlAttributes}>";
    ?>
        <main>
            <nav>
                <div><a href="./dashboard.php"><< BACK</a></div>
                <ul>
                    <li id="resources-link" class="link" onclick="switchTable('Resources');">RESOURCES</li>
                    <li id="users-link" class="link" onclick="switchTable('Users');">USERS</li>
                    <li id="loans-link" class="link" onclick="switchTable('Loans');">LOANS</li>
                </ul>
                <div></div>
            </nav>

            <div id="box-content">
                <div id="box-interaction-bar">
                    <div><button id="link-refresh" data="" onclick="clickRefresh();"><span class="material-symbols-outlined">refresh</span>REFRESH</button></div>
                    <div><button id="link-insert" data="" onclick="clickInsert();"><span class="material-symbols-outlined">add</span>INSERT</button></div>
                    <div><button id="link-clear" onclick="clickClear();"><span class="material-symbols-outlined">delete</span>CLEAR</button></div>
                    <form method="post" action="./php/delete.php" id="form-clear-table">
                        <input type="hidden" value="" name="table" id="input-clear-table">
                        <input type="hidden" value="" name="clear" id="input-clear-clear">
                    </form>
                </div>
                <p id="p-select" class="show">Select a table to display and manage it !</p>
            </div>

            <section id="section-update">
            </section>
        </main>
        <!--Box de chargement pour le chargement des tables-->
        <div id="box-loading"><p>Loading data...</p><div></div></div>
        <!--Clear table-->
        <div id="box-clear-background">
            <div id="box-clear">
                <p>You are about to clear this table !</p>
                <div>
                    <button onclick="validClear();">CLEAR</button>
                    <button onclick="cancelClear();">CANCEL</button>
                </div>
            </div>
        </div>
        <!--Javascript-->
        <script src="./javascript/update.js"></script>
        <script src="./javascript/table.js"></script>
        <script src="./javascript/interactions.js"></script>
    </body>
</html>
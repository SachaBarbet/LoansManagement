<?php require '../init.php';
if (!$_SESSION['isAdmin']) {
    header('location: ../index.php');
    exit();
}


// Ajout d'un élément dans l'une des tables de la base de données
if(isset($_POST["table"]) && isset($tablesStruct[$_POST["table"]])) {
    $table = $_POST["table"];
    $insertList = [];
    // Variable qui contient la requete
    $reqStart = "INSERT INTO {$table} (";
    $reqEnd = ") VALUES (";

    $isFirst = true;
    $qtyToReserv = 0;
    $resID = "";
    foreach($tablesStructNoID[$table] as $tableRows) {
        if(!isset($_POST[$tableRows])) continue;
        $element = htmlspecialchars($_POST[$tableRows]);
        if($table === "Loans") {
            if($tableRows === "qtyLent") {
                $qtyToReserv = $element;
            }
            if($tableRows === "resourceID") {
                $resID = $element;
            }
        }
        array_push($insertList, $element);
        if($isFirst) {
            $isFirst = false;
            $reqStart = "{$reqStart}{$tableRows}";
            $reqEnd = "{$reqEnd}?";
        } else {
            $reqStart = "{$reqStart}, {$tableRows}";
            $reqEnd = "{$reqEnd}, ?";
        }
    }

    $req = $reqStart . $reqEnd . ");";

    try {
        $pdo = new PDO($connect);
        $req = $pdo->prepare($req);
        $req->execute($insertList);
        $req->closeCursor();
        $pdo = null;
        $table = "?table={$table}";
    } catch (PDOException $e) {
        die("Error : " . $e);
    }

}
header("location: ../tables.php{$table}");
exit();
?>
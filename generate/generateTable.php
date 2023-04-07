<?php
    require '../init.php';

    // On vérifie que le nom de la table est défini dans l'url et quelle existe
    if(isset($_GET['tableName']) && isset($tablesStruct[$_GET['tableName']])) {
        $tableName = strtolower($_GET['tableName']);
        $firstLetterTableName = ucfirst($tableName);
        
        try {
            $pdo = new PDO($connect);
            $tableRows = $pdo->query("SELECT * FROM {$firstLetterTableName}");
            $pdo = null;
        } catch (PDOException $e) {
            die($e);
        }

        $tableLines = [];
        $tableHead = $tablesStruct[$firstLetterTableName]; //Contient l'entete de notre tableau (le nom des colones)
        # Pour chaque ligne de la table
        foreach($tableRows as $tableRow) {
            $line = "<tr>";
            # Pour chaque colonne de la ligne
            $skip = false; // Permet de sauter une valeur sur deux car on les retrouve en double
            $isCell1 = true; // La premiere valeur est toujours l'ID (la clé primaire) donc on la récupère, ça permet de mettre en form le formulaire d'insert sans l'id qui est en AI
            foreach($tableRow as $cell) {
                if ($skip) {
                    $skip = !$skip;
                    continue;
                }
                $skip = !$skip;
                if ($isCell1) {
                    $cellID = $cell;
                    $isCell1 = false;
                }
                
                $line .= "<td>{$cell}</td>";
            }
            // La cellule avec les boutons de modifications
            $line .= "<td class='td-button'><img src='./assets/images/pencil.png' class='image-update' onclick='updateBox(\"{$firstLetterTableName}\", \"{$cellID}\");' /><form action='./php/delete.php' method='post'><input type='hidden' name='deleteID' value='{$cellID}'><input type='hidden' name='table' value='{$firstLetterTableName}'><button class='button-sup' type='submit'><img src='./assets/images/delete.png' class='image-delete'></button></form></td>";
            $line .= "</tr>";
            array_push($tableLines, $line);
        }
    
        # Génération du HTML
        echo "<section id=\"section-{$tableName}\" class=\"section-table\">";
        // table
        echo "<table class=\"table-bdd\" id=\"table-{$tableName}\"><thead><tr>";
        foreach($tablesStruct[$firstLetterTableName] as $key) {
            echo "<th>{$key}</th>";
        }
        echo "<th class='th-button'></th></tr></thead><tbody>";
        foreach ($tableLines as $tableLinebis) {
            echo $tableLinebis;
        }
        echo "</tbody></table></section>";
    }
?>
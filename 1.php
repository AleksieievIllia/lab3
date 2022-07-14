<?php
include "connection.php";
$selectedProject = $_GET['selectedProject'];
$date = $_GET['date'];
$sqlSelect = $dbh->prepare("SELECT * FROM $db.work inner join $db.projects on $db.work.fid_projects = $db.projects.id_projects where $db.work.date = :date AND $db.projects.name = :selectedProject");
$sqlSelect->execute(array('date' => $date, 'selectedProject' => $selectedProject));
echo "<table border ='1'>";
echo "<tr><th>Выполненные таски</th><th>Дата</th><th>Проект</th></tr>";
while ($cell = $sqlSelect->fetch(PDO::FETCH_BOTH)) {
    echo "<tr><td>$cell[5]</td><td>$cell[2]</td><td>$cell[7]</td></tr>";
}
?>
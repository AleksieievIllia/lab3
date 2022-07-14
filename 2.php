<?php 
include "connection.php";
header('Content-Type', 'text/xml');
echo("<?xml version='1.0' encoding = 'UTF-16'?>");
echo "<root>";
$project = $_GET['project'];
 $sqlSelect = $dbh->prepare("SELECT ROUND(($db.work.time_end - $db.work.time_start)/10000,2) AS time, $db.projects.name, $db.worker.ID_WORKER FROM $db.work inner join $db.projects on $db.work.FID_PROJECTS = $db.projects.ID_projects inner join $db.worker on $db.work.FID_WORKER = $db.worker.ID_WORKER where $db.projects.name = :project;");
 $sqlSelect->execute(array('project' => $project));
 echo "<row><time>time</time><title>title</title><ID>id_workers</ID></row>";
 while ($cell = $sqlSelect->fetch(PDO::FETCH_BOTH)) {
    echo "<row><time>$cell[0]</time><title>$cell[1]</title><ID>$cell[2]</ID></row>";
 }
 echo "</root>";
 ?>

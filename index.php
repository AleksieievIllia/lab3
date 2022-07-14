<!DOCTYPE HTML>
<html>
<head>
    <title>ЛБ3</title>
    <script>
        var ajax = new XMLHttpRequest();

function text() {
    ajax.onreadystatechange = function() {
        if (ajax.readyState === 4) {
            if (ajax.status === 200) {
                console.dir(ajax.responseText);
                document.getElementById("res").innerHTML = ajax.responseText;
            }
        }
    }
    var selectedProject = document.getElementById("selectedProject").value;
    var date = document.getElementById("date").value;
    ajax.open("get", "1.php?selectedProject=" + selectedProject + "&" + "date=" + date);
    ajax.send();
}

function xml() {
    var project = document.getElementById("project").value;
    ajax.open("get", "2.php?project=" + project, true);
    ajax.overrideMimeType('text/xml');
    ajax.onreadystatechange = function() {
        if (ajax.readyState === 4) {
            if (ajax.status === 200) {
                console.dir(ajax.responseXML);
                let rows = ajax.responseXML.firstChild.children;
                let resTable = "<table border='1'>";
                let resDouble = 0.0; 
                for(var i = 0; i < rows.length; i++){
                    if(i == 0){
                    resTable += "<tr><th>" + rows[i].children[0].firstChild.nodeValue + "</th>";
                    resTable += "<th>" + rows[i].children[1].firstChild.nodeValue + "</th>";
                    resTable += "<th>" + rows[i].children[2].firstChild.nodeValue + "</th>" + "</tr>";
                    }
                    else{
                    resDouble += parseFloat(rows[i].children[0].firstChild.nodeValue);
                    resTable += "<tr><td>" + rows[i].children[0].firstChild.nodeValue + "</td>";
                    resTable += "<td>" + rows[i].children[1].firstChild.nodeValue + "</td>";
                    resTable += "<td>" + rows[i].children[2].firstChild.nodeValue + "</td></tr>";
                }
                }
                let res = "Общее количество времени затраченное на проект равно " + resDouble + " Ч." + resTable;
                console.dir(resDouble);
                document.getElementById("res").innerHTML = res;
            }    
        }
    }
    ajax.send();
}



function json() {
    ajax.onreadystatechange = function() {
    console.dir(ajax);
    let rows = JSON.parse(ajax.response);
    console.dir(rows);
     if (ajax.readyState === 4) {
        if (ajax.status === 200) {
            
            let result = "ID-cотрудников руководителя ";
            result += rows[0].chief + ":"
            for (var i = 0; i < rows.length; i++) {
             result += " " + rows[i].ID_WORKER + " ";
            }
            result += "</br> Общее число сотрудников руководителя равно " + rows.length;
            document.getElementById("res").innerHTML = result; 
            }
        } 
    };
    var chief = document.getElementById("chief").value;
    ajax.open("get", "3.php?chief=" + chief);
    ajax.send();
}   
    </script>
</head>

<body>
<h3>Алексеев Илья, КИУКИ-19-1, Вар №2</h3>
<p>Выполненные задачи</p>
    <select name="selectedProject" id="selectedProject">
        <?php
        include 'connection.php';
        $sqlSelect = "SELECT DISTINCT * FROM $db.projects";
        foreach ($dbh->query($sqlSelect) as $cell) {
            echo "<option>";
            print($cell[1]);
            echo "</option>";
        }
        ?>
    </select>
    <select name="date" id="date">
        <?php
        include 'connection.php';
        $sqlSelect = "SELECT DISTINCT $db.work.date FROM $db.work";
        foreach ($dbh->query($sqlSelect) as $cell) {
            echo "<option>";
            print($cell[0]);
            echo "</option>";
        }
        ?>
    </select>
    <input type="submit" value="ok" onclick = "text()">


<p>Время работы над проектом</p>
    <select name="project" id="project">
        <?php
        include 'connection.php';
        $sqlSelect = "SELECT DISTINCT * FROM $db.projects";
        foreach ($dbh->query($sqlSelect) as $cell) {
            echo "<option>";
            print($cell[1]);
            echo "</option>";
        }
        ?>
    </select>
    <input type="submit" value="ok" onclick = "xml()">

<p>Количество сотрудников отдела с руководителем</p>
    <select name="chief" id="chief">
        <?php
        include 'connection.php';
        $sqlSelect = "SELECT DISTINCT * FROM $db.department";
        foreach ($dbh->query($sqlSelect) as $cell) {
            echo "<option>";
            print($cell[1]);
            echo "</option>";
        }
        ?>
    </select>
    <input type="submit" value="ok" onclick="json()">
    <p></p>
    <div id = "res"></div>

</body>
</html>
<!-- The FULL OUTER JOIN keyword returns all records when there is a match in left (table1) or right (table2) table records. -->
<table border="1">
    <tr>
        <th>Id</th>
        <!-- <th>Name</th> -->
        <!-- <th>Age</th> -->
        <th>Sports</th>
        <th>Activity</th>
    </tr>
    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $databasename = "task";
    // Create connection
    $conn = new mysqli($servername, $username, $password, $databasename);
    //$query = "SELECT * FROM user as us inner join employees as em  on us.id = em.id";
    //$query = "SELECT us.ID,us.Name,us.Email,em.Salary FROM user as us inner join employees as em  on us.id = em.id";
    $query = "SELECT * FROM student_sports as spr cross join nss_ncc as ncs  on spr.id = ncs.id";
    $result = $conn->query($query);
    while ($row = $result->fetch_assoc()) {
    ?>
        <tr>
            <td><?php echo $row["ID"] ?></td>
            <!-- <td><//?php echo $row["Name"] ?></td> -->
            <!-- <td><//?php echo $row["Age"] ?></td> -->
            <td><?php echo $row["sports"] ?></td>
            <td><?php echo $row["activity"] ?></td>
        </tr>
    <?php
    }
    ?>
<!-- The LEFT JOIN keyword returns all records from the left table (table1), and the matching records from the right table (table2). The result is 0 records from the right side, if there is no match. -->
<table border="1">
    <tr>
        <th>Id</th>
        <th>Name</th>
        <th>Age</th>
        <th>Sports</th>
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
    $query = "SELECT * FROM student_details as det left join student_sports as spr  on det.id = spr.id";
    $result = $conn->query($query);
    while ($row = $result->fetch_assoc()) {
    ?>
        <tr>
            <td><?php echo $row["ID"] ?></td>
            <td><?php echo $row["Name"] ?></td>
            <td><?php echo $row["Age"] ?></td>
            <td><?php echo $row["sports"] ?></td>
        </tr>
    <?php
    }
    ?>
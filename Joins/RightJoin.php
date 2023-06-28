<!-- The RIGHT JOIN keyword returns all records from the right table (table2), and the matching records from the left table (table1). The result is 0 records from the left side, if there is no match. -->
<table border="1">
    <tr>
        <th>Id</th>
        <th>Name</th>
        <th>Age</th>
        <th>Email</th>
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
    $query = "SELECT * FROM user as us right join student_details as det on det.id = us.id";
    $result = $conn->query($query);
    while ($row = $result->fetch_assoc()) {
    ?>
        <tr>
            <td><?php echo $row["ID"] ?></td>
            <td><?php echo $row["Name"] ?></td>
            <td><?php echo $row["Age"] ?></td>
            <td><?php echo $row["Email"] ?></td>
        </tr>
    <?php
    }
    ?>
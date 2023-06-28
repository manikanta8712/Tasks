<!-- Inner Join used for to print data on common data in different tables-->
<!-- The INNER JOIN keyword selects records that have matching values in both tables. -->
<table border="1">
    <tr>
        <!-- <th>Id</th>
        <th>Name</th>
        <th>Email</th>
        <th>Salary</th> -->
        <th>Id</th>
        <th>Name</th>
        <th>Age</th>
        <th>Sports</th>
        <!-- <th>Email</th> -->
        <!-- <th>Phone Number</th> -->
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
    $query = "SELECT * FROM student_details as det inner join student_sports as spr  on det.id = spr.id";//two tables
    //$query = "SELECT * FROM student_details as det inner join student_sports as spr  on det.id = spr.id inner join user as us on spr.id = us.id";//three tables
    $result = $conn->query($query);
    while ($row = $result->fetch_assoc()) {
    ?>
        <tr>
            <!-- <td><//?php echo $row["ID"] ?></td>
            <td><//?php echo $row["Name"] ?></td>
            <td><//?php echo $row["Email"] ?></td>
            <td><//?php echo $row["Salary"] ?></td> -->
            <!-- <td><//?php echo $row["Phone Number"] ?></td> -->
            <td><?php echo $row["ID"] ?></td>
            <td><?php echo $row["Name"] ?></td>
            <td><?php echo $row["Age"] ?></td>
            <td><?php echo $row["sports"] ?></td>
            <!-- <td><//?php echo $row["Email"] ?></td> -->
        </tr>
    <?php
    }
    $conn->close();
    ?>
    <!-- SQL 
1)Inner Join ->it displays only common data
2)Left Join->it displays common and left table data
3)Right Join->it displays common and right table data
3)Full Outer Join->it displays common and uncommon data
4)Self Join-> -->
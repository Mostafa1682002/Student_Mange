<?php

include_once('session.php');
include_once('connection.php');
echo "Hello Admin " . $_SESSION['admin'];

$qury = $connection->query('select * from student inner join departments on student.stu_depart=departments.stu_depart ');
$allStudents = $qury->fetchAll(PDO::FETCH_ASSOC);
?>
<br>
<a href="logout.php">logout</a>
<br>
<a href="addStudent.php">add students</a>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.2/css/dataTables.bootstrap5.min.css">
    <!-- FontAwsome  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/login.css">
</head>

<body>
    <div class="my-5">
        <div class="container">
            <table id="example" class="table table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>phone</th>
                        <th>Date Of Birth</th>
                        <th>Department</th>
                        <th>Skills</th>
                        <th>Image</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($allStudents as $student) {
                    ?>
                        <tr>
                            <td><?php echo $student['stu_id'] ?></td>
                            <td><?php echo $student['stu_name'] ?></td>
                            <td><?php echo $student['stu_email'] ?></td>
                            <td><?php echo $student['stu_phone'] ?></td>
                            <td><?php echo $student['stu_date_birth'] ?></td>
                            <td><?php echo $student['depart_name'] ?></td>
                            <td>
                                <ul class="skills">
                                    <?php
                                    $skills = explode(',', $student['stu_skills']);
                                    foreach ($skills as $skill) {
                                        echo "<li>$skill</li>";
                                    }
                                    ?>
                                </ul>
                            </td>
                            <td><img src="uplode/imges/<?php echo  $student['stu_imge'] ?>" alt="" class="imge-stu">
                            </td>
                            <td>
                                <a href="update.php?id=<?php echo $student['stu_id'] ?>" class="btn  btn-success"><i class="fa-solid fa-pen-to-square"></i></a>
                                <a href="deleteStudent.php?id=<?php echo $student['stu_id'] ?>" class="btn btn-danger"><i class="fa-sharp fa-solid fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.2/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#example').DataTable();
        });
        fetch('api.json').then((e) => e.json()).then(e => console.log(e))
    </script>
</body>


</html>
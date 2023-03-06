<?php
include_once('session.php');
include_once('connection.php');
if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    header('Location: index.php');
}
$connection->query("delete from student where stu_id=$id");
header('Location: index.php');

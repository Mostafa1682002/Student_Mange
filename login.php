<?php
session_start();
if (isset($_SESSION['admin'])) {
    header('Location: index.php');
}
include_once('connection.php');
$q = $connection->query('select * from admin');

if (isset($_POST['login'])) {
    $email_admin = $_POST['email_admin'];
    $password_admin = $_POST['password_admin'];
    $Errors = [];
    if (empty($email_admin)) {
        $Errors['email_required'] = 'Email Adress Is Required';
    }
    if (empty($password_admin)) {
        $Errors['password_required'] = 'Password Adress Is Required';
    }

    $connection = $connection->query("select * from admin where admin_email='$email_admin' and admin_password='$password_admin'");
    $count = $connection->rowCount();
    $results = $connection->fetch(PDO::FETCH_ASSOC);
    if ($count == 1) {
        $admin_name = $results['admin_name'];
        $_SESSION['admin'] = $admin_name;
        header('location: index.php');
    }
    if ($count == 0 && !empty($email_admin) && !empty($password_admin)) {
        $Errors['pass_email_wrong'] = 'Email Or Password Adress Is Wrong';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/login.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Login School System</title>
</head>

<body>
    <section>
        <div class="container p-3">
            <h1 class="text-danger text-center pb-2">Admin Login</h1>
            <?php
            if (!empty($Errors)) {
                foreach ($Errors as $error) {
                    echo "<div class='alert alert-danger'>$error</div>";
                }
            }
            ?>
            <form action="" method="post" class="form">
                <div class="form-group p-2">
                    <label for="" class="form-label">Email :</label>
                    <input class="form-control" type="email" name="email_admin">
                </div>
                <div class="form-group p-2">
                    <label class="form-label">Password :</label>
                    <input class="form-control" type="password" name="password_admin">
                </div>
                <button class="btn btn-primary m-2" name="login">Login</button>
            </form>
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>

</html>
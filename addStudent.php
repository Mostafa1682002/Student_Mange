<?php
include_once('session.php');
include_once('connection.php');

$departments = $connection->query('select * from departments');
$departments = $departments->fetchAll(PDO::FETCH_ASSOC);
$skills = $connection->query('select * from skills');
$skills = $skills->fetchAll(PDO::FETCH_ASSOC);





if (isset($_POST['addstudent'])) {
    $stu_id = $_POST['stu_id'];
    $stu_name = $_POST['stu_name'];
    $stu_email = $_POST['stu_email'];
    $stu_phone = $_POST['stu_phone'];
    $stu_date_birth = $_POST['stu_date_birth'];
    $stu_depart = $_POST['stu_depart'];
    $stu_skills = !empty($_POST['stu_skills']) ? $_POST['stu_skills'] : [];
    $stu_imge = $_FILES['stu_imge']['tmp_name'] ? $_FILES['stu_imge']['tmp_name'] : '';
    $Error = [];
    if (empty($_FILES['stu_imge']['name']) && isset($_FILES['stu_imge'])) {
        $Error["imge_required"] = "Student Image Is Required";
    }


    $imgename = $_FILES['stu_imge']['name'];
    $to = 'uplode/imges/' . $imgename;

    //Filter Name And Skills
    $stu_name = ucwords(strtolower(filter_var($stu_name, FILTER_SANITIZE_STRING)));
    $fstu_skills = implode(',', $stu_skills);

    $checkStudent = $connection->query("select * from student where stu_id='$stu_id'");
    $count = $checkStudent->rowCount();
    if ($count > 0) {
        $Error['reapte_id'] = 'ID IS Exists Please Enter Another Id';
    }
    checkempty($stu_id, 'id_required', 'Student ID Is Required');
    checkempty($stu_name, 'name_required', 'Student Name Is Required');
    checkempty($stu_email, 'email_required', 'Student Email Is Required');
    checkempty($stu_depart, 'depart_required', 'Student Department Is Required');
    check($stu_email, FILTER_VALIDATE_EMAIL, 'invalid_Email', 'Please Enter Email validate');
    check($stu_id, FILTER_VALIDATE_INT, 'invalid_id', 'Id Can acceept Number Only');

    if (empty($Error)) {
        $connection->query("INSERT INTO `student` (`stu_id`, `stu_name`, `stu_email`, `stu_phone`, `stu_date_birth`, `stu_depart`, `stu_skills`,`stu_imge`) VALUES ($stu_id ,'$stu_name', '$stu_email', '$stu_phone', '$stu_date_birth', $stu_depart, '$fstu_skills','$imgename');");
        move_uploaded_file($stu_imge, $to);
        echo "<div class='alert alert-success'>Student Is Added</div>";
    }
}

function check($filed, $filter, $errorMsg, $msg)
{
    global $Error;
    if (!filter_var($filed, $filter)) {
        $Error["$errorMsg"] = $msg;
    }
}
function checkempty($filed, $errorMsg, $msg)
{
    global $Error;
    if (empty($filed)) {
        $Error["$errorMsg"] = $msg;
    }
};


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/login.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- FontAwsome  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Phone Validation  -->
    <!-- <link rel="stylesheet" href="build/css/demo.css" /> -->
    <link rel="stylesheet" href="build/css/intlTelInput.css" />
    <!-- Flatpicker  -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <title>Add Student</title>
</head>

<body>
    <section>
        <div class="container">
            <h2 class="text-primary text-center">Add Student</h2>
            <form action="" method="post" class="form" enctype="multipart/form-data">
                <div class="my-2 validate">
                    <label for="id" class="form-label">ID :</label>
                    <input type="text" name="stu_id" id="id" class="form-control" value="<?php echo isset($_POST['addstudent']) && !empty($Error) ? $stu_id : ''; ?>">
                    <?php
                    if (isset($Error['id_required'])) {
                        echo "<div class='alert alert-danger'>" . $Error['id_required'] . "</div>";
                    } elseif (isset($Error['reapte_id'])) {
                        echo "<div class='alert alert-danger'>" . $Error['reapte_id'] . "</div>";
                    } elseif (isset($Error['invalid_id'])) {
                        echo "<div class='alert alert-danger'>" . $Error['invalid_id'] . "</div>";
                    }
                    ?>
                </div>
                <div class="my-2 ">
                    <label for="name" class="form-label">Name :</label>
                    <input type="text" name="stu_name" id="name" class="form-control" value="<?php echo isset($_POST['addstudent']) && !empty($Error) ? $stu_name : ''; ?>">
                    <?php
                    if (isset($Error['name_required'])) {
                        echo "<div class='alert alert-danger'>" . $Error['name_required'] . "</div>";
                    }
                    ?>
                </div>
                <div class="my-2 ">
                    <label for="email" class="form-label">Email :</label>
                    <input type="text" name="stu_email" id="email" class="form-control" value="<?php echo isset($_POST['addstudent']) && !empty($Error) ? $stu_email : ''; ?>">
                    <?php
                    if (isset($Error['email_required'])) {
                        echo "<div class='alert alert-danger'>" . $Error['email_required'] . "</div>";
                    } elseif (isset($Error['invalid_Email'])) {
                        echo "<div class='alert alert-danger'>" . $Error['invalid_Email'] . "</div>";
                    }
                    ?>
                </div>
                <div class="my-2 ">
                    <label for="phone" class="form-label">Phone :</label>
                    <input type="tel" name="stu_phone" id="phone" class="form-control" value="<?php echo isset($_POST['addstudent']) && !empty($Error) ? $stu_phone : ''; ?>">
                </div>
                <div class="my-2">
                    <label for="birth" class="form-label">Date of Birth :</label>
                    <input type="datetime-local" name="stu_date_birth" id="birth" class="form-control" placeholder="Select Date">
                </div>
                <div class="my-2">
                    <label for="department" class="form-label">Department :</label>
                    <select class="form-select" name="stu_depart">
                        <option></option>
                        <?php
                        foreach ($departments as $depart) {
                        ?>
                            <option value="<?php echo $depart['stu_depart'] ?>" <?php echo isset($_POST['addstudent']) && !empty($Error) && $depart['stu_depart'] == $stu_depart ? 'selected' : ''; ?>>
                                <?php echo $depart['depart_name'] ?>
                            </option>
                        <?php } ?>
                    </select>
                    <?php
                    if (isset($Error['depart_required'])) {
                        echo "<div class='alert alert-danger'>" . $Error['depart_required'] . "</div>";
                    }
                    ?>
                </div>
                <div class="my-2">
                    <label for="Skills" class="form-label">Skills :</label><br>
                    <?php
                    foreach ($skills as $skill) {
                    ?>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="stu_skills[]" id="<?php echo $skill['skill_num'] ?>" value="<?php echo $skill['skill_name'] ?>" <?php echo isset($_POST['addstudent']) && !empty($Error) && in_array($skill['skill_name'], $stu_skills) ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="<?php echo $skill['skill_num'] ?>">
                                <?php echo $skill['skill_name'] ?>
                            </label>
                        </div>
                    <?php } ?>
                </div>
                <div class="my-2 .files">
                    <label for="userPhoto" class="form-label">image :</label>
                    <input type="file" name="stu_imge" id="userPhoto" class="form-control" accept="image/*">
                    <img src="" id="photo" class="photo" alt="">
                    <?php
                    if (isset($Error['imge_required'])) {
                        echo "<div class='alert alert-danger'>" . $Error['imge_required'] . "</div>";
                    }
                    ?>
                </div>
                <div class="py-3">
                    <input type="submit" name="addstudent" value="Add" class="btn btn-primary col-12">
                </div>
            </form>
        </div>
    </section>
    <!-- Flatpicker  -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <!-- Phone Validation  -->
    <script src="build/js/intlTelInput.js"></script>
    <script>
        var input = document.querySelector("#phone");
        window.intlTelInput(input, {});
        var config = {
            enableTime: true,
            dateFormat: "Y-m-d",
        }
        flatpickr("#birth", config);
        const inputUpload = document.getElementById("userPhoto");
        const image = document.getElementById("photo");
        if (inputUpload) {
            const imageSrc = image.getAttribute("src");
            inputUpload.onchange = () => {
                let reader = new FileReader();

                if (inputUpload.files[0]) {
                    reader.readAsDataURL(inputUpload.files[0]);
                } else {
                    image.setAttribute("src", imageSrc);
                    image.classList.remove("wid");
                }

                reader.onload = () => {
                    image.setAttribute("src", reader.result);
                    image.classList.add("wid");
                };
            };
        }
    </script>
</body>

</html>
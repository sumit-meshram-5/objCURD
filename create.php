<?php

use objCURD\LibObj;

include('LibObj.php');

$obj = new LibObj();


if (isset($_REQUEST['back'])) {
    header('Location: ./index.php');
}

if (isset($_REQUEST['submit'])) {
    //get variables
    $name = trim($_REQUEST['name']);
    $email = trim($_REQUEST['email']);

    //validate 
    //name aphanumeric
    if (!ctype_alnum($name)) {
        echo '<br>';
        echo $error['name'] = '<h5 class="text-center text-danger">name should be alpha numeric</h5>';
    } else {
        if (is_numeric(substr($name, 0, 1))) {
            echo '<br>';
            echo $error['name'] = '<h5 class="text-center text-danger">first letter of name should be alphabetical</h5>';
        }
    }

    //email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo '<br>';
        echo $error['email'] = '<h5 class="text-center text-danger">Invalid email format</h5>';
    }

    if (empty($error)) {
        //code for insert
        $data = [
            'name' => $name,
            'email' => $email,
        ];

        if ($obj->create($data)) {
            $success = $obj->getresult();
        } else {
            $fail = $obj->getresult();
        }
    } else {
        echo '';
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Object CRUD </title>

    <!-- google fonts -->



    <!-- bootstrap cdn link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>



</head>

<body>
    <div class="container">
        <!-- form card -->
        <br>
        <div class="card text-center m-auto">
            <div class="card-header">
                Object CRUD App
            </div>
            <?php if (isset($success)) : ?>
                <div class="alert alert-success">
                    <?= $success ?>
                </div>
            <?php endif ?>
            <?php if (isset($fail)) : ?>
                <div class="alert alert-danger">
                    <?= $fail ?>
                </div>
            <?php endif ?>
            <div class="card-body">
                <h5 class="card-title">Fill the Form</h5>
                <!-- form -->
                <form action="" method="post">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value=<?php if (isset($success)) {
                                                                                                echo '';
                                                                                            } else {
                                                                                                if (isset($_REQUEST['name'])) {
                                                                                                    echo $_REQUEST['name'];
                                                                                                } else {
                                                                                                    echo '';
                                                                                                }
                                                                                            }  ?>>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" class="form-control" id="email" name="email" value=<?php if (isset($success)) {
                                                                                                    echo '';
                                                                                                } else {
                                                                                                    if (isset($_REQUEST['email'])) {
                                                                                                        echo $_REQUEST['email'];
                                                                                                    } else {
                                                                                                        echo '';
                                                                                                    }
                                                                                                }  ?>>
                    </div>
                    <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                    <button type="submit" class="btn btn-primary" name="back">Back</button>
                </form>
            </div>
            <div class="card-footer">
                All rights Reserved
            </div>
        </div>
    </div>
</body>

</html>
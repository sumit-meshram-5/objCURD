<?php

use objCURD\LibObj;

include('LibObj.php');

$obj = new LibObj();

if (!is_numeric(($_REQUEST['id']))) {
    header('Location: ./index.php');
} else {
    $id = trim($_REQUEST['id']);
}
if ($obj->get($id)) {
    $row = $obj->getresult();
} else {
    $fail = $obj->getresult();
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
        <br>
        <div class="card text-center m-auto">
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
            <div class="card-header">
                Object CRUD App
            </div>
            <div class="card-body">
                <h5 class="card-title">View User Records</h5>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row"><?= $row['id']; ?></th>
                            <td><?= $row['name']; ?></td>
                            <td><?= $row['email']; ?></td>
                        </tr>
                    </tbody>
                </table>
                <a href="index.php" class="btn btn-primary  mx-auto">Back</a>
            </div>
            <div class="card-footer ">
                All rights Reserved
            </div>
        </div>
    </div>
</body>

</html>
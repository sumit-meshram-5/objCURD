<?php

use objCURD\LibObj;

include('LibObj.php');

$obj = new LibObj();


if (isset($_REQUEST['limit'])) {
    if (!is_numeric(($_REQUEST['limit']))) {
        //header('Location: ./index.php');
    } else {
        $limit = trim($_REQUEST['limit']);
    }
} else {
    $limit = 0;
}

if (isset($_REQUEST['limit'])) {
    if (!is_numeric(($_REQUEST['page']))) {
        //header('Location: ./index.php');
    } else {
        $page = trim($_REQUEST['page']);
    }
} else {
    $page = 1;
}

if ($obj->get_total_pages($limit)) {
    $total_pages = $obj->getresult();
}

if ($limit == 0) {
    $page = 1;
}

if ($obj->read($limit, $page)) {
    $data = $obj->getresult();
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
    <title>Object CRUD </title>

    <!-- bootstrap cdn link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>

</head>

<body>

    <!-- main card -->
    <div class="container">
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
                <h5 class="card-title">User Records
                    <a href="create.php" class="btn btn-primary float-end"> Create Records</a href="create.php">
                </h5>
                <form action="" method="get" class="float-start">
                    <!-- <label for="name" class="">Records per page :</label> -->
                    <select name="limit" id="limit">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="15">15</option>
                        <option value="20">20</option>
                        <option value="0">All</option>
                    </select>
                    <button type="submit" class="btn btn-sm btn-primary" value="1" name="page">Set Records per page </button>
                </form>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- php code here -->
                        <?php foreach ($data as $row) : ?>
                            <tr>
                                <th scope="row"><?= $row['id']; ?></th>
                                <td><?= $row['name']; ?></td>
                                <td><?= $row['email']; ?></td>
                                <td>
                                    <a href="view.php?id=<?= $row['id']; ?>" class="btn btn-primary">View</a>
                                    <a href="edit.php?id=<?= $row['id']; ?>" class="btn btn-primary">Edit</a>
                                    <a href="delete.php?id=<?= $row['id']; ?>" class="btn btn-danger">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <nav aria-label="Page navigation">
                <ul class="pagination">
                    <?php if ($page > 1) : ?>
                        <li class="page-item "><a class="page-link" href="/index.php?limit=<?= $limit ?>&page=<?= $page - 1 ?>">Prev</a></li>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                        <?php if ($i == $page) : ?>
                            <li class="page-item active"><a class="page-link" href="/index.php?limit=<?= $limit ?>&page=<?= $i ?>"><?= $i ?></a></li>
                        <?php else : ?>
                            <li class="page-item "><a class="page-link" href="/index.php?limit=<?= $limit ?>&page=<?= $i ?>"><?= $i ?></a></li>
                        <?php endif; ?>
                    <?php endfor; ?>
                    <?php if ($page != $total_pages) : ?>
                        <li class="page-item"><a class="page-link" href="/index.php?limit=<?= $limit ?>&page=<?= $page + 1 ?>">Next</a></li>
                    <?php endif; ?>
                </ul>
            </nav>

            <div class="card-footer ">
                All rights Reserved
            </div>
        </div>
    </div>

</body>

</html>
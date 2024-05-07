<?php
session_start();
include "connect.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Basic PHP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body class="p-5">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card-title">Post List</div>
                            </div>
                            <div class="col-md-6">
                                <a href="post_create.php" class="float-end btn btn-primary">+ Add New</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php if (isset($_SESSION['successMsg'])) : ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <?php
                                echo $_SESSION['successMsg'];
                                unset($_SESSION['successMsg']);
                                ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>


                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $statement = $db->prepare("SELECT * FROM posts");
                                $statement->execute();
                                $posts = $statement->fetchAll(PDO::FETCH_ASSOC);

                                foreach ($posts as $post) {
                                ?>
                                    <tr>
                                        <td><?php echo $post['id']; ?></td>
                                        <td><?php echo $post['title'];  ?></td>
                                        <td><?php echo $post['description'];  ?></td>
                                        <td>
                                            <a href="post_edit.php?postID=<?php echo $post['id']; ?>">Edit</a> |
                                            <a href="index.php?delete_postID=<?php echo $post['id']; ?>" onclick="return confirm('Are you sure you want to delete')">Delete</a>
                                        </td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    if (isset($_GET['delete_postID'])) {
        $delete_postID = $_GET['delete_postID'];
        $statement = $db->prepare("DELETE FROM posts WHERE id=$delete_postID");
        $statement->execute();
        $_SESSION['successMsg'] = 'A post Deleted successfully';
        echo '<script>window.location.href = "index.php";</script>';
        exit();
    }
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>


    <script>
        if (<?php echo isset($_SESSION['successMsg']) ? 'true' : 'false'; ?>) {
            window.location.href = "index.php";
        }
    </script>
</body>

</html>
<?php
session_start();
include 'connect.php';
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
                                <div class="card-title">Post Edit Form</div>
                            </div>
                            <div class="col-md-6">
                                <a href="index.php" class="float-end btn btn-secondary">
                                    << Back</a>
                            </div>
                        </div>
                    </div>

                    <?php
                    $titleErr = '';
                    $desErr = '';
                    $title = '';
                    $desc = '';

                    if (isset($_GET['postID'])) {
                        $update_post_id = $_GET['postID'];

                        $statement = $db->prepare("SELECT * FROM posts WHERE id=$update_post_id");
                        // $statement->bindParam(':update_post_id', $_GET['postID']);

                        // bindParam သုံးမယ်ဆိုရင် WHERE id= ":update_post_id" လို့ပြောင်းရမယ်

                        $statement->execute();

                        $rowCount = $statement->rowCount();

                        if ($rowCount == 1) {
                            $row = $statement->fetch(PDO::FETCH_ASSOC);
                            $postID = $row['id'];
                            $title = $row['title'];
                            $desc = $row['description'];
                        }
                    }

                    // Update Post

                    if (isset($_POST['update_post_button'])) {
                        $postID = $_POST['post_id'];
                        $title = $_POST['title'];
                        $desc = $_POST['description'];

                        if (empty($title)) {
                            $titleErr = "The Title Field is required";
                        }
                        if (empty($desc)) {
                            $desErr = "The Description is required";
                        }

                        if (!empty($title) && !empty($desc)) {
                            $statement = $db->prepare("UPDATE posts SET title=:title, description=:desc WHERE id=:postID");
                            $statement->execute(['title' => $title, 'desc' => $desc, 'postID' => $postID]);
                            $_SESSION['successMsg'] = 'A post Updated successfully';
                            header('location:index.php');
                            exit;
                        }
                    }


                    // if (isset($_POST['update_post_button'])) {
                    //     $postID = $_POST['post_id'];
                    //     $title = $_POST['title'];
                    //     $desc = $_POST['description'];

                    //     $statement = $db->prepare("UPDATE posts SET title=:title, description=:description WHERE id=:postID");
                    //     $statement->bindParam(':title', $title);
                    //     $statement->bindParam(':description', $desc);
                    //     $statement->bindParam(':postID', $postID);
                    //     $statement->execute();
                    // }

                    ?>

                    <form action="post_edit.php" method="post">
                        <div class="card-body">
                            <input type="hidden" name="post_id" value="<?php echo $postID; ?>">
                            <div class="form-group">
                                <label for="">Title</label>
                                <input type="text" placeholder="Please Add Title" class="form-control mt-2 <?php if ($titleErr != '') : ?> is-invalid <?php endif ?>" name="title" value="<?php echo $title; ?>">
                                <span class="text-danger"><?php echo $titleErr ?></span>
                            </div>
                            <div class="form-group mt-3">
                                <label for="">Description</label>
                                <textarea class="form-control mt-2 <?php if ($desErr != '') : ?> is-invalid <?php endif ?>" placeholder="Please Add Description" name="description"><?php echo $desc; ?></textarea>
                                <span class="text-danger"><?php echo $desErr ?></span>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" name="update_post_button" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>





    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>
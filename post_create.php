<?php
session_start();
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
                                <div class="card-title">Post Creation Form</div>
                            </div>
                            <div class="col-md-6">
                                <a href="index.php" class="float-end btn btn-secondary">
                                    << Back</a>
                            </div>
                        </div>
                    </div>

                    <?php
                    include "connect.php";
                    $titleErr = '';
                    $desErr = '';
                    $title = '';
                    $desc = '';
                    if (isset($_POST['post_button'])) {
                        $title = $_POST['title'];
                        $desc = $_POST['description'];

                        if (empty($title)) {
                            $titleErr = "The Title Field is required";
                        }
                        if (empty($desc)) {
                            $desErr = "The Description is required";
                        }

                        if (!empty($title) && !empty($desc)) {
                            $sql = "INSERT INTO posts (title, description) VALUES (:title, :desc)";
                            $statement = $db->prepare($sql);
                            $statement->execute(['title' => $title, 'desc' => $desc]);
                            $_SESSION['successMsg'] = 'A post created successfully';
                            header('location: index.php');
                        }
                    }
                    ?>

                    <form action="post_create.php" method="post">
                        <div class="card-body">
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
                            <button type="submit" name="post_button" class="btn btn-primary">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>





    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>
<?php 
    include_once '../helpers/Format.php';
    $fm = new Format();

    // $path = $_SERVER['SCRIPT_FILENAME'];
    // $currentpage = basename($path,'.php');
?>

<!doctype html>
<html lang="en">
  <head>

    <!--  ======== Show Title Name By Page Changing Start ====== -->
    <title><?php echo $fm->title() ?></title>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css    "> -->
</head>
  <body>


    <!-- Navbar -->
    <div class="container-fluid p-1 m-1">
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <a class="navbar-brand mr-5" href="#">Admin</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
          
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-5">
                    <li class="nav-item  <?php if($fm->title()=='Home'){ echo 'active'; } ?>" >
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item  <?php if($fm->title()=='Category'){ echo 'active'; } ?>">
                        <a class="nav-link" href="category.php">Category</a>
                    </li>
                    <li class="nav-item  <?php if($fm->title()=='Post'){ echo 'active'; } ?>">
                        <a class="nav-link" href="post.php">Post</a>
                    </li>
                </ul>
                <a href="../index.php" class="ml-auto btn btn-outline-warning">Go To BLOG</a>
            </div>          
          </nav>
    </div>
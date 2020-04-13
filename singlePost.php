<?php 
    include_once 'inc/header.php'; 


    spl_autoload_register(function($class){
        include_once "classes/".$class.".php";
    });

    $category = new Category();
    $post     = new Post();
    // $fm = new Format(); //Already Included in "inc/header.php"

    // 1st receive data by slug of Post
    if (!isset($_GET['title']) || $_GET['title']==NULL) 
    {
        echo "<script>window.location='index.php';</script>";
    }
    else{
        $postSlug = $_GET['title']; // can use this line or bellow the line
        // $titleSlug = preg_replace('/[^-a-zA-Z0-9_]/', '',$_GET['slug']);
    }
?>


<!-- Main Content -->
<section style="min-height:500px;">

<div class="container">
    <div class="row">

<!-- Left Sidebar -->
        <div class="col-md-8">

<!-- ================= Get Single Post By Slug ======= -->
<?php
    $getPost = $post->getSinglePostBySlug($postSlug);  //Go- 'classes/Post' Mehod-8
    if ($getPost) {
        $data = $getPost->fetch_assoc() 
?>
            <div class="card mb-5">
                <img class="card-img-top" src="admin/<?php echo $data['image'] ?>" alt="Card image cap" height="300px">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $data['title'] ?></h5>
                    <p class="card-text"><?php echo $data['description'] ?></p> 
                    <p class="card-text mb-0"><small class="text-muted">Category : <?php echo $data['category_name'] ?></small></p>
                    <p class="card-text"><small class="text-muted">Post Published : <?php echo date('d M, Y', strtotime($data['datetime'])) ?></small></p>
                </div>
            </div>
<?php } ?>
        </div>


        <div class="col-md-1"></div>

<!-- Right Sidebar -->

        <div class="col-md-3">
            <?php include_once 'inc/sidebar.php'; ?>
        </div>

    </div>
</div>
</section>



<?php include_once 'inc/footer.php'; ?>
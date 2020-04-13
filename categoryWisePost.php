<?php 
    include_once 'inc/header.php'; 


    spl_autoload_register(function($class){
        include_once "classes/".$class.".php";
    });

    $category = new Category();
    $post     = new Post();
    // $fm = new Format(); //Already Included in "inc/header.php"

    // 1st receive data by slug of Category
    if (!isset($_GET['category']) || $_GET['category']==NULL) 
    {
        echo "<script>window.location='index.php';</script>";
    }
    else{
        $categorySlug = $_GET['category']; // can use this line or bellow the line
        // $postSlug = preg_replace('/[^-a-zA-Z0-9_]/', '',$_GET['slug']);
    }
?>


<!-- Main Content -->
<section style="min-height:500px;">

<div class="container">
    <div class="row">

<!-- Left Sidebar -->
        <div class="col-md-7">

            <!-- =========== Category Wise All Post ========= -->
            <?php
                $getPosts = $post->getCategoryWisePostsBySlug($categorySlug); //Goto - 'classes/Post' Method-9
                if ($getPosts) {
                    while ($data = $getPosts->fetch_assoc()) {                      
            ?>
                        <div class="card mb-5">
                            <img class="card-img-top" src="admin/<?php echo $data['image'] ?>" alt="Card image cap" height="180px">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $data['title'] ?></h5>
                                <p class="card-text"><?php echo $fm->textShorten($data['description'],235) ?> <a href="singlePost.php?title=<?php echo $data['slug'] ?>" class="text-info"><strong>Continue Reading</strong></a> </p> 
                                <p class="card-text mb-0"><small class="text-muted">Category : <?php echo $data['category_name'] ?></small></p>
                                <p class="card-text"><small class="text-muted">Post Published : <?php echo date('d M, Y', strtotime($data['datetime'])) ?></small></p>
                            </div>
                        </div>
            <?php }} ?>
        </div>


        <div class="col-md-1"></div>

<!-- Right Sidebar -->

        <div class="col-md-4">
            <?php include_once 'inc/sidebar.php'; ?>
        </div>

    </div>
</div>
</section>



<?php include_once 'inc/footer.php'; ?>
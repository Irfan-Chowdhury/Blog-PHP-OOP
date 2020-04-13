<?php 
    include_once 'inc/header.php'; 


    spl_autoload_register(function($class){
        include_once "classes/".$class.".php";
    });

    $category = new Category();
    $post     = new Post();
    // $fm = new Format(); //Already Included in "inc/header.php"
?>


<!-- Main Content -->
<section style="min-height:500px;">

<div class="container">
    <div class="row">

<!-- Left Sidebar -->
        <div class="col-md-8">

            <!-- =========== <PHP> Get All Post ========= -->
            <?php
                $getPosts = $post->getAllBlogPost(); //Goto - 'classes/Post' Method-6
                if ($getPosts) {
                    while ($data = $getPosts->fetch_assoc()) {
            ?>
            <div class="card mb-5">
                <img class="card-img-top" src="admin/<?php echo $data['image'] ?>" alt="Card image cap" height="180px">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $data['title'] ?></h5>
                    <p class="card-text"><?php echo $fm->textShorten($data['description'],235) ?> <a href="#" class="text-info"><strong>Continue Reading</strong></a> </p> 
                    <p class="card-text mb-0"><small class="text-muted">Category : <?php echo $data['category_name'] ?></small></p>
                    <p class="card-text"><small class="text-muted">Post Published : <?php echo date('d M, Y', strtotime($data['datetime'])) ?></small></p>
                </div>
            </div>
            <?php }} ?>
        </div>


        <div class="col-md-1"></div>

<!-- Right Sidebar -->

        <div class="col-md-3">

            <!-- =========== <PHP> Get All Category ========= -->
            <h4 class="mt-5">Category</h4>
            <?php
                $getCategories = $category->getAllCategory(); //Goto - 'classes/Category' Method-2
                if ($getCategories) {
                    while ($data = $getCategories->fetch_assoc()) {
            ?>
                <p><a href="#" class="text-dark"><?php echo $data['category_name'] ?></a></p>
            <?php }} ?>


            <!-- =========== <PHP> Get All Post ========= -->
            <h4 class="mt-5">Latest Post</h4>
            <?php
                $getPosts = $post->getAllLatestPost(); //Goto - 'classes/Post' Method-7
                if ($getPosts) {
                    while ($data = $getPosts->fetch_assoc()) {
            ?>
                <p><a href="#" class="text-info"><?php echo $data['title'] ?></a></p>
            <?php }} ?>

        </div>

    </div>
</div>
</section>



<?php include_once 'inc/footer.php'; ?>
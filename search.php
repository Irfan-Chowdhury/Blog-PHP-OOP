<?php 
    include_once 'inc/header.php'; 


    spl_autoload_register(function($class){
        include_once "classes/".$class.".php";
    });

    $category = new Category();
    $post     = new Post();
    // $fm = new Format(); //Already Included in "inc/header.php"

    if (!isset($_GET['search']) || $_GET['search']==null) {
		header("Location:index.php");
	}else {
		$search = $_GET['search'];
	}
?>


<!-- Main Content -->
<section style="min-height:500px;">

<div class="container">
    <div class="row">

<!-- Left Sidebar -->
        <div class="col-md-7">

            <!-- =========== <PHP> Get All Post ========= -->
            <?php
                $getPosts = $post->getArticleBySearch($search); //Goto - 'classes/Post' Method-6
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
            
            <?php }}else {
                   echo "<h1 class='display-4 text-danger'><strong>Sorry Data Not Found</strong></h1>" ; 
            } ?>

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
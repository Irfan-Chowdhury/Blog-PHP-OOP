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
                $per_page=3;  //3 post in per page 
                if(isset($_GET["page"])){
                    $page=$_GET["page"];
                }else {
                    $page=1;
                }
                $start_from = ($page-1)* $per_page; //in database row index=1 means 0, index=2 means=1 so that's why if current page=1, database_row strat= (1-1)*3= 0 that's means starting from 1st no row. 
                
                $getPosts = $post->getAllBlogPost($start_from, $per_page); //Goto - 'classes/Post' Method-6
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

            <!-- ===============  Pagination Start =============== -->
            <div class="d-flex justify-content-center">
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <?php
                            $result     = $post->getAllPost(); //'classes/Post' Method-3
                            $total_rows = mysqli_num_rows($result);  //Count Total Rows
                            $total_pages= ceil($total_rows/$per_page); //ceil means if total_rows=7 & per_page=3  then toal_page= (7/3)=2.3 = 3 pages 
                        ?>
                                <li class="page-item <?php if(($_GET["page"]==0)||($_GET["page"]==1)) echo 'active' ?>"><a class="page-link" href="blog.php?page=1">First</a></li> 
                        <?php  for($i= 2; $i<$total_pages; $i++){ ?> 
                                <li class="page-item <?php if($_GET["page"]==$i) echo 'active' ?>"><a class="page-link" href="blog.php?page=<?php echo $i ?>"><?php echo $i ?></a></li>
                        <?php  } ?> 
                                <li class="page-item <?php if($_GET["page"]==$total_pages) echo 'active' ?>"><a class="page-link" href="blog.php?page=<?php echo $total_pages ?>">Last</a></li> 

                        <!-- ?> -->
                    </ul>
                </nav>
            </div>
            <!-- ==============  Pagination End ================ -->

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
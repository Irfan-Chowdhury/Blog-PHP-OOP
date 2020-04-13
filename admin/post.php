<?php 
    include_once 'inc/header.php'; 

    // spl_autoload_register(function($class){
    //     include_once "../classes/".$class.".php";
    // });
    include_once '../classes/Post.php'; //We Can Use this instesad of spl_autoload_register
    //include_once '../helpers/Format.php'; //No Need this line because we already declare it 'Post' class

    $post     = new Post();
    $fm	      = new Format();

    //For Delete Post
    if(isset($_GET['delPostId']))
    {
        $delPostId  = preg_replace('/[^-a-zA-Z0-9_]/', '',$_GET['delPostId']); 
        $deletePost = $post->delPostById($delPostId); // (see - 'classes/Post.php', method-5)
        // header("Location:post.php");
    }
?>

    <!-- Main Content Start -->
    <div style="min-height:530px;">
    <div class="container">
        <div class="d-flex justify-content-center mb-5">
            <h4 class="display-4 text-bold text-secondary">Post Manage</h4>
        </div>

        <!-- Add New Category Button -->
        <div class="d-flex justify-content-end mb-5">
            <a href="addPost.php" class="btn btn-primary">+ Add New Post</a>                   
        </div>
        
        <!-- ========= <PHP> Show Message Start ============== --> 
            <?php if (isset($deletePost)) { echo $deletePost;} ?>  
        <!-- ========= <PHP> Show Message End ====================== -->

        <!-- Table -->
        <table id="example" class="table table-striped table-bordered text-center" style="width:100%">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Image</th>
                    <th>Category</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Author</th> <!--It's not Dynamic, Just Static -->
                    <th>Date</th>
                    <th>Time</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>

            <!-- =========== <PHP> Get All Category Start ========= -->
            <?php
                $getPosts = $post->getAllPost(); //Goto - 'classes/Post' Method-2
                if ($getPosts) {
                    $i=0;
                    while ($result = $getPosts->fetch_assoc()) {
                        $i++;
            ?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td><img src="<?php echo $result['image'] ?>" height="50px" width="50px"></td>
                    <td><?php echo $result['category_name']; ?></td>                    
                    <td><?php echo $result['title']; ?></td>                    
                    <td><?php echo $fm->textShorten($result['description'],30) ?></td>
                    <td><?php echo $result['author'] ?></td>
                    <td><?php echo date('d-m-Y', strtotime($result['datetime'])) ?></td> <!-- 13-01-2020 -->
                    <td><?php echo date('h:i A',strtotime($result['datetime'])) ?></td> <!-- 13-01-2020 -->
                    <td>
                        <!-- <a href="editCategory.php?id=<?php //echo $result['id']; ?>" class="btn btn-info">Edit</a> -->
                        <a href="editPost.php?id=<?php echo $result['id']; ?>" class="btn btn-info">Edit</a>
                        <a href="?delPostId=<?php echo $result['id'] ?>" onclick="return confirm('Are you sure to Delete ?');" class="btn btn-danger">Delete</a>
                    </td>
                </tr>

            <?php } } ?>
            <!-- =========== <PHP> Get All Category End ========= -->

            </tbody>
        </table>
    </div>
    
</div>

    <!-- Main Content End -->



<script src="https://code.jquery.com/jquery-3.3.1.js"></script> <!--Don't Delete-->
<?php include_once 'inc/footer.php'; ?>





<?php 
    include_once 'inc/footer.php'; 
?>
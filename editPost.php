<?php
    include_once 'inc/header.php'; 

    spl_autoload_register(function($class){
        include_once "classes/".$class.".php";
    });

    $category = new Category();
    $post     = new Post();
    
    // 1st receive data by id
    if (!isset($_GET['id']) || $_GET['id']==NULL) 
    {
        echo "<script>window.location='post.php';</script>";
    }
    else
    {
        $postId = preg_replace('/[^-a-zA-Z0-9_]/', '',$_GET['id']); //this line for security purpose
    }


    // 2nd for Update Data
    if ($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['submit'])) 
    {
        $updatePost   = $post->updatePost($_POST, $_FILES,$postId); //Go- 'classes/Post' Mehod-4
    }

?>

<!-- Main Content Start -->
<div style="min-height:530px;">
    <div class="container">
        <div class="d-flex justify-content-center mb-5">
            <h4 class="display-4 text-bold text-secondary">Edit Post</h4>
        </div>

        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
<!-- ========= Show Message Start ==================== --> 
<?php if (isset($updatePost)) { echo $updatePost;}  ?>  
<!-- ========= Show Message End ====================== -->

                <form action="" method="POST" enctype="multipart/form-data">


<!-- ================= Get Post By Id Start ======= -->
<?php
    $getPost = $post->getPostById($postId);  //Go- 'classes/Post' Mehod-3
    if ($getPost) {
        $postData = $getPost->fetch_assoc() 
?>
                        <div class="form-group">
                            <label><strong>Category</strong></label>
                            <select name="category_id" class=form-control required>
                                <option value="">--- Select Category ---</option>
                            <!-- ================= Get All Category Start ======= -->
                            <?php 
                                $getCategory = $category->getAllCategory(); //goto- 'classes/Category.php' Method-2
                                if ($getCategory){
                                    while ($categoryData = $getCategory->fetch_assoc()){ 
                            ?>
                               <option <?php if ($categoryData['id']==$postData['category_id']) { ?>
                                            selected="selected"
                                        <?php }  ?>                      
                                        value="<?php echo $categoryData['id']; ?>"> <?php echo $categoryData['category_name']; ?>
                                </option>

                            <?php } } ?> 
                            <!-- =============== Get All Category End =======  -->
                            </select>
                        </div>

                        <div class="form-group">
                            <label><strong>Post Title</strong></label>
                            <input type="text" name="title" class="form-control" value="<?php echo $postData['title']?>" required>
                        </div>

                        <div class="form-group">
                          <label><strong>Post Description</strong></label>
                          <textarea class="form-control" name="description" rows="3" required><?php echo $postData['description']?></textarea>
                        </div>

                        <div class="form-group">
                          <label><strong>Upload Image</strong></label> <br>
                          <img src="<?php echo $postData['image']?>" height="100px" width="100px" id="image"> <br>
                          <input type="file" name="image" onchange="showImage(this,'image')" >
                        </div>
<?php } ?>
<!-- ================= Get Post By Id Start ======= -->

                        <button type="submit" name="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
            <div class="col-md-3"></div>
        </div>
    </div>
</div>


<script>
        //Image Show Before Upload Start
        $(document).ready(function(){
            $('input[type="file"]').change(function(e){
                var fileName = e.target.files[0].name;
                if (fileName){
                    $('#fileLabel').html(fileName);
                }
            });
        });
        
        function showImage(data, imgId){
            if(data.files && data.files[0]){
                var obj = new FileReader();
                obj.onload = function(d){
                    var image = document.getElementById(imgId);
                    image.src = d.target.result;
                }
                obj.readAsDataURL(data.files[0]);
            }
        }
        //Image Show Before Upload End
</script>

<?php include_once 'inc/footer.php'; ?>
  
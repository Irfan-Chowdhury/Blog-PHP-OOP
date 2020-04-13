<?php
  include_once 'inc/header.php'; 
  // include '../classes/Category.php';

  spl_autoload_register(function($class){
    include_once "classes/".$class.".php";
  });

  $category = new Category();
  $post     = new Post();
  
  if ($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['submit'])) 
  {
      $addPost   = $post->addPost($_POST, $_FILES); //Go- 'classes/Post' Mehod-1
  }

?>

<!-- Main Content Start -->
<div style="min-height:530px;">
    <div class="container">
        <div class="d-flex justify-content-center mb-5">
            <h4 class="display-4 text-bold text-secondary">Add New Post</h4>
        </div>

        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
<!-- ========= Show Message Start ==================== --> 
<?php if (isset($addPost)) { echo $addPost;}  ?>  
<!-- ========= Show Message End ====================== -->

                <form action="" method="POST" enctype="multipart/form-data">

                        <div class="form-group">
                            <label><strong>Category</strong></label>
                            <select name="category_id" class=form-control required>
                                <option value="">--- Select Category ---</option>
                            <!-- ================= Get All Category Start ======= -->
                            <?php 
                                $cat=new Category();
                                $getCategory = $category->getAllCategory(); //goto- 'classes/Category.php' Method-2
                                if ($getCategory) 
                                {
                                    while ($result = $getCategory->fetch_assoc())
                                    { 
                            ?>
                                <option value="<?php echo $result['id']; ?>"><?php echo $result['category_name']; ?></option>       
                            <?php } } ?> 
                            <!-- =============== Get All Category End =======  -->
                            </select>
                        </div>

                        <div class="form-group">
                            <label><strong>Post Title</strong></label>
                            <input type="text" name="title" class="form-control" placeholder="Type Post Title" required>
                        </div>

                        <div class="form-group">
                          <label><strong>Post Description</strong></label>
                          <textarea class="form-control" name="description"  rows="3" required></textarea>
                        </div>

                        <div class="form-group">
                          <label><strong>Upload Image</strong></label> <br>
                          <img src="https://image.freepik.com/free-vector/retro-blank-instant-photo-frame_1199-192.jpg" height="100px" width="100px" id="image"> <br>
                          <input type="file" name="image" onchange="showImage(this,'image')" >
                        </div>
                        
                        <button type="submit" name="submit" class="btn btn-primary">Save</button>
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
  
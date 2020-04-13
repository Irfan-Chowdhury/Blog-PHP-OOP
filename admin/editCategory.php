<?php
  include_once 'inc/header.php'; 
  // include '../classes/Category.php';


  spl_autoload_register(function($class){
    include_once "../classes/".$class.".php";
  });

  $category = new Category();

  // 1st receive data by id
  if (!isset($_GET['id']) || $_GET['id']==NULL) 
  {
    echo "<script>window.location='category.php';</script>";
  }
  else{
      //$categoryId = $_GET['id']; // can use this line
      $categoryId = preg_replace('/[^-a-zA-Z0-9_]/', '',$_GET['id']); //this line for security purpose
  }
    


  // 2nd update
  if ($_SERVER['REQUEST_METHOD']=='POST') 
  {
      $categoryName    = $_POST['category_name'];

      $updatetCategory = $category->categoryUpdate($categoryName,$categoryId); //Go- 'classes/Category' Mehod-4
  }

?>

    <!-- Main Content Start -->
    <div style="min-height:530px;">
        <div class="container">
            <div class="d-flex justify-content-center mb-5">
                <h4 class="display-4 text-bold text-secondary">Category Edit</h4>
            </div>

            <div class="row">
              <div class="col-md-3"></div>
              <div class="col-md-6">

<!-- ========= Show Message Start ==================== --> 
      <?php if (isset($updatetCategory)) { echo $updatetCategory;}  ?>  
<!-- ========= Show Message End ====================== -->


<!-- ==================== Get CategoryById Start ============== -->
<?php
    $getCategory = $category->getCategoryById($categoryId);
    if ($getCategory) {
        $result = $getCategory->fetch_assoc() 
?>
                  <form action="" method="POST">
                      <div class="form-group">
                        <label for="">Category Name</label>
                        <input type="text" name="category_name" value="<?php echo $result['category_name']; ?>" class="form-control" required>
                      </div>

                      <button type="submit" class="btn btn-primary">Update</button>
                </form>
<?php }  ?> 
<!-- ==================== Get CategoryById End  ============== -->

              </div>
              <div class="col-md-3"></div>
            </div>
      </div>
  </div>



<?php include_once 'inc/footer.php'; ?>
  
<?php 

    include_once 'inc/header.php'; 

    spl_autoload_register(function($class){
      include_once "classes/".$class.".php";
    });

    $category = new Category();

    //For Add Category
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $addCategory = $category->addCategory($_POST); // (see - 'classes/Category.php', method-1)
    }

    //For Delete Category
    if(isset($_GET['delCategoryId'])){
        //$delid=$_GET['delCategoryId'];
        $delCategoryId= preg_replace('/[^-a-zA-Z0-9_]/', '',$_GET['delCategoryId']); 
        $deleteCategory = $category->delCategoryById($delCategoryId); // (see - 'classes/Category.php', method-5)
    }
	
?>

    <!-- Main Content Start -->
<div style="min-height:530px;">
    <div class="container">
        <div class="d-flex justify-content-center mb-5">
            <h4 class="display-4 text-bold text-secondary">Category Setup</h4>
        </div>

        <!-- Add New Category Button -->
        <div class="d-flex justify-content-end mb-5">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addCategory">+ Add New Category</button>                   
               
                <!-- <PHP> include addCategory -->
                <?php include 'addCategory.php' ; ?>
        </div>
        
        <!-- ========= <PHP> Show Message Start ============== --> 
            <?php if (isset($addCategory)) { echo $addCategory;}
                  elseif (isset($deleteCategory)) {echo $deleteCategory; }  ?>  
        <!-- ========= <PHP> Show Message End ====================== -->

        <!-- Table -->
        <table id="example" class="table table-striped table-bordered text-center" style="width:100%">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Category Name</th>
                    <th colspan="2">Action</th>
                </tr>
            </thead>
            <tbody>

            <!-- =========== <PHP> Get All Category Start ========= -->
            <?php
                $getCategories = $category->getAllCategory(); //Goto - 'classes/Category' Method-2
                if ($getCategories) {
                    $i=0;
                    while ($result = $getCategories->fetch_assoc()) {
                        $i++;
            ?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $result['category_name']; ?></td>
                    <td>
                        <a href="editCategory.php?id=<?php echo $result['id']; ?>" class="btn btn-info">Edit</a>
                        <a href="?delCategoryId=<?php echo $result['id']; ?>" onclick="return confirm('Are you sure to Delete ?');" class="btn btn-danger">Delete</a>
                    </td>
                </tr>

            <?php } } ?>
            <!-- =========== <PHP> Get All Category End ========= -->

            </tbody>
            <tfoot>
                <tr>
                    <th>SL</th>
                    <th>Category Name</th>
                    <th>Action</th>
                </tr>
            </tfoot>
        </table>
    </div>
    
</div>

    <!-- Main Content End -->




<?php include_once 'inc/footer.php'; ?>


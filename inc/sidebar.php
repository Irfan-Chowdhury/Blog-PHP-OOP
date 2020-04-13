            
            <!-- =========== Searching Option ========= -->

            <form class="form-inline my-2 my-lg-0" action="search.php" method="GET">
                <input class="form-control mr-sm-2" name="search" type="search" placeholder="Search" aria-label="Search">
                <button type="submit" class="btn btn-outline-info my-2 my-sm-0">Search</button>
            </form>


            <!-- =========== <PHP> Get All Category ========= -->
            <h4 class="mt-5">Category</h4>
            <?php
                $getCategories = $category->getAllCategory(); //Goto - 'classes/Category' Method-2
                if ($getCategories) {
                    while ($data = $getCategories->fetch_assoc()) {
            ?>
                <p><a href="categoryWisePost.php?category=<?php echo $data['slug'] ?>" class="text-secondary"><?php echo $data['category_name'] ?></a></p>
            <?php }} ?>



            <!-- =========== <PHP> Get All Post ========= -->
            <h4 class="mt-5">Latest Post</h4>
            <?php
                $getPosts = $post->getAllLatestPost(); //Goto - 'classes/Post' Method-7
                if ($getPosts) {
                    while ($data = $getPosts->fetch_assoc()) {
            ?>
                <p><a href="singlePost.php?title=<?php echo $data['slug'] ?>" class="text-info"><?php echo $data['title'] ?></a></p>
            <?php }} ?>
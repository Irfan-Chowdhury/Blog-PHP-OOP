            
            
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
                <p><a href="singlePost.php?slug=<?php echo $data['slug'] ?>" class="text-info"><?php echo $data['title'] ?></a></p>
            <?php }} ?>
<?php

$filepath = realpath(dirname(__FILE__)); //realpath = get absolute path || expmale - C:/xampp/htdocs/..../classes/Category.php  
                                        // dirname  = Return the directory name from the path || Example- 'classes/Category.php' -> then it return 'classes/'

include_once ($filepath.'/../lib/Database.php');
include_once ($filepath.'/../helpers/Format.php');

class Post
{
    private $db;
    private $fm;

    public function __construct()
    {
        $this->db =new Database();
        $this->fm= new Format();
    }

    public function addPost($data,$file)  // Method-1
    {
        $categoryId = $this->fm->validation($data['category_id']);
        $post_title       = $this->fm->validation($data['title']);
        $post_description = $this->fm->validation($data['description']);
        
        $category_id  = mysqli_real_escape_string($this->db->link, $categoryId);
        $title        = mysqli_real_escape_string($this->db->link, $post_title);
        $description  = mysqli_real_escape_string($this->db->link, $post_description);

        //$slug = preg_replace(pattern, replacement, subject)
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));

        $author = "Irfan Chowdhury"; //This is not dynamically created. Only Static


        // -- Image Handling Start --
        $permited  = array('jpg', 'jpeg', 'png', 'gif');
        $file_name = $file['image']['name'];
        $file_size = $file['image']['size'];
        $file_temp = $file['image']['tmp_name'];

        $div = explode('.', $file_name);
        $file_ext = strtolower(end($div));
        $unique_image = substr(md5(time()), 0, 10).'.'.$file_ext;
        $uploaded_image = "uploads/".$unique_image;
        // -- Image Handling End --

        if ($category_id == "" || $title=="" || $description=="" || $file_name=="") 
        {
            $msg = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                        <strong>Error!</strong> Feild must not be empty.
                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                            <span aria-hidden='true'>&times;</span>
                        </button>
                    </div>" ;
            return $msg;
        }
        else 
        {
            // For Unique Title Name 
            $titleQuery = "SELECT *FROM posts WHERE title ='$title' OR slug = '$slug' LIMIT 1";
            $titleUnique = $this->db->select($titleQuery);

            if ($titleUnique != false) 
            {
                $msg = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                            <strong>Error!</strong> Title name already exists !!!
                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                <span aria-hidden='true'>&times;</span>
                            </button>
                        </div>" ;

                return $msg;
            }
            elseif ($file_size >1048567) //Image File Size
            {
                $msg = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                            <strong>Error!</strong> Image Size should be less then 1MB!
                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                <span aria-hidden='true'>&times;</span>
                            </button>
                        </div>" ;
                return $msg;
            } 
            elseif (in_array($file_ext, $permited) === false) //Image File type
            {
                $msg = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                            <strong>Error!</strong>You can upload only:-".implode(', ', $permited)."
                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                <span aria-hidden='true'>&times;</span>
                            </button>
                        </div>" ;
                return $msg;
            }
            else 
            {
                move_uploaded_file($file_temp, $uploaded_image);

                // $query = "INSERT INTO posts (category_id, title, description, image, datetime, author) 
                // VALUES('$category_id','$title','$description','$uploaded_image','$datetime', '$author') ";

                $query = "INSERT INTO posts (category_id, title, slug, description, image, author, datetime) 
                VALUES('$category_id', '$title', '$slug', '$description', '$uploaded_image', '$author', now())";
                
                $inserted_row=$this->db->insert($query);

                if ($inserted_row) 
                {
                    $msg = "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                                <strong>Success!</strong>  Post Added successfully.
                                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                    <span aria-hidden='true'>&times;</span>
                                </button>
                            </div>" ;

                    return $msg;
                }
                else 
                {
                    $msg= "<span class='error'>Post Inserted Failed</span>";
                    return $msg;
                }
            }
        }
    }

    // ******************** Post List *************************

    public function getAllPost() //Method-2
    {
        $query  =   "SELECT posts.*, categories.category_name 
                    FROM posts
                    INNER JOIN categories ON categories.id = posts.category_id
                    ORDER BY posts.id DESC";

        $result = $this->db->select($query);
        return $result;
    }


    // ******************** Post Edit ***************************

    public function getPostById($id)  // --->> Method-3 
    {
        $query  = "SELECT *FROM posts WHERE id='$id' ";
        $result = $this->db->select($query);
        return $result;
    }


    public function updatePost($data,$file,$id) // --->> Method-4
    {
        $categoryId = $this->fm->validation($data['category_id']);
        $post_title       = $this->fm->validation($data['title']);
        $post_description = $this->fm->validation($data['description']);
        
        $category_id  = mysqli_real_escape_string($this->db->link, $categoryId);
        $title        = mysqli_real_escape_string($this->db->link, $post_title);
        $description  = mysqli_real_escape_string($this->db->link, $post_description);

        //$slug = preg_replace(pattern, replacement, subject)
        // $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));
        $slug = strtolower(trim(preg_replace('/[^a-z0-9]+/i', '-', $title))); //both same

        $author = "Irfan Chowdhury"; //This is not dynamically created. Only Static

        // -- Image Handling Start --
        $permited  = array('jpg', 'jpeg', 'png', 'gif');
        $file_name = $file['image']['name'];
        $file_size = $file['image']['size'];
        $file_temp = $file['image']['tmp_name'];

        $div = explode('.', $file_name);
        $file_ext = strtolower(end($div));
        $unique_image = substr(md5(time()), 0, 10).'.'.$file_ext;
        $uploaded_image = "uploads/".$unique_image;
        // -- Image Handling End --

        if ($category_id=="" || $title=="" || $description=="") 
        {
            $msg = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                        <strong>Error!</strong> Feild must not be empty.
                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                            <span aria-hidden='true'>&times;</span>
                        </button>
                    </div>" ;
            return $msg;
        }
        elseif ( $file_name=="") //If Image File not selected, Only Data Save
        {
            $query = "UPDATE posts 
                    SET
                    category_id = '$category_id',
                    title       = '$title',
                    slug        = '$slug',
                    description = '$description',
                    author      = '$author',
                    datetime    = now()
                    WHERE   id  = '$id' ";
            
            $updated_row = $this->db->update($query);

            if ($updated_row) 
            {
                $msg = "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                            <strong>Success!</strong>  Post Updated successfully.
                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                <span aria-hidden='true'>&times;</span>
                            </button>
                        </div>" ;

                return $msg;
            }
            else 
            {
                $msg= "<span class='error'>Post Updated Failed</span>";
                return $msg;
            }
        }
        else 
        {
            if ($file_size >1048567) //Image File Size
            {
                $msg = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                            <strong>Error!</strong> Image Size should be less then 1MB!
                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                <span aria-hidden='true'>&times;</span>
                            </button>
                        </div>" ;
                return $msg;
            } 
            elseif (in_array($file_ext, $permited) === false) //Image File type
            {
                $msg = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                            <strong>Error!</strong>You can upload only:-".implode(', ', $permited)."
                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                <span aria-hidden='true'>&times;</span>
                            </button>
                        </div>" ;
                return $msg;
            }
            else //if Image also selected
            {
                // -- 1st- Delete Previous Image From Storage -- 
                $query = "SELECT *FROM posts WHERE id = '$id' ";
                $getData = $this->db->select($query);
                if ($getData) 
                {
                    $delImg = $getData->fetch_assoc();
                    unlink($delImg['image']);
                }

                // --2nd- Then Updated new Imgae in Storage --
                move_uploaded_file($file_temp, $uploaded_image);

                //& Also in Database
                $query = "UPDATE posts 
                        SET
                        category_id = '$category_id',
                        title       = '$title',
                        slug        = '$slug',
                        description = '$description',
                        image       = '$uploaded_image', 
                        author      = '$author',
                        datetime    = now()
                        WHERE   id  = '$id' ";
                
                $updated_row = $this->db->update($query);

                if ($updated_row) 
                {
                    $msg = "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                                <strong>Success!</strong>  Post Updated successfully.
                                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                    <span aria-hidden='true'>&times;</span>
                                </button>
                            </div>" ;

                    return $msg;
                }
                else 
                {
                    $msg= "<span class='error'>Post Updated Failed</span>";
                    return $msg;
                }
            }
        }
    }


    // ******************** Post Delete *************************

    public function delPostById($id) //Method-5
    {
        // -- Delete File From Storage -- 
        $query = "SELECT *FROM posts WHERE id = '$id' ";
        $getData = $this->db->select($query);
        if ($getData) 
        {
            $delImg = $getData->fetch_assoc();
            unlink($delImg['image']);
        }

        // -- Delete From Database -- 
        $delquery = "DELETE FROM posts WHERE id = '$id' ";
        $postDelete= $this->db->delete($delquery);

        if($postDelete)
        {
            $msg = "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                        <strong>Success!</strong>  Post Deleted successfully.
                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                            <span aria-hidden='true'>&times;</span>
                        </button>
                    </div>" ;

            return $msg;
        }
        else {
            echo "<span class='error'>Product Not Deleted..</span>";
        }
    }


    // ==================== For BLOG SECTION ==================


    public function getAllBlogPost() //Method-6
    {
        // $query  = "SELECT posts.* FROM posts LIMIT 3";
        // $result = $this->db->select($query);
        // return $result;

        $query  =   "SELECT posts.*, categories.category_name 
                    FROM posts
                    INNER JOIN categories ON categories.id = posts.category_id";

        $result = $this->db->select($query);
        return $result;
    }


    public function getAllLatestPost() //Method-7
    {
        $query  = "SELECT posts.* FROM posts ORDER BY id DESC LIMIT 5";
        $result =  $this->db->select($query);
        return $result;
    }

    
}

?>
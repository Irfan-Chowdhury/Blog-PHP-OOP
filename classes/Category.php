<?php

$filepath = realpath(dirname(__FILE__)); //realpath = get absolute path || expmale - C:/xampp/htdocs/..../classes/Category.php  
                                        // dirname  = Return the directory name from the path || Example- 'classes/Category.php' -> then it return 'classes/'

include_once ($filepath.'/../lib/Database.php');
include_once ($filepath.'/../helpers/Format.php');


class Category
{
    private $db;
    private $fm;

    public function __construct()
    {
        $this->db =new Database();
        $this->fm= new Format();
    }


    // ******************** Add New Category *************************

    public function addCategory($data)  // Method-1
    {
        $categoryName  = $this->fm->validation($data['category_name']); //Validation
        $category_name  = mysqli_real_escape_string($this->db->link, $categoryName); //mysqli_real_escape_string = prevent SQL Injection & This function is used to create a legal SQL string that you can use in an SQL statement. The given string is encoded to an escaped SQL string, taking into account the current character set of the connection.

        //$slug = preg_replace(pattern, replacement, subject)
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $category_name)));

        if (empty($category_name)) 
        // if ($category_name=="") 
        {
            $msg = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                        <strong>Error!</strong> Feild must not be empty.
                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                            <span aria-hidden='true'>&times;</span>
                        </button>
                    </div>" ;

            return $msg;
        }

        $categoryNameQuery = "SELECT *FROM categories WHERE category_name ='$category_name' LIMIT 1";
        $categoryNameUnique = $this->db->select($categoryNameQuery);

        if ($categoryNameUnique != false) 
        {
            $msg = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                        <strong>Error!</strong> Category already exists !!!
                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                            <span aria-hidden='true'>&times;</span>
                        </button>
                    </div>" ;

            return $msg;
        }
        else 
        {
            $query = "INSERT INTO  categories (category_name, slug)
                      VALUES('$category_name', '$slug') ";

            $inserted_row = $this->db->insert($query);

            if ($inserted_row) 
            {
                $msg = "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                            <strong>Success!</strong> Category Added successfully.
                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                <span aria-hidden='true'>&times;</span>
                            </button>
                        </div>" ;

                return $msg;

                //header("Location:category.php");
            }
            else 
            {
                $msg= "<span class='error'>Category Inserted Failed</span>";
                return $msg;
            }  
        }
    }

    // ******************** Category List *************************
    public function getAllCategory()  // Method-2
    {
        $query  = "SELECT *FROM categories ORDER BY id DESC";
        $result = $this->db->select($query);
        return $result;
    }

        // ******************** Category Edit *************************


        public function getCategoryById($categoryId)  // --->> Method-3 
        {
            $query  = "SELECT *FROM categories WHERE id='$categoryId' ";
            $result = $this->db->select($query);
            return $result;
        }
    

        public function categoryUpdate($categoryName,$categoryId)  // Method-4
        {
            $categoryName  = $this->fm->validation($categoryName); //Validation
            $categoryId    = $this->fm->validation($categoryId); //Validation
    
            $category_name  = mysqli_real_escape_string($this->db->link, $categoryName); //mysqli_real_escape_string = prevent SQL Injection & This function is used to create a legal SQL string that you can use in an SQL statement. The given string is encoded to an escaped SQL string, taking into account the current character set of the connection.
            $id             = mysqli_real_escape_string($this->db->link, $categoryId);
    
            //$slug = preg_replace(pattern, replacement, subject)
            $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $category_name)));
    
            if (empty($category_name)) 
            {
                $msg = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                            <strong>Error!</strong> Feild must not be empty.
                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                <span aria-hidden='true'>&times;</span>
                            </button>
                        </div>" ;
    
                return $msg;
            }
    
            $categoryNameQuery      = "SELECT *FROM categories WHERE category_name ='$category_name' OR slug = '$slug' LIMIT 1";
            $categoryNameUnique     = $this->db->select($categoryNameQuery);
            
            if ($categoryNameUnique != false) 
            {
                $msg = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                            <strong>Error!</strong> Category already exists !!!
                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                <span aria-hidden='true'>&times;</span>
                            </button>
                        </div>" ;
    
                return $msg;
            }
            else 
            {
                $query = "UPDATE categories 
                            SET
                            category_name ='$category_name',
                            slug          = '$slug'
                            WHERE     id  ='$id' ";
    
                $categoryUpdate = $this->db->update($query);
    
                if ($categoryUpdate) 
                {
                    $msg = "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                                <strong>Success!</strong> Category Updated successfully.
                                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                    <span aria-hidden='true'>&times;</span>
                                </button>
                            </div>" ;
    
                    return $msg;
    
                    //header("Location:category.php");
                }
                else 
                {
                    $msg= "<span class='error'>Category Updated Failed</span>";
                    return $msg;
                }  
            }
        }
    

        // ******************** Category Delete *************************

        public function delCategoryById($delCategoryId) //--->> Method-5
        {
            $query="DELETE FROM categories WHERE id='$delCategoryId' ";

            $categoryDelete= $this->db->delete($query);

            if($categoryDelete)
            {
                $msg = "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                            <strong>Success!</strong> Category Deleted successfully.
                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                <span aria-hidden='true'>&times;</span>
                            </button>
                        </div>" ;

                return $msg;
            }
            else 
            {
                echo "<span class='error'>Category Not Deleted..</span>";
            }
        }

}




?>
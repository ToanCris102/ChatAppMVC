<?php 
    class Register extends Controller {
        private $md;
        private $list;
        public function __construct(){
            $this->md = $this->model("UserModel");            
        }

        public function Construct(){
            $this->view("master1" , [
                "page" => "regist"
            ]);
        }
        
        public function Signup(){
            $fname = $_POST['fname'];
            $lname = $_POST['lname'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            if(!empty($fname) && !empty($lname) && !empty($email) && !empty($password)){
                if(filter_var($email, FILTER_VALIDATE_EMAIL)){                    
                    $list = $this->md->checkSignup($email);
                    if(!empty($list[0]['email'])){ 
                        echo "$email - This email already exist!";
                    }else{
                        if(isset($_FILES['image'])){
                            $img_name = $_FILES['image']['name'];
                            $img_type = $_FILES['image']['type'];
                            $tmp_name = $_FILES['image']['tmp_name'];
                            
                            $img_explode = explode('.',$img_name);
                            $img_ext = end($img_explode);
            
                            $extensions = ["jpeg", "png", "jpg"];
                            if(in_array($img_ext, $extensions) === true){
                                $types = ["image/jpeg", "image/jpg", "image/png"];
                                if(in_array($img_type, $types) === true){
                                    $time = time();
                                    $new_img_name = $time.$img_name;
                                    if(move_uploaded_file($tmp_name,"./public/images/".$new_img_name)){
                                        $ran_id = rand(time(), 100000000);
                                        $status = "Active now";
                                        $encrypt_pass = md5($password);                                        
                                        if($this->md->insertUser($ran_id, $fname, $lname, $email, $encrypt_pass, $new_img_name, $status)){
                                            $list = $this->md->checkSignup($email);
                                            if(!empty($list[0]['email'])){                                
                                                $_SESSION['unique_id'] = $list[0]['unique_id'];
                                                echo "success";
                                            }else{
                                                echo "This email address not Exist!";
                                            }
                                        }else{
                                            echo "Something went wrong. Please try again!";
                                        }
                                    }
                                }else{
                                    echo "Please upload an image file - jpeg, png, jpg";
                                }
                            }else{
                                echo "Please upload an image file - jpeg, png, jpg";
                            }
                        }
                    }
                }else{
                    echo "$email is not a valid email!";
                }
            }else{
                echo "All input fields are required!";
            }
        }
    }
?>
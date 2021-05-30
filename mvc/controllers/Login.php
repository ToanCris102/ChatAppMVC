<?php 
    class Login extends Controller{
        public $md;

        public function __construct(){
            $this->md = $this->model("UserModel");
        }

        public function Construct(){
            $this->view("master1", [
                "page" => "login"
            ]);
        }

        public function checkLogin(){
            $email = $_POST['email'];
            $password = $_POST['password'];
            if(!empty($email) && !empty($password)){
                
                $list = $this->md->checkSignup($email);
                if(isset($list[0]['email'])){
                    $user_pass = md5($password);
                    $enc_pass = $list[0]['password'];
                    if($user_pass === $enc_pass){
                        $status = "Active now";
                        if($this->md->updateStatus($list[0]['unique_id'], $status)){
                            $_SESSION['unique_id'] = $list[0]['unique_id'];
                            echo "success";
                        }else{
                            echo "Something went wrong. Please try again!";
                        }
                    }else{
                        echo "Email or Password is Incorrect!";
                    }
                }else{
                    echo "$email - This email not Exist!";
                }
            }else{
                echo "All input fields are required!";
            }
        }
    }
?>
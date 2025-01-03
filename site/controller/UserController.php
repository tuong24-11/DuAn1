<?php

class UserController {
    // thuộc tính
    private $userModel;
    
    // Khởi tạo
    public function __construct() {
        require_once('../site/model/UserModel.php');
        $this->userModel = new UserModel();
    }
    
    // Tạo trang đăng nhập
    public function renderLogin() {
        require_once('view/login.php');
    }
    public function login($data){
        // Lấy thông tin người dùng từ cơ sở dữ liệu
        $message = ""; // Khởi tạo biến thông báo

        $user = $this->userModel->getUser($data);
        
        if($user){
            echo "Đăng nhập thành công";
            $_SESSION['user'] = $user;
    
            // Kiểm tra vai trò của người dùng
            if($user['Vai_tro'] == 1){
                // Vai trò là quản trị viên
                header('location: ../admin/index.php');
            } else {
                // Vai trò là người dùng
                header('location: index.php');
            }
        } else {
            $message = "Đăng nhập thất bại";
        }
        require_once('view/login.php');
    }
    public function renderRegister() {
        require_once('view/register.php');
    }
    public function register($data) {
        $message2 = "";
        if ($data) {
            $result = $this->userModel->addUser($data);
            if ($result) {
                header('location: index.php?page=loginpage');
            } else {
                $message2 =  "Đăng ký thất bại: Email đã tồn tại."; 
            }
        }
        require_once('view/register.php');
    }
}

?>
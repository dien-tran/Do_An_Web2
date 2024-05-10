<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Bookept | Login</title>
   <meta name="description" content="Knowledge space for nerds. Search online books by subject and add them to your favorite cart">
   <meta name="keywords" content="php, sql, mysql, html, css, javascript, book">
   <link rel="shortcut icon" href="./public/favicon.ico" type="image/x-icon">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  
   <style>
    body 
    {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100vh;
        margin: 0;
        padding: 0;
        font-family: Arial, sans-serif;
        background-color: #000;
        color: #000;
    }

    .form-container 
    {
        background-color: rgba(0, 0, 0, 0.8);
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
    }
   
    .form-inner 
    {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    .form-inner h2 
    {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .input-group 
    {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
    }

    .icon 
    {
        margin-right: 10px;
    }

    .btn-group 
    {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .btn-group button 
    {
        padding: 10px;
        margin-top: 20px;
        border: none;
        border-radius: 5px;
        background-color: #007bff;
        color: #fff;
        cursor: pointer;
    }

    .btn-group button:hover 
    {
        background-color: #0056b3;
    }
    input
    {
        padding: 10px;
        margin: 10px 0;
        border: none;
        border-radius: 5px;
    }
</style>
</head>

<body>
<?php 
      if(isset($message))
      {
         foreach($message as $msg)
         {
            echo '
            <div class="message">
            <span>' . $msg . '</span>
            <i clss="fas fa-times" onclick="this.parentElement.remove();"></i>
            ';
         }
      }
   ?>
   <div class="form-container">
      <form class="login_form" action="" method="post">
         <div class="form-inner">
         <h2 style="color: #fff;">Admin login</h2>
            <div class="input-group">
               <div class="icon">
                  <img src="./public/form/user.svg" alt="user">
               </div>
               <input type="email" name="email" placeholder="enter your email" required />
            </div>
            <div class="input-group">
               <div class="icon">
                  <img src="./public//form/finger_print.svg" alt="finger_print">
               </div>
               <input type="password" name="password" placeholder="enter your password" required />
            </div>
            <div class="btn-group">
               <button class="btn btn--primary" type="submit" name="submit" value="login now">Sign in</button>
            </div>
            <br>
         </div>
      </form>
   </div>
   <script src="https://code.jquery.com/jquery-3.7.1.js"></script>





</body>

</html>

<?php
include "config.php"; // chứa các cấu hình, thông tin kết nối cơ sở dữ liệu SQL
session_start();
//bắt đầu hoặc khôi phục một phiên làm việc cho người dùng.
//lưu trữ thông tin về người dùng trong suốt thời gian họ tương tác với trang web VD :giỏ hàng,...
//=>Sau khi phiên làm việc được bắt đầu
//<=> bạn có thể sử dụng biến $_SESSION để lưu trữ và truy xuất thông tin của người dùng trong suốt phiên làm việc.
if (isset($_POST['submit'])) // kiểm tra giá trị tồn tại và có ko null
{
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = mysqli_real_escape_string($conn, md5($_POST['password']));
   // $conn :là biến được định nghĩa bên config.php . mục đích kết nối csdl MySQL, thực hiện quá trình lọc
   //mysqli_real_escape_string : lọc các kí tự đặc biệt ra để tránh bị hack
   $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email' AND password = '$pass'") or die('query failed');    // kiểm tra tài khoản đã tồn lại hay chưa 
   if (mysqli_num_rows($select_users) > 0) // kiểm tra dòng SQL của user đó có lớn hơn 0 ? nếu lớn hơn ko là tồn tại
   //bảng "user" cả email và password đều trùng khớp với thông tin mà người dùng đã nhập.
   {
        $check = mysqli_fetch_assoc($select_users); // lấy dòng có giá trị trùng với giá trị user
        if ($check['user_type'] == 'admin') 
        {
            $_SESSION['admin_id'] = $check['id'];
            $_SESSION['admin_name'] = $check['name']; 
            $_SESSION['admin_email'] = $check['email'];
            $_SESSION['admin_passwword'] = $check['passwword'];
            //$_session: dùng để lưu thông tin lại trên server, vì v ngay khi người dùng(admin or user) out ra vào lại thì tk vẫn còn
            header('location:admin_main.php'); //Chuyển hướng người dùng đến trang admin_page.php.
        }
    }

   /* ?> ---<?php ?> để tạo ra một đoạn mã JavaScript,nó sẽ được PHP xử lý trước khi được gửi về cho trình duyệt. 
                      Kết quả là trình duyệt sẽ nhận được một chuỗi HTML chứa đoạn mã JavaScript, không phải là một trang HTML hoàn chỉnh.
        //     <script>
        //         alert("Email hoặc mật khẩu không chính xác!");
        //     </script>
         <?php */ else {
      echo "<script>alert('Email or password is incorrect!');</script>";
   }
} ?>
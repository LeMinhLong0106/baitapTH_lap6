<?php
require_once('db/connect.php');
?>

<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link rel="stylesheet" href="style.css" />
</head>

<body>
    <?php
    //Khai báo sử dụng session
    session_start();
    //Khai báo utf-8 để hiển thị được tiếng việt
    header('Content-Type: text/html; charset=UTF-8');
    $tb = [];
    //Xử lý đăng nhập
    if (isset($_POST['dangnhap'])) {

        //Lấy dữ liệu nhập vào
        $username = strip_tags($_POST['username']);
        $username = addslashes($_POST['username']);
        $passwords = strip_tags($_POST['passwords']);
        $passwords = addslashes($_POST['passwords']);

        if ($username == "" || $passwords == "") {
            array_push($tb, "Username hoặc passwords bạn không được để trống!");
        } else {
            $sql = "select * from user where username = '$username' and passwords = '$passwords' ";
            $query = mysqli_query($connect, $sql);
            $num_rows = mysqli_num_rows($query);
            if ($num_rows == 0) {
                array_push($tb, "Tên đăng nhập hoặc mật khẩu không đúng !");
            } else {
                //tiến hành lưu tên đăng nhập vào session để tiện xử lý sau này
                $_SESSION['username'] = $username;
                // Thực thi hành động sau khi lưu thông tin vào session
                // chuyển hướng trang web tới một trang phong
                header('Location: phong');
            }
        }
    }
    ?>

    <form action='' class="dangnhap" method='POST'>
        Tên đăng nhập : <input type='text' name='username' />
        Mật khẩu : <input type='password' name='passwords' />
        <input type='submit' class="button" name="dangnhap" value='Đăng nhập' />
        <form>
        <?php if (count($tb) > 0) {
            echo '<div style="text-align: center;">';
            foreach ($tb as $loi) {
                echo '<i style="color: red;">' . $loi . '</i><br>';
            }
            echo '</div>';
        } ?>

</body>

</html>
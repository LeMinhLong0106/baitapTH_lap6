<?php
require('../db/connect.php');
?>
<!DOCTYPE html>
<html>

<head>
    <title>Thêm nhân viên</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</head>

<body>
    <?php
    $errors = array(); //khởi tạo 1 mảng chứa lỗi
    $manv = $honv = $tennv = $ngaysinh = $gioitinh = $diachi = $maloai= $maphong ="";

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $manv = trim($_POST['manv']);
        $honv = trim($_POST['honv']);
        $tennv = trim($_POST['tennv']);
        $ngaysinh = $_POST['ngaysinh'];
        $gioitinh = $_POST['gioitinh'];
        $diachi = trim($_POST['diachi']);
        $maloai = $_POST['maloai'];
        $maphong = $_POST['maphong'];

        if ($_FILES['anh']['name'] != "") {
            $hinh = $_FILES['anh'];
            $ten_hinh = $hinh['name'];
            $type = $hinh['type'];
            $size = $hinh['size'];
            $tmp = $hinh['tmp_name'];
            if (($type == 'image/jpeg' || ($type == 'image/bmp') || ($type == 'image/gif') || ($type == 'image/png') && $size < 8000)) {
                move_uploaded_file($tmp, "../hinh_nv/" . $ten_hinh);
            }
        }

        if (
            // !empty($_POST['manv']) && !empty($_POST['honv']) && !empty($_POST['tennv']) && !empty($_POST['ngaysinh']) &&
            // !empty($_POST['gioitinh']) && !empty($_POST['diachi']) && !empty($_POST['maloai']) && !empty($_POST['maphong'])
            $_POST['manv'] != "" && $_POST['honv'] != "" && $_POST['tennv'] != "" && $_POST['ngaysinh'] != ""  
            && $_POST['diachi'] != "" 
        ) {
            $sql = 'select * from nhanvien';

            $nhanvienList = executeResult($sql);

            $flag = true; // giả định không trùng mã
            foreach ($nhanvienList as $m) {
                if ($manv == $m['manv']) {
                    $flag = false;
                    break;
                }
            }
            if ($flag == true) {
                $query = "INSERT INTO nhanvien VALUES ('$manv','$honv','$tennv','$ngaysinh',$gioitinh,'$diachi','$ten_hinh','$maloai','$maphong')";
                $result = mysqli_query($connect, $query);
                // khi bấm nút lưu thì quay lại trang index
                header('Location: index.php');
                die();
            } else {
                array_push($errors, "Mã nhân viên này đã tồn tại");
            }
        }
        else {
            if ($_POST['manv'] == "") {
                array_push($errors, "Bạn chưa nhập mã nhân viên");
            }
            if ($_POST['honv'] == "") {
                array_push($errors, "Bạn chưa nhập họ nhân viên");
            }
            if ($_POST['tennv'] == "") {
                array_push($errors, "Bạn chưa nhập tên nhân viên");
            }
            if ($_POST['ngaysinh'] == "") {
                array_push($errors, "Bạn chưa nhập ngày sinh nhân viên");
            }
            if ($_POST['diachi'] == "") {
                array_push($errors, "Bạn chưa nhập địa chỉ nhân viên");
            }
        }
    }

    ?>
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link " href="../phong">Phòng</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="#">Nhân viên</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="../loainv">Loại nhân viên</a>
        </li>
    </ul>

    <div class="container">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h2 class="text-center">Thêm nhân viên</h2>
            </div>
            <div class="panel-body">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Mã nhân viên:</label>
                        <input type="text" class="form-control" name="manv" value="<?= $manv ?>">
                    </div>

                    <div class="form-group">
                        <label>Họ nhân viên:</label>
                        <input type="text" class="form-control" name="honv" value="<?= $honv ?>">
                    </div>

                    <div class="form-group">
                        <label>Tên nhân viên:</label>
                        <input type="text" class="form-control" name="tennv" value="<?= $tennv ?>">
                    </div>

                    <div class="form-group">
                        <label>Ngày sinh:</label>
                        <input type="date" name="ngaysinh" value="<?= $ngaysinh ?>">
                    </div>

                    <div class="form-group">
                        <label>Giới tính:</label>
                        <input type="radio" name="gioitinh" value="1" checked /> Nam
                        <input type="radio" name="gioitinh" value="0" /> Nữ
                    </div>

                    <div class="form-group">
                        <label>Địa chỉ:</label>
                        <input type="text" class="form-control" name="diachi" value="<?= $diachi ?>">
                    </div>

                    <div class="form-group">
                        <label>Ảnh:</label>
                        <input type="file" name="anh" value="<?= $ten_hinh ?>">
                    </div>

                    <div class="form-group">
                        <label>Loại nhân viên:</label>
                        <select class="form-control" name="maloai" >
                            <!-- <option>Lựa chọn loại nhân viên</option> -->
                            <?php
                            $sql          = 'select * from loainv';
                            $loainvList = executeResult($sql);
                            foreach ($loainvList as $item) {
                                if ($item['maloai'] == $maloai) {
                                    echo '<option selected value="' . $item['maloai'] . '">' . $item['tentl'] . '</option>';
                                } else {
                                    echo '<option value="' . $item['maloai'] . '">' . $item['tentl'] . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Phòng ban:</label>
                        <select class="form-control" name="maphong" >
                            <!-- <option>Lựa chọn phòng ban</option> -->
                            <?php
                            $sql          = 'select * from phongban';
                            $phongbanList = executeResult($sql);
                            foreach ($phongbanList as $item) {
                                if ($item['maphong'] == $maphong) {
                                    echo '<option selected value="' . $item['maphong'] . '">' . $item['tenphong'] . '</option>';
                                } else {
                                    echo '<option value="' . $item['maphong'] . '">' . $item['tenphong'] . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <button class="btn btn-success">Thêm</button>
                    <button class="comeback">
                        <a href="javascript:window.history.back(-1);">Quay lại</a>
                    </button>
                </form>
            </div>
            <div style="text-align: center;color: red;font-weight: bold;">
                <?php
                if (count($errors) > 0) {
                    foreach ($errors as $er) {
                        echo $er . "<br>";
                    }
                }
                ?>
            </div>
        </div>
    </div>

</body>

</html>
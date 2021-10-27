<?php
require_once('../db/connect.php');
?>
<!DOCTYPE html>
<html>

<head>
    <title>Sửa thông tin nhân viên</title>
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
    if (isset($_GET['manv'])) {
        $manv       = $_GET['manv'];
        $sql      = "select * from nhanvien where manv = '$manv'";

        // $category = executeSingleResult($sql);
        $result = mysqli_query($connect, $sql);
        $row = null;
        if ($result != null) {
            $row    = mysqli_fetch_array($result, 1);
        }

        $honv = $row['honv'];
        $tennv = $row['tennv'];
        $ngaysinh = $row['ngaysinh'];
        $gioitinh = $row['gioitinh'];
        $diachi = $row['diachi'];
        $ten_hinh = $row['anh'];
        $maloai = $row['maloai'];
        $maphong = $row['maphong'];
    }

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $errors = array(); //khởi tạo 1 mảng chứa lỗi
        
        if (empty($_POST['honv'])) {
            $errors[] = "Bạn chưa nhập họ";
        } else {
            $honv = trim($_POST['honv']);
        }
        if (empty($_POST['tennv'])) {
            $errors[] = "Bạn chưa nhập tên";
        } else {
            $tennv = trim($_POST['tennv']);
        }

        if (empty($_POST['ngaysinh'])) {
            $errors[] = "Bạn chưa nhập ngày sinh";
        } else {
            $ngaysinh = $_POST['ngaysinh'];
        }
        $gioitinh = $_POST['gioitinh'];

        if (empty($_POST['diachi'])) {
            $errors[] = "Bạn chưa nhập địa chỉ";
        } else {
            $diachi = trim($_POST['diachi']);
        }

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
        if (isset($_POST['maloai'])) {
            $maloai = $_POST['maloai'];
        }
        if (isset($_POST['maphong'])) {
            $maphong = $_POST['maphong'];
        }

        if (empty($errors)) //neu khong co loi xay ra
        {
            $query = "UPDATE nhanvien SET honv = '$honv' ,tennv = '$tennv' ,ngaysinh = '$ngaysinh' ,gioitinh = $gioitinh ,
        diachi = '$diachi' , anh = '$ten_hinh', maloai = '$maloai' , maphong = '$maphong' WHERE manv = '$manv'";

            $result = mysqli_query($connect, $query);
            // khi bấm nút lưu thì quay lại trang index
            header('Location: index.php');
            die();
        }
    }

    ?>

    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link active" href="#">Phòng</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="../nhanvien">Nhân viên</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="../loainv">Loại nhân viên</a>
        </li>
    </ul>

    <div class="container">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h2 class="text-center">Sửa thông tin nhân viên</h2>
            </div>
            <div class="panel-body">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Mã nhân viên:</label>
                        <input readonly type="text" class="form-control" name="manv" value="<?= $manv ?>">
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
                        <input type="date" class="form-control" name="ngaysinh" value="<?= $ngaysinh ?>">
                    </div>

                    <div class="form-group">
                        <label>Giới tính:</label>
                        Nam <input id="gioitinh" name="gioitinh" type="radio" value="1" <?php echo $row['gioitinh']  == 1 ? 'checked' : '' ?> /> &nbsp;
                        Nữ <input id="gioitinh" name="gioitinh" type="radio" value="0" <?php echo $row['gioitinh'] == 0 ? 'checked' : '' ?> />
                        <td>
                    </div>

                    <div class="form-group">
                        <label>Địa chỉ:</label>
                        <input type="text" class="form-control" name="diachi" value="<?= $diachi ?>">
                    </div>

                    <div class="form-group">
                        <label>Ảnh:</label>
                        <input type="file" class="form-control" name="anh" value="<?= $ten_hinh ?>">
                    </div>

                    <div class="form-group">
                        <label>Loại nhân viên:</label>
                        <select name="maloai" class="form-control">
                            <?php
                            $sql          = 'select * from loainv';
                            $categoryList = executeResult($sql);
                            foreach ($categoryList as $item) {
                                if ($item['maloai'] == $maloai) {
                                    $s = "selected";
                                } else {
                                    $s = "";
                                }
                                echo '<option ' . $s . ' value="' . $item['maloai'] . '" class = "form-control">' . $item['tentl'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="price">Chọn Danh Mục:</label>
                        <select class="form-control" name="maphong">
                            <?php
                            $sql          = 'select * from phongban';
                            $categoryList = executeResult($sql);

                            foreach ($categoryList as $item) {
                                if ($item['maphong'] == $maphong) {
                                    echo '<option selected value="' . $item['maphong'] . '">' . $item['tenphong'] . '</option>';
                                } else {
                                    echo '<option value="' . $item['maphong'] . '">' . $item['tenphong'] . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-offset-2 col-md-6">
                        <button class="btn btn-success">Lưu</button>
                        <button class="comeback">
                            <a href="javascript:window.history.back(-1);">Quay lại</a>
                        </button>
                    </div>
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
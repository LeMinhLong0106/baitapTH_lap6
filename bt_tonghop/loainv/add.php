<?php
require_once('../db/connect.php');
?>
<!DOCTYPE html>
<html>

<head>
    <title>Thêm Loại Nhân Viên</title>
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
    $malnv = $tenlnv = "";
    $errors = array(); //khởi tạo 1 mảng chứa lỗi

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $malnv = trim($_POST['malnv']);
        $tenlnv = trim($_POST['tenlnv']);

        if ($_POST['malnv'] != "" && $_POST['tenlnv'] != "") {
            $sql = 'select * from loainv';

            $loainvList = executeResult($sql);

            $flag = true; // giả định không trùng mã
            foreach ($loainvList as $m) {
                if ($malnv == $m['maloai']) {
                    $flag = false;
                    break;
                }
            }
            if ($flag == true) {
                $query = 'insert into loainv values ("' . $malnv . '", "' . $tenlnv . '")';
                $result = mysqli_query($connect, $query);
                // khi bấm nút lưu thì quay lại trang index
                header('Location: index.php');
                die();
            } else {
                array_push($errors, "Mã loại nhân viên này đã tồn tại");
            }
        } else {
            if ($_POST['malnv'] == "") {
                array_push($errors, "Bạn chưa nhập mã loại nhân viên");
            }
            if ($_POST['tenlnv'] == "") {
                array_push($errors, "Bạn chưa nhập tên loại nhân viên");
            }
        }
    }
    ?>

    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link " href="../phong">Phòng</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="../nhanvien">Nhân viên</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="#">Loại nhân viên</a>
        </li>
    </ul>

    <div class="container">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h2 class="text-center">Thêm/Sửa Loại Nhân Viên</h2>
            </div>
            <div class="panel-body">
                <form method="post">
                    <div class="form-group">
                        <label>Mã loại nhân viên:</label>
                        <input type="text" class="form-control" name="malnv" value="<?= $malnv ?>">
                    </div>

                    <div class="form-group">
                        <label>Tên loại nhân viên:</label>
                        <input type="text" class="form-control" name="tenlnv" value="<?= $tenlnv ?>">
                    </div>
                    <button class="btn btn-success">Lưu</button>
                    <button class="comeback">
                        <a href="javascript:window.history.back(-1);">Quay lại</a>
                    </button>
                </form>
            </div>
            <?php
            if (count($errors) > 0) {
                foreach ($errors as $er) {
                    echo $er . "<br>";
                }
            }
            ?>
        </div>
    </div>
</body>

</html>
<?php
require_once('../db/connect.php');

?>
<!DOCTYPE html>
<html>

<head>
    <title>Thêm Danh Mục Phòng</title>
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
    $maphong = $tenphong = "";
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $maphong = trim($_POST['maphong']);
        $tenphong = trim($_POST['tenphong']);

        if ($_POST['maphong'] != "" && $_POST['tenphong'] != "") {
            $sql = 'select * from phongban';

            $phongbanList = executeResult($sql);

            $flag = true; // giả định không trùng mã
            foreach ($phongbanList as $m) {
                if ($maphong == $m['maphong']) {
                    $flag = false;
                    break;
                }
            }
            if ($flag == true) {
                $query = 'insert into phongban values ("' . $maphong . '", "' . $tenphong . '")';
                $result = mysqli_query($connect, $query);
                // khi bấm nút lưu thì quay lại trang index
                header('Location: index.php');
                die();
            } else {
                array_push($errors, "Mã phòng đã tồn tại");
            }
        } else {
            if ($_POST['maphong'] == "") {
                array_push($errors, "Bạn chưa nhập mã phòng");
            }
            if ($_POST['tenphong'] == "") {
                array_push($errors, "Bạn chưa nhập tên phòng");
            }
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
                <h2 class="text-center">Thêm Phòng</h2>
            </div>
            <div class="panel-body">
                <form method="post">
                    <div class="form-group">
                        <label>Mã phòng:</label>
                        <input type="text" class="form-control" name="maphong" value="<?= $maphong ?>">
                    </div>

                    <div class="form-group">
                        <label>Tên phòng:</label>
                        <input type="text" class="form-control" name="tenphong" value="<?= $tenphong ?>">
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
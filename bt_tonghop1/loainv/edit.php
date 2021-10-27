<?php
require_once('../db/connect.php');
?>
<!DOCTYPE html>
<html>

<head>
    <title>Sửa loại nhân viên</title>
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
    if (isset($_GET['maloai'])) {
        $maloai       = $_GET['maloai'];
        $sql      = "select * from loainv where maloai = '$maloai'";
        $result = executeSingleResult($sql);
        if ($result != null) {
            $tentl = $result['tentl'];
        }
    }

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        //kiểm tra tên 
        if (empty($_POST['tentl'])) {
            $errors[] = "Bạn chưa nhập tên loại nhân viên";
        } else {
            $tentl = trim($_POST['tentl']);
        }

        if (empty($errors)) //neu khong co loi xay ra
        {
            $query = "UPDATE loainv SET tentl = '$tentl' WHERE maloai = '$maloai'";

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
                <h2 class="text-center">Sửa loại nhân viên</h2>
            </div>
            <div class="panel-body">
                <form method="post">
                    <div class="form-group">
                        <label>Mã loại nhân viên:</label>
                        <input readonly type="text" class="form-control" name="maloai" value="<?php echo $maloai ?>">
                    </div>

                    <div class="form-group">
                        <label>Tên loại nhân viên:</label>
                        <input type="text" class="form-control" name="tentl" value="<?php echo $tentl ?>">
                    </div>
                    <button class="btn btn-success">Lưu</button>
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
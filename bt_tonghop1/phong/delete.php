<?php
require_once('../db/connect.php');
?>
<!DOCTYPE html>
<html>

<head>
    <title>Xóa Danh Mục Phòng</title>
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
    $maphong = $tenphong = "";
    $errors = [];
    if (isset($_GET['maphong'])) {
        $maphong       = $_GET['maphong'];
        $sql      = "select * from phongban where maphong = '$maphong'";

        // $category = executeSingleResult($sql);
        $result = mysqli_query($connect, $sql);
        $row = null;
        if ($result != null) {
            $row    = mysqli_fetch_array($result, 1);
        }
        $tenphong = $row['tenphong'];
    }

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $sql = 'select * from nhanvien ';

        $nhanvienList = executeResult($sql);

        $flag = true; // giả định không trùng mã
        foreach ($nhanvienList as $m) {
            if ($maphong == $m['maphong']) {
                $flag = false;
                break;
            }
        }
        if ($flag == true) {
            $query = "DELETE from phongban WHERE maphong = '$maphong'";
            // DELETE FROM `phongban` WHERE `phongban`.`maphong` = 'a';
            $result = mysqli_query($connect, $query);
            // khi bấm nút lưu thì quay lại trang index
            header('Location: index.php');
            die();
        } else {
            array_push($errors, "Mã phòng tồn tại trong bảng nhân viên, không thể xóa được");
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
                <h2 class="text-center">Xóa Phòng</h2>
            </div>
            <div class="panel-body">
                <form method="post">
                    <div class="form-group">
                        <label>Mã phòng:</label>
                        <input readonly type="text" class="form-control" name="maphong" value="<?php echo $maphong ?>">
                    </div>

                    <div class="form-group">
                        <label>Tên phòng:</label>
                        <input readonly type="text" class="form-control" name="tenphong" value="<?php echo $tenphong ?>">
                    </div>
                    <button class="btn btn-success">Xóa</button>
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
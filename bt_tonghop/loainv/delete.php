<?php
require_once('../db/connect.php');
?>
<!DOCTYPE html>
<html>

<head>
    <title>Xóa loại nhân viên</title>
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
    $maloai = $tentl = "";
    $errors = [];
    if (isset($_GET['maloai'])) {
        $maloai       = $_GET['maloai'];
        $sql      = "select * from loainv where maloai = '$maloai'";

        // $category = executeSingleResult($sql);
        $result = mysqli_query($connect, $sql);
        $row = null;
        if ($result != null) {
            $row    = mysqli_fetch_array($result, 1);
        }

        $tentl = $row['tentl'];
    }

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $sql = 'select * from nhanvien ';

        $nhanvienList = executeResult($sql);

        $flag = true; // giả định không trùng mã
        foreach ($nhanvienList as $m) {
            if ($maloai == $m['maloai']) {
                $flag = false;
                break;
            }
        }
        if ($flag == true) {
            $query = "DELETE from loainv WHERE maloai = '$maloai'";
            // DELETE FROM `phongban` WHERE `phongban`.`maphong` = 'a';
            $result = mysqli_query($connect, $query);
            // khi bấm nút lưu thì quay lại trang index
            header('Location: index.php');
            die();
        } else {
            array_push($errors, "Mã loại nhân viên đã tồn tại trong bảng nhân viên, không thể xóa được");
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
                        <input readonly required="true" type="text" class="form-control" name="maloai" value="<?php echo $maloai ?>">
                    </div>

                    <div class="form-group">
                        <label>Tên phòng:</label>
                        <input required="true" type="text" class="form-control" name="tentl" value="<?php echo $tentl ?>">
                    </div>
                    <button class="btn btn-success">Xóa</button>
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
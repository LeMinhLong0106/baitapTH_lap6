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
    $maloai = $tentl = "";

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $errors = array(); //khởi tạo 1 mảng chứa lỗi
        //kiem tra ma sua
        if (empty($_POST['maloai'])) {
            $errors[] = "Bạn chưa nhập mã loại";
        } else {
            $maloai = trim($_POST['maloai']);
        }
        //kiểm tra tên sản phẩm
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
        } else { //neu co loi
            echo "<h2>Lỗi</h2><p>Có lỗi xảy ra:<br/>";
            foreach ($errors as $msg) {
                echo "- $msg<br /><\n>";
            }
            echo "</p><p>Hãy thử lại.</p>";
        }
    }
    // mysqli_close($connect);

    if (isset($_GET['maloai'])) {
        $maloai       = $_GET['maloai'];
        $sql      = "select * from loainv where maloai = '$maloai'" ;

        // $category = executeSingleResult($sql);
        $result = mysqli_query($connect, $sql);
        $row = null;
        if ($result != null) {
            $row    = mysqli_fetch_array($result, 1);
        }
        $tentl = $row['tentl'];
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
                        <input readonly required="true" type="text" class="form-control" name="maloai" value="<?php echo $maloai ?>">
                    </div>

                    <div class="form-group">
                        <label>Tên loại nhân viên:</label>
                        <input required="true" type="text" class="form-control" name="tentl" value="<?php echo $tentl ?>">
                    </div>
                    <button class="btn btn-success">Lưu</button>
                    <button class="comeback">
                        <a href="javascript:window.history.back(-1);">Quay lại</a>
                    </button>
                </form>

            </div>
        </div>
    </div>

</body>

</html>
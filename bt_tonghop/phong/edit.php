<?php
require_once('../db/connect.php');
?>
<!DOCTYPE html>
<html>

<head>
    <title>Sửa Danh Mục Phòng</title>
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
    // $maphong = $tenphong = "";
    $errors = array(); //khởi tạo 1 mảng chứa lỗi
    if (isset($_GET['maphong'])) {
        $maphong       = $_GET['maphong'];
        $sql      = "select * from phongban where maphong = '$maphong'";
        $result = executeSingleResult($sql);
        if ($result != null) {
            $tenphong = $result['tenphong'];
        }
    }

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $errors = array(); //khởi tạo 1 mảng chứa lỗi
        //kiểm tra tên sản phẩm
        if (empty($_POST['tenphong'])) {
            $errors[] = "Bạn chưa nhập tên phòng";
        } else {
            $tenphong = trim($_POST['tenphong']);
        }

        if (empty($errors)) //neu khong co loi xay ra
        {
            $query = "UPDATE phongban SET tenphong = '$tenphong' WHERE maphong = '$maphong'";

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
                <h2 class="text-center">Sửa Phòng</h2>
            </div>
            <div class="panel-body">
                <form method="post">
                    <div class="form-group">
                        <label>Mã phòng:</label>
                        <input readonly type="text" class="form-control" name="maphong" value="<?php echo $maphong ?>">
                    </div>

                    <div class="form-group">
                        <label>Tên phòng:</label>
                        <input type="text" class="form-control" name="tenphong" value="<?php echo $tenphong ?>">
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
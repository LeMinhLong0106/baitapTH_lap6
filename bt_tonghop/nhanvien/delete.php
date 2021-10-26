<?php
require_once('../db/connect.php');
?>
<!DOCTYPE html>
<html>

<head>
    <title>Xóa nhân viên</title>
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
    // $manv = $honv = "";

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
        $query = "DELETE from nhanvien WHERE manv = '$manv'";
        $result = mysqli_query($connect, $query);
        // khi bấm nút lưu thì quay lại trang index
        header('Location: index.php');
        die();
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

    <div class="checkform">
        <div class="content">
            <h3 class="text-center">Bạn chắc chắn muốn xóa nhân viên này ?</h3>
            <form method="post">
                <div class="form-horizontal" style="display:flex; justify-content:center">
                    <?php
                    echo '<img style="width: 250px; height: 270px; align-self: center; display: flex;" src="../hinh_nv/' . $ten_hinh . '" />';
                    ?>
                    <div style=" margin-left: 10px; width: 350px;">
                        <label class="form-control">Mã nhân viên: <?php echo $manv ?> </label>
                        <label class="form-control">Họ tên nhân viên: <?php echo $honv . $tennv ?> </label>
                        <label class="form-control">Ngày sinh:
                            <?php
                            $date = str_replace('-', '/', $ngaysinh);
                            echo date('d/m/Y', strtotime($date));
                            ?>
                        </label>
                        <label class="form-control">Giới tính:
                            <?php
                            if ($gioitinh == 1)
                                echo "Nam";
                            else
                                echo "Nữ";

                            ?> </label>
                        <label class="form-control">Địa chỉ: <?php echo $diachi ?> </label>
                        <label class="form-control">Loại nhân viên:
                            <?php
                            $sql = 'select * from loainv';
                            $categoryList = executeResult($sql);
                            foreach ($categoryList as $item) {
                                if ($item['maloai'] == $maloai)
                                    echo $item['tentl'];
                            } ?> </label>
                        <label class="form-control">Phòng ban:
                            <?php
                            $sql = 'select * from phongban';
                            $categoryList = executeResult($sql);
                            foreach ($categoryList as $item) {
                                if ($item['maphong'] == $maphong)
                                    echo $item['tenphong'];
                            } ?> </label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-offset-2 col-md-6">
                        <input type="submit" value="Xóa" class="btn btn-primary" />
                    </div>
                    <div class="col-md-offset-2 col-md-6">
                        <button class="comeback">
                            <a href="javascript:window.history.back(-1);">Quay lại</a>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</body>

</html>
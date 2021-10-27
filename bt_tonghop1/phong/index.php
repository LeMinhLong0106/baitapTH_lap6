<!-- nhúng từ các file khác -->
<?php
require_once('../db/connect.php');
require_once('../db/phantrang.php');
session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <title>Quản Lý Danh Mục</title>
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
    <div style="text-align: end;color: red;font-weight: bold;">
        Chào mừng <?php echo $_SESSION['username'];  ?>
    </div>

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
                <h2 class="text-center">Thông tin phòng</h2>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-6">
                        <a href="add.php">
                            <button class="btn btn-success" style="margin-bottom: 15px;">Thêm phòng</button>
                        </a>
                    </div>
                    <div class="col-lg-6">
                        <form method="get">
                            <div class="form-group" style="width: 200px; float: right;">
                                <input type="text" class="form-control" placeholder="Tìm kiếm..." id="s" name="s" value="<?php if (isset($_GET['s'])) echo $_GET['s']; ?>">
                            </div>
                        </form>
                    </div>
                </div>

                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th width="50px">STT</th>
                            <th>Mã phòng</th>
                            <th>Tên phòng</th>
                            <th width="50px"></th>
                            <th width="50px"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        //số lượng sản phẩm trong 1 trang
                        $limit = 5;
                        $page = 1;
                        //trang cần lấy sp
                        if (isset($_GET['page'])) {
                            $page = $_GET['page'];
                        }
                        //tránh tình trạng nhập page nhỏ hơn 0
                        if ($page <= 0) {
                            $page = 1;
                        }
                        $firstIndex = ($page - 1) * $limit;
                        //dữ liệu tìm kiếm
                        $s = '';
                        if (isset($_GET['s'])) {
                            $s = $_GET['s'];
                        }

                        $additional = '';
                        if (!empty($s)) {
                            $additional = ' and maphong like "%' . $s . '%" or tenphong like "%' . $s . '%"';
                        }

                        $sql = 'select * from phongban where 1 ' . $additional . ' limit ' . $firstIndex . ',' . $limit;

                        $phongbanList = executeResult($sql);

                        $sql = 'select count(maphong) as total from phongban ' . $additional;
                        $countR = executeSingleResult($sql);

                        $number = 0;
                        if ($countR != null) {
                            $count =  $countR['total'];
                            $number = ceil($count / $limit);
                        }

                        if (!empty($phongbanList)) {
                            foreach ($phongbanList as $item) {
                                echo '
                            <tr>
                                <td>' . (++$firstIndex) . '</td>
                                <td>' . $item['maphong'] . '</td> 
                                <td>' . $item['tenphong'] . '</td> 
                                <td>
                                    <a href="edit.php?maphong=' . $item['maphong'] . '"><button class="btn btn-warning">Sửa</button></a>
                                </td>
                                <td>
                                <a href="delete.php?maphong=' . $item['maphong'] . '"><button class="btn btn-danger">Xóa</button></a>
                                </td>
                            </tr>';
                            }
                        } else {
                            echo '<tr>';
                            echo '<td colspan="5" style="text-align: center; color: red;font-weight: bold;">Không tìm thấy thông tin phòng </td>';
                            echo '</tr>';
                        }

                        ?>
                    </tbody>
                </table>
                <!-- bài toán phân trang -->
                <?php paginarion($number, $page, '&s=' . $s) ?>
            </div>
        </div>
    </div>
</body>

</html>
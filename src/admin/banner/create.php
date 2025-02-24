<?php
// Include file kết nối CSDL
include_once '../dbconnect.php';

// Xử lý khi form được submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form
    $bannerName = $_POST['banner_name'];
    $content = $_POST['content'];
    $link = $_POST['link'];

    // Xử lý ảnh banner
    $targetDir = "../assets/img/imgbanners/";    

    // Lấy ngày tháng năm hiện tại
    $currentDate = date("YmdHis");

    // Upload ảnh banner
    $targetFile = $targetDir . $currentDate . "_" . basename($_FILES["banner_image"]["name"]);
    if (move_uploaded_file($_FILES["banner_image"]["tmp_name"], $targetFile)) {
        // Thêm mới thông tin banner vào CSDL
        $insertBannerQuery = "INSERT INTO banners (banner_name, banner_image, content, link) VALUES ('$bannerName', '$targetFile', '$content', '$link')";

        if (mysqli_query($conn, $insertBannerQuery)) {
            // Đặt thông điệp thành công vào session
            $_SESSION['success_message'] = 'Banner đã được thêm thành công!';
        } else {
            $_SESSION['success_message'] = 'Có lỗi khi thêm banner!';
        }
    } else {
        $_SESSION['success_message'] = 'Có lỗi khi tải ảnh lên!';
    }

    // Chuyển hướng về trang danh sách banner sau khi thêm mới
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../assets/css/modal.css">
    <title>Thêm mới Banner</title>
    <style>
        .container {
            margin-top: 80px;
        }
    </style>
</head>

<body>
    <?php include_once '../header.php'; ?>
    <div class="container">
        <div class="row">
            <main role="main" class="col-md-9 ms-sm-auto col-lg-10 px-4">
                <a href="index.php" class="btn btn-secondary"><i class="fa-solid fa-left-long"></i></a>
                <h2 class="my-4">Thêm mới Banner</h2>

                <?php
                if (isset($_SESSION['success_message'])) {
                    echo '<div class="alert alert-success">' . $_SESSION['success_message'] . '</div>';
                    unset($_SESSION['success_message']);
                }
                ?>

                <form action="create.php" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="banner_name" class="form-label">Tên banner:</label>
                        <input type="text" class="form-control" id="banner_name" name="banner_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="banner_image" class="form-label">Ảnh banner:</label>
                        <input type="file" class="form-control" id="banner_image" name="banner_image" accept="image/*" required>
                    </div>
                    <div class="mb-3">
                        <label for="content" class="form-label">Nội dung:</label>
                        <textarea class="form-control" id="content" name="content"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="link" class="form-label">Link:</label>
                        <input type="text" class="form-control" id="link" name="link">
                    </div>
                    <button type="submit" class="btn btn-primary">Thêm mới</button>
                </form>
            </main>
        </div>
    </div>
    <?php include_once '../footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
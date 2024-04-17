<?php
session_start(); // 启动会话

// 数据库连接设置
$host = 'localhost';
$dbname = 'userdata';
$user = 'root';
$pass = '';
$error = ""; // 错误消息初始化

// 使用PDO连接数据库
$dsn = "mysql:host=$host;dbname=$dbname;charset=UTF8";
try {
    $pdo = new PDO($dsn, $user, $pass);
} catch (PDOException $e) {
    die('数据库连接失败: ' . $e->getMessage());
}

// 处理注册表单提交
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $realname = $_POST['realname'];

    // 查询用户名或邮箱是否已存在
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username = ? OR email = ?");
    $stmt->execute([$username, $email]);
    
    if ($stmt->fetchColumn() > 0) {
        $error = "用户名或邮箱已被注册。";
    } else {
        // 加密密码并插入新用户
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password, realname, identity) VALUES (?, ?, ?, ?,'normal_user')");
        
        if ($stmt->execute([$username, $email, $passwordHash, $realname])) {
            // 注册成功后重定向到登录页面
            header("Location: login.php");
            exit;
        } else {
            $error = "注册失败，请稍后再试。";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>注册页面</title>
    <!-- 引入您提供的样式 -->
    <!-- Bootstrap CSS -->
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<!-- Style CSS -->
<link rel="stylesheet" type="text/css" href="css/style.css">
<!-- Responsive CSS -->
<link rel="stylesheet" href="css/responsive.css">
<!-- Favicon -->
<link rel="icon" href="images/fevicon.png" type="image/gif" />
<!-- Scrollbar Custom CSS -->
<link rel="stylesheet" href="css/jquery.mCustomScrollbar.min.css">
<!-- Owl Stylesheets -->
<link rel="stylesheet" href="css/owl.carousel.min.css">
<link rel="stylesheet" href="css/owl.theme.default.min.css">
<style>
    .container-fluid {
    display: flex;
    align-items: center; /* 这会垂直居中flex项 */
    justify-content: space-between; /* 这会在两侧的项目之间添加空间 */
}

  .navbar-brand img {
    max-height: 20px; /* Adjust the size as needed */
}

.navbar {
    font-size: 1.8em; /* Larger font size for nav items */
}

.nav-item.nav-link {
    padding: 0 1em; /* Add some space on the sides of nav items */
}
/* 添加背景色和居中样式到注册部分 */
.contact_section {
    background-color: #f5f0eb; /* 肉色背景 */
    padding: 50px 0;
    display: flex;
    justify-content: center; /* 水平居中 */
}

/* 设定一个蓝色边框盒子样式 */
.box {
    background: #ffffff; /* 设置背景色为白色 */
    border-radius: 10px; /* 设置边角的圆滑程度 */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* 给盒子添加阴影 */
    padding: 40px; /* 内部填充空间 */
    margin: 40px auto; /* 上下保持40px间距，并自动居中 */
    width: 80%; /* 盒子宽度为父元素的80% */
    max-width: 500px; /* 最大宽度为500px */
}

.container-fluid {
    background-color: #f5f0eb; /* 肉色背景 */
    padding: 10px 20px; /* 上下10px、左右20px的填充 */
    margin-bottom: 40px; /* 与下面内容的间距 */
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* 轻微的阴影 */
}

.form-container {
    max-width: 500px; /* 最大宽度为500px */
    margin: 0 auto; /* 自动外边距使得元素水平居中 */
    padding: 40px; /* 内部填充空间 */
    background: #ffffff; /* 设置背景色为白色 */
    border-radius: 10px; /* 设置边角的圆滑程度 */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* 给盒子添加阴影 */
}

.contact_section {
    background-color: #f5f0eb; /* 肉色背景 */
    padding: 50px 0; /* 上下内边距 */
}
/* 添加间隔的样式 */
.btn-space {
    margin-top: 20px; /* 比如增加20px的间隔 */
}
.custom-button {
    background-color: #303b53; /* 这里是示例颜色，您需要使用取色工具获取您图片中按钮的准确颜色 */
    color: white; /* 文本颜色设置为白色 */
    border: none; /* 没有边框 */
    padding: 15px 32px; /* 内边距，可根据需要调整大小 */
    text-align: center; /* 文本居中 */
    text-decoration: none; /* 无下划线 */
    display: inline-block; /* 使按钮不独占一行，依据文本内容调整宽度 */
    font-size: 16px; /* 字体大小，可根据需要调整 */
    margin: 4px 2px; /* 外边距，可根据需要调整 */
    cursor: pointer; /* 鼠标悬停时显示指针手型图标 */
    border-radius: 4px; /* 边角圆滑，可根据需要调整 */
  }

</style>
</head>
<body>

<!-- 顶部导航栏 -->
<div class="container-fluid">
    <!-- Logo placed on the left side -->
    <a class="navbar-brand" href="index.php"><img src="images/logo.png" alt="Logo"></a>

    <!-- Navigation links placed on the right side -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light justify-content-end">
        <div class="navbar-nav">
            <a class="nav-item nav-link" href="index.php">Home</a>
            <a class="nav-item nav-link" href="products.php">Products</a>
            <a class="nav-item nav-link" href="about.html">About</a>
            <a class="nav-item nav-link" href="contact.html">Contact</a>
        </div>
    </nav>
</div>

<!-- 注册表单 -->
<div class="contact_section layout_padding">
    <div class="container">
        <div class="form-container">
            <h1 class="contact_taital">Register</h1>
            <?php if (!empty($error)): ?>
                <div style="color: red;"><?php echo $error; ?></div>
            <?php endif; ?>
            <form method="post" action="register.php">
                <input type="text" name="username" placeholder="Username" required><br>
                <input type="email" name="email" placeholder="Email" required><br>
                <input type="password" name="password" placeholder="Password" required><br>
                <input type="text" name="realname" placeholder="What's your name?" required><br><br>
                <h2><button type="submit" class="custom-button">Register now</button></h2>

            </form>
        </div>
    </div>
</div>

</body>
</html>

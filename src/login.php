<?php
// 启动会话
session_start();

// 连接数据库（根据你的配置进行调整）
$host = 'localhost'; // 数据库服务器
$dbname = 'userdata'; // 数据库名
$user = 'root'; // 数据库用户名
$pass = ''; // 数据库密码
$error = ""; // 初始化错误信息为空字符串

// 使用PDO连接数据库
$dsn = "mysql:host=$host;dbname=$dbname;charset=UTF8";
try {
  $pdo = new PDO($dsn, $user, $pass);
} catch (PDOException $e) {
  die('数据库连接失败: ' . $e->getMessage());
}

// 用户提交登录表单时处理
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
  $username = $_POST['username']; // 修改为账号
  $password = $_POST['password'];

  // 查询数据库以查找用户
  $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?"); // 修改为账号
  $stmt->execute([$username]);
  $user = $stmt->fetch(PDO::FETCH_ASSOC);


  // 检查用户是否存在且密码是否正确
  if ($user && password_verify($password, $user['password'])) {
      // 密码正确，设置会话变量
      $_SESSION['user_id'] = $user['id'];
      $_SESSION['username'] = $user['username'];
      $_SESSION['identity'] = $user['identity']; // 假设用户身份存储在 'identity' 字段

      // 根据用户身份重定向到不同页面
      if ($_SESSION['identity'] == 'admin') {
          header("Location: admin.php");
          exit;
      } else if ($_SESSION['identity'] == 'normal_user') {
          header("Location: products.php");
          exit;
      } else {
          // 可以处理其他用户类型或默认重定向
          header("Location: index.php");
          exit;
      }
  } else {
      // 密码或账号不正确，显示错误
      $error = password_verify($password, $user['password']); // 修改为账号
  }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
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
  <meta charset="UTF-8">
  <title>Simple Login Form Example</title>
  <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Rubik:400,700'><link rel="stylesheet" href="./css/signinstyle.css">
  <style>
    /* 添加对包含表单输入和忘记密码链接的容器的样式 */
    .input-field {
    position: relative; /* 设置相对定位，作为后续绝对定位的参考 */
    display: flex; /* 使用flex布局 */
    flex-direction: column; /* 使得元素垂直排列 */
    justify-content: flex-end; /* 把内容推到底部 */
}

.forgot-password-link {
    align-self: flex-end; /* 把链接推到右边 */
    margin-top: -30px; /* 向上移动，值可以根据实际情况调整 */
    margin-bottom: 20px; /* 添加一些下边距，值可以根据实际情况调整 */
    font-size: 1em; /* 设置字体大小，可根据需要进行调整 */
    color: #007bff; /* Bootstrap链接颜色，或者根据你的设计调整 */
    text-decoration: none; /* 去除下划线 */
}


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

  <div class="login-form">
    <?php if (!empty($error)): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>
    <form action="login.php" method="POST">
    <h1 class="contact_taital">Login</h1>
      <div class="content">
        <div class="input-field">
          <input type="text" name="username" placeholder="Username" autocomplete="off" required> <!-- 修改为账号输入 -->
        </div>
        <div class="input-field">
    <input type="password" name="password" placeholder="Password" autocomplete="new-password" required>
    <!-- 忘记密码链接 -->
    <a href="forgot_password.php" class="forgot-password-link">Forget your password?</a>
</div>

      <div class="action">
        <button type="submit" name="login">Sign in</button> <!-- 添加了name属性 -->
        <button type="button" onclick="window.location='register.php';">Register</button> <!-- 添加注册按钮 -->
        <!-- 忘记密码链接 -->
      </div>
    </form>
  </div>
</body>
</html>

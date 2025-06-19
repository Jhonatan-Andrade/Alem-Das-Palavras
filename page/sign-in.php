<?php
    include '../db/services.php';

    if (isset($_POST['create'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        if(empty($username) || empty($password)) {
            $message = "Todos os campos são obrigatórios.";
        }else{
            $stmt = login($db,  $username,  $password);
            if($stmt) {
                header("location: ./userList.php"); 
            } else {
                $message = "Dados incorretos.";
            }
        }

    }
    
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PhpTest</title>
    <link rel="stylesheet" href="../css/styles.css">
    <style>
    .link {
        display: inline-block;
        margin-top: 20px;
        text-decoration: none;
        color: #f4f4f4;
        background-color:#007bff ;
        padding: 10px 15px;
        border-radius: 5px;
        transition: background-color 0.3s;
        
    }
    </style>
</head>
<body>
    <div class="center-container">
        <form  method="post" class="login-form">
            <h2>Login</h2>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password">
            </div>
            <button name="create" type="submit" class="login-btn">Login</button>
            <p class="erroText"><?php if (isset($message)) echo $message; ?></p>
            <a class="link" href="./sign-up.php"> sign-up</a>
            <a class="link" href="./userList.php"> users</a>
        </form>
    </div>
</body>
</html>
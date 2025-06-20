<?php
    include '../db/services.php';
    session_start();
    if (isset($_POST['login'])) {


        $username = $_POST['username'];
        $password = $_POST['password'];
        if(empty($username) || empty($password)) {
            $message = "Todos os campos são obrigatórios.";
            echo "<script>
                setTimeout(function() {
                    document.querySelectorAll('.erroText').forEach(function(el) {
                    el.textContent = ' ';
                    });
                }, 2000);
            </script>";
        } else {
            $stmt = login($db,  $username,  $password);
            if($stmt) {
                $_SESSION["username"] = $username;
                header("location: ./home.php"); 
                exit();
            } else {
                unset($_SESSION["username"]);
                $message = "Dados incorretos.";
                echo "<script>
                    setTimeout(function() {
                        document.querySelectorAll('.erroText').forEach(function(el) {
                        el.textContent = ' ';
                        });
                    }, 2000);
                </script>";
            }
        }

    }
    if (isset($_POST['create'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $confirmPassword = $_POST['confirmPassword'];
        if(empty($username) || empty($password) || empty($confirmPassword)) {
            $message = "Todos os campos são obrigatórios.";
            echo "<script>
                setTimeout(function() {
                    document.querySelectorAll('.erroText').forEach(function(el) {
                    el.textContent = ' ';
                    });
                }, 2000);
            </script>";
        } elseif ($password !== $confirmPassword) {
            $message = "Dados incorretos.";
            echo "<script>
                setTimeout(function() {
                    document.querySelectorAll('.erroText').forEach(function(el) {
                    el.textContent = ' ';
                    });
                }, 2000);
            </script>";
        } else {
            $stmt = createUser($db,  $username,  $password);

            if($stmt) {
                $_SESSION["username"] = $username;
                header("location: ./home.php"); 
                exit();
            } else {
                unset($_SESSION["username"]);
                $message = "Usuário já existente ";
                echo "<script>
                    setTimeout(function() {
                        document.querySelectorAll('.erroText').forEach(function(el) {
                        el.textContent = ' ';
                        });
                    }, 2000);
                </script>";
            }
        }
    }
    
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User</title>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/sign-In-Up.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <style>
        *{
            box-sizing: border-box;
            font-family: "Inter", sans-serif;
            padding: 0;
            margin: 0;
        }
        body{
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100vw;
            height: 100dvh;
            background-image: url("../assets/bg.jpg");
            background-size: cover;
            background-repeat: no-repeat;
            background-color: black;
        }
    </style>
</head>
<body>
    <div class="center-container">
        <form  method="post" class="sign-in-form form">
            <h2>Login</h2>
            <div class="form-group">
                <div class="form-group-input">
                    <label for="username">Username</label>
                    <input type="text" id="sign-in-username"  name="username">
                </div>
                <div class="form-group-input">
                    <label for="password">Password</label>
                    <input type="password" id="sign-in-password" name="password">
                </div>
            </div>  
            <p class="erroText"><?php if (isset($message)) echo $message; ?></p>
            <button  name="login" type="submit" class="sign-in-btn submitButton">Login</button>
            <button name="nav" type="submit" onclick="navigate('sign-up')" class="navButton">sign-up</button>
        </form>

        <form  method="post" class="sign-up-form form">
                <h2>Cadastre-se</h2>
                <div class="form-group">
                    <div class="form-group-input">
                        <label for="username">Username</label>
                        <input type="text" name="username">
                    </div>
                    <div class="form-group-input">
                        <label for="password">Password</label>
                        <input type="password" name="password">
                    </div>
                    <div class="form-group-input">
                        <label for="confirm password">Password</label>
                        <input type="password" name="confirmPassword">
                    </div>
                </div>
                <p class="erroText"><?php if (isset($message)) echo $message; ?></p>
                <button name="create" type="submit" class="sign-up-btn submitButton">Criar</button>
                <button name="nav" type="submit"  onclick="navigate('sign-in')" class="navButton">sign-in</button>
             
        </form>
    </div>
</body>
<script src="../js/navigation.js"></script>
</html>
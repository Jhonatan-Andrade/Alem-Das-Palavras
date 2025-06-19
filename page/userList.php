<?php
    include '../db/services.php';
    $users = readUsers($db);

    if (isset($_POST['delete'])) {
        $id = $_POST['userId'];
        $stmt = deleteUser($db,  $id);
        if($stmt) {
            header("location: ./userList.php"); 
        } else {
            $message = "erro ao deletar";
        }
        
    }
    if (isset($_POST['update'])) {
        $id = $_POST['userId'];
        $username = $_POST['userName'];
        $stmt = changeUserName($db,  $id, $username);
        if($stmt) {
            header("location: ./userList.php"); 
        } else {
            $message = "erro ao iditar $userpassword";
        }
        
    }
?>
<!DOCTYPE html>
<html>
<head>
    <title>Lista de Usuarios</title>
</head>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 20px;
    }
    h1 {
        text-align: center;
        color: #333;
    }
    ul {
        list-style-type: none;
        padding: 0;
    }
    li {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: rgb(182, 182, 182);
        margin: 10px 0;
        padding: 10px 50px ;
        border-radius: 5px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);

    }
    li p{
        color: #007bff;
        font-size: 12pt;
        font-family: Arial, Helvetica, sans-serif;
        font-weight: bold;
    }
    li button{
        display: inline-block;
        text-decoration: none;
        color: #f4f4f4;
        background-color:#007bff ;
        padding: 10px 15px;
        border-radius: 5px;
        transition: background-color 0.3s;
        border: none;
    }
    li .updateButton{
         background-color: #007bff;
    }
    li .deleteButton{
         background-color:rgb(255, 69, 69);
    }
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
    .updateInput{
        color: #007bff;
        padding: 10px 15px;
        border-radius: 5px;
        border: none;
        transition: background-color 0.3s;
    }
</style>
<body>
    <h1>Lista de Usuarios</h1>
    <ul>
        <?php foreach ($users as $user): ?>
            <li>
                <p>
                    <?php echo htmlspecialchars($user['username']); ?>
                </p>
                <div>
                     <form method="post" style="display:inline;">
                        <input type="hidden" name="userId" value="<?php echo htmlspecialchars($user['id']); ?>">
                        <input class="updateInput" type="text" name="userName">
                        <button class="updateButton" name="update" type="submit">Editar</button>
                    </form>                   
                    <form method="post" style="display:inline;">
                        <input type="hidden" name="userId" value="<?php echo htmlspecialchars($user['id']); ?>">
                        <button class="deleteButton" name="delete" type="submit" onclick="return confirm('Tem certeza que deseja excluir este usuário?');">Excluir</button>
                    </form>

                </div>
            </li>
        <?php endforeach; ?>
    </ul>
    <p class="erroText"><?php if (isset($message)) echo $message; ?></p>
    <a class="link" href="./sign-in.php"> sign-in</a>
    <a class="link" href="./sign-up.php"> sign-up</a>
    <script>

        function update(params) {
            prompt("Digite o nome do usuário")
            confirm('Tem certeza que deseja editar este usuário?')
            return
        }
    </script>
</body>
</html>
<?php
    require 'pdo.php';

    if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['submit'])){
        $id = $_POST['id'];
        $f_name = $_POST['f_name'];
        $l_name = $_POST['l_name'];
        $m = $_POST['m'];
        $email = $_POST['email'];
        $username = $_POST['username'];
        $password = $_POST['password'];

        $sql = "UPDATE users SET
                f_name = :f_name,
                l_name = :l_name,
                m = :m,
                email = :email,
                username = :username,
                password= :password";
        try{
            $stmt = $pdo->prepare($sql);

            $updated = $stmt->execute([
            ':f_name' => $f_name,
            ':l_name' => $l_name,
            ':m' => $m,
            ':username' => $username,
            ':email' => $email,
            ':password' => $password,
            ':id'=> $id
        ]);
        if($updated){
            header("Location: customer.php?succes=1");
            exit();
        }else{
            header("Location: customer.php?error=1");
            exit();
        }

        }catch(PDOException $e){
            die("Pataka ra ka da");
        }
    }
?>
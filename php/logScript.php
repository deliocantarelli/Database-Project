<?php
    function login ()
    {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $db = new mysqli('localhost', 'root', '', 'Databases');
        if($db->connect_errno > 0)
        {
            die('Unable to connect to database [' . $db->connect_error . ']');
        }
 
        if ($result = $db->query("SELECT * FROM Users where Email like '" . $email . "' and Password like '" . $password . "'"))
        {
            if($result->num_rows > 0)
            {
                header("Location: http://localhost/Database/home.html");
                exit();
            }
        }
 
        return false; // Para vc saber que deu erro
    }
    function logout ()
    {
 
    }
           
    if ($_POST) { // O usuário submeteu o FORM
        $loginResult = login();
 
        if (!$loginResult) {
                $error = 'Login failed. Please check your email and password.';
        }
    }
?>
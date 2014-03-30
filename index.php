<?php
    if(isset($_SESSION))
    {
        session_destroy();
    }
    error_reporting(E_ALL);
    function startSession()
    {
        $db = new mysqli('localhost', 'root', '', 'Databases');
        $statement = $db->prepare("SELECT UserID FROM Users where Email like ?");
        $statement->bind_param("s", $_POST['email']);
        $statement->execute();
        $statement->bind_result($ID);
        $statement->store_result();
        $statement->fetch();


        $idSession = "s";
        for ($i = 0; $i < 15; $i++)
        {
            $idSession = $idSession . dechex(rand(1, 16));
        }
        session_id($idSession);
        session_start();
        header("Location: http://localhost/Database/home.php?user=".$ID);
    }
    function login ()
    {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $db = new mysqli('localhost', 'root', '', 'Databases');
        if($db->connect_errno > 0)
        {
            die('Unable to connect to database [' . $db->connect_error . ']');
        }
        $statement = $db->prepare("SELECT * FROM Users where Email like ? and Password like ?");
        $statement->bind_param("ss", $email, $password);
        if($statement->execute())
        {
            $statement->store_result();
            if($statement->num_rows > 0)
            {
                $statement = $db->prepare("UPDATE Users set LastLogin=NOW() where Email like ?");
                $statement->bind_param("s", $_POST['email']);
                $statement->execute();
                startSession();
                exit();
            }
        }
        $statement->close();
 
        return false; // Para vc saber que deu erro
    }
    function signup ()
    {
        global $error_type;
        $error_type['password'] = false;
        $error_type['email'] = false;


        $db = new mysqli('localhost', 'root', '', 'Databases');
        if($db->connect_errno > 0)
        {
            die('Unable to connect to database [' . $db->connect_error . ']');
        }
        $errors = false;

        if(strcmp($_POST['password'], $_POST['confirm-password']) !== 0)
        {
            $errors = true;
            $error_type['password'] = true;
        }
        $statement = $db->prepare("SELECT * FROM Users where Email like ?");
        $statement->bind_param("s", $_POST['email']);
        if($statement->execute())
        {
            $statement->store_result();
            if($statement->num_rows > 0)
            {
                $errors = true;
                $error_type['email'] = true;
            }
        }
        if(!$errors)
        {
            $statement = $db->prepare("INSERT INTO Users (Email, Password, GivenName, Surname, Address, Town, PostCode) values (?, ?, ?, ?, ?, ?, ?)");
            $statement->bind_param("sssssss", $_POST['email'], $_POST['password'], $_POST['first-name'], $_POST['surname'], $_POST['address'], $_POST['town'], $_POST['post-code']);
            if($statement->execute())
            {
                startSession();
            }
        }

    } 
    if (isset($_POST['funct'])) { // O usuário submeteu o FORM
        //header("Location: http://localhost/Database/home.html");

        $loginResult = false;

        if($_POST['funct'] === 'signin')
        {
            $loginResult = login();
        }
        else 
        {
            $loginResult = signup();

        }
 
        if (!$loginResult) {
                $error = 'Login failed. Please check your email and password.';
        }
    }
?>

<!doctype>
<html style="height: 100%">
	<head>
		<meta charset="utf-8" />
		<title>Media Tags</title>

		<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="css/login.css">
        <script type="text/javascript"></script>
	</head>
	<body class="background">
		<div class="container">
			<div class="texts">
				<h1 class="title">Media Tags</h1>
				<h3 class="description">Shopping media easily!</h3>
			</div>
			<div id="test" class="login-box">
				<ul class="nav nav-tabs">
				  <li id="signinTab" class="active"><a id="signinText" class="login-active-tab-text">Sign in</a></li>
				  <li id="signupTab"><a id="signupText">Sign up</a></li>
				</ul>
				<div id="jumbotron" class="jumbotron">
                    <?php include 'html/errorImage.html' ?>
				</div>
			</div>
		</div>
		<script type="text/javascript" src="js/jquery-1.11.0.js"></script>
		<script type="text/javascript" src="js/bootstrap.min.js"></script>
		<script type="text/javascript" src="js/changeContent.js"></script>
        <?php if(isset($_POST['funct']) && $_POST['funct'] === 'signup') : ?>

            <script type="text/javascript">
                $("#signinTab").removeClass("active");
                $("#signinText").removeClass("login-active-tab-text");
                $("#signupTab").addClass("active");
                $("#signupText").addClass("login-active-tab-text");
                $("#jumbotron").load("html/signupContainer.php");

                  /*
                    //var email_error = <?php echo $error_type['email'] ?>;
                    //if(!email_error)
                    //{
                        //$("#email-div").load("html/errorImage.html");
                    //}
                };*/
            </script>
            <!--
            <?php if($error_type['email'] === true && $error_type['password'] === true) : ?>
                <script type="text/javascript">
                    $("#jumbotron").load("html/signupContainer.php?email=true&password=true");
                </script>
            <?php elseif ($error_type['email'] === true) : ?>
                <script type="text/javascript">
                    $("#jumbotron").load("html/signupContainer.php?email=true&password=false");
                </script>
            <?php elseif ($error_type['password'] === true) : ?>
                <script type="text/javascript">
                    $("#jumbotron").load("html/signupContainer.php?email=false&password=true");
                </script>
            <?php endif ?> -->
        <?php else : ?>
            <script type="text/javascript">
                $("#jumbotron").load("html/signinContainer.php");
            </script>
        <?php endif; ?>
        <script>
            $(document).ready( function() {
                window.email.load("html/errorImage.html");
            });
        </script>	
    </body>
</html>
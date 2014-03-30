<?php
	session_id($_GET['session']);
	session_start();
?>
<!doctype>
<html>
	<body>
		<?php
			echo session_id();
			if(!isset($_SESSION['cart']))
			{
				$_SESSION['cart'] = array();
			}
			else
			{

			}
			if (isset($_GET['addCart'])) {

				array_splice($_SESSION['cart'], count($_SESSION['cart']), 0, $_GET['addCart']);
			}
			elseif(isset($_GET['removeCart']))
			{
				array_splice($_SESSION['cart'], array_search($_GET['removeCart'], $_SESSION['cart']), 1);
			}
		?>
	</body>
</html>
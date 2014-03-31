<?php
	function refValues($arr){
	    if (strnatcmp(phpversion(),'5.3') >= 0) //Reference is required for PHP 5.3+
	    {
	        $refs = array();
	        foreach($arr as $key => $value)
	        {
	            $refs[$key] = &$arr[$key];
	        }
	        return $refs;
	    }
	    return $arr;
	}
	if(!isset($_SESSION))
	{
		session_start();
	}
	global $count, $statement, $ID, $DVD_Title, $Price, $Genre, $Year;
	$count = count($_SESSION['cart']);
	echo $count;
	if($count > 0)
	{
	    $db = new mysqli('localhost', 'root', '', 'Databases');
	    $query = "SELECT ID, DVD_Title, Price, Genre, Year FROM Medias where ID = ?";
	    $parameters = array();
	    $parameters[0] = $_SESSION['cart'][0];

	    for ($i=1; $i < $count; $i++) { 
	    	$query = $query . " or ID = ?";
	    	$parameters[$i] = $_SESSION['cart'][$i];
	    }

	    $statement = $db->prepare($query);
	    $types = "";
        foreach($parameters as $value)
            $types .= "s";
        $parameters = array_merge(array($types),$parameters);

	    call_user_func_array(array($statement, 'bind_param'), refValues($parameters));

	    $statement->execute();
    	$statement->bind_result($ID, $DVD_Title, $Price, $Genre, $Year);
    	$statement->store_result();
	}
	else
	{
		echo '<script>setCartDatas(0, 0)</script>';
	}
?>

<!doctype>

<html style="height: 100%;">
	<head>
		<meta charset="utf-8" />
		<title>Media Tags</title>

		<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="css/default-theme.css">
	</head>
	<body style="height: 100%;">						<!-- navigation bar -->
		<div class="container">
			<div class="navbar navbar-inverse navbar-fixed-top default-background-color1" role="navigation">
				<div class="container">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle" data-toggle="colapse" data-target=".navbar-collapse"></button>
						<a class="navbar-brand default-text-color1" href="/Database/home.php?home=true">Media Tag</a>
					</div>
					<div class="navbar-collapse collapse">
						<div class="nav navbar-nav default-text-color1">
							<li>
								<a href="/Database/home.php?home=true">Home</a>
							</li>
							<!--<li>
								<a href="#shop">Shop</a>
							</li>-->
							<li class="active">
								<a>My Cart</a>
							</li>
							<li>
								<a href="/Database/sell.php">Sell</a>
							</li>
							<li>
								<a href="#about">About</a>
							</li>
						</div>
						<div class="nav navbar-nav default-text-color1 navbar-right">
							<li>
								<a href="/Database">Log Out</a>
							</li>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="container-fluid" style="height: 100%">
			<div class="row not-row">			<!--side bar!! -->
					<div class="col-sm-3 col-md-2 sidebar search-box">
						<ul class="nav nav-sidebar">
								<li><a id="numberItensText" style="margin-top: 200px;">Number of Itens: </a></li>
								<li><a id="totalText">Total: </a></li>
							  <button class="btn dropdown-toggle sr-only to-button cart-button" type="button" id="addCartButton">
							    Buy Now!
							  </button>
						</ul>
					</div>
			</div>			
			<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">	<!-- main body -->
				<div>
					<h2 class="sub-header share-index">
						Medias Selected
					</h2>
				</div>
			</div>

			<div class="table-responsive" style="float: right; margin-right: 400px;">				<!-- table of content -->
				<table class="table table-striped">
					<thead>
						<tr>
							<th>Delete</th>
							<th>Name</th>
							<th>Price</th>
							<th>Genre</th>
							<th>Year</th>
						</tr>
					</thead>
					<tbody>
						<?php
			            	for ($i = 0; $i < $count && ($statement->fetch()); $i ++)
							{
								echo

								"<tr>" .
								"<td><button type=\"button\" name=\"".$ID. "\" class=\"btn\" style=\"background-color: #428bca; margin-top: 3px;\"/></button>" .
								"<td>".$DVD_Title."</td>".
								"<td>£".$Price."</td>".
								"<td>".$Genre."</td>".
								"<td>".$Year."</td>".

								"</tr>";
							}
						?>


					</tbody>
				</table>
			</div>
		</div>


		<script type="text/javascript" src="js/jquery-1.11.0.js"></script>
		<script type="text/javascript" src="js/bootstrap.min.js"></script>
		<script type="text/javascript">
			function setCartDatas(countElements, totalValue)
			{
				$("#totalText").html($("#totalText").html() + totalValue);
				$("#numberItensText").html($("#numberItensText").html() + countElements);
			}
		</script>
	</body>
</html>
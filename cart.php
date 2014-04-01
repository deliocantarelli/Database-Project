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
	if(isset($_GET['finishPurchase']) && isset($_SESSION['cart']) && count($_SESSION['cart']) > 0)
	{
		$cartCount = count($_SESSION['cart']);

	    $db = new mysqli('localhost', 'root', '', 'Databases');
	    $query = "delete FROM Medias where ID = " . $_SESSION['cart'][0];

	    for ($i=1; $i < $cartCount; $i++) { 
	    	$query .= " or ID = " . $_SESSION['cart'][i];
	    }

		$_SESSION['cart'] = NULL;

		global $showAlert;

		$showAlert = true;

	}
	if(isset($_POST['eraseElement']))
	{
		if(in_array($_POST['eraseElement'], $_SESSION['cart']))
		{
			array_splice($_SESSION['cart'], array_search($_POST['eraseElement'], $_SESSION['cart']), 1);
		}

	}
	if(isset($_POST['eraseCart']) )
	{
		$_SESSION['cart'] = NULL;
	}

	global $count, $statement, $ID, $DVD_Title, $Price, $Genre, $Year, $sum, $givenName, $surname;
	$count = count($_SESSION['cart']);
	$sum = 0;
	if($count > 0)
	{
	    $db = new mysqli('localhost', 'root', '', 'Databases');
	    $query = "SELECT m.ID, m.DVD_Title, m.Price, m.Genre, m.Year, u.GivenName, u.Surname FROM Medias As m, Users As u where m.Owner = u.UserID and (m.ID = ? ";
	    $parameters = array();
	    $parameters[0] = $_SESSION['cart'][0];

	    for ($i=1; $i < $count; $i++) { 
	    	$query = $query . " or m.ID = ?";
	    	$parameters[$i] = $_SESSION['cart'][$i];
	    }
	    $query .= ")";


	    $statement = $db->prepare($query);
	    $types = "";
        foreach($parameters as $value)
            $types .= "s";
        $parameters = array_merge(array($types),$parameters);

	    call_user_func_array(array($statement, 'bind_param'), refValues($parameters));

	    $statement->execute();
    	$statement->bind_result($ID, $DVD_Title, $Price, $Genre, $Year, $givenName, $surname);
    	$statement->store_result();
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
	<body style="height: 100%;">					<!-- navigation bar -->
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
			<div class="row not-row-cart">			<!--side bar!! -->
					<div class="col-sm-3 col-md-2 sidebar search-box">
						<ul class="nav nav-sidebar">
								<li><a id="numberItensText" style="margin-top: 200px;">Number of Itens: </a></li>
								<li><a id="totalText">Total: £</a></li>
							  <button class="btn dropdown-toggle sr-only to-button cart-button" type="button" id="addCartButton" <?php if($count > 0){echo 'data-toggle="modal"';} ?> data-target="#buyModal">
							    Buy Now!
							  </button>
							 	<button class="btn dropdown-toggle sr-only erase-button" type="submit" id="eraseCart" style="margin-left: 40px" onclick="cleanCart()">
							    	Clean Cart
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

			<div class="table-responsive" style="float: left; margin-rleft: 20px;">				<!-- table of content -->
				<table class="table table-striped">
					<thead>
						<tr>
							<th>Remove</th>
							<th style="min-width: 420px;">Name</th>
							<th>Price</th>
							<th style="min-width: 100px;">Genre</th>
							<th>Year</th>
						</tr>
					</thead>
					<tbody>
						<?php
			            	for ($i = 0; $i < $count && ($statement->fetch()); $i ++)
							{
								$sum += $Price;
								echo

								"<tr>" .
								"<td><button type=\"button\" name=\"".$ID. "\" class=\"btn\" style=\"background-color: #428bca; margin-top: 3px;\" onclick=\"eraseElement(". $ID .")\" /></button></td>" .
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
		<div class="modal fade" id="buyModal" tabindex="-1" role="dialog" aria-hidden="true" aria-labelledby="buyLabelModal" >
			<div class="modal-dialog" style="width: 1000px; margin-right: auto; margin-left: auto">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="buyLabelModal">Itens</h4>
					</div>
					<div class="modal-body" style="overflow-y: auto; max-height: 500px; width: auto; ">


							<div class="table-responsive" style="float: right; position: relative; margin-right: 0px;">			<!-- table of content -->
								<table class="table table-striped">
									<thead>
										<tr>
											<th style="min-width: 200px;">Seller</th>
											<th style="min-width: 550px;">Name</th>
											<th>Price</th>
											<th style="min-width: 100px;">Genre</th>
											<th>Year</th>
										</tr>
									</thead>
									<tbody>
										<?php
											if($count > 0)
											{
												$statement->data_seek(0);
											}
							            	for ($i = 0; $i < $count && ($statement->fetch()); $i ++)
											{
												$sum += $Price;
												echo

												"<tr>" .
												"<td>".$givenName . " " . $surname . "</td>" .
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
					<div class="modal-footer">
				        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				        <button type="button" class="btn btn-primary" onclick="buyItens()">Confirm</button>
					</div>
				</div>
			</div>

		</div>
		<div>
			<form name="formEraseCart" id="eraseCart" method="post" action="">
				<input type="hidden" name="eraseCart" value="true" />
			</form>
		</div>
		<div>
			<form name="formEraseElement" id="formEraseElement" method="post" action="">
				<input type="hidden" name="eraseElement" id="eraseElement" value="" />
			</form>
		</div>
		<div>
			<form name="finishPurchase" id="finishPurchase" method="get" action="">
				<input type="hidden" name="finishPurchase" value="true" />
			</form>
		</div>


		<script type="text/javascript" src="js/jquery-1.11.0.js"></script>
		<script type="text/javascript" src="js/bootstrap.min.js"></script>
		<script type="text/javascript">
			function cleanCart()
			{
				document.formEraseCart.submit();
			}
			function eraseElement(id)
			{
				$("#eraseElement").val(id);
				document.formEraseElement.submit();
			}
			function buyItens()
			{
				document.finishPurchase.submit();
			}
			function showAlert()
			{
				$(document).ready(function() {});
			}
			<?php
				echo '
				function setCartDatas()
				{
					$("#totalText").html($("#totalText").html() + '  . $sum . ');
					$("#numberItensText").html($("#numberItensText").html() + ' . $count . ');
				}
				$(document).ready(function() {setCartDatas();';
				if(isset($showAlert))
				{
					echo " alert('Your purchase was succesful. Thank you for using Media Tag!');})";
				}
				else
				{
					echo '});';
				}
			?>

		
		</script>
	</body>
</html>
<?php 
//error_reporting(E_ALL);
//ini_set('display_errors', 1);

/* change log
 * Date		Change
 * 02/11/17	called amoount function in mailer to get mc_gross
 * 04/02/17 updated mc_gross_x as total amount for each cart level item
 */
 

include('SQLFunctions.php');
require('PaypalIPN.php');
include('mailer.php');
//use PaypalIPN;

$ipn = new PaypalIPN();

// Use the sandbox endpoint during testing.
//$ipn->useSandbox();

// verify IPN
$verified = $ipn->verifyIPN();

if ($verified) 
{

	/*
	 * Process IPN
	 * A list of variables is available here:
	 * https://developer.paypal.com/webapps/developer/docs/classic/ipn/integration-guide/IPNandPDTVariables/
	 */

	$link = f_sqlConnect();
	

	
	//We are going to divide the values from the form in an array that we will use later 
	// First do customer data
	// assign posted variables to local variables
	$customerdata['receiver_email'] = mysqli_real_escape_string($link, $_POST['receiver_email']);
	$customerdata['payer_email'] = mysqli_real_escape_string($link, $_POST['payer_email']);
	$customerdata['first_name'] = mysqli_real_escape_string($link, $_POST['first_name']);
	$customerdata['last_name'] = mysqli_real_escape_string($link, $_POST['last_name']);
	$customerdata['address_name'] = mysqli_real_escape_string($link, $_POST['address_name']);
	$customerdata['address_street'] = mysqli_real_escape_string($link, $_POST['address_street']);
	$customerdata['address_city'] = mysqli_real_escape_string($link, $_POST['address_city']);
	$customerdata['address_state']     		= $_POST['address_state'];
	$customerdata['address_zip']     		= $_POST['address_zip'];
	$customerdata['address_country']    	= $_POST['address_country'];
	$customerdata['address_country_code']   = $_POST['address_country_code'];

	$keys = implode(", ", (array_keys($customerdata)));
	$values = implode("', '", (array_values($customerdata)));

	/*check to see if the table exists*/
	$table = "customers";
	if (!f_tableExists($link, $table, DB_NAME) ) {
		die('<br>Destination Table Does Not Exist:'.$table);
	}

	//check if this customer exists
	$address_street = $customerdata['address_street'];
	$payer_email = $customerdata['payer_email'];

	$sql ="SELECT id, address_street FROM customers WHERE address_street = '$address_street' and payer_email = '$payer_email' LIMIT 1;";
	
	if ($result=mysqli_query($link,$sql))
	{
		// get the number of rows in result set
		$rowcount=mysqli_num_rows($result);
	  
		if ($rowcount > 0) 
		{
		//  customer exists
		}
		else 
		// no existing customer, insert new customer
		{
			$sql="INSERT INTO $table ($keys) VALUES ('$values')";
			// proceed with insert 		
			if (!mysqli_query($link,$sql)) 
				{
				echo $sql;
				die("SQL error: 1" . $link->connect_error);
				} 
		}	
	}	
	// get id of customer that matches order customer street address
	$sql ="SELECT id FROM customers WHERE address_street = '$address_street' and payer_email = '$payer_email';";
	// next put id into orders.customer_id column
	if ($result=mysqli_query($link,$sql))
	{
		//$result = mysqli_query($link, $sql) or die(mysqli_error($DBi));
		$row = mysqli_fetch_assoc($result);
		$id = $row['id'];
	}
	else
	{
		echo $sql;
		die("SQL error: 2" . $link->connect_error);
	}
  
	// outer loop is  cart items   
	$n = $_POST['num_cart_items'];
	
	for ($i = 1; $i <= $n; $i++) 
	{

		// inner loop is quantity on each cart item
		// cart item is the basis of the array suffix.
		$n2 = $_POST['quantity'.$i];
		for ($i2 = 1; $i2 <= $n2; $i2++) 
		{

			// 	then do order data
			// 	assign posted variables to local variables
			// do order level data first
			$ordersdata['customer_id'] = $id;
			// set time zone
			$timezone_identifier = "America/Chicago";
			date_default_timezone_set($timezone_identifier);
			//base order data
			$ordersdata['payment_date']         	= date("Y-m-d H:i:s");
			$ordersdata['txn_id']         	 		= $_POST['txn_id'];
			$ordersdata['payment_status']     		= $_POST['payment_status'];
			$ordersdata['mc_currency']		   		= $_POST['mc_currency'];
			$ordersdata['mc_shipping']     	  		= $_POST['mc_shipping'];
			$ordersdata['mc_fee'] 		      		= $_POST['mc_fee'];
			$ordersdata['ipn_track_id'] 	 		= $_POST['ipn_track_id'];
			$ordersdata['num_cart_items']			= $_POST['num_cart_items'];
			
			// cart level data
			
			//$ordersdata['mc_gross'] 				= amount($_POST['item_number'.$i]);
			$ordersdata['mc_gross'] 				= $_POST['mc_gross_'.$i] / $_POST['quantity'.$i];
			$ordersdata['item_name']      	   		= $_POST['item_name'.$i];
			$ordersdata['item_number']	        	= $_POST['item_number'.$i];
			$ordersdata['quantity']    	      		= $_POST['quantity'.$i];
  			$ordersdata['option_name1'] = mysqli_real_escape_string($link, $_POST['option_name1_'.$i]);
    		$ordersdata['option_name2'] = mysqli_real_escape_string($link, $_POST['option_name2_'.$i]);
    		$ordersdata['option_selection1'] = mysqli_real_escape_string($link, $_POST['option_selection1_'.$i]);
    		$ordersdata['option_selection2'] = mysqli_real_escape_string($link, $_POST['option_selection2_'.$i]);
						
			$keys = implode(", ", (array_keys($ordersdata)));
			$values = implode("', '", (array_values($ordersdata)));

			/*check to see if the table exists*/
			$table = "orders";
	
			if (!f_tableExists($link, $table, DB_NAME) ) 
			{
				die('<br>Destination Table Does Not Exist:'.$table);
			}
		
			/* We now assemble the SQL that will insert our values into the database.*/
			$sql="INSERT INTO $table ($keys) VALUES ('$values')"; 

			/*We attempt the SQL Insert, mysqli_query() actually tries to execute the sql against the database connection provided. */
				if (!mysqli_query($link,$sql)) 
				{
					$rejectredirecturl = "fail.html";
					if (!empty ($rejectredirecturl))
						{
					//header("Location: $rejectredirecturl?msg=1"); 
					}
			} 
			//$successredirecturl = "success.html";
			if (!empty ($successredirecturl)) 
			{
				//header("Location: $successredirecturl?msg=1");
			} 

		} /* end of inner for next */

	} /* end of outer for next */


	// 	/*Lastly - It’s always good practice to close the database connection*/
	mysqli_close ($link); 

}
else
{
 	echo "not verified.";
}

header("HTTP/1.1 200 OK"); 

if  ($ordersdata['payment_status'] == 'Completed') 
 {

	// call mail function
 	mailer();
}















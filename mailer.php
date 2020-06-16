 <?php

function mailer()
{
	// pick up to email from payer email
	$to = $_POST['payer_email'];
	//$to = 'wbraat1@gmail.com';
		
		// set email subject
	$subject = "Order for ".$_POST['item_name1'];
	$headers = 'From: John Braat and Company<order@dutchbirthplates.com>' ."\r\n" . "X-Mailer: php";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Bcc: wbraat@dutchbirthplates.com\r\n";
	
	// pick up customer data
	$customerdata['address_name']     		= $_POST['address_name'];
	$customerdata['address_street']     	= $_POST['address_street'];
	$customerdata['address_city']     		= $_POST['address_city'];
	$customerdata['address_state']     		= $_POST['address_state'];
	$customerdata['address_zip']     		= $_POST['address_zip'];
	$customerdata['address_country']    	= $_POST['address_country'];

	// 	pick up order data totals
	$ordersdata['mc_shipping']     	  		= $_POST['mc_shipping'];
	$ordersdata['mc_gross']     	  		= $_POST['mc_gross'];
		
	// pick up  each individual cart item
	$ordersdata['mc_gross_1']     	  		= $_POST['mc_gross_1'];
	$ordersdata['item_number1']          	= $_POST['item_number1'];
	$ordersdata['item_name1']          		= $_POST['item_name1'];
	$ordersdata['quantity1']          		= $_POST['quantity1'];
	$ordersdata['option_selection1_1'] 		= $_POST['option_selection1_1'];
	$ordersdata['option_selection2_1'] 		= $_POST['option_selection2_1'];

	//start position of first pipe of first variable in first item
	$start1_1 = strpos($ordersdata['option_selection1_1'],"|",0);
	//start position of 2nd pipe of first variable
	$start2_1 = strpos($ordersdata['option_selection1_1'], "|", $start1_1+1);
	//length of 3rd node of first variable
	$length3_1 = strlen($ordersdata['option_selection1_1']) - ($start1_1+1);

	//start position of first pipe of 2nd variable in first item
	$start12_1 = strpos($ordersdata['option_selection2_1'],"|",0);
	//start position of 2nd pipe of 2nd variable
	$start22_1 = strpos($ordersdata['option_selection2_1'], "|", $start12_1+1);

	//see if there is a 3rd pipe in the 2ND variable of first item
	$start32_1 = strpos($ordersdata['option_selection2_1'],"|", ($start22_1+1));
	if ($start32_1==FALSE)
	{
		//length of 3rd node of 2nd selection of first item
		$length32_1 = strlen($ordersdata['option_selection2_1']) - ($start22_1+1);
	}
	else
	{
		// length of 4th node of 2nd selection of first item
		$length42_1 = strlen($ordersdata['option_selection2_1']) - ($start32_1+1);
	}
	
	if (substr($ordersdata['item_number1'],0,1) == 'B') 
	{
		$childname1 = substr($ordersdata['option_selection1_1'],0, $start1_1);
		$birthplace1 = substr($ordersdata['option_selection1_1'],$start1_1+1, ($start2_1 - $start1_1) - 1);
		$birthdate1 = substr($ordersdata['option_selection1_1'], $start2_1+1, $length3_1);

		$birthtime1 = substr($ordersdata['option_selection2_1'],0, $start12_1);
		$birthweight1 = substr($ordersdata['option_selection2_1'],$start12_1+1, ($start22_1 - $start12_1) - 1);
	
		if ($start32_1==FALSE)
		{
			$birthheight1 = substr($ordersdata['option_selection2_1'], $start22_1+1, $length32_1);
		}
		else
		{
			$birthheight1 = substr($ordersdata['option_selection2_1'], $start22_1+1,($start32_1 - $start22_1) - 1);
			$extratext1 = substr($ordersdata['option_selection2_1'], $start32_1+1, $length42_1); 
		}			
	}
	// item #2
	if (isset($_POST['item_name2'])) 
	{
		$ordersdata['mc_gross_2']     	  		= $_POST['mc_gross_2'];
		$ordersdata['item_number2']          	= $_POST['item_number2'];
		$ordersdata['item_name2']          		= $_POST['item_name2'];
		$ordersdata['quantity2']          		= $_POST['quantity2'];
		$ordersdata['option_selection1_2'] 		= $_POST['option_selection1_2'];
		$ordersdata['option_selection2_2'] 		= $_POST['option_selection2_2'];

		//start position of first pipe of first variable in first item
		$start1_2 = strpos($ordersdata['option_selection1_2'],"|",0);
		//start position of 2nd pipe of first variable
		$start2_2 = strpos($ordersdata['option_selection1_2'], "|", $start1_2+1);
		//length of 3rd node of first variable
		$length3_2 = strlen($ordersdata['option_selection1_2']) - ($start1_2+1);

		//start position of first pipe of 2nd variable in first item
		$start12_2 = strpos($ordersdata['option_selection2_2'],"|",0);
		//start position of 2nd pipe of 2nd variable
		$start22_2 = strpos($ordersdata['option_selection2_2'], "|", $start12_2+1);

		//see if there is a 3rd pipe in the 2ND variable of first item
		$start32_2 = strpos($ordersdata['option_selection2_2'],"|", ($start22_2+1));
		if ($start32_2==FALSE)
		{
			//length of 3rd node of 2nd selection of first item
			$length32_2 = strlen($ordersdata['option_selection2_2']) - ($start22_2+1);
		}
		else
		{
			// length of 4th node of 2nd selection of first item
			$length42_2 = strlen($ordersdata['option_selection2_2']) - ($start32_2+1);
		}
		if (substr($ordersdata['item_number2'],0,1) == 'B') 
		{
			$childname2 = substr($ordersdata['option_selection1_2'],0, $start1_2);
			$birthplace2 = substr($ordersdata['option_selection1_2'],$start1_2+1, ($start2_2 - $start1_2) - 1);
			$birthdate2 = substr($ordersdata['option_selection1_2'], $start2_2+1, $length3_2);

			$birthtime2 = substr($ordersdata['option_selection2_2'],0, $start12_2);
			$birthweight2 = substr($ordersdata['option_selection2_2'],$start12_2+1, ($start22_2 - $start12_2) - 1);
	
			if ($start32_2==FALSE)
			{
				$birthheight2 = substr($ordersdata['option_selection2_2'], $start22_2+1, $length32_2);
			}
			else
			{
				$birthheight2 = substr($ordersdata['option_selection2_2'], $start22_2+1,($start32_2 - $start22_2) - 1);
				$extratext2 = substr($ordersdata['option_selection2_2'], $start32_2+1, $length42_2); 
	
			}
		}
	}				
	//start item 3
	if (isset($_POST['item_name3'])) 
	{
		$ordersdata['mc_gross_3']     	  		= $_POST['mc_gross_3'];
		$ordersdata['item_number3']          	= $_POST['item_number3'];
		$ordersdata['item_name3']          		= $_POST['item_name3'];
		$ordersdata['quantity3']          		= $_POST['quantity3'];
		$ordersdata['option_selection1_3'] 		= $_POST['option_selection1_3'];
		$ordersdata['option_selection2_3'] 		= $_POST['option_selection2_3'];

		//start position of first pipe of first variable in first item
		$start1_3 = strpos($ordersdata['option_selection1_3'],"|",0);
		//start position of 2nd pipe of first variable
		$start2_3 = strpos($ordersdata['option_selection1_3'], "|", $start1_3+1);
		//length of 3rd node of first variable
		$length3_3 = strlen($ordersdata['option_selection1_3']) - ($start1_3+1);

		//start position of first pipe of 2nd variable in first item
		$start12_3 = strpos($ordersdata['option_selection2_3'],"|",0);
		//start position of 2nd pipe of 2nd variable
		$start22_3 = strpos($ordersdata['option_selection2_3'], "|", $start12_3+1);

		//see if there is a 3rd pipe in the 2ND variable of first item
		$start32_3 = strpos($ordersdata['option_selection2_3'],"|", ($start22_3+1));

		if ($start32_3==FALSE)
		{
			//length of 3rd node of 2nd selection of first item
			$length32_3 = strlen($ordersdata['option_selection2_3']) - ($start22_3+1);
		}
		else
		{
			// length of 4th node of 2nd selection of first item
			$length42_3 = strlen($ordersdata['option_selection2_3']) - ($start32_3+1);
		}
		if (substr($ordersdata['item_number3'],0,1) == 'B') 
		{
			$childname3 = substr($ordersdata['option_selection1_3'],0, $start1_3);
			$birthplace3 = substr($ordersdata['option_selection1_3'],$start1_3+1, ($start2_3 - $start1_3) - 1);
			$birthdate3 = substr($ordersdata['option_selection1_3'], $start2_3+1, $length3_3);

			$birthtime3 = substr($ordersdata['option_selection2_3'],0, $start12_3);
			$birthweight3 = substr($ordersdata['option_selection2_3'],$start12_3+1, ($start22_3 - $start12_3) - 1);
	
			if ($start32_3==FALSE)
			{
				$birthheight3 = substr($ordersdata['option_selection2_3'], $start22_3+1, $length32_3);
			}
			else
			{
				$birthheight3 = substr($ordersdata['option_selection2_3'], $start22_3+1,($start32_3 - $start22_3) - 1);
				$extratext3 = substr($ordersdata['option_selection2_3'], $start32_3+1, $length42_3); 
	
			}
		}
	}
	// START OF item 4
	if (isset($_POST['item_name4'])) 
	{
		$ordersdata['mc_gross_4']     	  		= $_POST['mc_gross_4'];
		$ordersdata['item_number4']          	= $_POST['item_number4'];
		$ordersdata['item_name4']          		= $_POST['item_name4'];
		$ordersdata['quantity4']          		= $_POST['quantity4'];
		$ordersdata['option_selection1_4'] 		= $_POST['option_selection1_4'];
		$ordersdata['option_selection2_4'] 		= $_POST['option_selection2_4'];
	
		//start position of first pipe of first variable in first item
		$start1_4 = strpos($ordersdata['option_selection1_4'],"|",0);
		//start position of 2nd pipe of first variable
		$start2_4 = strpos($ordersdata['option_selection1_4'], "|", $start1_4+1);
		//length of 3rd node of first variable
		$length3_4 = strlen($ordersdata['option_selection1_4']) - ($start1_4+1);

		//start position of first pipe of 2nd variable in first item
		$start12_4 = strpos($ordersdata['option_selection2_4'],"|",0);
		//start position of 2nd pipe of 2nd variable
		$start22_4 = strpos($ordersdata['option_selection2_4'], "|", $start12_4+1);

		//see if there is a 3rd pipe in the 2ND variable of first item
		$start32_4 = strpos($ordersdata['option_selection2_4'],"|", ($start22_4+1));
		if ($start32_4==FALSE)
		{
			//length of 3rd node of 2nd selection of first item
			$length32_4 = strlen($ordersdata['option_selection2_4']) - ($start22_4+1);
		}
		else
		{
			// length of 4th node of 2nd selection of first item
			$length42_4 = strlen($ordersdata['option_selection2_4']) - ($start32_4+1);
		}
		if (substr($ordersdata['item_number4'],0,1) == 'B') 
		{
			$childname4 = substr($ordersdata['option_selection1_4'],0, $start1_4);
			$birthplace4 = substr($ordersdata['option_selection1_4'],$start1_4+1, ($start2_4 - $start1_4) - 1);
			$birthdate4 = substr($ordersdata['option_selection1_4'], $start2_4+1, $length3_4);

			$birthtime4 = substr($ordersdata['option_selection2_4'],0, $start12_4);
			$birthweight4 = substr($ordersdata['option_selection2_4'],$start12_4+1, ($start22_4 - $start12_4) - 1);
	
			if ($start32_4==FALSE)
			{
				$birthheight4 = substr($ordersdata['option_selection2_4'], $start22_4+1, $length32_4);
			}
			else
			{
				$birthheight4 = substr($ordersdata['option_selection2_4'], $start22_4+1,($start32_4 - $start22_4) - 1);
				$extratext4 = substr($ordersdata['option_selection2_4'], $start32_4+1, $length42_4); 
			}
		}
	}
	
	$msg = "Thank you for your order.  It will be processed immediately.\n
Please check the order details closely and email me if there are corrections needed.\n\n Best Regards, \n\n Will Braat \n John Braat and Company \n wwww.dutchbirthplates.com";	
	
	// item specific information
	// item 1 *********

	$msg = $msg."\n\nItem #1 Information";
	$msg = $msg."\nDescription: ".$ordersdata['item_name1'];
	
	if (substr($ordersdata['item_number1'],0,1) == 'B') 
		{
	
			$msg = $msg."\nChildname: ".$childname1;
			$msg = $msg."\nBirthPlace: ".$birthplace1;
			$msg = $msg."\nBirthDate: ".$birthdate1;
	
			$msg = $msg."\nBirthTime: ".$birthtime1;
			$msg = $msg."\nBirthWeight: ".$birthweight1;
			$msg = $msg."\nBirthHeight: ".$birthheight1;
	
			if ($start32_1<>FALSE)
			{
				$msg = $msg."\nExtraText: ".$extratext1;
			}	
		}	
		else
		{
			$msg = $msg."\nGroomBride: ".$ordersdata['option_selection1_1'];
			$msg = $msg."\nDatePlaceExtraText: ".$ordersdata['option_selection2_1'];
		}	
		$msg = $msg."\nQuantity: ".$ordersdata['quantity1'];
		
	//$amount1 = ($ordersdata['mc_gross_1'] - ($ordersdata['mc_shipping1'] * $ordersdata['quantity1']));
	//$amount1 = number_format($amount1,2);
		$amount1 = amount($ordersdata['item_number1']);
		$amount1 = $amount1 * $ordersdata['quantity1'];
		$amount1 = number_format($amount1,2);
		$msg = $msg."\nAmount: $".$amount1;
	
	//item 2 **********
	if (isset($_POST['item_name2'])) 
	{
		$msg = $msg."\n\nItem #2 Information";
		$msg = $msg."\nDescription: ".$ordersdata['item_name2'];
		
		if (substr($ordersdata['item_number2'],0,1) == 'B') 
		{
		
			$msg = $msg."\nChildname: ".$childname2;
			$msg = $msg."\nBirthPlace: ".$birthplace2;
			$msg = $msg."\nBirthDate: ".$birthdate2;
	
			$msg = $msg."\nBirthTime: ".$birthtime2;
			$msg = $msg."\nBirthWeight: ".$birthweight2;
			$msg = $msg."\nBirthHeight: ".$birthheight2;
	
			if ($start32_2<>FALSE)
			{
				$msg = $msg."\nExtraText: ".$extratext2;
			}			
		}
		else
		{
			$msg = $msg."\nGroomBride: ".$ordersdata['option_selection1_2'];
			$msg = $msg."\nDatePlaceExtraText: ".$ordersdata['option_selection2_2'];
		}

		$msg = $msg."\nQuantity: ".$ordersdata['quantity2'];
		$amount2 = amount($ordersdata['item_number2']);
		$amount2 = $amount2 * $ordersdata['quantity2'];
		$amount2 = number_format($amount2,2);
		$msg = $msg."\nAmount: $".$amount2;
	}
	//item 3 *************
	if (isset($_POST['item_name3'])) 
	{
		$msg = $msg."\n\nItem #3 Information";
		$msg = $msg."\nDescription: ".$ordersdata['item_name3'];
		if (substr($ordersdata['item_number3'],0,1) == 'B') 
		{
			$msg = $msg."\nChildname: ".$childname3;
			$msg = $msg."\nBirthPlace: ".$birthplace3;
			$msg = $msg."\nBirthDate: ".$birthdate3;
	
			$msg = $msg."\nBirthTime: ".$birthtime3;
			$msg = $msg."\nBirthWeight: ".$birthweight3;
			$msg = $msg."\nBirthHeight: ".$birthheight3;
	
			if ($start32_3<>FALSE)
			{
				$msg = $msg."\nExtraText: ".$extratext3;
			}	
		}
		else
		{
			$msg = $msg."\nGroomBride: ".$ordersdata['option_selection1_3'];
			$msg = $msg."\nDatePlaceExtraText: ".$ordersdata['option_selection2_3'];
		}				
		$msg = $msg."\nQuantity: ".$ordersdata['quantity3'];
		$amount3 = amount($ordersdata['item_number3']);
		$amount3 = $amount3 * $ordersdata['quantity3'];
		$amount3 = number_format($amount3,2);
		$msg = $msg."\nAmount: $".$amount3;
	}

	//item 4 *****************
	if (isset($_POST['item_name4'])) 
	{

		$msg = $msg."\n\nItem #4 Information";
		$msg = $msg."\nDescription: ".$ordersdata['item_name4'];
	
		if (substr($ordersdata['item_number4'],0,1) == 'B') 
		{	
			$msg = $msg."\nChildname: ".$childname4;
			$msg = $msg."\nBirthPlace: ".$birthplace4;
			$msg = $msg."\nBirthDate: ".$birthdate4;
	
			$msg = $msg."\nBirthTime: ".$birthtime4;
			$msg = $msg."\nBirthWeight: ".$birthweight4;
			$msg = $msg."\nBirthHeight: ".$birthheight4;
	
			if ($start32_4<>FALSE)
			{
				$msg = $msg."\nExtraText: ".$extratext4;
			}
		}
		else
		{
			$msg = $msg."\nGroomBride: ".$ordersdata['option_selection1_4'];
			$msg = $msg."\nDatePlaceExtraText: ".$ordersdata['option_selection2_4'];
		}
										
		$msg = $msg."\nQuantity: ".$ordersdata['quantity4'];
		$amount4 = amount($ordersdata['item_number4']);
		$amount4 = $amount4 * $ordersdata['quantity4'];
		$amount4 = number_format($amount4,2);
		$msg = $msg."\nAmount: $".$amount4;
	
	}
	// end of individual item processing.
	// order total information (sum of all items)  	
	$msg = $msg."\n\nOrder Shipping and Handling: $".$ordersdata['mc_shipping'];
	$msg = $msg."\nOrder Total: $".$ordersdata['mc_gross'];
	
	// Customer shipping Address 	
	$msg = $msg."\n\nShipping Address";
	$msg = $msg."\n".$customerdata['address_name'];
	$msg = $msg."\n".$customerdata['address_street'];
	$msg = $msg."\n".$customerdata['address_city'];
	$msg = $msg."\n".$customerdata['address_state'];
	$msg = $msg."\n".$customerdata['address_zip'];
	$msg = $msg."\n".$customerdata['address_country'];
		
	// send email
	mail($to,$subject,$msg,$headers);
//end function
}

function amount($itemnumber)
{
	switch ($itemnumber) 
	{
   	case "BP016":
   			$amount = "58.95";
       	  	break;
   	case "BP016ET1":
   			$amount = "68.95";
       	  	break;
   	case "BP016M":
   			$amount = "58.95";
       	  	break;
   	case "BP016ET1M":
   			$amount = "68.95";
       	  	break;
    	case "BP021":
        	$amount = "79.95";
         	break;
   	case "BP021ET":
   			$amount = "89.95";
       	  	break;
   	case "BP021ET1":
   			$amount = "89.95";
       	  	break;
   	case "BP021M":
   			$amount = "79.95";
       	  	break;
   	case "BP021ETM":
   			$amount = "89.95";
       	  	break;
   	case "BPP021":
   			$amount = "89.95";
       	  	break;
    	case "BPP021M":
   			$amount = "89.95";
       	  	break;
   	case "BPP021ET1":
   			$amount = "99.95";
       	  	break;
   	case "BPP021ET1M":
   			$amount = "99.95";
       	  	break;
   	case "BP027":
         	$amount = "129.95";
         	break;
   	case "BP027M":
         	$amount = "129.95";
         	break;
   	case "BP027ET1":
         	$amount = "139.95";
         	break;
   	case "BP027ET1M":
         	$amount = "139.95";
         	break;
   	case "WP027":
         	$amount = "129.95";
         	break;
   	case "AP027":
         	$amount = "129.95";
         	break;
   	case "WP027M":
         	$amount = "129.95";
         	break;
	case "AP027M":
         	$amount = "129.95";
         	break;
	case "WP027ET1":
         	$amount = "139.95";
         	break;
    	case "AP027ET1":
         	$amount = "139.95";
         	break;     	
	case "WP027ET1M":
         	$amount = "139.95";
         	break;
    	case "AP027ET1M":
         	$amount = "139.95";
         	break;     	
    	case "BT015":
         	$amount = "58.95";
         	break; 
    	case "BTP015":
         	$amount = "58.95";
         	break;     	     	
    	case "BT015M":
         	$amount = "58.95";
         	break; 
    	case "BTP015M":
         	$amount = "58.95";
         	break;     	     	
    	case "WT015":
    	     	$amount = "58.95";
         	break;     	     	     	     	    	     	
    	case "WT015M":
         	$amount = "58.95";
         	break;     	     	     	     	    	     	

	} /* end switch */
return $amount;
} /* end amounts function */

 	


	
	



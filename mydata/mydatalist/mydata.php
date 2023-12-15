<?php

// This code uses the Apache HTTP client from HTTP Components (http://hc.apache.org/httpcomponents-client-ga/)
require_once 'HTTP/Request2.php';

$mydata = '';
$request = new Http_Request2($aade_api);
$url = $request->getUrl();

$headers = array(
		// Request headers
		'aade-user-id' => AADE_USER,
		'Ocp-Apim-Subscription-Key' => AADE_KEY,
		);

$request->setHeader($headers);

$parameters = array(
		// Request parameters
		);

$url->setQueryVariables($parameters);

$request->setMethod(HTTP_Request2::METHOD_POST);


// Request body
$body='
<InvoicesDoc xmlns="http://www.aade.gr/myDATA/invoice/v1.0"
xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
xmlns:N1="https://www.aade.gr/myDATA/incomeClassificaton/v1.0"
xsi:schemaLocation="http://www.aade.gr/myDATA/invoice/v1.0 schema.xsd">

<invoice>
<issuer>
<vatNumber>'.preg_replace('/\D/', '', VAT_NUMBER).'</vatNumber>
<country>GR</country>
<branch>0</branch>
</issuer>
';

if ($mydata_type == 0 || $mydata_type == 1 || $mydata_type == 4){

	$body.='

		<counterpart>
		<vatNumber>'.$vat.'</vatNumber> 
		<country>'.$country.'</country>
		<branch>0</branch>
		'.$counterpart_name.'
		<address>
		<street>'.$street.'</street>
		<number></number>
		<postalCode>'.$po.'</postalCode>
		<city>'.$city.'</city>
		</address>
		</counterpart>
		';
}

$body.='
<invoiceHeader>
<series>'.$inv_series.'</series>
<aa>'.$inv_num.'</aa>
<issueDate>'.$date.'</issueDate>
<invoiceType>'.$invtype.'</invoiceType>
<currency>'.$currency.'</currency>
'.$exchangeRate.'
</invoiceHeader>
<paymentMethods>
<paymentMethodDetails>
<type>'.$payment_type.'</type>
<amount>'.$total.'</amount>
</paymentMethodDetails>
</paymentMethods>
';

?>


<?php

if (MYDATA_SUPPORT_MULTILINE == true){

	$popup_div = "<a class='popper' href=''>SUBLIST</a>
		<div id='pop'>
		<p><strong>SUBITEM LISTING</strong></p>
		<table id='subprod' style='width:100%'>
		<tr class='sb'><td class='sb'>#</td><td class='sb'>Description</td><td class='sb'>NET</td><td class='sb'>VAT%</td><td class='sb'>Total</td></tr>
		";
}

// Calculate Subproducts

$query_subprod = "select rang,description,round(".$dolibarr_main_db_prefix."facturedet.total_ht,2) as subprod_net,round(tva_tx) as subprod_tax_percent,round(".$dolibarr_main_db_prefix."facturedet.total_tva,2) as subprod_tax,round(".$dolibarr_main_db_prefix."facturedet.total_ttc,2) subprod_gross  from ".$dolibarr_main_db_prefix."facture left join ".$dolibarr_main_db_prefix."facturedet on ".$dolibarr_main_db_prefix."facturedet.fk_facture = ".$dolibarr_main_db_prefix."facture.rowid where ".$dolibarr_main_db_prefix."facture.rowid =  '".$rowid."' order by rang asc";


if (MYDATA_SUPPORT_MULTILINE == true){

	$result_subprod = mysqli_query($con, $query_subprod) or trigger_error("Query Failed! SQL: $query_subprod - Error: ".mysqli_error($con), E_USER_ERROR);

	while ($sub_row = $result_subprod->fetch_assoc())

	{

		$subprod_rang = preg_replace('/\D/', '', $sub_row["rang"]);
                $subprod_desc = substr(html($sub_row["description"]),0,254);
		$subprod_net = abs(number_format($sub_row["subprod_net"],2,'.',''));
		$subprod_tax_percent = $sub_row["subprod_tax_percent"];
		$subprod_tax = abs(number_format($sub_row["subprod_tax"],2,'.',''));
		$subprod_gross= abs(number_format($sub_row["subprod_gross"],2,'.',''));

		// Subproduct VAT Percentage categorization
		if ($subprod_tax_percent == 24) { $sub_vat_categ = 1; $vatExemptionCategory = "";}
		elseif ($subprod_tax_percent == 13) { $sub_vat_categ = 2; $vatExemptionCategory = "";}
		elseif ($subprod_tax_percent == 6) { $sub_vat_categ = 3; $vatExemptionCategory = "";}
		elseif ($subprod_tax_percent == 17) { $sub_vat_categ = 4; $vatExemptionCategory = "";}
		elseif ($subprod_tax_percent == 9) { $sub_vat_categ = 5; $vatExemptionCategory = "";}
		elseif ($subprod_tax_percent == 4) { $sub_vat_categ = 6; $vatExemptionCategory = "";}
		elseif  ($subprod_tax_percent == 0) { $sub_vat_categ = 7;}
		else {$sub_vat_categ = 7;}

		$popup_div.= "<tr class='sb'><td class='sb'>$subprod_rang</td><td class='sb'>$subprod_desc</td><td class='sb'>$subprod_net</td><td class='sb'>$subprod_tax_percent</td><td class='sb'>$subprod_gross</td></tr>";

		// Ignore subline that has a zero value - AADE does not like zero valued lines -> https://mydata-dev.portal.azure-api.net/issues/5ef0b812c757301110596fb1
		if ($subprod_net != 0 ) {
			$body.='

				<invoiceDetails>
				<lineNumber>'.$subprod_rang.'</lineNumber>
				<netValue>'.$subprod_net.'</netValue>
				<vatCategory>'.$sub_vat_categ.'</vatCategory>

				<vatAmount>'.$subprod_tax.'</vatAmount>
				'.$vatExemptionCategory.'
                <lineComments>'.$subprod_desc.'</lineComments>

				<incomeClassification>
				<N1:classificationType>'.$classificationType.'</N1:classificationType>
				<N1:classificationCategory>'.$classificationCategory.'</N1:classificationCategory>
				<N1:amount>'.$subprod_net.'</N1:amount>
				</incomeClassification>
				</invoiceDetails>
				';
		}
	}

	$vat_percent = $popup_div;
	$vat_percent.= "</table></div>";
} else

{
	$body.='
		<invoiceDetails>
		<lineNumber>1</lineNumber>
		<netValue>'.$net.'</netValue>
		<vatCategory>'.$vat_categ.'</vatCategory>
		<vatAmount>'.$tax.'</vatAmount>

		'.$vatExemptionCategory;
	
    $body.='       
		<incomeClassification>
		<N1:classificationType>'.$classificationType.'</N1:classificationType>
		<N1:classificationCategory>'.$classificationCategory.'</N1:classificationCategory>
		<N1:amount>'.$net.'</N1:amount>
		</incomeClassification>
		</invoiceDetails>
		';

	//Add tax withheld data to invoice xml for invoices that has total vat and taxes. Setting multiple vat is off
	if ($taxwh != 0 ) {
		$body.=' 	
			<taxesTotals>
			<taxes>
			<taxType>1</taxType>
			<taxCategory>'.$taxwh_cat.'</taxCategory>
			<underlyingValue>'.$net.'</underlyingValue>
			<taxAmount>'.$taxwh.'</taxAmount>
			</taxes>
			</taxesTotals>
			';
	}
}

$body.='
<invoiceSummary>
<totalNetValue>'.$net.'</totalNetValue>
<totalVatAmount>'.$tax.'</totalVatAmount>
<totalWithheldAmount>'.$taxwh.'</totalWithheldAmount>
<totalFeesAmount>0.00</totalFeesAmount>
<totalStampDutyAmount>0.00</totalStampDutyAmount>
<totalOtherTaxesAmount>0.00</totalOtherTaxesAmount>
<totalDeductionsAmount>0.00</totalDeductionsAmount>
<totalGrossValue>'.$total.' </totalGrossValue>
<incomeClassification>	
<N1:classificationType>'.$classificationType.'</N1:classificationType>
<N1:classificationCategory>'.$classificationCategory.'</N1:classificationCategory>
<N1:amount>'.$net.'</N1:amount>
</incomeClassification>
</invoiceSummary>
</invoice>
</InvoicesDoc>';


// Request body
$request->setBody($body);
//$request->setBody(var_dump($body));
try
{
	//echo $body;
	$response = $request->send();
	//echo $response->getBody();
	//$mydata = $response->getBody();

	$xmlstr = $response->getBody();
	$xmlreply = new SimpleXMLElement($xmlstr);
	$datetime = date("y/m/d H:i"); 

	if (200 == $response->getStatus()) {

		if ($xmlreply->response[0]->statusCode == "Success") 
		{
			$mydata = $datetime ." [". $xmlreply->response[0]->invoiceMark ."]" ;
			$mydata_check = 1;
			$update_query = "UPDATE ".$dolibarr_main_db_prefix."facture left join ".$dolibarr_main_db_prefix."facture_extrafields on ".$dolibarr_main_db_prefix."facture_extrafields.fk_object = ".$dolibarr_main_db_prefix."facture.rowid set mydata_reply ='$mydata', mydata_check='1' where ".$dolibarr_main_db_prefix."facture.rowid=" . $rowid;
			$update_result = mysqli_query($con, $update_query);

		}
		else{
			$mydata = $datetime ." " . $xmlreply->response[0]->statusCode ." ". $xmlreply->response[0]->errors[0]->error[0]->message;
			//$mydata = $response->getBody();
			$mydata_check =0;
			$update_query = "UPDATE ".$dolibarr_main_db_prefix."facture left join ".$dolibarr_main_db_prefix."facture_extrafields on ".$dolibarr_main_db_prefix."facture_extrafields.fk_object = ".$dolibarr_main_db_prefix."facture.rowid set mydata_reply ='$mydata' where ".$dolibarr_main_db_prefix."facture.rowid=" . $rowid;
			$update_result = mysqli_query($con, $update_query);
		}

	} else
	{
		echo 'Unexpected HTTP status: ' . $response->getStatus() . ' ' .
			$response->getReasonPhrase();
	}
}
catch (HttpException $ex)
{
	echo $ex;
}

?>



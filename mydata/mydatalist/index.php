<?php

/*
   This program is free software: you can redistribute it and/or modify
   it under the terms of the GNU General Public License as published by
   the Free Software Foundation, either version 3 of the License, or
   (at your option) any later version.

   This program is distributed in the hope that it will be useful,
   but WITHOUT ANY WARRANTY; without even the implied warranty of
   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
   GNU General Public License for more details.

   You should have received a copy of the GNU General Public License
   along with this program.  If not, see <https://www.gnu.org/licenses/>

 */

define('CHARSET', 'ISO-8859-1');
define('REPLACE_FLAGS', ENT_COMPAT | ENT_XHTML);

date_default_timezone_set("Europe/Athens");

set_include_path(DOL_DOCUMENT_ROOT."/custom/mydata/pear_modules/:usr/share/php/:/usr/share/pear/:/usr/lib/pear");

require_once(__DIR__ . '/config.php');
require_once DOL_DOCUMENT_ROOT.'/conf/conf.php';

if (MYDATA_DEV == 1) {
	$aade_api = "https://mydata-dev.azure-api.net/SendInvoices";
} else $aade_api = "https://mydatapi.aade.gr/myDATA/SendInvoices";


function html($string) {
	return htmlspecialchars($string, REPLACE_FLAGS, CHARSET);
}


/*
   function write_log($log_msg)
   {
   $log_filename = "logs";
   if (!file_exists($log_filename))
   {
   mkdir($log_filename, 0777, true);
   }
   $log_file_data = $log_filename.'/debug.log';
   file_put_contents($log_file_data, $log_msg . "\n", FILE_APPEND);

   }
 */

$con = mysqli_connect($dolibarr_main_db_host,$dolibarr_main_db_user,$dolibarr_main_db_pass,$dolibarr_main_db_name);
$con->set_charset("utf8mb4");

$from_date = MYDATA_FROM_DATE ;

$query_open_inv = "select COALESCE(".$dolibarr_main_db_prefix."c_paiement.code,5) as payment_type,COALESCE(mydata_type,0) as mydata_type,round((multicurrency_total_tva * 100) / multicurrency_total_ht,0) as vat_percent,".$dolibarr_main_db_prefix."facture.rowid,ref,mydata_reply,mydata_check,datef,nom,".$dolibarr_main_db_prefix."c_country.code,address,town,zip,tva_intra,total_ttc,".$dolibarr_main_db_prefix."facture.multicurrency_code,multicurrency_tx,multicurrency_total_ht,multicurrency_total_ttc,multicurrency_total_tva from ".$dolibarr_main_db_prefix."facture left join ".$dolibarr_main_db_prefix."societe on ".$dolibarr_main_db_prefix."societe.rowid = ".$dolibarr_main_db_prefix."facture.fk_soc left join ".$dolibarr_main_db_prefix."c_country on ".$dolibarr_main_db_prefix."c_country.rowid = ".$dolibarr_main_db_prefix."societe.fk_pays left join ".$dolibarr_main_db_prefix."facture_extrafields on ".$dolibarr_main_db_prefix."facture_extrafields.fk_object = ".$dolibarr_main_db_prefix."facture.rowid LEFT JOIN llx_c_paiement on ".$dolibarr_main_db_prefix."c_paiement.id = ".$dolibarr_main_db_prefix."facture.fk_mode_reglement where fk_statut in (1,2,3,4,5) AND COALESCE(mydata_check,0) = 0 ORDER BY ref DESC";

$query_from_date = "select COALESCE(".$dolibarr_main_db_prefix."c_paiement.code,5) as payment_type,COALESCE(mydata_type,0) as mydata_type,round((multicurrency_total_tva * 100) / multicurrency_total_ht,0) as vat_percent,".$dolibarr_main_db_prefix."facture.rowid,ref,mydata_reply,mydata_check,datef,nom,".$dolibarr_main_db_prefix."c_country.code,address,town,zip,tva_intra,total_ttc,".$dolibarr_main_db_prefix."facture.multicurrency_code,multicurrency_tx,multicurrency_total_ht,multicurrency_total_ttc,multicurrency_total_tva from ".$dolibarr_main_db_prefix."facture left join ".$dolibarr_main_db_prefix."societe on ".$dolibarr_main_db_prefix."societe.rowid = ".$dolibarr_main_db_prefix."facture.fk_soc left join ".$dolibarr_main_db_prefix."c_country on ".$dolibarr_main_db_prefix."c_country.rowid = ".$dolibarr_main_db_prefix."societe.fk_pays left join ".$dolibarr_main_db_prefix."facture_extrafields on ".$dolibarr_main_db_prefix."facture_extrafields.fk_object = ".$dolibarr_main_db_prefix."facture.rowid LEFT JOIN llx_c_paiement on ".$dolibarr_main_db_prefix."c_paiement.id = ".$dolibarr_main_db_prefix."facture.fk_mode_reglement where fk_statut in (1,2,3,4,5) AND DATE(datef) >= '".$from_date."' AND COALESCE(mydata_check,0) = 0 ORDER BY ref DESC";

//echo $query_open_inv;

if (MYDATA_SEARCH_BY == 1){
	$query = $query_from_date;
} 
else 
{
	$query = $query_open_inv;
}

//echo $query;

$result = mysqli_query($con, $query) or trigger_error("Query Failed! SQL: $sql - Error: ".mysqli_error($con), E_USER_ERROR);

// Test if there was a query error
if ($result->connect_errno) {
	printf("connection failed: %s\n", $con->connect_error());
	exit();
}


$option = '';
$a = 0;


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>MyDATA</title>
<link rel="stylesheet" type="text/css" href="mydatalist/DataTables/css/jquery.dataTables.min.css" />
<link rel="stylesheet" type="text/css" href="mydatalist/DataTables/datatables.css">
<link rel="stylesheet" type="text/css" href="mydatalist/DataTables/css/jquery.dataTables.css">
<link href="mydatalist/css/style.css" rel="stylesheet" />
<script type="text/javascript" language="javascript" src="mydatalist/DataTables/jquery-3.5.1.js"></script>
<script type="text/javascript" charset="utf8" src="mydatalist/DataTables/datatables.js"></script>
<script>

$(document).ready( function () {
		$('#mydata').DataTable({"pageLength":25});
		} );
</script>

</head>

<body>

<div id="loader"></div>

<?php

if(!empty($_GET))
{
	echo "<h2>MyDATA Invoices -> Sent</h2>";
} else echo "<h2>MyDATA Invoices</h2>";
?>

<table id="mydata" class="display" style="width:100%">
<thead>
<tr>
<th>Σειρά-Αριθμός</th> 
<th>Τύπος Παραστατικού</th>
<th>Ημερομηνία</th>
<th>Πελάτης</th>
<th>Χώρα</th>
<th>ΑΦΜ</th>
<th>MyData Απάντηση</th>
<th>MyData Απεσταλμένο</th>
<th>Καθαρή Αξία</th>
<th>Φόρος</th>
<th>ΦΠΑ %</th>
<th>Σύνολο</th>
<th>Ισοτιμία Συναλλάγματος</th>
<th>Συνολο σε συνάλλαγμα</th>
</tr>
</thead>
<tbody>

<?php


while ($row = $result->fetch_assoc()) 

{

	// var_dump($row);
	// $option .= '<option value = "'.$row[0].'">'.$row[1].'  --->  '.$row[2].'</option>';

	$rowid = $row["rowid"];
	$num = $row["ref"];
	$date = $row["datef"];
	// $num_prt = explode("-", $num);
	$dealer = html($row["nom"]); //remove special characters
	$country = $row["code"];
	$street = html($row["address"]);
	$city = $row["town"];
	$po = $row["zip"];
	$vat_percent = $row["vat_percent"];
	$vat = preg_replace('/\D/', '', $row["tva_intra"]);
	$mydata = $row["mydata_reply"];
	$mydata_check = $row["mydata_check"];
	$net = abs(number_format($row["multicurrency_total_ht"],2,'.',''));
	$total = abs(number_format($row["total_ttc"],2,'.',''));
	$currency = $row["multicurrency_code"];
	$forex = abs(number_format($row["multicurrency_tx"],2,'.',''));
	$forex_total = abs(number_format($row["multicurrency_total_ttc"],2,'.',''));
	$tax = abs(number_format($row["multicurrency_total_tva"],2,'.','')); //Fixed after dkalivis reported bug
	$payment_type =  $row["payment_type"];

	$mydata_type =  $row["mydata_type"];

	$eu_countries = array("AT","BE","BG","CY","CZ","DE","DK","EE","ES","FI","FR","HU","HR","IE","IT","LT","LU","LV","MT","NL","PL","PT","RO","SE","SI","SK");
	$local_country = array("GR");

	//Set GR if no country defined
	if ($country == '' && MYDATA_COUNTRY_DEFAULT == '1'){
		$country = "GR";

	}

	//Set ClassificationType

	//Timologio Paroxis Ipiresion
	if ($mydata_type == 1){

		if (in_array($country, $local_country, TRUE )){

			$invtype = "2.1"; //Timolog Ypiresias GR
			$classificationCategory = "category1_3";
			$classificationType = CLASSIFICATION_TYPE_GR;
			$vatExemptionCategory = "";
			$counterpart_name = "";
			$exchangeRate="";
		}
		else if (in_array($country, $eu_countries, TRUE )){
			$invtype = "2.2"; //Timolog Ypiresias EU
			$classificationCategory = "category1_3";
			$classificationType = CLASSIFICATION_TYPE_EU;
			$vatExemptionCategory = "<vatExemptionCategory>".VAT_EXEMP_CATEG_EU."</vatExemptionCategory>";
			$counterpart_name = "<name>".$dealer."</name>";
			$exchangeRate="";
		}
		else {
			$invtype = "2.3"; //Timolog Ypiresias 3RD
			$classificationCategory = "category1_3";
			$classificationType = CLASSIFICATION_TYPE_3RD;
			$vatExemptionCategory = "<vatExemptionCategory>".VAT_EXEMP_CATEG_3RD."</vatExemptionCategory>";
			$counterpart_name = "<name>".$dealer."</name>";
			$exchangeRate= "<exchangeRate>".$forex."</exchangeRate>";
		}

	}
	//Apodeiksi Lianikis Proionton (GR +EU)
	elseif ($mydata_type == 2){
		$invtype = "11.1"; //ALP
		$classificationCategory = "category1_2";
		$classificationType = "E3_561_003";
		$vatExemptionCategory = "";
		$counterpart_name = "";
		$exchangeRate="";
	}
	//Apodeiksi Lianikis Ypiresion (GR+EU)
	elseif ($mydata_type == 3){
		$invtype = "11.2"; //ALY
		$classificationCategory = "category1_3";
		$classificationType = "E3_561_003";
		$vatExemptionCategory = "";
		$counterpart_name = "";
		$exchangeRate="";
	}

	//PISTOTIKO TIMOLOGIO ( Πώληση Εμπορευμάτων)
	elseif ($mydata_type == 4){

		if (in_array($country, $local_country, TRUE )){

			$invtype = "5.2";  //Pistotiko Timologio GR
			$classificationCategory = "category1_1";
			$classificationType = CLASSIFICATION_TYPE_GR;
			$vatExemptionCategory = "";
			$counterpart_name = "";
			$exchangeRate="";
		}
		else if (in_array($country, $eu_countries, TRUE )){
			$invtype = "5.2"; // Pistotiko Timolog Ypiresias EU
			$classificationCategory = "category1_1";
			$classificationType = CLASSIFICATION_TYPE_EU;
			$vatExemptionCategory = "<vatExemptionCategory>".VAT_EXEMP_CATEG_EU."</vatExemptionCategory>";
			$counterpart_name = "<name>".$dealer."</name>";
			$exchangeRate="";
		}
		else {
			$invtype = "5.2"; // Pistotiko Timolog Ypiresias 3RD
			$classificationCategory = "category1_1";
			$classificationType = CLASSIFICATION_TYPE_3RD;
			$vatExemptionCategory = "<vatExemptionCategory>".VAT_EXEMP_CATEG_3RD."</vatExemptionCategory>";
			$counterpart_name = "<name>".$dealer."</name>";
			$exchangeRate= "<exchangeRate>".$forex."</exchangeRate>";
		}

	}

	elseif ($mydata_type == 5){ //Pistoriko Lianikis

		if (in_array($country, $local_country, TRUE )){

			$invtype = "11.4";  //Pistotiko Timologio GR
			$classificationCategory = "category1_2";
			$classificationType = "E3_561_003";
			$vatExemptionCategory = "";
			$counterpart_name = "";
			$exchangeRate="";
		}
	}

	else { //0
		//Timologio Polisis
		if (in_array($country, $local_country, TRUE )){
			$invtype = "1.1"; //Timolog Polisis GR
			$classificationType = CLASSIFICATION_TYPE_GR;
			$classificationCategory = "category1_1";
			$vatExemptionCategory = "";
			$counterpart_name = "";
			$exchangeRate="";
		}
		else if (in_array($country, $eu_countries, TRUE )){
			$invtype = "1.2"; //Timolog Polisis EU
			$classificationType = CLASSIFICATION_TYPE_EU;
			$classificationCategory = "category1_1";
			$vatExemptionCategory = "<vatExemptionCategory>".VAT_EXEMP_CATEG_EU."</vatExemptionCategory>";
			$counterpart_name = "<name>".$dealer."</name>";
			$exchangeRate="";
		}
		else {
			$invtype = "1.3"; //Timolog Polisis 3RD
			$classificationType = CLASSIFICATION_TYPE_3RD;
			$classificationCategory = "category1_1";
			$vatExemptionCategory = "<vatExemptionCategory>".VAT_EXEMP_CATEG_3RD."</vatExemptionCategory>";
			$counterpart_name = "<name>".$dealer."</name>";
			$exchangeRate= "<exchangeRate>".$forex."</exchangeRate>";
		}

	}

	/*
	   echo $classificationType;
	   echo "-";
	   echo $invtype;
	   echo "-";
	   echo $counterpart_name;
	   echo "-";
	   echo $mydata_type;
	 */

	// VAT Percentage
	if ($vat_percent == 24) { $vat_categ = 1;}
	else if ($vat_percent == 13) { $vat_categ = 2;}
	else if ($vat_percent == 6) { $vat_categ = 3;}
	else if ($vat_percent == 17) { $vat_categ = 4;}
	else if ($vat_percent == 9) { $vat_categ = 5;}
	else if ($vat_percent == 4) { $vat_categ = 6;}
	else if  ($vat_percent == 0) { $vat_categ = 7;}
	else {$vat_categ = 1;}


	// Construct Invoice name
	if (INVOICE_NAME == 1)

	{
		$num_prt = explode("-", $num);
		$inv_series = $num_prt[1] ;
		$inv_num = $num_prt[2]; 
	}

	else 

	{

		$num_prt = explode("-", $num);
		$inv_series = $num_prt[0] ;
		$inv_num = $num_prt[1];

	}

	//Do not use serial for apodeikseis
	if (INVOICE_APODIXI_NUM == 1) {

		if ($mydata_type == "2" || $mydata_type == "3")
		{
			$inv_series = "0";
			$inv_num = $num_prt[0] ;		
		}
	}	


	switch ($mydata_type) {
		case 0:
			$mydata_type_str = "Τιμολόγιο Πώλησης";
			break;
		case 1:
			$mydata_type_str = "Τιμολόγιο Παροχής Υπηρεσιών";
			break;
		case 2:
			$mydata_type_str = "Απόδειξη Λιανικής";
			break;
		case 3:
			$mydata_type_str = "Απόδειξη Παροχής Υπηρεσιών";
			break;
		case 4:
			$mydata_type_str = "Πιστωτικό Τιμολόγιο";
			break;
		case 5:
			$mydata_type_str = "Πιστωτικό Λιανικής";
			break;
	}


	//Run mydata post
	//print_r($_GET);
	if (in_array("send", $_GET, true)) {
		include 'mydata.php';
	}


	/*
	   if(!empty($_GET))
	   {
	   }
	 */

	echo "<tr>";

	echo "<td>";
	echo $inv_series ."-" . $inv_num;
	echo "</td>";

	echo "<td>";
	echo $mydata_type_str;
	echo "</td>";

	echo "<td>";
	echo $date;
	echo "</td>";

	echo "<td>";
	echo $dealer;
	echo "</td>";

	echo "<td>";
	echo $country;
	echo "</td>";

	echo "<td>";
	echo $vat;
	echo "</td>";

	echo "<td>";
	echo $mydata;
	echo "</td>";

	echo "<td>";
	if ($mydata_check == 1) echo "<center><img src='mydatalist/img/pass.png' alt='SUCCESS'></center>";
	else echo "<center><img src='mydatalist/img/fail.png' alt='FAILED'></center>";
	echo "</td>";

	echo "<td>";
	echo  number_format($net, 2, ',', '.');
	echo "</td>";

	echo "<td>";
	echo number_format($tax, 2, ',', '.');
	echo "</td>";

	echo "<td>";
	echo $vat_percent;
	echo "</td>";

	echo "<td>";
	echo "EUR ". number_format($total, 2, ',', '.');
	echo "</td>";

	echo "<td>";
	echo $forex;
	echo "</td>";

	echo "<td>";
	echo $currency ." ".number_format($forex_total, 2, ',', '.');
	echo "</td>";

	echo "</tr>";

}
?>
</tbody>


</table>
<button onClick="window.location.href='mydataindex.php'">Ανανέωση Λίστας</button>
<br>
<br>
<form class="form horizontal">
<button class="btn btn-primary" type="submit" onClick="window.location.href='mydataindex.php?mydata=send'">Αποστολή στο MyDATA</button>
</form>
<br>
<?php

mysqli_close($con);
?>

<script>
var spinner = $('#loader');
$(function() {
		$('form').submit(function(e) {
				e.preventDefault();
				spinner.show();
				$.ajax({
data: $(this).serialize(),
method: 'post',
dataType: 'JSON'
}).done(function(resp) {
	spinner.hide();
	alert(resp.status);
	});
				});
		});

$(function() {

		$('.popper').hover(function(e) {
				//Code to show the popup
				// Modify to use any standard popup library
				// The code below , for now display the desc only.
				$(this).next().show();

				}, function() {
				$(this).next().hide();
				});

		});
</script>

<?php
$response = new stdClass;
$response->status = "success";
?>

</body>
</html>

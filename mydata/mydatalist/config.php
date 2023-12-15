<?php

define("AADE_USER", $conf->global->MYDATA_AADE_USER); // your aade_user
define("AADE_KEY",  $conf->global->MYDATA_AADE_KEY); // your aade key

define("VAT_NUMBER", $conf->global->MYDATA_AFM); // Your company's VAT number (only number, without EL in front)


/* Select the syntax / name of your invoice - ONLY ONE SELECTION */
define("INVOICE_NAME",$conf->global->MYDATA_INVOICE_NAME );    	// SERIES-YEAR-NUMBER E.g INV-2021-123
//define("INVOICE_NAME","2");  	// SERIES-NUMBER E.g FA231-123

/* Search Criteria - ONLY ONE SELECTION!*/

define ("MYDATA_SEARCH_BY", $conf->global->MYDATA_SEARCH_BYDATE);	
define ("MYDATA_FROM_DATE", $conf->global->MYDATA_FROM_DATE);

//Invoice Types
//8.8 Κωδικός Κατηγορίας Χαρακτηρισμού Εσόδων
//8.1 Είδη παραστατικών – Σελ42
define("INV_TYPE_GR", $conf->global->MYDATA_INV_TYPE_GR);  // Invoice Type GR
define("INV_TYPE_EU", $conf->global->MYDATA_INV_TYPE_EU);  // Invoice Type EU
define("INV_TYPE_3RD", $conf->global->MYDATA_INV_TYPE_3RD); // Invoice Type 3RD COUNTRIES

//8.3 Κατηγορία Αιτίας Εξαίρεσης ΦΠΑ
define("VAT_EXEMP_CATEG_GR",  $conf->global->MYDATA_VAT_EXEMP_CATEG_GR);  // Invoice Type GR 
define("VAT_EXEMP_CATEG_EU",  $conf->global->MYDATA_VAT_EXEMP_CATEG_EU);  // Invoice Type EU Countries (excluding Greece)
define("VAT_EXEMP_CATEG_3RD", $conf->global->MYDATA_VAT_EXEMP_CATEG_3RD); // Invoice Type 3rd Countries

//8.8 Κωδικός Κατηγορίας Χαρακτηρισμού Εσόδων - Σελ48
//define("CLASSIFICATION_CATEGORY", $conf->global->MYDATA_CLASSIFICATION_CATEGORY); // Classification Category
//8.9 Κωδικός Τύπου Χαρακτηρισμού Εσόδων - Σελ50
define("CLASSIFICATION_TYPE_GR", $conf->global->MYDATA_CLASSIFICATION_TYPE_GR); // Classification Type Category for GR
define("CLASSIFICATION_TYPE_EU", $conf->global->MYDATA_CLASSIFICATION_TYPE_EU); // Classification Type Category for EU
define("CLASSIFICATION_TYPE_3RD", $conf->global->MYDATA_CLASSIFICATION_TYPE_3RD); // Classification Type Category for 3rd Countries

//8.12 Τρόποι Πληρωμής
//define("PAYMENT_METHOD", $conf->global->MYDATA_PAYMENT_METHOD);  // Payment method

// Production or Development API
define("MYDATA_DEV", $conf->global->MYDATA_DEV);  // Payment method

define("MYDATA_COUNTRY_DEFAULT", $conf->global->MYDATA_COUNTRY_DEFAULT);  // Default Country
define("MYDATA_SUPPORT_MULTILINE", $conf->global->MYDATA_SUPPORT_MULTILINE);  // Support Multiline Invoice

//Tax withheld enable or disable
define("MYDATA_TAXWH", $conf->global->MYDATA_TAXWH);

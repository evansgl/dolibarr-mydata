# DOLIBARR ERP & CRM MODULE FOR GREEK AADE MYDATA 

This Dolibarr module pushes invoices to AADE MyDATA

Check also that the /custom directory is active by adding into dolibarr `conf/conf.php` file the following
two lines, so dolibarr will also scan /custom directory to find external external modules:

```php
$dolibarr_main_url_root_alt='/custom';
$dolibarr_main_document_root_alt='/path_to_dolibarr/htdocs/custom/';
```

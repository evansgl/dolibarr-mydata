# CHANGELOG MYDATA FOR [DOLIBARR ERP CRM](https://www.dolibarr.org)

# 1.5
Bug: Fixes a bug in invoice numbering
<br>
Bug: Remove html parse on description. Trunkate to 250 chars
<br>
Bug: Fix multicurrency_total_tva reported by dkalivis
<br>
Bug: Fix CLASSIFICATION_CATEGORY. Old variable from old version
<br>
Feature: Ignore zero valued lines in invoices
<br>

## 1.4 
Feature: Use dolibarr sql prefix for any sql query.
<br>
Feature: Keep only numeric characters in VATs.
<br>
Feature: Trim product descriptions to 254 characters
<br>
Bug: Handle SQL NULL field query during module initialization.

## 1.3
Feature: Option to send multi lines (including different VAT per line) of invoice to MyDATA 
<br>
Feature: Option to select default invoice country: Greece
<br>
Feature: Tag different invoice MyDATA types in invoice

## 1.2
Bug: There are cases in php environments where module cannot find required php pear module. Installed inside module to make sure that module works.

## 1.1
Bug: Fixed wrong sql query in listing invoices
<br>
Bug: Removed a wrong value in configuration


## 1.0

Initial version

INSERT INTO llx_c_paiement (code, libelle, type) VALUES ('1', 'Επαγ. Λογαριασμός Πληρωμών Ημεδαπής', '2');
INSERT INTO llx_c_paiement (code, libelle, type) VALUES ('2', 'Επαγ. Λογαριασμός Πληρωμών Αλλοδαπής', '2');
INSERT INTO llx_c_paiement (code, libelle, type) VALUES ('3', 'Μετρητά', '2');
INSERT INTO llx_c_paiement (code, libelle, type) VALUES ('4', 'Επιταγή', '2');
INSERT INTO llx_c_paiement (code, libelle, type) VALUES ('5', 'Επί Πιστώσει', '2');
INSERT INTO llx_c_paiement (code, libelle, type) VALUES ('6', 'Web Banking', 2);
INSERT INTO llx_c_paiement (code, libelle, type) VALUES ('7', 'POS / e-POS', 2);

INSERT INTO llx_facture_extrafields (fk_object) select llx_facture.rowid from llx_facture left join llx_facture_extrafields on llx_facture_extrafields.fk_object = llx_facture.rowid where COALESCE(fk_object,0) = 0;

-- UNCOMMENT BELOW LINE TO REMOVE ALL MYDATA DONE RECORDS. CLICK DISABLE AND ENABLE MODULE TO APPLY - REMEMBER TO COMMENT IT AGAIN AFTER ENABLING THE MODULE
--UPDATE llx_facture_extrafields SET mydata_check='',mydata_reply='', mydata_reply_QR='', mydata_reply_invoiceUid='';




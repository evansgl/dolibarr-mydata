INSERT INTO llx_facture_extrafields (fk_object) select llx_facture.rowid from llx_facture left join llx_facture_extrafields on llx_facture_extrafields.fk_object = llx_facture.rowid where COALESCE(fk_object,0) = 0;

-- UNCOMMENT BELOW LINE TO REMOVE ALL MYDATA DONE RECORDS. CLICK DISABLE AND ENABLE MODULE TO APPLY - REMEMBER TO COMMENT IT AGAIN AFTER ENABLING THE MODULE
--UPDATE llx_facture_extrafields SET mydata_check='',mydata_reply='';


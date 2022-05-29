<?php
$con = mysqli_connect("localhost", "kashiram", "root","chhori_bachat");
    if(!$con){
        echo "Database Error Occured";
    }
    
$year=$_POST['year'];
$month=$_POST['month'];
$payment_chhori=" SELECT chori_bachat.id,chori_bachat.name,chori_account_details.id as account_id,bank_details.id as bank_id,chori_account_details.account_no,bank_details.bank_name
                FROM chori_bachat  JOIN chori_account_details on chori_account_details.fk_chori_bachat=chori_bachat.id
                JOIN bank_details on bank_details.id=chori_bachat.fk_bank_details 
                JOIN payment_chori on payment_chori.fk_chori_bachat=chori_bachat.id
                WHERE chori_bachat.status=5 
                AND payment_chori.fk_economic_year=$year
                AND payment_chori.fk_month=$month
                ";
$query = mysqli_query($con,$payment_chhori);
$exeucte = mysqli_fetch_assoc($query);
echo $payment_chhori;
?>



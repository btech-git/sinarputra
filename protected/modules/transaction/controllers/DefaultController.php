<?php

class DefaultController extends Controller
{
	public function actionIndex()
	{
		$this->render('index');
	}
    
    public function actionTest() {
        $file = fopen('/home/pmahendro/temp/customer.csv', 'r');
        while (($line = fgets($file)) !== false) {
            list(, $code, $company, , $address, $phone, $fax, $name, $paymentTerm, $creditLimit, $taxNumber, $taxName, $taxAddress) = explode(';', $line);
            $code = trim($code);
            $company = trim($company);
            $address = trim($address);
            $phone = trim($phone);
            $fax = trim($fax);
            $name = trim($name);
            $creditLimit = trim($creditLimit);
            $taxNumber = trim($taxNumber);
            $taxName = trim($taxName);
            $taxAddress = trim($taxAddress);
            echo "UPDATE tblsp_customer SET company = '$company', address_main = '$address', phone = '$phone', fax = '$fax', name = '$name', invoice_due_days = $paymentTerm, credit_limit = '$creditLimit', tax_registration_number = '$taxNumber', tax_name = '$taxName', tax_address_main = '$taxAddress' WHERE code = '$code';";
            echo '<br />';
        }
        fclose($file);
    }
}
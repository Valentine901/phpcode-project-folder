<?php

require_once "../bank-system/src/Models/SavingAccount.php";
$mySavings = new SavingAccount("SA-10023", 500.00, 1, 0.05);

echo "Initial Balance: ₦" . $mySavings->getBalance() ."<br>";

echo "----------Deposit-----------<br>";
$mySavings->deposit(599.68);
echo "Total bal: " . $mySavings->getBalance() . "<br>";


echo "----------Withdrawal-----------<br>";
if($mySavings->withdraw(300.00)) {
    echo "Withdrawal successful remaining balance: " . $mySavings->getBalance() . "<br>";
} else {
    echo "Withdrawal failed, insufficient balance";
}


echo "----------Interest-----------<br>";
$mySavings->addInterest();
echo "Deposited: " . $mySavings->getBalance() . "<br>";

?>
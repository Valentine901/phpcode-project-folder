<?php

require_once "Account.php";

class SavingAccount extends Account {
    private float $interestRate;
    
    public function __construc(string $accountNumber, float $balance, int $customerId, float $interestRate) {
        parent::__construct($accountNumber, $balance, $customerId);

        $this->interestRate = $interestRate;
    }

    #[Override]
    public function withdraw(float $amount): bool {
        $minimumBalance = 100.00;

        if (($this->balance - $amount) >= $minimumBalance) {
            $this->balance -= $amount;
            return true;
        }
        return false;
    }

    public function addInterest(): void {
        $this->balance += ($this->balance * $this->interestRate);
    }

}



?>
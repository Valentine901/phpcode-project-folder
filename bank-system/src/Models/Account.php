<?php

abstract class Account {
    // encapsulation protects these properties from being modified arbitrary from outside using access modifier
    protected string $accountNumber;
    protected float $balance;
    protected int $customerId;

    public function __construct(string $accountNumber, float $balance, int $customerId){
        $this->accountNumber = $accountNumber;
        $this->balance = $balance;
        $this->customerId = $customerId;
    }

    public function getBalance(): float {
        return $this -> balance;
    }

    public function getAccountNumber(): string {
        return $this -> accountNumber;
    }

    abstract public function withdraw(float $amount): bool;

    public function deposit(float $amount): void {
        if ($amount > 0) {
            $this -> balance += $amount;
        }
    }
}




?>
<?php


class AuthClass{
    public function hashUserPassword(string $password) {
        // PASSWORD_DEFAULT uses strongest hashing algorithm "bycrypt"
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public function verifyUserPassword(string $plain_password, string $hashed_password) {
        return password_verify($plain_password, $hashed_password);
    }
}

?>
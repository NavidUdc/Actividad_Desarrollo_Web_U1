<?php

declare(strict_types=1);

class UserPassword
{
    private string $hash;

    private function __construct(string $hash)
    {
        $this->hash = $hash;
    }

    public static function fromPlainText(string $plain): self
    {
        $plain = trim($plain);
        if ($plain === '') {
            throw InvalidUserPasswordException::becauseValueIsEmpty();
        }
        if (strlen($plain) < 8) {
            throw InvalidUserPasswordException::becauseLengthIsTooShort(8);
        }
        return new self(password_hash($plain, PASSWORD_BCRYPT));
    }

    public static function fromHash(string $hash): self
    {
        return new self($hash);
    }

    public function verifyPlain(string $plain): bool
    {
        return password_verify($plain, $this->hash);
    }

    public function value(): string
    {
        return $this->hash;
    }
    public function equals(UserPassword $other): bool
    {
        return $this->hash === $other->value();
    }
    public function __toString(): string
    {
        return $this->hash;
    }
}

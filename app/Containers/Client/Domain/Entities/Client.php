<?php

namespace App\Containers\Client\Domain\Entities;

use App\Containers\Client\Domain\Properties\Values\BirthdayValue;
use App\Containers\Client\Domain\Properties\Values\EmailValue;
use App\Containers\Client\Domain\Properties\Values\NameValue;
use App\Containers\Client\Domain\Properties\Values\VerifyCodeValue;
use App\Ship\Parents\Entities\Entity;
use App\Ship\Values\PhoneValue;
use Illuminate\Support\Facades\Hash;

class Client extends Entity
{
    private PhoneValue $phone;

    private NameValue $name;

    private EmailValue $email;

    private VerifyCodeValue $verifyCode;

    private BirthdayValue $birthday;

    public function changeName(NameValue $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function changeEmail(EmailValue $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function changeBirthday(BirthdayValue $birthday): self
    {
        $this->birthday = $birthday;

        return $this;
    }

    public function changePhone(PhoneValue $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function hasPhone(): bool
    {
        return ! empty($this->phone);
    }

    public function hasEmail(): bool
    {
        return ! empty($this->email);
    }

    public function getPhone(): string
    {
        return $this->phone->getValue();
    }

    public function getName(): string
    {
        return $this->name ?? '';
    }

    public function getEmail(): string
    {
        return $this->email ?? '';
    }

    public function getBirthday(): ?string
    {
        return $this->birthday ?? null;
    }

    public function getVerifyCode(): ?string
    {
        return $this->verifyCode ?? null;
    }

    public function checkVerifyCode(string $code): bool
    {
        return Hash::check($code, $this->verifyCode);
    }

    public function generateVerifyCode(): string
    {
        $code = rand(1000, 9999);

        $this->verifyCode = new VerifyCodeValue(Hash::make($code));

        return $code;
    }
}

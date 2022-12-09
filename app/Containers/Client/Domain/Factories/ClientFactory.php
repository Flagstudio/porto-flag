<?php

namespace App\Containers\Client\Domain\Factories;

use App\Containers\Client\Domain\Entities\Client;
use App\Containers\Client\Domain\Models\User;
use App\Containers\Client\Domain\Properties\Values\BirthdayValue;
use App\Containers\Client\Domain\Properties\Values\EmailValue;
use App\Containers\Client\Domain\Properties\Values\NameValue;
use App\Containers\Client\Domain\Properties\Values\VerifyCodeValue;
use App\Ship\Parents\Domain\Factories\ParentFactory;
use App\Ship\Values\IdValue;
use App\Ship\Values\PhoneValue;

class ClientFactory extends ParentFactory
{
    public function general(): Client
    {
        return new Client();
    }

    public function new(PhoneValue $phone): Client
    {
        $client = $this->general();

        $this->writer($client, 'phone', $phone);

        return $client;
    }

    public function fromModel(User $user): Client
    {
        $client = $this->general();

        $verify = $user->verificationCode()->whereTime('expires_in', '>', now())->first();

        if ($verify) {
            $this->writer($client, 'verifyCode', new VerifyCodeValue($verify->code));
        }

        $this->writer($client, 'id', new IdValue($user->id));
        $this->writer($client, 'phone', new PhoneValue($user->phone));

        if (! empty($user->birthday)) {
            $this->writer($client, 'birthday', new BirthdayValue($user->birthday));
        }

        return $client->changeName(new NameValue($user->name))
            ->changeEmail(new EmailValue($user->email ?? ''));
    }
}

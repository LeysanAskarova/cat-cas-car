<?php

namespace App\Form\Model;

use Symfony\Component\Validator\Constraints as Assert;
use App\Validator\UniqueUser;


class UserRegistrationFormModel
{
    /**
    * @Assert\NotBlank()
    * @Assert\Email()
    * @UniqueUser()
    */
    public $email;

    public $firstName;
    /**
     * @Assert\NotBlank(message="Пароль не указан")
     * @Assert\Length(min="6", minMessage="Пароль должен быть длиной не меньше 6 символов")
     */
    public $plainPassword;
    /**
     * @Assert\IsTrue(message="Вы должны согласиться с условиями")
     */
    public $agreeTerms;
}
<?php
/**
 * @author Boris Guéry <guery.b@gmail.com>
 */

namespace Tiquette\Domain;

use Tiquette\Utils\Ensure;

class Member
{
    private $id;
    private $email;
    private $nickname;
    private $encodedPassword;
    private $roles;

    public static function signUp(Email $email, string $nickname, EncodedPassword $encodedPassword): self
    {
        return new self(UniqId::generate(), $email, $nickname, $encodedPassword, ['ROLE_USER']);
    }

    public function promoteAdmin(): void
    {
        $this->roles = array_unique(array_merge($this->roles, ['ROLE_ADMIN']));
    }

    public function demoteAdmin(): void
    {
        if (false !== ($roleIndex = array_search('ROLE_ADMIN', $this->roles, false))) {
            unset($this->roles[$roleIndex]);
        }
    }

    public function getId(): UniqId
    {
        return $this->id;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getNickname(): string
    {
        return $this->nickname;
    }

    public function getEncodedPassword(): EncodedPassword
    {
        return $this->encodedPassword;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    private function __construct(UniqId $memberId, Email $email, string $nickname, EncodedPassword $encodedPassword, array $roles)
    {
        Ensure::string($nickname);
        Ensure::minLength($nickname, 1);

        $this->id = $memberId;
        $this->email = $email;
        $this->nickname = $nickname;
        $this->encodedPassword = $encodedPassword;
        $this->roles = array_unique(array_merge(['ROLE_USER'], $roles));
    }

    /**
     * This method should be used only to hydrate object from a persistent storage
     * and never to create / sign up a Member.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            UniqId::fromString($data['uuid']),
            new Email($data['email']),
            $data['nickname'],
            new EncodedPassword($data['encoded_password'], $data['password_salt']),
            explode(',', trim(str_replace(' ', '', $data['roles'])))
        );
    }
}

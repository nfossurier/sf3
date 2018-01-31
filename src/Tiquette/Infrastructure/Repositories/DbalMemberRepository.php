<?php
/**
 * @author Boris Guéry <guery.b@gmail.com>
 */

namespace Tiquette\Infrastructure\Repositories;

use Doctrine\DBAL\Connection;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Tiquette\Domain\Member;
use Tiquette\Domain\MemberRepository;

class DbalMemberRepository implements MemberRepository, UserLoaderInterface
{
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function save(Member $member): void
    {
        $data = [
            'email'            => (string)$member->getEmail(),
            'nickname'         => $member->getNickname(),
            'encoded_password' => $member->getEncodedPassword()->getEncodedPassword(),
            'password_salt'    => $member->getEncodedPassword()->getSalt(),
        ];

        $this->connection->insert('members', $data);
    }

    /**
     * Loads the user for the given username.
     *
     * This method must return null if the user is not found.
     *
     * @param string $username The username
     *
     * @return UserInterface|null
     */
    public function loadUserByUsername($username)
    {
        $row = $this->connection->createQueryBuilder()
            ->select('*')
            ->from('members')
            ->where('nickname = :username')
            ->setParameter('username', $username)
            ->getFirstResult();


    }
}

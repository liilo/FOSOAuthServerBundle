<?php

/*
 * This file is part of the FOSOAuthServerBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FOS\OAuthServerBundle\DynDbDocument;

use FOS\OAuthServerBundle\Model\AuthCodeInterface;
use FOS\OAuthServerBundle\Model\AuthCodeManager as BaseAuthCodeManager;
use Cpliakas\DynamoDb\ODM\DocumentManager;

class AuthCodeManager extends BaseAuthCodeManager
{
    /**
     * @var \Cpliakas\DynamoDb\ODM\DocumentManager
     */
    protected $dm;

    /**
     * @var string
     */
    protected $class;

    public function __construct(DocumentManager $dm, $class)
    {
        $this->dm = $dm;
        $this->class = $class;
    }

    /**
     * {@inheritdoc}
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * {@inheritdoc}
     */
    public function findAuthCodeBy(array $criteria)
    {
        return $this->repository->findOneBy($criteria);
    }

    /**
     * {@inheritdoc}
     */
    public function updateAuthCode(AuthCodeInterface $authCode)
    {
        $this->dm->persist($authCode);
        $this->dm->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function deleteAuthCode(AuthCodeInterface $authCode)
    {
        $this->dm->remove($authCode);
        $this->dm->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function deleteExpired()
    {
        $result = $this
            ->repository
            ->createQueryBuilder()
            ->remove()
            ->field('expiresAt')->lt(time())
            ->getQuery(array('safe' => true))
            ->execute();

        return $result['n'];
    }
}

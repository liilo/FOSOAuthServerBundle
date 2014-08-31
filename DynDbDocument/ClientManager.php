<?php

/*
 * This file is part of the FOSOAuthServerBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FOS\OAuthServerBundle\Document;

use FOS\OAuthServerBundle\Model\ClientManager as BaseClientManager;
use FOS\OAuthServerBundle\Model\ClientInterface;
use Cpliakas\DynamoDb\ODM\DocumentManager;

class ClientManager extends BaseClientManager
{
    /* @var $dm \Cpliakas\DynamoDb\ODM\DocumentManager */
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
    public function findClientBy(array $criteria)
    {
        return $this->repository->findOneBy($criteria);
    }

    /**
     * {@inheritdoc}
     */
    public function updateClient(ClientInterface $client)
    {
        $this->dm->update($client);
    }

    /**
     * {@inheritdoc}
     */
    public function deleteClient(ClientInterface $client)
    {
        $this->dm->delete($client);
    }
}

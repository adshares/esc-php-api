<?php

namespace Adshares\Ads\Entity;

use Adshares\Ads\Util\AdsConverter;

/**
 * @package Adshares\Ads\Entity
 */
class Account extends AbstractEntity
{
    /**
     * Account address
     *
     * @var string
     */
    protected $address;

    /**
     * Balance
     *
     * @var int
     */
    protected $balance;

    /**
     * Hash
     *
     * @var string
     */
    protected $hash;

    /**
     * Block time of an outgoing transaction request
     *
     * @var \DateTime
     */
    protected $localChange;

    /**
     * Msid
     *
     * @var int
     */
    protected $msid;

    /**
     * Node ordinal number
     *
     * @var int
     */
    protected $node;

    /**
     * Paired account address
     *
     * @var null|string
     */
    protected $pairedAddress;

    /**
     * Paired node ordinal number
     *
     * @var int
     */
    protected $pairedNode;

    /**
     * Public key
     *
     * @var string
     */
    protected $publicKey;

    /**
     * Block time of an incoming transaction from a remote host
     *
     * @var \DateTime
     */
    protected $remoteChange;

    /**
     * Status
     *
     * @var int
     */
    protected $status;

    /**
     * Time of last transaction
     *
     * @var \DateTime
     */
    protected $time;

    /**
     * @return string account address
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * @return int Balance
     */
    public function getBalance(): int
    {
        return $this->balance;
    }

    /**
     * @return string Hash
     */
    public function getHash(): string
    {
        return $this->hash;
    }

    /**
     * @return \DateTime Block time of an outgoing transaction request
     */
    public function getLocalChange(): \DateTime
    {
        return $this->localChange;
    }

    /**
     * @return int Msid
     */
    public function getMsid(): int
    {
        return $this->msid;
    }

    /**
     * @return int Node ordinal number
     */
    public function getNode(): int
    {
        return $this->node;
    }

    /**
     * @return string Node id
     */
    public function getNodeId(): string
    {
        return sprintf('%04X', $this->node);
    }

    /**
     * @return null|string Paired account address
     */
    public function getPairedAddress(): ?string
    {
        return $this->pairedAddress;
    }

    /**
     * @return int Paired node ordinal number
     */
    public function getPairedNode(): int
    {
        return $this->pairedNode;
    }

    /**
     * @return string Paired node id
     */
    public function getPairedNodeId(): string
    {
        return sprintf('%04X', $this->pairedNode);
    }

    /**
     * @return string Public key
     */
    public function getPublicKey(): string
    {
        return $this->publicKey;
    }

    /**
     * @return \DateTime Block time of an incoming transaction from a remote host
     */
    public function getRemoteChange(): \DateTime
    {
        return $this->remoteChange;
    }

    /**
     * @return int Status
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @return \DateTime Time of last transaction
     */
    public function getTime(): \DateTime
    {
        return $this->time;
    }

    /**
     * @return bool true if account has been deleted, false otherwise
     */
    public function isStatusDeleted(): bool
    {
        return ($this->status & 1) != 0;
    }

    /**
     * @inheritdoc
     */
    protected static function castProperty(string $name, $value, \ReflectionClass $refClass = null)
    {
        if ("balance" === $name) {
            return AdsConverter::adsToClicks($value);
        } else {
            return parent::castProperty($name, $value, $refClass);
        }
    }
}

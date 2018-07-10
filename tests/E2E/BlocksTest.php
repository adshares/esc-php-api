<?php

namespace Adshares\Ads\Tests\E2E;

use Adshares\Ads\AdsClient;
use Adshares\Ads\Driver\CliDriver;
use Adshares\Ads\Exception\CommandException;

class BlocksTest extends \PHPUnit\Framework\TestCase
{
    /**
     * No new blocks. All blocks were downloaded.
     */
    const NO_NEW_BLOCKS = "No new blocks to download";
    /**
     * No message list. Need to retry after short delay.
     */
    const NO_MESSAGE_LIST_FILE = "No message list file";

    private $address = "0001-00000000-9B6F";
    private $secret = "BB3425F914CA9F661CA6F3B908E07092B5AFB7F2FDAE2E94EDE12C83207CA743";
    private $host = "10.69.3.43";
    private $port = 9001;

    public function testGetBlocks()
    {
        $driver = new CliDriver($this->address, $this->secret, $this->host, $this->port);
        $client = new AdsClient($driver);

        while (true) {
            try {
                $response = $client->getBlocks();

                $blocks = $response->getBlocks();
                foreach ($blocks as $block) {
                    echo $block . "\n";
                }
            } catch (CommandException $ce) {
                $this->assertEquals(self::NO_NEW_BLOCKS, $ce->getMessage());
                break;
            }
        }
    }

    public function testGetMessageList()
    {
        $driver = new CliDriver($this->address, $this->secret, $this->host, $this->port);
        $client = new AdsClient($driver);

        $response = $client->getMe();
        $blockTime = $response->getPreviousBlockTime();
        $blockTime = $blockTime->getTimestamp();

        $blockTime = dechex($blockTime);

        $packages = [];
        $isMessageList = false;
        do {
            try {
                $response = $client->getPackageList($blockTime);
                $packages = $response->getPackages();
                $isMessageList = true;
            } catch (CommandException $ce) {
                $this->assertEquals($ce->getMessage(), self::NO_MESSAGE_LIST_FILE);
                sleep(4);
            }
        } while (!$isMessageList);

        $this->assertGreaterThan(0, count($packages));
        foreach ($packages as $package) {
            /* @var \Adshares\Ads\Entity\Package $package */
            echo $package->getNode() . '-' . $package->getNodeMsid() . "\n";

            $response = $client->getPackage($package->getNode(), $package->getNodeMsid(), $blockTime);
            $transactions = $response->getTransactions();
            foreach ($transactions as $transaction) {
                /* @var \Adshares\Ads\Entity\Transaction $transaction */
                echo "\t" . $transaction->getType() . '-' . $transaction->getId() . "\n";
            }
        }
    }
}
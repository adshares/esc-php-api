<?php

namespace Adshares\Ads\Tests\Unit\Entity\Transaction;

use Adshares\Ads\Entity\EntityFactory;
use Adshares\Ads\Entity\Transaction\SendManyTransaction;

class SendManyTransactionTest extends \PHPUnit\Framework\TestCase
{
    public function testSendManyFromRaw(): void
    {
        /* @var SendManyTransaction $transaction */
        $transaction = EntityFactory::createTransaction($this->getRawSendMany());

        $this->assertEquals('0001:0000001F:0001', $transaction->getId());
        $this->assertEquals('send_many', $transaction->getType());
        $this->assertEquals(1, $transaction->getNode());
        $this->assertEquals(0, $transaction->getUser());
        $this->assertEquals('0001-00000000-9B6F', $transaction->getSenderAddress());
        $this->assertEquals(5, $transaction->getMsgId());

        $date = new \DateTime();
        $date->setTimestamp(1532005558);
        $this->assertEquals($date, $transaction->getTime());
        $wireCount = $transaction->getWireCount();
        $this->assertEquals(2, $wireCount);
        $this->assertCount($wireCount, $transaction->getWires());
        $this->assertEquals(50000000, $transaction->getSenderFee());
        $this->assertEquals(
            'F30906B2258C664987031F2D1DDA558EB47EB55A8F1C6E3E12A3A389271ADB4B'
            . '1A7B4C2D75FE9790B2CF665ED8D55EBB13F51C8F172FE42CDED5BEC2356AB90E',
            $transaction->getSignature()
        );
        $this->assertEquals(109, $transaction->getSize());
    }

    private function getRawSendMany(): array
    {
        return json_decode('{
            "id": "0001:0000001F:0001",
            "type": "send_many",
            "node": "1",
            "user": "0",
            "sender_address": "0001-00000000-9B6F",
            "msg_id": "5",
            "time": "1532005558",
            "wire_count": "2",
            "sender_fee": "0.00050000000",
            "wires": [
                {
                    "target_node": "1",
                    "target_user": "1",
                    "target_address": "0001-00000001-8B4E",
                    "amount": "0.00000000001"
                },
                {
                    "target_node": "1",
                    "target_user": "0",
                    "target_address": "0001-00000000-9B6F",
                    "amount": "1.00000000000"
                }
            ],
            "signature": "F30906B2258C664987031F2D1DDA558EB47EB55A8F1C6E3E12A3A389271ADB4B'
            . '1A7B4C2D75FE9790B2CF665ED8D55EBB13F51C8F172FE42CDED5BEC2356AB90E",
            "size": "109"
        }', true);
    }
}
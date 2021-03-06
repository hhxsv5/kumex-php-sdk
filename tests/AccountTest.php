<?php

namespace KuMEX\SDK\Tests;

use KuMEX\SDK\ApiCode;
use KuMEX\SDK\Exceptions\BusinessException;
use KuMEX\SDK\PrivateApi\Account;

class AccountTest extends TestCase
{
    protected $apiClass = Account::class;
    protected $apiWithAuth = true;

    /**
     * @dataProvider apiProvider
     * @param Account $api
     * @throws BusinessException
     * @throws \KuMEX\SDK\Exceptions\HttpException
     * @throws \KuMEX\SDK\Exceptions\InvalidApiUriException
     */
    public function testGetOverview(Account $api)
    {
        $accounts = $api->getOverview(['currency' => 'XBT']);
        $this->assertInternalType('array', $accounts);
        $this->assertArrayHasKey('accountEquity', $accounts);
        $this->assertArrayHasKey('unrealisedPNL', $accounts);
        $this->assertArrayHasKey('marginBalance', $accounts);
        $this->assertArrayHasKey('positionMargin', $accounts);
        $this->assertArrayHasKey('orderMargin', $accounts);
        $this->assertArrayHasKey('frozenFunds', $accounts);
        $this->assertArrayHasKey('availableBalance', $accounts);
    }

    /**
     * @dataProvider apiProvider
     * @param Account $api
     * @throws BusinessException
     * @throws \KuMEX\SDK\Exceptions\HttpException
     * @throws \KuMEX\SDK\Exceptions\InvalidApiUriException
     */
    public function testGetTransactionHistory(Account $api)
    {
        $accounts = $api->getTransactionHistory(['currency' => 'XBT']);
        $this->assertInternalType('array', $accounts);
        foreach ($accounts['dataList'] as $item) {
            $this->assertArrayHasKey('time', $item);
            $this->assertArrayHasKey('type', $item);
            $this->assertArrayHasKey('amount', $item);
            $this->assertArrayHasKey('accountEquity', $item);
            $this->assertArrayHasKey('status', $item);
            $this->assertArrayHasKey('offset', $item);
        }
    }

    /**
     * @deprecated
     * @dataProvider apiProvider
     * @param Account $api
     * @throws BusinessException
     * @throws \KuMEX\SDK\Exceptions\HttpException
     * @throws \KuMEX\SDK\Exceptions\InvalidApiUriException
     */
//    public function testTransferIn(Account $api)
//    {
//        $amount   = 0.1;
//        $accounts = $api->transferIn($amount);
//        $this->assertInternalType('array', $accounts);
//        if (isset($accounts['applyId'])) {
//            $this->assertArrayHasKey('applyId', $accounts);
//        }
//    }

    /**
     * @dataProvider apiProvider
     * @param Account $api
     * @throws BusinessException
     * @throws \KuMEX\SDK\Exceptions\HttpException
     * @throws \KuMEX\SDK\Exceptions\InvalidApiUriException
     */
    public function testTransferOut(Account $api)
    {
        $bizNo    = rand(1, 9999);
        $amount   = 0.1;
        $accounts = $api->transferOut($bizNo, $amount);
        $this->assertInternalType('array', $accounts);
        if (isset($accounts['applyId'])) {
            $this->assertArrayHasKey('applyId', $accounts);
        }
    }

    /**
     * @dataProvider apiProvider
     * @param Account $api
     * @throws BusinessException
     * @throws \KuMEX\SDK\Exceptions\HttpException
     * @throws \KuMEX\SDK\Exceptions\InvalidApiUriException
     */
    public function testCancelTransferOut(Account $api)
    {
        $applyId = $this->getTransferId($api);
        $accounts = $api->cancelTransferOut($applyId);
        $this->assertNull($accounts);
    }

    /**
     * @dataProvider apiProvider
     * @param Account $api
     * @throws BusinessException
     * @throws \KuMEX\SDK\Exceptions\HttpException
     * @throws \KuMEX\SDK\Exceptions\InvalidApiUriException
     */
    public function testGetTransferList(Account $api)
    {
        $accounts = $api->getTransactionHistory();
        $this->assertInternalType('array', $accounts);
        foreach ($accounts['dataList'] as $item) {
//            $this->assertArrayHasKey('applyId', $item);
//            $this->assertArrayHasKey('currency', $item);
            $this->assertArrayHasKey('status', $item);
            $this->assertArrayHasKey('amount', $item);
            $this->assertArrayHasKey('offset', $item);
        }
    }

    /**
     * @dataProvider apiProvider.
     *
     * @param Account $api
     * @throws \KuMEX\SDK\Exceptions\BusinessException
     * @throws \KuMEX\SDK\Exceptions\HttpException
     * @throws \KuMEX\SDK\Exceptions\InvalidApiUriException
     */
    private function getTransferId($api)
    {
        $bizNo = '10000000001';
        $amount   = 0.1;
        $accounts = $api->transferOut($bizNo, $amount);
        $this->assertInternalType('array', $accounts);
        return $accounts['applyId'];
    }


    /**
     * @dataProvider apiProvider
     * @param Account $api
     * @throws BusinessException
     * @throws \KuMEX\SDK\Exceptions\HttpException
     * @throws \KuMEX\SDK\Exceptions\InvalidApiUriException
     */
    public function testTransferOutV2(Account $api)
    {
        $bizNo    = rand(1, 9999);
        $amount   = 0.1;
        $currency = 'XBT';
        $accounts = $api->transferOutV2($bizNo, $amount, $currency);
        $this->assertInternalType('array', $accounts);
        if (isset($accounts['applyId'])) {
            $this->assertArrayHasKey('applyId', $accounts);
        }
    }

}

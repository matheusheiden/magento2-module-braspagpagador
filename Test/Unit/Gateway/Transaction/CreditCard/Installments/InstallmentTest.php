<?php

namespace Webjump\BraspagPagador\Test\Unit\Gateway\Transaction\CreditCard\Installments;

use Webjump\BraspagPagador\Gateway\Transaction\CreditCard\Resource\Installments\Installment;

class InstallmentTest extends \PHPUnit_Framework_TestCase
{
	protected $installment;

    public function setUp()
    {
        $this->pricingHelper = $this->getMockBuilder('Magento\Framework\Pricing\Helper\Data')
            ->disableOriginalConstructor()
            ->setMethods(array('currency'))
            ->getMock();

        $this->pricingHelper->expects($this->once())
            ->method('currency')
            ->with(10.00, true, false)
            ->will($this->returnValue('R$10,00'));

    	$this->installment = new Installment(
            $this->pricingHelper
        );
    }

    public function tearDown()
    {

    }

    public function testSetData()
    {
    	$this->installment->setIndex(1);
    	$this->installment->setPrice(10.00);
        $this->installment->setWithInterest(true);

    	static::assertEquals(1, $this->installment->getId());
    	static::assertEquals('1x R$10,00 with interest*', $this->installment->getLabel());
    }

    public function testSetDataWithoutInterest()
    {
        $this->installment->setIndex(1);
        $this->installment->setPrice(10.00);
        $this->installment->setWithInterest(false);

        static::assertEquals(1, $this->installment->getId());
        static::assertEquals('1x R$10,00 without interest', $this->installment->getLabel());
    }
}
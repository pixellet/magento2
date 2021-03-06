<?php
/**
 * @copyright Copyright (c) 2014 X.commerce, Inc. (http://www.magentocommerce.com)
 */

namespace Magento\Shipping\Test\Constraint;

use Magento\Sales\Test\Page\SalesGuestPrint;
use Mtf\Constraint\AbstractConstraint;

/**
 * Assert that shipping method was printed correctly on sales guest print page.
 */
class AssertShippingMethodOnPrintOrder extends AbstractConstraint
{
    /* tags */
    const SEVERITY = 'low';
    /* end tags */

    /**
     * Shipping method and carrier template.
     */
    const SHIPPING_TEMPLATE = "%s - %s";

    /**
     * Assert that shipping method was printed correctly on sales guest print page.
     *
     * @param SalesGuestPrint $salesGuestPrint
     * @param array $shipping
     * @return void
     */
    public function processAssert(SalesGuestPrint $salesGuestPrint, $shipping)
    {
        $expected = sprintf(self::SHIPPING_TEMPLATE, $shipping['shipping_service'], $shipping['shipping_method']);
        \PHPUnit_Framework_Assert::assertTrue(
            $salesGuestPrint->getInfoShipping()->isShippingMethodVisible($expected),
            "Shipping method was printed incorrectly."
        );
    }

    /**
     * Returns a string representation of successful assertion.
     *
     * @return string
     */
    public function toString()
    {
        return "Shipping method was printed correctly.";
    }
}

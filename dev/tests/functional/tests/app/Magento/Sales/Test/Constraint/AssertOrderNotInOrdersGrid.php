<?php
/**
 * @copyright Copyright (c) 2014 X.commerce, Inc. (http://www.magentocommerce.com)
 */

namespace Magento\Sales\Test\Constraint;

use Magento\Sales\Test\Fixture\OrderInjectable;
use Magento\Sales\Test\Page\Adminhtml\OrderIndex;
use Mtf\Constraint\AbstractConstraint;

/**
 * Class AssertOrderNotInOrdersGrid
 * Assert that order with fixture data in not more in the Orders grid
 */
class AssertOrderNotInOrdersGrid extends AbstractConstraint
{
    /* tags */
    const SEVERITY = 'low';
    /* end tags */

    /**
     * Assert that order with fixture data in not more in the Orders grid
     *
     * @param OrderInjectable $order
     * @param OrderIndex $orderIndex
     * @return void
     */
    public function processAssert(OrderInjectable $order, OrderIndex $orderIndex)
    {
        $data = $order->getData();
        $filter = ['id' => $data['id']];
        $orderIndex->open();
        $errorMessage = implode(', ', $filter);
        \PHPUnit_Framework_Assert::assertFalse(
            $orderIndex->getSalesOrderGrid()->isRowVisible($filter),
            'Order with following data \'' . $errorMessage . '\' is present in Orders grid.'
        );
    }

    /**
     * Returns a string representation of the object
     *
     * @return string
     */
    public function toString()
    {
        return 'Order is absent in sales orders grid.';
    }
}

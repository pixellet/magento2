<?php
/**
 * @copyright Copyright (c) 2014 X.commerce, Inc. (http://www.magentocommerce.com)
 */
namespace Magento\Framework\Search;

use Magento\Framework\Search\Request\BucketInterface;
use Magento\Framework\Search\Request\Dimension;
use Magento\Framework\Search\Request\QueryInterface;

/**
 * Search Request
 */
interface RequestInterface
{
    /**
     * Get Name
     *
     * @return string
     */
    public function getName();

    /**
     * Get Index name
     *
     * @return string
     */
    public function getIndex();

    /**
     * Get all dimensions
     *
     * @return Dimension[]
     */
    public function getDimensions();

    /**
     * Get Aggregation Buckets
     *
     * @return BucketInterface[]
     */
    public function getAggregation();

    /**
     * Get Main Request Query
     *
     * @return QueryInterface
     */
    public function getQuery();

    /**
     * Get From
     *
     * @return int|null
     */
    public function getFrom();

    /**
     * Get Size
     *
     * @return int|null
     */
    public function getSize();
}

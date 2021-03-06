<?php
/**
 * @copyright Copyright (c) 2014 X.commerce, Inc. (http://www.magentocommerce.com)
 */
namespace Magento\Integration\Model\Resource\Oauth;

/**
 * oAuth nonce resource model
 *
 * @author Magento Core Team <core@magentocommerce.com>
 */
class Nonce extends \Magento\Framework\Model\Resource\Db\AbstractDb
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('oauth_nonce', null);
    }

    /**
     * Delete old entries
     *
     * @param int $minutes Delete entries older than
     * @return int
     */
    public function deleteOldEntries($minutes)
    {
        if ($minutes > 0) {
            $adapter = $this->_getWriteAdapter();

            return $adapter->delete(
                $this->getMainTable(),
                $adapter->quoteInto('timestamp <= ?', time() - $minutes * 60, \Zend_Db::INT_TYPE)
            );
        } else {
            return 0;
        }
    }

    /**
     * Select a unique nonce row using a composite primary key (i.e. $nonce and $consumerId)
     *
     * @param string $nonce - The nonce string
     * @param int $consumerId - The consumer id
     * @return array - Array of data
     */
    public function selectByCompositeKey($nonce, $consumerId)
    {
        $adapter = $this->_getReadAdapter();
        $select = $adapter->select()->from(
            $this->getMainTable()
        )->where(
            'nonce = ?',
            $nonce
        )->where(
            'consumer_id = ?',
            $consumerId
        );
        $row = $adapter->fetchRow($select);
        return $row ? $row : [];
    }
}

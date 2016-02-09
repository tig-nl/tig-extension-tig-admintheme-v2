<?php
/**
 * Magento Enterprise Edition
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Magento Enterprise Edition End User License Agreement
 * that is bundled with this package in the file LICENSE_EE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.magento.com/license/enterprise-edition
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magento.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magento.com for more information.
 *
 * @category    Mage
 * @package     Mage_Adminhtml
 * @copyright Copyright (c) 2006-2014 X.commerce, Inc. (http://www.magento.com)
 * @license http://www.magento.com/license/enterprise-edition
 */

/**
 * Adminhtml menu block
 *
 * @method Mage_Adminhtml_Block_Page_Menu setAdditionalCacheKeyInfo(array $cacheKeyInfo)
 * @method array getAdditionalCacheKeyInfo()
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author     Magento Core Team <core@magentocommerce.com>
 */
class TIG_Admintheme_Block_Page_Menu extends Mage_Adminhtml_Block_Page_Menu
{
    /**
     * Get menu level HTML code
     *
     * @param array $menu
     * @param int $level
     * @return string
     */
    public function getMenuLevel($menu, $level = 0)
    {
        /**
         * Check if the TIG admintheme is enable. If not, use the original method.
         */
        if (Mage::getStoreConfig('design/tigadmintheme/theme') == 0) {
            return parent::getMenuLevel($menu, $level);
        }

        $menuColumn = 0;
        $counter = 0;

        $html = '';

        if ($level == 1) {
            $html .= '<div class="submenu-container cf">';
        }

        $html .= '<ul ' . (!$level ? 'id="nav"' : '') . ' class="column-' . $menuColumn . '">' . PHP_EOL;
        foreach ($menu as $item) {

            $counter++;

            if ($counter % 12 == 0 && $level > 0){
                $menuColumn++;
                $html .= '</ul><ul ' . (!$level ? 'id="nav"' : '') . ' class="column-' . $menuColumn . '">' . PHP_EOL;
            }

            $html .= '<li ' . ' class="'
                . (!$level && !empty($item['active']) ? ' active' : '') . ' '
                . (!empty($item['children']) ? ' parent' : '')
                . (!empty($level) && !empty($item['last']) ? ' last' : '')
                . ' level' . $level . '"> <a href="' . $item['url'] . '" '
                . (!empty($item['title']) ? 'title="' . $item['title'] . '"' : '') . ' '
                . (!empty($item['click']) ? 'onclick="' . $item['click'] . '"' : '') . ' class="'
                . ($level === 0 && !empty($item['active']) ? 'active' : '') . '"><span>'
                . $this->escapeHtml($item['label']) . '</span></a>' . PHP_EOL;

            if (!empty($item['children'])) {
                $html .= $this->getMenuLevel($item['children'], $level + 1);
            }
            $html .= '</li>' . PHP_EOL;
        }
        $html .= '</ul>' . PHP_EOL;

        if ($level == 1) {
            $html .= '</div>';
        }

        return $html;
    }
}

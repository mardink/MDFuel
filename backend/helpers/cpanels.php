<?php
/**
 * @package MDFuel
 * @copyright Copyright (c)2013 Martijn Hiddink / mardinkwebdesign.com
 * @license GNU General Public License version 3 or later
 */

defined('_JEXEC') or die();

class MdfuelHelperCpanels
{

    /*
         * This helper gets the number new calls per month from the database
         * The result is used for the bar graph
         */
    public static function getFuelperMonth() {
        // Get a db connection.
        $db = JFactory::getDBO();
        $query = "SELECT SUM(liters) as liter, MONTHNAME(tankdatum) as month FROM #__mdfuel_receipts GROUP BY YEAR(tankdatum), MONTH(tankdatum) ASC";
        $db->setQuery($query);
        $db->query();
        $result = $db->loadObjectList();
        return $result;
    }

}

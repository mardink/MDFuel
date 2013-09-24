<?php
/**
 * @package MDFuel
 * @copyright Copyright (c)2013 Martijn Hiddink / mardinkwebdesign.com
 * @license GNU General Public License version 3 or later
 */

defined('_JEXEC') or die();

class MdfuelModelReceipt extends FOFModel
{
    public function buildQuery($overrideLimits = false)
    {
        $db = $this->getDbo();

        $query = $db->getQuery(true)
            ->select('*')
            ->from($db->quoteName('#__mdfuel_cars'))
            ->where($db->qn('enabled').' != '.$db->q('0'));

        return $query;
    }
// get the current mileages plates from the database
   /* overbodig
    public static function getCurrentMileage($carid)
    {
        // Get a db connection.
        $db = JFactory::getDbo();
        // Create a new query object.
        $query = $db->getQuery(true);
        $query
            ->select('MAX(kmstand_tank)')
            ->from($db->quoteName('#__mdfuel_receipts'))
            ->where(
                '('.
                '('.$db->qn('mdfuel_car_id').' = '.$db->quote($carid).')'.
                ')'
            );
        $db->setQuery($query); //set the limit
        $result = $db->loadResult();
        return $result;
    }
    */
}
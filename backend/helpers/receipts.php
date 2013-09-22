<?php
/**
 * @package MDFuel
 * @copyright Copyright (c)2013 Martijn Hiddink / mardinkwebdesign.com
 * @license GNU General Public License version 3 or later
 */

defined('_JEXEC') or die();

class MdfuelHelperReceipts
{

// get th licence plates from the database
    public static function getKenteken($carid)
    {
        // Get a db connection.
        $db = JFactory::getDbo();
        // Create a new query object.
        $query = $db->getQuery(true);
        $query
            ->select('kenteken')
            ->from($db->quoteName('#__mdfuel_cars'))
            ->where(
                '('.
                '('.$db->qn('mdfuel_car_id').' = '.$db->quote($carid).')'.
                ')'
            );
        $db->setQuery($query); //set the limit
        $result = $db->loadResult();
        return $result;
    }


}

<?php
/**
 * @package MDFuel
 * @copyright Copyright (c)2013 Martijn Hiddink / mardinkwebdesign.com
 * @license GNU General Public License version 3 or later
 */

defined('_JEXEC') or die();

class MdfuelHelperReceipts
{

// get the licence plates from the database
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
    // get the current mileages plates from the database
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
                '('.$db->qn('mdfuel_car_id').' = '.$db->quote($carid).') AND'.
                '('.$db->qn('enabled').' = '.$db->quote('1').')'.
                ')'
            );
        $db->setQuery($query); //set the limit
        $result = $db->loadResult();
        if (!$result) {
            // Get a db connection.
            $db = JFactory::getDbo();
            // Create a new query object.
            $query = $db->getQuery(true);
            $query
                ->select('kmstand_start')
                ->from($db->quoteName('#__mdfuel_cars'))
                ->where(
                    '('.
                    '('.$db->qn('mdfuel_car_id').' = '.$db->quote($carid).')'.
                    ')'
                );
            $db->setQuery($query);
            $result2 = $db->loadResult();
            return $result2;
        } else {
        return $result;
        }
    }
    // Get the mileage between 2 receipts
    public static function getReceiptMileage($carid, $tankdate, $mileage) {
        // Get a db connection.
        $db = JFactory::getDbo();
        // Create a new query object.
        $query = $db->getQuery(true);
        $query
            ->select('kmstand_tank')
            ->from($db->quoteName('#__mdfuel_receipts'))
            ->where(
                '('.
                '('.$db->qn('mdfuel_car_id').' = '.$db->quote($carid).') AND'.
                '('.$db->qn('enabled').' = '.$db->quote('1').') AND'.
                '('.$db->qn('tankdatum').' < '.$db->quote($tankdate).')'.
                ')'
            )
            ->order('tankdatum DESC');
        $db->setQuery($query);
        $result = $db->loadObjectList();
        if (is_object($result)) {
        $previousmileage = intval($result[0]->kmstand_tank);
        } else {
            // Get a db connection.
            $db = JFactory::getDbo();
            // Create a new query object.
            $query = $db->getQuery(true);
            $query
                ->select('kmstand_start')
                ->from($db->quoteName('#__mdfuel_cars'))
                ->where(
                    '('.
                    '('.$db->qn('mdfuel_car_id').' = '.$db->quote($carid).')'.
                    ')'
                );
            $db->setQuery($query);
            $previousmileage = $db->loadResult();
        }
        $current_mileage = intval($mileage);
        $tankmileage = $current_mileage - $previousmileage;

        return intval($tankmileage);

    }
    // Get the fuel type from the car
    public static function getFuelType($carid){
        // Get a db connection.
        $db = JFactory::getDbo();
        // Create a new query object.
        $query = $db->getQuery(true);
        $query
            ->select('fuel')
            ->from($db->quoteName('#__mdfuel_cars'))
            ->where(
                '('.
                '('.$db->qn('mdfuel_car_id').' = '.$db->quote($carid).')'.
                ')'
            );
        $db->setQuery($query);
        $result = $db->loadResult();
        return $result;
    }
    // get the total amount of liters fuel plates from the database
    public static function getTotalAmountFuel($carid)
    {
        // Get a db connection.
        $db = JFactory::getDbo();
        // Create a new query object.
        $query = $db->getQuery(true);
        $query
            ->select('SUM(liters)')
            ->from($db->quoteName('#__mdfuel_receipts'))
            ->where(
                '('.
                '('.$db->qn('mdfuel_car_id').' = '.$db->quote($carid).') AND'.
                '('.$db->qn('enabled').' = '.$db->quote('1').')'.
                ')'
            );
        $db->setQuery($query); //set the limit
        $result = $db->loadResult();
            return $result;

    }
    // get the total amount  fuel from the database
    public static function getTotalAmount($carid)
    {
        // Get a db connection.
        $db = JFactory::getDbo();
        // Create a new query object.
        $query = $db->getQuery(true);
        $query
            ->select('SUM(tankbedrag)')
            ->from($db->quoteName('#__mdfuel_receipts'))
            ->where(
                '('.
                '('.$db->qn('mdfuel_car_id').' = '.$db->quote($carid).') AND'.
                '('.$db->qn('enabled').' = '.$db->quote('1').')'.
                ')'
            );
        $db->setQuery($query); //set the limit
        $result = $db->loadResult();
        return $result;

    }


}

<?php
/**
 * @package MDFuel
 * @copyright Copyright (c)2013 Martijn Hiddink / mardinkwebdesign.com
 * @license GNU General Public License version 3 or later
 */

defined('_JEXEC') or die();

class MdfuelHelperSelect
{
    protected static function genericlist($list, $name, $attribs, $selected, $idTag)
    {
        if(empty($attribs))
        {
            $attribs = null;
        }
        else
        {
            $temp = '';
            foreach($attribs as $key=>$value)
            {
                $temp .= $key.' = "'.$value.'"';
            }
            $attribs = $temp;
        }

        return JHTML::_('select.genericlist', $list, $name, $attribs, 'value', 'text', $selected, $idTag);
    }

    // Set the pagination fields
    public static function pagination($selected = null, $id = 'limit', $attribs = array())
    {
        $options = array();
        $options[] = JHTML::_('select.option','20','20');
        $options[] = JHTML::_('select.option','50','50');
        $options[] = JHTML::_('select.option','100','100');
        $options[] = JHTML::_('select.option','8888',JText::_('COM_MDTICKETS_NOPAGINATION'));

        return self::genericlist($options, $id, $attribs, $selected, $id);
    }
// get the licence plates from the database
    public static function kenteken($selected = null, $id = 'type', $attribs = array() )
    {
        $db = JFactory::getDBO();
        $query = $db->getQuery(true)
            ->select('*')
            ->from($db->quoteName('#__mdfuel_cars'))
            ->group('kenteken')
            ->order('kenteken ASC');
        $db->setQuery( $query );
        $result = $db->loadObjectList( );
        $options = array();
        $options[] = JHTML::_('select.option','','- '.JText::_('COM_MDFUEL_RECIEPTS_FIELD_KENTEKEN').' -');
        //now fill the array with your database result
        foreach($result as $key=>$value) :
            $options[] = JHTML::_('select.option',$value->mdfuel_car_id,$value->kenteken);
        endforeach;

        return self::genericlist($options, $id, $attribs, $selected, $id);
    }
    // Get the active cars
    public static function ActiveCars($selected = null, $id = 'type', $attribs = array() )
    {
        $db = JFactory::getDBO();
        $query = $db->getQuery(true)
            ->select('*')
            ->from($db->quoteName('#__mdfuel_cars'))
            ->where($db->qn('enabled').' != '.$db->q('0'))
            ->order('kenteken ASC')
            ->group('kenteken');
        $db->setQuery( $query );
        $result = $db->loadObjectList( );
        $options = array();
        //now fill the array with your database result
        foreach($result as $key=>$value) :
            $options[] = JHTML::_('select.option',$value->mdfuel_car_id,$value->kenteken);
        endforeach;

        return self::genericlist($options, $id, $attribs, $selected, $id);
    }
    public static function renderaccess($access_level_id)
    {
        static $levelMap = null;

        if(is_null($levelMap)) {
            $db = JFactory::getDBO();
            $query = 'SELECT `id`, `title` FROM `#__viewlevels`';
            $db->setQuery($query);
            $levelMap = $db->loadAssocList('id','title');
        }

        if(array_key_exists($access_level_id, $levelMap)) {
            return $levelMap[$access_level_id];
        } else {
            return 'UNKNOWN '.$access_level_id;
        }
    }
    // Set the status fields
    public static function fuel($selected = null, $id = 'type', $attribs = array() )
    {
        $options = array();
        $options[] = JHTML::_('select.option','','- '.JText::_('COM_MDFUEL_CARS_FIELD_FUEL').' -');
        $options[] = JHTML::_('select.option','0',JText::_('COM_MDFUEL_CARS_FIELD_FUEL_DIESEL'));
        $options[] = JHTML::_('select.option','1',JText::_('COM_MDFUEL_CARS_FIELD_FUEL_GAS'));
        $options[] = JHTML::_('select.option','2',JText::_('COM_MDFUEL_CARS_FIELD_FUEL_LPG'));

        return self::genericlist($options, $id, $attribs, $selected, $id);
    }

}

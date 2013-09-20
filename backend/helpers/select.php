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
// get th licence plates from the database
    public static function kenteken($selected = null, $id = 'type', $attribs = array() )
    {
        $db = JFactory::getDBO();

        $query = 'SELECT DISTINCT kenteken'
            . ' FROM #__mdfuel_cars'
            . ' ORDER BY kenteken ASC';
        $db->setQuery( $query );
        $result = $db->loadObjectList( );
        $options = array();
        $options[] = JHTML::_('select.option','','- '.JText::_('COM_MDFUEL_CARS_FIELD_ORDERING').' -');
        //now fill the array with your database result
        foreach($result as $key=>$value) :
            $options[] = JHTML::_('select.option',$value->kenteken,$value->kenteken);
        endforeach;

        return self::genericlist($options, $id, $attribs, $selected, $id);
    }

}

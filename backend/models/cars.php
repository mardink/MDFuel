<?php
/**
 * @package MDFuel
 * @copyright Copyright (c)2013 Martijn Hiddink / mardinkwebdesign.com
 * @license GNU General Public License version 3 or later
 */

defined('_JEXEC') or die();

class MdfuelModelCars extends FOFModel
{
    public function buildQuery($overrideLimits = false)
    {
        $db = $this->getDbo();

        $query = $db->getQuery(true)
            ->select('*')
            ->from($db->quoteName('#__mdfuel_cars'));

        $fltKenteken		= $this->getState('kenteken', null, 'string');
        if($fltKenteken) {
            $query->where($db->qn('kenteken').' = '.$db->q($fltKenteken));
        }
        $fltFuel		= $this->getState('fuel', null, 'string');
        if($fltFuel) {
            $query->where($db->qn('fuel').' = '.$db->q($fltFuel));
        }

        $fltMdticket	= $this->getState('mdfuel_car_id', null, 'string');
        if($fltMdticket) {
            $fltMdticket = "%$fltMdfuel";
            $query->where($db->qn('mdfuel_car_id').' LIKE '.$db->q($fltMdfuel));
        }


        $fltAccess		= $this->getState('access', null, 'cmd');
        if($fltAccess) {
            $query->where($db->qn('access').' = '.$db->q($fltAccess));
        }
        $fltSearch_kenteken	= $this->getState('search_kenteken', null, 'string');
        if($fltSearch_kenteken) {
            $fltSearch_kenteken = "%$fltSearch_kenteken%";
            $query->where($db->qn('kenteken').' LIKE '.$db->q($fltSearch_kenteken));
        }
        $fltSearch_brand	= $this->getState('search_brand', null, 'string');
        if($fltSearch_brand) {
            $fltSearch_brand = "%$fltSearch_brand%";
            $query->where($db->qn('merk').' LIKE '.$db->q($fltSearch_brand));
        }

        $fltPublished	= $this->getState('published', null, 'cmd');
        if($fltPublished != '') {
            $query->where($db->qn('published').' = '.$db->q($fltPublished));
        }

        $fltNoBEUnpub	= $this->getState('nobeunpub', null, 'int');
        if($fltNoBEUnpub) {
            $query->where('NOT('.$db->qn('published').' = '.$db->q('0').')');
        }

        $fltLanguage	= $this->getState('language', null, 'cmd');
        $fltLanguage2	= $this->getState('language2', null, 'string');
        if($fltLanguage && ($fltLanguage != '*')) {
            $query->where($db->qn('language').' IN('.$db->q('*').','.$db->q($fltLanguage).')');
        } elseif($fltLanguage2) {
            $query->where($db->qn('language').' = '.$db->q($fltLanguage2));
        }

        $search = $this->getState('search',null);
        if($search)
        {
            $search = '%'.$search.'%';
            $query->where(
                '('.
                '('.$db->qn('kenteken').' LIKE '.$db->quote($search).') OR'.
                '('.$db->qn('merk').' LIKE '.$db->quote($search).') OR'.
                '('.$db->qn('type').' LIKE '.$db->quote($search).')'.
                ')'
            );
        }

        $order = $this->getState('filter_order', 'ordering', 'cmd');
        if(!in_array($order, array_keys($this->getTable()->getData()))) $order = 'mdfuel_car_id';
        $dir = $this->getState('filter_order_Dir', 'ASC', 'cmd');
        $query->order($order.' '.$dir);

        return $query;
    }

    /*public function getPagination()
    {
        if (empty($this->pagination))
        {
            // Import the pagination library
            JLoader::import('joomla.html.pagination');

            // Prepare pagination values
            $total = $this->getTotal();
            //$limitstart = $this->getState('limitstart');
            //$limit = $this->getState('limit');
            $limit = '1111';
            $limitstart = '0';

            // Create the pagination object
            $this->pagination = new JPagination($total, $limitstart, $limit);
        }

        return $this->pagination;
    }*/
}
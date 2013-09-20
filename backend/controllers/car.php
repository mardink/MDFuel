<?php
/**
 * @package MDFuel
 * @copyright Copyright (c)2013 Martijn Hiddink / mardinkwebdesign.com
 * @license GNU General Public License version 3 or later
 */
defined('_JEXEC') or die();

class MdfuelControllerCar extends FOFController {
   /*
    * Before saving the ticket the following will be done
    * When creating a new ticket the modified date will be set with the current date
    * When a ticket is closed or cancelled and no completion date is set the current date will be set
    * When a file is given teh file will be cleaned from strange letters and upload to a subfolder bijlage
    *
    */

    public function onBeforeApplySave(&$data) {
       $model = $this->getThisModel();
       $item = $model->getItem();
       $jinput = JFactory::getApplication()->input;
       $kmstand = $item->get('kmstand');
       $kmstand_start = $jinput->get('kmstand_start', '', 'string');

       if(!$kmstand){
           $data['kmstand'] = $kmstand_start;
           $data['totaalbedrag'] = "0";
           $data['totaalverbuik'] = "0";
           $data['gemverbruik'] = "-";
       }
       return $data;
   }

}
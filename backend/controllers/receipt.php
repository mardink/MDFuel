<?php
/**
 * @package MDFuel
 * @copyright Copyright (c)2013 Martijn Hiddink / mardinkwebdesign.com
 * @license GNU General Public License version 3 or later
 */
defined('_JEXEC') or die();

class MdfuelControllerReceipt extends FOFController {
   /*
    * Before saving the ticket the following will be done
    * When creating a new ticket the modified date will be set with the current date
    * When a ticket is closed or cancelled and no completion date is set the current date will be set
    * When a file is given teh file will be cleaned from strange letters and upload to a subfolder bijlage
    *
    */

    public function onBeforeApplySave(&$data) {
        // require helper file
        JLoader::register('MdfuelHelperReceipts', JPATH_COMPONENT.'/helpers/receipts.php');
    $model = $this->getThisModel();
        $item = $model->getItem();
        $carid = $item->get('mdfuel_car_id');
        $fueltype = MdfuelHelperReceipts::getFuelType($carid);
        $jinput = JFactory::getApplication()->input;
        $liters = $jinput->get('liters');
        $liter_prijs = $jinput->get('liter_prijs');
        $tankbedrag = $liters * $liter_prijs;
        $data['tankbedrag'] = $tankbedrag;
        $data['fuel'] = $fueltype;
    return $data;
}

    public function onAfterApplySave() {
        // require helper file
        JLoader::register('MdfuelHelperReceipts', JPATH_COMPONENT.'/helpers/receipts.php');
       $model = $this->getThisModel();
       $item = $model->getItem();
       $jinput = JFactory::getApplication()->input;
       $carid = $item->get('mdfuel_car_id');
       $current_mileage = MdfuelHelperReceipts::getCurrentMileage($carid);
        // prepare the data and send it to cars database
        $db = JFactory::getDbo();
        $row = new JObject();
        $row->mdfuel_car_id = $carid;
        $row->kmstand = $current_mileage;
       $result = $db->updateObject('#__mdfuel_cars', $row, 'mdfuel_car_id', false);
        return $result;
   }

}
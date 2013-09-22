<?php
/**
 * @package MDTickets
 * @copyright Copyright (c)2013 Martijn Hiddink / mardinkwebdesign.com
 * @license GNU General Public License version 3 or later
 */
// Load the CSS file
//FOFTemplateUtils::addCSS('media://com_mdtickets/css/mdtickets.css');

// Load JQuery
//JHtml::_('bootstrap.framework');
// Load custom js file
//$document = JFactory::getDocument();
//$document->addScript('media/com_mdtickets/js/mdtickets.js');

//load joomla validation
JHTML::_('behavior.formvalidation');
// Load helper
$this->loadHelper('select');

// Load the editor
$editor = JFactory::getEditor();
?>
<div class="container span12">
<form action="index.php" method="post" id="adminForm" class="form-validate" onsubmit="return isValid()"
      enctype="multipart/form-data" xmlns="http://www.w3.org/1999/html"> <!-- added onsubmit="return isValid()"  to prevent saaving-->
    <input type="hidden" name="option" value="com_mdfuel" />
    <input type="hidden" name="view" value="receipt" />
    <input type="hidden" name="task" value="" />
    <input type="hidden" id="mdfuel_receipt_id" name="mdfuel_receipt_id" value="<?php echo $this->item->mdfuel_receipt_id ?>" />
    <input type="hidden" name="<?php echo JFactory::getSession()->getFormToken();?>" value="1" />
    <div class="row">
            <span class="span2 mdfuel_form"><?php echo JText::_('COM_MDFUEL_CARS_FIELD_KENTEKEN') ?></span>
        <?php echo MdfuelHelperSelect::ActiveCars($this->item->mdfuel_car_id, 'mdfuel_car_id', array('class' => 'input')) ?>
    </div>
    <div class="row">
        <span class="span2 mdfuel_form"><?php echo JText::_('COM_MDFUEL_RECEIPT_FIELD_TANKDATUM') ?></span>
        <?php echo JHTML::_('calendar', $this->item->tankdatum, 'tankdatum',  '%Y-%m-%d', array('class' => 'required')); ?>
    </div>
</div>
</form>
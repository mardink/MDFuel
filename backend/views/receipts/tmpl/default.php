<?php
/**
 * @package MDFuel
 * @copyright Copyright (c)2013 Martijn Hiddink / mardinkwebdesign.com
 * @license GNU General Public License version 3 or later
 */

defined('_JEXEC') or die();

JHTML::_('behavior.framework');
// eerst JQuery toevoegen
JHtml::_('bootstrap.framework');
// Load custom js file
$document = JFactory::getDocument();
// Load helper
$this->loadHelper('select');
$this->loadHelper('receipts');
jimport('joomla.application.component.helper');
$hasAjaxOrderingSupport = $this->hasAjaxOrderingSupport();
?>
<div class="row-fluid">
    <div class="span12">
    <form name="adminForm" id="adminForm" action="index.php" method="post">
        <input type="hidden" name="option" id="option" value="com_mdfuel" />
        <input type="hidden" name="view" id="view" value="receipts" />
        <input type="hidden" name="task" id="task" value="browse" />
        <input type="hidden" name="boxchecked" id="boxchecked" value="0" />
        <input type="hidden" name="hidemainmenu" id="hidemainmenu" value="0" />
        <input type="hidden" name="filter_order" id="filter_order" value="<?php echo $this->lists->order; ?>" />
        <input type="hidden" name="filter_order_Dir" id="filter_order_Dir" value="ASC" />
        <input type="hidden" name="<?php echo JFactory::getSession()->getFormToken();?>" value="1" />
        <div id="j-sidebar-container" class="span2">
            <?php echo JHtmlSidebar::render(); ?>
            <hr>
            <div class="filter-select hidden-phone">
                <h4 class="page-header">Filter:</h4>
            <?php echo MdfuelHelperSelect::kenteken($this->getModel()->getState('kenteken'), 'kenteken', array('onchange'=>'this.form.submit();','class' => 'input')) ?><br/>
            <?php echo MdfuelHelperSelect::fuel($this->getModel()->getState('fuel'), 'fuel', array('onchange'=>'this.form.submit();','class' => 'input')) ?>
            </div>
        </div>
        <div id="j-main-container" class="span10">


    <table class="adminlist table table-striped span12" id="itemsList">
            <thead>
<tr>
    <?php if($hasAjaxOrderingSupport !== false): ?>
        <th width="10px">
            <?php echo JHtml::_('grid.sort', '<i class="icon-menu-2"></i>', 'ordering', $this->lists->order_Dir, $this->lists->order, null, 'asc', 'JGRID_HEADING_ORDERING'); ?>
        </th>
    <?php endif; ?>
    <th width="20px">
        <input type="checkbox" name="toggle" value="" onclick="Joomla.checkAll(this);" />
    </th>
    <th>
        <?php echo JHTML::_('grid.sort', 'COM_MDFUEL_RECEIPT_FIELD_TANKDATUM', 'tankdatum', $this->lists->order_Dir, $this->lists->order) ?>
    </th>
    <th class="span2">
        <?php echo JHTML::_('grid.sort', 'COM_MDFUEL_RECIEPTS_FIELD_KENTEKEN', 'mdfuel_car_id', $this->lists->order_Dir, $this->lists->order) ?>
    </th>
    <th class="span2">
        <?php echo JHTML::_('grid.sort', 'COM_MDFUEL_RECEIPTS_FIELD_WINTERBANDEN', 'winterbanden', $this->lists->order_Dir, $this->lists->order) ?>
    </th>
    <th class="span1">
        <?php echo JHTML::_('grid.sort', 'COM_MDFUEL_CARS_FIELD_FUEL', 'fuel', $this->lists->order_Dir, $this->lists->order) ?>
    </th>
    <th class="span2">
        <?php echo JHTML::_('grid.sort', 'COM_MDFUEL_CARS_FIELD_KMSTAND', 'kmstand_tank', $this->lists->order_Dir, $this->lists->order) ?>
    </th>
    <th class="span1">
        <?php echo JHTML::_('grid.sort', 'COM_MDFUEL_RECEIPTS_LITERS', 'liters', $this->lists->order_Dir, $this->lists->order) ?>
    </th>
    <th class="span2">
        <?php echo JHTML::_('grid.sort', 'COM_MDFUEL_RECEIPT_FIELD_PRICE', 'liter_prijs', $this->lists->order_Dir, $this->lists->order) ?>
    </th>
    <th class="span2">
        <?php echo JHTML::_('grid.sort', 'COM_MDFUEL_RECEIPT_FIELD_TOTALPRICE', 'tankbedrag', $this->lists->order_Dir, $this->lists->order) ?>
    </th>
    <th class="span2">
        <?php echo JHTML::_('grid.sort', 'COM_MDFUEL_RECEIPT_FIELD_MILEAGE', 'gereden_km', $this->lists->order_Dir, $this->lists->order) ?>
    </th>
    <th class="span2">
        <?php echo JHTML::_('grid.sort', 'COM_MDFUEL_RECEIPT_FIELD_COMMENT', 'comment', $this->lists->order_Dir, $this->lists->order) ?>
    </th>
    <th width="80">
        <?php echo JHTML::_('grid.sort', 'COM_MDFUEL_CARS_FIELD_ENABLED', 'enabled', $this->lists->order_Dir, $this->lists->order) ?>
    </th>
    </tr>
    </thead>
    <tfoot>
    <tr>
        <td colspan="13">
            <?php if($this->pagination->total > 0) echo $this->pagination->getListFooter() ?>
        </td>

    </tr>
    </tfoot>
<tbody>
<?php if($count = count($this->items)): ?>
<?php
$i = 0;
$m = 1;
foreach($this->items as $item):
$m = 1 - $m;


?>
<tr class="row<?php echo $m?>">
    <?php if($hasAjaxOrderingSupport !== false): ?>
        <td class="order nowrap center hidden-phone">
            <?php if ($this->perms->editstate) :
                $disableClassName = '';
                $disabledLabel	  = '';
                if (!$hasAjaxOrderingSupport['saveOrder']) :
                    $disabledLabel    = JText::_('JORDERINGDISABLED');
                    $disableClassName = 'inactive tip-top';
                endif; ?>
                <span class="sortable-handler <?php echo $disableClassName?>" title="<?php echo $disabledLabel?>" rel="tooltip">
					<i class="icon-menu"></i>
				</span>
                <input type="text" style="display:none"  name="order[]" size="5"
                       value="<?php echo $item->ordering;?>" class="input-mini text-area-order " />
            <?php else : ?>
                <span class="sortable-handler inactive" >
					<i class="icon-menu"></i>
				</span>
            <?php endif; ?>
        </td>
    <?php endif; ?>
    <td><?php echo JHTML::_('grid.id', $i, $item->mdfuel_receipt_id); ?></td>
    <td><span class="tankdatum">
        <a href="index.php?option=com_mdfuel&view=receipt&task=edit&id=<?php echo $item->mdfuel_receipt_id;?>"><?php echo $item->tankdatum; ?></a>
     </span></td>
    <td><span class="kenteken">
    <?php echo MdfuelHelperReceipts::getKenteken($item->mdfuel_car_id);?>
    </span></td>
    <td><span class="tires">
            <?php if ($item->winterbanden == "0") {
                echo JText::_('COM_MDFUEL_RECEIPTS_FIELD_WINTERBANDEN_NO');
            } else {
                echo JText::_('COM_MDFUEL_RECEIPTS_FIELD_WINTERBANDEN_YES');
            } ?>
    </span></td>
     <td><span class="fuel">
            <?php if ($item->fuel == "0") {
                echo JText::_('COM_MDFUEL_CARS_FIELD_FUEL_DIESEL');
            } elseif ($item->fuel == "1") {
                echo JText::_('COM_MDFUEL_CARS_FIELD_FUEL_GAS');
            } elseif ($item->fuel == "2") {
                echo JText::_('COM_MDFUEL_CARS_FIELD_FUEL_LPG');
            } ?>
    </span></td>
    <td><span class="kmstand"><?php echo $item->kmstand_tank;?></span></td>
    <td><span class="liters"><?php echo $item->liters;?></span></td>
    <td><?php echo JText::_('COM_MDFUEL_RECEIPTS_CURRENCY');?><span class="liter_prijs"><?php echo $item->liter_prijs;?></span></td>
    <td><?php echo JText::_('COM_MDFUEL_RECEIPTS_CURRENCY');?><span class="tankbedrag"><?php echo $item->tankbedrag;?></span></td>
    <td><span class="km"><?php echo MdfuelHelperReceipts::getReceiptMileage($item->mdfuel_car_id, $item->tankdatum, $item->kmstand_tank);?></span></td>
    <td><span class="comment">
            <?php if ($item->comment != "") {
                echo $item->comment;
            } else {
                echo " - ";
            }?></span></td>
    <td align="center">
        <?php echo JHtml::_('jgrid.published', $item->enabled, $i, '', $this->perms->editstate); ?>
    </td>
    </tr>

        <?php
    $i++;
endforeach;
    ?>
<?php else : ?>
    <tr>
        <td></td>
        <td colspan="10" align="center"><?php echo JText::_('COM_MDFUEL_COMMON_NOITEMS_LABEL') ?></td>
    </tr>
<?php endif;?>
</tbody>
    </table>
        </div>
    </div>

        </form>
</div>
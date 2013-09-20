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
jimport('joomla.application.component.helper');
$hasAjaxOrderingSupport = $this->hasAjaxOrderingSupport();
?>
<div class="row-fluid">
    <div class="span12">
    <form name="adminForm" id="adminForm" action="index.php" method="post">
        <input type="hidden" name="option" id="option" value="com_mdfuel" />
        <input type="hidden" name="view" id="view" value="cars" />
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
            <?php echo MdfuelHelperSelect::kenteken($this->getModel()->getState('kenteken'), 'kenteken', array('onchange'=>'this.form.submit();','class' => 'input')) ?>
            </div>
        </div>
        <div id="j-main-container" class="span10">

    <div class="row span12">
    <!-- Search in ticket number -->
        <span class="input-append">
    <input type="text" name="mdtickets_item_id" id="mdtickets_item_id"
           value="<?php echo $this->escape($this->getModel()->getState('mdfuel_car_id',''));?>"
           class="text_area input-small" onchange="document.adminForm.submit();"
           placeholder="<?php echo JText::_('COM_MDTICKETS_SEARCH_TICKET') ?>"/>
    <button class="btn" onclick="document.adminForm.mdtickets_item_id.value='';this.form.submit();">
        <i class="icon-cancel"></i>
    </button>
         <button class="btn" onclick="document.adminForm.itoncall.value='';this.form.submit();">
            <i class="icon-cancel"></i>
        </button>
        <button class="btn" onclick="this.form.submit();">
            <i class="icon-search"></i><?php echo JText::_('COM_MDTICKETS_SEARCH_FILTER') ?>
        </button>
            </span>
    </div>
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
        <?php echo JHTML::_('grid.sort', 'COM_MDFUEL_CARS_FIELD_KENTEKEN', 'kenteken', $this->lists->order_Dir, $this->lists->order) ?>
    </th>
    <th class="span1">
        <?php echo JHTML::_('grid.sort', 'COM_MDFUEL_CARS_FIELD_MERK', 'merk', $this->lists->order_Dir, $this->lists->order) ?>
    </th>
    <th class="span1">
        <?php echo JHTML::_('grid.sort', 'COM_MDFUEL_CARS_FIELD_TYPE', 'type', $this->lists->order_Dir, $this->lists->order) ?>
    </th>
    <th class="span1">
        <?php echo JHTML::_('grid.sort', 'COM_MDFUEL_CARS_FIELD_FUEL', 'fuel', $this->lists->order_Dir, $this->lists->order) ?>
    </th>
    <th class="span1">
        <?php echo JHTML::_('grid.sort', 'COM_MDFUEL_CARS_FIELD_KMSTAND', 'kmstand', $this->lists->order_Dir, $this->lists->order) ?>
    </th>
    <th class="span1">
        <?php echo JHTML::_('grid.sort', 'COM_MDFUEL_CARS_FIELD_WINTERBANDENCORRECTIE', 'winterbandencorrectie', $this->lists->order_Dir, $this->lists->order) ?>
    </th>
    <th class="span1">
        <?php echo JHTML::_('grid.sort', 'COM_MDFUEL_CARS_FIELD_TOTAALVERBRUIK', 'totaalverbruik', $this->lists->order_Dir, $this->lists->order) ?>
    </th>
    <th class="span1">
        <?php echo JHTML::_('grid.sort', 'COM_MDFUEL_CARS_FIELD_GEMVERBRUIK', 'gemverbruik', $this->lists->order_Dir, $this->lists->order) ?>
    </th>
    <th class="span1">
        <?php echo JHTML::_('grid.sort', 'COM_MDFUEL_CARS_FIELD_TOTAALBEDRAG', 'totaalbedrag', $this->lists->order_Dir, $this->lists->order) ?>
    </th>
    <th class="span1">
        <?php echo JHTML::_('grid.sort', 'COM_MDFUEL_CARS_FIELD_ACCESS', 'access', $this->lists->order_Dir, $this->lists->order) ?>
    </th>
    <th class="span1">
        <?php echo JHTML::_('grid.sort', 'COM_MDFUEL_CARS_FIELD_ENABLED', 'enabled', $this->lists->order_Dir, $this->lists->order) ?>
    </th>
    </tr>
    </thead>
    <tfoot>
    <tr>
        <td colspan="7">
            <?php if($this->pagination->total > 0) echo $this->pagination->getListFooter() ?>
        </td>
        <td style="padding-top: 29px;" colspan="4"><span><?php echo JText::_('COM_MDFUEL_PAGINATION') ?></span>
        <?php echo MdfuelHelperSelect::pagination($this->getModel()->getState('limit'), 'limit', array('onchange'=>'this.form.submit();','class' => 'input-small')) ?></td>
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
    <td><?php echo JHTML::_('grid.id', $i, $item->mdfuel_car_id); ?></td>
    <td><span class="kenteken">
        <a href="index.php?option=com_mdtickets&view=item&task=edit&id=<?php echo $item->mdfuel_car_id;?>"><?php echo $item->kenteken; ?></a>
     </span></td>
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
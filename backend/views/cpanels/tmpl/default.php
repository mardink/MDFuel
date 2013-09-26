<?php
/**
 * @package MDFuel
 * @copyright Copyright (c)2013 Martijn Hiddink / mardinkwebdesign.com
 * @license GNU General Public License version 3 or later
 */

defined('_JEXEC') or die();

// Load helper
jimport('joomla.application.component.helper');
$this->loadHelper('cpanels');
// Load framework
JHTML::_('behavior.framework');
// eerst JQuery toevoegen
JHtml::_('bootstrap.framework');
// Load jquery file
//FOFTemplateUtils::addJS('media://com_mdfuel/js/mdtickets_dashboard.js');
// load JQPlot js files
FOFTemplateUtils::addJS('media://com_mdfuel/js/jqplot/jquery.jqplot.min.js');
FOFTemplateUtils::addJS('media://com_mdfuel/js/jqplot/jqplot.barRenderer.min.js');
FOFTemplateUtils::addJS('media://com_mdfuel/js/jqplot/jqplot.categoryAxisRenderer.min.js');
FOFTemplateUtils::addJS('media://com_mdfuel/js/jqplot/jqplot.pointLabels.min.js');
FOFTemplateUtils::addJS('media://com_mdfuel/js/jqplot/jqplot.pieRenderer.min.js');

// Load the CSS files
//FOFTemplateUtils::addCSS('media://com_mdfuel/css/mdfuel.css');
FOFTemplateUtils::addCSS('media://com_mdfuel/css/jquery.jqplot.min.css');
?>
<div id="j-sidebar-container" class="span2">
	<?php echo JHtmlSidebar::render(); ?>
</div>
<div id="j-main-container" class="span10">
    <!-- Row for jQplot graphs -->
    <div class="row">
        <div class="span6">
            <div id="chart1" style="height:300px;width:600px; "></div>
        </div>
</div>
<!-- Begin scripts ofr graphs see JQplot webiste for more information -->
<?php // prepare data for graphs
$charts1 = MdfuelHelperCpanels::getFuelperMonth();

?>
<!-- Script chart1 -->
<script>
    jQuery(document).ready(function(){
        var s1 = [<?php foreach($charts1 as $chart1){ echo $chart1->liter . ', ';}?>]
        // Can specify a custom tick Array.
        // Ticks should match up one for each y value (category) in the series.
        var ticks = [<?php foreach($charts1 as $chart1){ echo '\'' .$chart1->month . '\', '; }?>];
        var plot1 = jQuery.jqplot('chart1', [s1], {
            // The "seriesDefaults" option is an options object that will
            // be applied to all series in the chart.
            seriesDefaults:{
                renderer:jQuery.jqplot.BarRenderer,
                rendererOptions: {fillToZero: true},
                pointLabels: {show: true} // laat de waarde van de bar zien
            },
            // Custom labels for the series are specified with the "label"
            // option on the series option.  Here a series option object
            // is specified for each series.
            series:[
                {label:'Liters per month'}
            ],
            // Show the legend and put it outside the grid, but inside the
            // plot container, shrinking the grid to accomodate the legend.
            // A value of "outside" would not shrink the grid and allow
            // the legend to overflow the container.
            legend: {
                show: true,
                placement: 'outsideGrid'
            },
            axes: {
                // Use a category axis on the x axis and use our custom ticks.
                xaxis: {
                    renderer: jQuery.jqplot.CategoryAxisRenderer,
                    ticks: ticks
                },
                // Pad the y axis just a little so bars can get close to, but
                // not touch, the grid boundaries.  1.2 is the default padding.
                yaxis: {
                    pad: 1.05,

                    //tickOptions: {formatString: '$%d'}
                }
            }

        });
    });
</script>
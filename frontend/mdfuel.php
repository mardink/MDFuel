<?php
//*
* @package MDFuel
* @copyright Copyright (c)2013 Martijn Hiddink / mardinkwebdesign.com
* @license GNU General Public License version 2 or later
*/

defined('_JEXEC') or die();

require_once JPATH_LIBRARIES.'/fof/include.php';

FOFDispatcher::getTmpInstance('com_mdfuel')->dispatch();
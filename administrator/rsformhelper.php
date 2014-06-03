<?php
/**
 * @version     1.0.2
 * @package     com_rsformhelper
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Rene Kreijveld <email@renekreijveld.nl> - http://www.renekreijveld.nl
 */


// no direct access
defined('_JEXEC') or die;

// Access check.
if (!JFactory::getUser()->authorise('core.manage', 'com_rsformhelper')) 
{
	throw new Exception(JText::_('JERROR_ALERTNOAUTHOR'));
}

// Include dependancies
jimport('joomla.application.component.controller');

$controller	= JControllerLegacy::getInstance('Rsformhelper');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();
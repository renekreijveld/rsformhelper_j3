<?php

/**
 * @version     1.0.2
 * @package     com_rsformhelper
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Rene Kreijveld <email@renekreijveld.nl> - http://www.renekreijveld.nl
 */
// No direct access
defined('_JEXEC') or die;

/**
 * Rsformhelper helper.
 */
class RsformhelperBackendHelper {

    /**
     * Configure the Linkbar.
     */
    public static function addSubmenu($vName = '') {
        		JHtmlSidebar::addEntry(
			JText::_('COM_RSFORMHELPER_TITLE_FORMSELECTS'),
			'index.php?option=com_rsformhelper&view=formselects',
			$vName == 'formselects'
		);

    }

    /**
     * Gets a list of the actions that can be performed.
     *
     * @return	JObject
     * @since	1.6
     */
    public static function getActions() {
        $user = JFactory::getUser();
        $result = new JObject;

        $assetName = 'com_rsformhelper';

        $actions = array(
            'core.admin', 'core.manage', 'core.create', 'core.edit', 'core.edit.own', 'core.edit.state', 'core.delete'
        );

        foreach ($actions as $action) {
            $result->set($action, $user->authorise($action, $assetName));
        }

        return $result;
    }


}

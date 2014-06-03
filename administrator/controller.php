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

class RsformhelperController extends JControllerLegacy {

    /**
     * Method to display a view.
     *
     * @param	boolean			$cachable	If true, the view output will be cached
     * @param	array			$urlparams	An array of safe url parameters and their variable types, for valid values see {@link JFilterInput::clean()}.
     *
     * @return	JController		This object to support chaining.
     * @since	1.5
     */
    public function display($cachable = false, $urlparams = false) {
        require_once JPATH_COMPONENT . '/helpers/rsformhelper.php';

        $view = JFactory::getApplication()->input->getCmd('view', 'formselects');
        JFactory::getApplication()->input->set('view', $view);

        parent::display($cachable, $urlparams);

        return $this;
    }

}
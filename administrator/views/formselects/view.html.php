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

jimport('joomla.application.component.view');

/**
 * View class for a list of Rsformhelper.
 */
class RsformhelperViewFormselects extends JViewLegacy
{
	protected $items;
	protected $pagination;
	protected $state;

	/**
	 * Display the view
	 */
	public function display($tpl = null)
	{
		$this->state = $this->get('State');
		$this->items = $this->get('Items');

		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			throw new Exception(implode("\n", $errors));
		}
        
		// RsformhelperBackendHelper::addSubmenu('Formselect');
        
		$this->addToolbar();
        
        $this->sidebar = JHtmlSidebar::render();
		parent::display($tpl);
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @since	1.6
	 */
	protected function addToolbar()
	{
		require_once JPATH_COMPONENT.'/helpers/rsformhelper.php';

		$state	= $this->get('State');
		$canDo	= RsformhelperBackendHelper::getActions($state->get('filter.category_id'));

		JToolBarHelper::title(JText::_('COM_RSFORMHELPER_TITLE_FORMSELECTS'), 'formselects.png');

		if ($canDo->get('core.admin')) {
			JToolBarHelper::preferences('com_rsformhelper');
		}
        
        //Set sidebar action - New in 3.0
		JHtmlSidebar::setAction('index.php?option=com_rsformhelper&view=formselects');
        
        $this->extra_sidebar = '';
        //
        
	}
    
	protected function getSortFields()
	{
		return array();
	}

}

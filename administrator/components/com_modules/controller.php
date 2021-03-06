<?php
/**
 * @version		$Id: controller.php 19281 2010-10-29 10:12:49Z eddieajau $
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

jimport('joomla.application.component.controller');

/**
 * Modules manager master display controller.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_modules
 * @since		1.6
 */
class ModulesController extends JController
{
	/**
	 * Method to display a view.
	 *
	 * @param	boolean			If true, the view output will be cached
	 * @param	array			An array of safe url parameters and their variable types, for valid values see {@link JFilterInput::clean()}.
	 *
	 * @return	JController		This object to support chaining.
	 * @since	1.5
	 */
	public function display($cachable = false, $urlparams = false)
	{
		require_once JPATH_COMPONENT.'/helpers/modules.php';

		// Load the submenu.
		ModulesHelper::addSubmenu(JRequest::getWord('view', 'modules'));

		$view		= JRequest::getWord('view', 'modules');
		$layout 	= JRequest::getWord('layout', 'default');
		$id			= JRequest::getInt('id');

		// Check for edit form.
		if ($view == 'module' && $layout == 'edit' && !$this->checkEditId('com_modules.edit.module', $id)) {
			// Somehow the person just went to the form - we don't allow that.
			$this->setError(JText::sprintf('JLIB_APPLICATION_ERROR_UNHELD_ID', $id));
			$this->setMessage($this->getError(), 'error');
			$this->setRedirect(JRoute::_('index.php?option=com_modules&view=modules', false));

			return false;
		}

		parent::display();
	}
}
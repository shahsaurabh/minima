<?php
/**
 * @version		$Id: logout.php 19527 2010-11-17 13:58:55Z chdemko $
 * @package		Joomla
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_BASE') or die;

jimport('joomla.plugin.plugin');
jimport('joomla.error.error');
jimport('joomla.utilities.utility');

/**
 * Plugin class for logout redirect handling.
 *
 * @package		Joomla
 * @subpackage	plgSystemLogout
 */
class plgSystemLogout extends JPlugin
{
	/**
	 * Object Constructor.
	 *
	 * @access	public
	 * @param	object	The object to observe -- event dispatcher.
	 * @param	object	The configuration object for the plugin.
	 * @return	void
	 * @since	1.0
	 */
	function __construct(&$subject, $config)
	{
		parent::__construct($subject, $config);

		$hash = JUtility::getHash('plgSystemLogout');
		if (JFactory::getApplication()->isSite() and JRequest::getString($hash, null ,'cookie'))
		{
			// Destroy the cookie
			$conf = JFactory::getConfig();
			$cookie_domain 	= $conf->get('config.cookie_domain', '');
			$cookie_path 	= $conf->get('config.cookie_path', '/');
			setcookie($hash, false, time() - 86400, $cookie_path, $cookie_domain);

			// Set the error handler for E_ALL to be the class handleError method.
			JError::setErrorHandling(E_ALL, 'callback', array('plgSystemLogout', 'handleError'));
		}
	}

	/**
	 * This method should handle any logout logic and report back to the subject
	 *
	 * @param	array	$user		Holds the user data.
	 * @param	array	$options	Array holding options (client, ...).
	 *
	 * @return	object	True on success
	 * @since	1.5
	 */
	public function onUserLogout($user, $options = array())
	{
		if (JFactory::getApplication()->isSite())
		{
			// Create the cookie
			$hash = JUtility::getHash('plgSystemLogout');
			$conf = JFactory::getConfig();
			$cookie_domain 	= $conf->get('config.cookie_domain', '');
			$cookie_path 	= $conf->get('config.cookie_path', '/');
			setcookie($hash, true, time() + 86400, $cookie_path, $cookie_domain);
		}
		return true;
	}

	static function handleError(&$error)
	{
		// Get the application object.
		$app = JFactory::getApplication();

		// Make sure the error is a 403 and we are in the frontend.
		if ($error->getCode() == 403 and $app->isSite()) {
			// Redirect to the home page
			$lang = JFactory::getLanguage();
			$lang->load('plg_system_logout', JPATH_ADMINISTRATOR, null, false, false)
		||	$lang->load('plg_system_logout', JPath::clean(JPATH_PLUGINS . "/system/logout"), null, false, false)
		||	$lang->load('plg_system_logout', JPATH_ADMINISTRATOR, $lang->getDefault(), false, false)
		||	$lang->load('plg_system_logout', JPath::clean(JPATH_PLUGINS . "/system/logout"), $lang->getDefault(), false, false);
			$app->redirect('index.php', JText::_('PLG_SYSTEM_LOGOUT_REDIRECT'), null, true, false);
		}
		else {
			// Render the error page.
			JError::customErrorPage($error);
		}
	}
}

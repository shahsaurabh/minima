<?php
/** 
 * @package     Minima
 * @author      Marco Barbosa
 * @copyright   Copyright (C) 2010 Webnific. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;
$user = JFactory::getUser();

$gravatar_hash =  md5( strtolower( trim( $user->email ) ) );
echo "<ul id=\"user-status\">";
    echo "<li class=\"pic\"><a href=\"index.php?option=com_admin&amp;task=profile.edit\"><img id=\"gravatar\" src=\"http://www.gravatar.com/avatar/$gravatar_hash?d=mm&s=26\" alt=\"$user->name\" /></a></li>";
    echo "<li><a href=\"index.php?option=com_admin&amp;task=profile.edit\">".$user->username."</a></li>";
    echo "<li><span class=\"$inboxClass\"><a href=\"$inboxLink\">". $unread . "</a></span></li>";
    echo "<li><a href=\"index.php?option=com_login&amp;task=logout\">".JText::_('mod_status_Log_out')."</a></li>";
echo "</ul>";
<?php
/**
 * @version		$Id: edit_options.php 19648 2010-11-25 12:00:06Z infograf768 $
 * @package		Joomla.Administrator
 * @subpackage	templates.hathor
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @since		1.6
 */

// No direct access.
defined('_JEXEC') or die; ?>
 
<?php echo JHtml::_('sliders.panel',JText::_('JGLOBAL_FIELDSET_PUBLISHING'), 'publishing-details'); ?>
 
	<fieldset class="panelform">
	<legend class="element-invisible"><?php echo JText::_('COM_CONTENT_FIELDSET_PUBLISHING'); ?></legend>
		<ul class="adminformlist">
		
			<li><?php echo $this->form->getLabel('created_user_id'); ?>
			<?php echo $this->form->getInput('created_user_id'); ?></li>

			<li><?php echo $this->form->getLabel('created_time'); ?>
			<?php echo $this->form->getInput('created_time'); ?></li>

			<?php if ($this->item->modified_user_id) : ?>
				<li><?php echo $this->form->getLabel('modified_user_id'); ?>
				<?php echo $this->form->getInput('modified_user_id'); ?></li>

				<li><?php echo $this->form->getLabel('modified_time'); ?>
				<?php echo $this->form->getInput('modified_time'); ?></li>
			<?php endif; ?>
			
		</ul>
	</fieldset>

<?php $fieldSets = $this->form->getFieldsets('params');

foreach ($fieldSets as $name => $fieldSet) :
	$label = !empty($fieldSet->label) ? $fieldSet->label : 'COM_CATEGORIES_'.$name.'_FIELDSET_LABEL';
	echo JHtml::_('sliders.panel',JText::_($label), $name.'-options');
		if (isset($fieldSet->description) && trim($fieldSet->description)) :
			echo '<p class="tip">'.$this->escape(JText::_($fieldSet->description)).'</p>';
		endif;
		?>
	<fieldset class="panelform">
	<legend class="element-invisible"><?php echo JText::_($label); ?></legend>
	<ul class="adminformlist">
		<?php foreach ($this->form->getFieldset($name) as $field) : ?>
			<li><?php echo $field->label; ?>
			<?php echo $field->input; ?></li>
		<?php endforeach; ?>
       	<li><?php echo $this->form->getLabel('note'); ?>
		<?php echo $this->form->getInput('note'); ?></li>

	</ul>
	</fieldset>
<?php endforeach; ?>

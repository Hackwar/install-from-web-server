<?php
/**
 * Joomla! Install From Web Server
 *
 * @copyright  Copyright (C) 2013 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later
 */

defined('JPATH_BASE') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;

$extension_data = $displayData['extension'];
$breadcrumbs    = $displayData['breadcrumbs'];
$tags           = $extension_data->includes->value;
?>
<div class="item-view">
	<div class="grid-header">
		<ul class="breadcrumb">
			<li><a class="transcode" href="<?php echo AppsHelper::getAJAXUrl(['view' => 'dashboard']); ?>"><?php echo Text::_('COM_APPS_EXTENSIONS'); ?></a></li>
			<?php foreach ($breadcrumbs as $bc) : ?>
				<span class="divider"> / </span>
				<li><a class="transcode" href="<?php echo AppsHelper::getAJAXUrl(['view' => 'category', 'id' => $bc->id]); ?>"><?php echo $bc->name; ?></a></li>
			<?php endforeach; ?>
			<span class="divider"> / </span>
			<li><?php echo $extension_data->core_title->value; ?></li>
		</ul>
	</div>
	<div class="full-item-container">
		<h2>
			<span><?php echo $extension_data->core_title->value; ?></span>
			<?php if ($extension_data->popular->value == 1): ?>
				 <span class="label label-info"><?php echo Text::_('COM_APPS_POPULAR_TEXT'); ?></span>
			<?php endif; ?>
		</h2>

		<div id="item-left-container" class="pull-left">
			<img class="img img-polaroid" src="<?php echo $extension_data->image; ?>" width="200">
		</div>

		<div class="item-info-container pull-left">
			<div class="rating">
				<a target="_blank" href="<?php echo AppsHelper::getJEDUrl($extension_data) . '#reviews'; ?>">
					<?php echo strip_tags(Text::sprintf('COM_APPS_EXTENSION_VOTES_REVIEWS_LIST', $extension_data->score->value, $extension_data->num_reviews->value)); ?>
				</a>
			</div>
			<div class="item-version control-group">
				<div class="control-label">
					<?php echo Text::_('COM_APPS_EXTENSION_VERSION'); ?>
				</div>
				<div class="controls">
					<?php echo $extension_data->version->value; ?>
					<?php if ($extension_data->core_modified_time->value != '0000-00-00 00:00:00') : ?>
						<?php echo ' ' . Text::sprintf('COM_APPS_EXTENSION_LAST_UPDATE', HTMLHelper::_('date', $extension_data->core_modified_time->value)); ?>
					<?php endif; ?>
				</div>
			</div>
			<?php if ($extension_data->license->value): ?>
				<div class="item-license control-group">
					<div class="control-label">
						<?php echo Text::_('COM_APPS_EXTENSION_LICENSE', $extension_data->license->text); ?>
					</div>
					<div class="controls">
						<?php echo $extension_data->license->text; ?>
						&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
						<span><?php echo $extension_data->type->text; ?></span>
					</div>
				</div>
			<?php endif; ?>
			<div class="item-addedon control-group">
				<div class="control-label">
					<?php echo Text::_('COM_APPS_EXTENSION_ADDEDON'); ?>
				</div>
				<div class="controls">
					<?php echo HTMLHelper::date($extension_data->core_created_time->value); ?>
				</div>
			</div>
			<div class="item-badge-container">
				<?php if (in_array('com', $tags)) : ?>
					<span title="<?php echo Text::_('COM_APPS_COMPONENT'); ?>" class="badge jbadge badge-jcomponent"><?php echo Text::_('COM_APPS_COMPONENT'); ?></span>&nbsp;
				<?php endif; ?>
				<?php if (in_array('lang', $tags)) : ?>
					<span title="<?php echo Text::_('COM_APPS_LANGUAGE'); ?>" class="badge jbadge badge-jlanguage"><?php echo Text::_('COM_APPS_LANGUAGE'); ?></span>&nbsp;
				<?php endif; ?>
				<?php if (in_array('mod', $tags)) : ?>
					<span title="<?php echo Text::_('COM_APPS_MODULE'); ?>" class="badge jbadge badge-jmodule"><?php echo Text::_('COM_APPS_MODULE'); ?></span>&nbsp;
				<?php endif; ?>
				<?php if (in_array('plugin', $tags)) : ?>
					<span title="<?php echo Text::_('COM_APPS_PLUGIN'); ?>" class="badge jbadge badge-jplugin"><?php echo Text::_('COM_APPS_PLUGIN'); ?></span>&nbsp;
				<?php endif; ?>
				<?php if (in_array('esp', $tags)) : ?>
					<span title="<?php echo Text::_('COM_APPS_EXTENSION_SPECIFIC_ADDON'); ?>" class="badge jbadge badge-jspecial"><?php echo Text::_('COM_APPS_EXTENSION_SPECIFIC_ADDON'); ?></span>&nbsp;
				<?php endif; ?>
				<?php if (in_array('tool', $tags)) : ?>
					<span title="<?php echo Text::_('COM_APPS_TOOL'); ?>" class="badge jbadge badge-jtool"><?php echo Text::_('COM_APPS_TOOL'); ?></span>
				<?php endif; ?>
			</div>
		</div>

		<div class="clearfix"></div>

		<?php if ($extension_data->download_type > 1): ?>
			<input id="joomlaapsinstallatinput" type="hidden" name="installat" value="" />
			<input id="joomlaapsinstallfrominput" type="hidden" name="installfrom" value="<?php echo $extension_data->downloadurl; ?>" />
			<input type="hidden" name="installapp" value="<?php echo $extension_data->link_id ?? null; ?>" />
		<?php endif; ?>
		<div class="item-buttons form-actions">
			<?php if ($extension_data->downloadurl && is_numeric($extension_data->download_type)): ?>
				<?php if ($extension_data->download_type == 0): ?>
					<a target="_blank" class="transcode install btn btn-success" href="<?php echo $extension_data->downloadurl; ?>"><span class="icon-download" aria-hidden="true" aria-hidden="true"></span> <?php echo Text::_('COM_APPS_INSTALL_DOWNLOAD_EXTERNAL') . "&hellip;"; ?></a>
				<?php elseif ($extension_data->download_type == 1): ?>
					<a class="install btn btn-success" href="#" onclick="return Joomla.installfromweb('<?php echo $extension_data->downloadurl; ?>', '<?php echo $extension_data->core_title->value; ?>')"><span class="icon-checkmark" aria-hidden="true" aria-hidden="true"></span> <?php echo Text::_('COM_APPS_INSTALL') . "&hellip;"; ?></a>
				<?php elseif ($extension_data->download_type == 2): ?>
					<button class="install btn btn-success" id="appssubmitbutton" onclick="return Joomla.installfromwebexternal('<?php echo $extension_data->downloadurl; ?>');" type="submit"><span class="icon-pencil" aria-hidden="true" aria-hidden="true"></span> <?php echo Text::_('COM_APPS_INSTALL_REGISTER') . "&hellip;"; ?></button>
				<?php elseif ($extension_data->download_type == 3): ?>
					<button class="install btn btn-success" id="appssubmitbutton" onclick="return Joomla.installfromwebexternal('<?php echo $extension_data->downloadurl; ?>');" type="submit"><span class="icon-cart" aria-hidden="true" aria-hidden="true"></span> <?php echo Text::_('COM_APPS_INSTALL_PURCHASE') . "&hellip;"; ?></button>
				<?php endif; ?>&nbsp;&nbsp;&nbsp;
			<?php elseif ($extension_data->download_link->value) : ?>
				<?php if ((is_numeric($extension_data->download_type) && $extension_data->download_type == 0) || $extension_data->download_type == 1 || (strtolower($extension_data->download_type->value) == "free" && !$extension_data->requires_registration->value)): ?>
					<a target="_blank" class="transcode install btn btn-success" href="<?php echo $extension_data->download_link->value; ?>"><span class="icon-download" aria-hidden="true" aria-hidden="true"></span> <?php echo Text::_('COM_APPS_INSTALL_DOWNLOAD_EXTERNAL') . "&hellip;"; ?></a>
				<?php elseif ($extension_data->download_type == 2 || (strtolower($extension_data->download_type->value) == "free" && $extension_data->requires_registration->value)): ?>
					<a target="_blank" class="install btn btn-success" href="<?php echo $extension_data->download_link->value; ?>"><span class="icon-pencil" aria-hidden="true" aria-hidden="true"></span> <?php echo Text::_('COM_APPS_INSTALL_REGISTER_DOWNLOAD_EXTERNAL') . "&hellip;"; ?></a>
				<?php elseif ($extension_data->download_type == 3 || (strtolower($extension_data->download_type->value) != "free")): ?>
					<a target="_blank" class="install btn btn-success" href="<?php echo $extension_data->download_link->value; ?>"><span class="icon-cart" aria-hidden="true" aria-hidden="true"></span> <?php echo Text::_('COM_APPS_INSTALL_PURCHASE_EXTERNAL') . "&hellip;"; ?></a>
				<?php endif; ?>&nbsp;&nbsp;&nbsp;
			<?php endif; ?>
			<a target="_blank" class="btn btn-primary" href="<?php echo AppsHelper::getJEDUrl($extension_data); ?>"><span class="icon-list" aria-hidden="true" aria-hidden="true"></span> <?php echo Text::_('COM_APPS_DIRECTORY_LISTING'); ?></a>
			<?php if ($extension_data->homepage_link->value) : ?>
				&nbsp;&nbsp;&nbsp;<a target="_blank" class="btn btn-primary" href="<?php echo $extension_data->homepage_link->text; ?>"><span class="icon-share-alt" aria-hidden="true" aria-hidden="true"></span> <?php echo Text::_('COM_APPS_DEVELOPER_WEBSITE'); ?></a>
			<?php endif; ?>
		</div>
		<div class="item-desc">
			<p class="item-desc-title">
				<strong><?php echo $extension_data->core_title->text; ?></strong>
				<?php if ($extension_data->core_created_user_id->value): ?>
					 <?php echo Text::sprintf('COM_APPS_EXTENSION_AUTHOR', $extension_data->core_created_user_id->text); ?>
				<?php endif; ?>
			</p>
			<p class="item-desc-text" align="justify">
				<?php echo nl2br($extension_data->core_body->text); ?>
			</p>
		</div>
		<div class="clearfix"></div>
	</div>
	<hr class="bottom-dash"></hr>
</div>

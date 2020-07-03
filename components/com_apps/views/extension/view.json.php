<?php
/**
 * Joomla! Install From Web Server
 *
 * @copyright  Copyright (C) 2013 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\MVC\View\HtmlView;
use Joomla\CMS\Response\JsonResponse;

/**
 * Extension view class
 *
 * @since  1.0
 */
class AppsViewExtension extends HtmlView
{
	/**
	 * @var    array
	 * @since  1.0
	 */
	protected $breadcrumbs = [];

	/**
	 * @var    array
	 * @since  1.0
	 */
	protected $categories = [];

	/**
	 * @var    stdClass
	 * @since  1.0
	 */
	protected $extension;

	/**
	 * @var    string
	 * @since  1.0
	 */
	protected $release = '';

	/**
	 * @var    string
	 * @since  1.0
	 */
	protected $pluginVersion = '';

	/**
	 * Execute and display a template script.
	 *
	 * @param   string $tpl The name of the template file to parse; automatically searches through the template paths.
	 *
	 * @return  mixed  A string if successful, otherwise an Error object.
	 *
	 * @since   1.0
	 */
	public function display($tpl = null)
	{
		$app = Factory::getApplication();
		$app->allowCache(true);

		if ($app->input->getCmd('callback', ''))
		{
			$this->document->setMimeEncoding('application/javascript');
		}

		$this->extension     = $this->get('Extension');
		$this->categories    = $this->get('Categories');
		$this->breadcrumbs   = $this->get('Breadcrumbs');
		$this->release       = $this->getModel()->getState('filter.release');
		$this->pluginVersion = $this->getModel()->getState('plugin_version');

		$json = new JsonResponse(
			[
				'html'           => iconv("UTF-8", "UTF-8//IGNORE", $this->loadTemplate($tpl)),
				'pluginuptodate' => $this->get('PluginUpToDate'),
			]
		);

		if ($app->input->getCmd('callback', ''))
		{
			echo str_replace(['\n', '\t'], '', $app->input->get('callback') . '(' . $json . ')');
		}
		else
		{
			echo str_replace(['\n', '\t'], '', $json);
		}
	}
}

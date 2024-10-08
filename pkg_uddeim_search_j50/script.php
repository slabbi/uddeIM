<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  Search
 *
 * @copyright   (C) 2005 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Installer\InstallerScript;

/**
 * Installation class to perform additional changes during install/uninstall/update
 *
 * @since  4.1.0
 */
class Pkg_SearchInstallerScript extends InstallerScript
{
	/**
	 * Extension script constructor.
	 *
	 * @return  void
	 *
	 * @since   4.1.0
	 */
	public function __construct()
	{
		$this->minimumJoomla = '4.2.0';
		$this->minimumPhp    = JOOMLA_MINIMUM_PHP;
	}
}

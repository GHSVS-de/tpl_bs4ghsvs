<?php
defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Installer\InstallerScript;
use Joomla\CMS\Log\Log;

class  bs4ghsvsInstallerScript extends InstallerScript
{
	/**
	 * A list of files to be deleted with method removeFiles().
	 *
	 * @var    array
	 * @since  2.0
	 */
	protected $deleteFiles = [
		'/templates/bs4ghsvs/html/com_content/category/blogghsvs-bs_footableghsvs.php',
		'/templates/bs4ghsvs/html/com_content/category/blogghsvs-bs_listeghsvs.php',
		'/templates/bs4ghsvs/favicon.ico',
		// JQuery free Venobox 2 doesn't need that anymore.
		'/templates/bs4ghsvs/css/venobox.css',
		'/templates/bs4ghsvs/css/venobox.css.map',
		'/templates/bs4ghsvs/css/venobox.min.css',
		'/templates/bs4ghsvs/css/venobox.min.css.map',
		'/templates/bs4ghsvs/html/com_osmap/html/defaultold.php',
		'/templates/bs4ghsvs/scss-ghsvs/__________venobox.scss',
		'/templates/bs4ghsvs/scss-ghsvs/_____________venobox.scss',
		'/templates/bs4ghsvs/scss-ghsvs/_reboot-bug-fix-5.1.0.scss',
		'/templates/bs4ghsvs/scss-ghsvs/_buttons.scss',
		'/templates/bs4ghsvs/scss-ghsvs/_caret.scss',
		'/templates/bs4ghsvs/scss-ghsvs/_collapse.scss',
		'/templates/bs4ghsvs/scss-ghsvs/_dropdown.scss',
		'/templates/bs4ghsvs/scss-ghsvs/_navbar-old.scss',
		'/templates/bs4ghsvs/scss-ghsvs/_text-styles-fuer-Arbeitsseite.scss',
	];

	/**
	 * A list of folders to be deleted with method removeFiles().
	 *
	 * @var    array
	 * @since  2.0
	 */
	protected $deleteFolders = [
		'/templates/bs4ghsvs/html/com_tags',
		'/templates/bs4ghsvs/less',
		'/templates/bs4ghsvs/html/layouts/com_contact/joomla/system',
		'/templates/bs4ghsvs/js/system',
		'/templates/bs4ghsvs/js/plg_system_bs3ghsvs/bootstrap',
		'/templates/bs4ghsvs/scss-ghsvs/_fontawesome-free.scss',
		'/templates/bs4ghsvs/scss-ghsvs/_icomoon2fontawseome-free.scss',
		'/templates/bs4ghsvs/scss-ghsvs/_icomoon2fontawseome-free_base.scss',
		'/templates/bs4ghsvs/scss-ghsvs/_icomoon2fontawseome-free_small.scss',
	];

	public function preflight($type, $parent)
	{
		$manifest = @$parent->getManifest();

		if ($manifest instanceof SimpleXMLElement)
		{
			if ($type === 'update' || $type === 'install' || $type === 'discover_install')
			{
				$minimumPhp = trim((string) $manifest->minimumPhp);
				$minimumJoomla = trim((string) $manifest->minimumJoomla);

				// Custom
				$maximumPhp = trim((string) $manifest->maximumPhp);
				$maximumJoomla = trim((string) $manifest->maximumJoomla);

				$this->minimumPhp = $minimumPhp ? $minimumPhp : $this->minimumPhp;
				$this->minimumJoomla = $minimumJoomla ? $minimumJoomla : $this->minimumJoomla;

				if ($maximumJoomla && version_compare(JVERSION, $maximumJoomla, '>'))
				{
					$msg = 'Your Joomla version (' . JVERSION . ') is too high for this extension. Maximum Joomla version is: ' . $maximumJoomla . '.';
					Log::add($msg, Log::WARNING, 'jerror');
				}

				// Check for the maximum PHP version before continuing
				if ($maximumPhp && version_compare(PHP_VERSION, $maximumPhp, '>'))
				{
					$msg = 'Your PHP version (' . PHP_VERSION . ') is too high for this extension. Maximum PHP version is: ' . $maximumPhp . '.';

					Log::add($msg, Log::WARNING, 'jerror');
				}

				if (isset($msg))
				{
					return false;
				}
			}

			if (trim((string) $manifest->allowDowngrades))
			{
				$this->allowDowngrades = true;
			}
		}

		if (!parent::preflight($type, $parent))
		{
			return false;
		}

		if ($type === 'update')
		{
			$this->removeOldUpdateservers();
		}

		return true;
	}

	/**
	 * Runs right after any installation action is preformed on the component.
	 *
	 * @param  string    $type   - Type of PostFlight action. Possible values are:
	 *                           - * install
	 *                           - * update
	 *                           - * discover_install
	 * @param  \stdClass $parent - Parent object calling object.
	 *
	 * @return void
	 */
	function postflight($type, $parent)
	{
		if ($type === 'update')
		{
			$this->removeFiles();
		}
	}

	/**
	 * Remove the outdated updateservers.
	 *
	 * @return  void
	 *
	 * @since   version after 2019.05.29
	 */
	protected function removeOldUpdateservers()
	{
		$db = Factory::getDbo();

		try
		{
			$query = $db->getQuery(true);

			$query->select('update_site_id')
				->from($db->qn('#__update_sites'))
				->where($db->qn('location') . ' = '
					. $db->q('https://raw.githubusercontent.com/GHSVS-de/upadateservers/master/bs4ghsvs-update.xml'));

			$ids = $db->setQuery($query)->loadAssocList('update_site_id');

			if (!$ids)
			{
				return;
			}

			$ids = array_keys($ids);
			$ids =implode(',', $ids);

			// Delete from update sites
			$db->setQuery(
				$db->getQuery(true)
					->delete($db->qn('#__update_sites'))
					->where($db->qn('update_site_id') . ' IN (' . $ids . ')')
			)->execute();

			// Delete from update sites extensions
			$db->setQuery(
				$db->getQuery(true)
					->delete($db->qn('#__update_sites_extensions'))
					->where($db->qn('update_site_id') . ' IN (' . $ids . ')')
			)->execute();
		}
		catch (Exception $e)
		{
			return;
		}
	}
}

<?php
/**
 * @package    Mod_Competition_Search_Participants
 * @author     Dmitry Rekun <support@norrnext.com>
 * @copyright  Copyright (C) 2015 - 2020 NorrNext. All rights reserved.
 * @license    GNU General Public License version 3 or later; see license.txt
 */
defined('_JEXEC') or die();
/* Check that Norr Competition is installed */

if (! file_exists(JPATH_ROOT . '/components/com_competition/includes/defines.php')) {
    echo 'Please install NorrCompetition';

    return;
}
require_once __DIR__ . '/helper.php';

use Joomla\CMS\Factory;
use Joomla\Database\DatabaseInterface;
use Joomla\CMS\Uri\Uri;

$db = Factory::getContainer()->get(DatabaseInterface::class);

require_once __DIR__ . '/helper.php';


$photo_path = \Joomla\CMS\Uri\Uri::root() . 'NorrCompetitionImages/photos/';

$award_names= ModCompetitionGalleryHelper::getAwardTitles($db);

$all_items = array();

$competitions=$params->get('competition_id');

foreach($competitions as $competition_id) {
   // var_dump($competition_id);
$items = ModCompetitionGalleryHelper::getItemsForSingleCompetition($db, $competition_id, $award_names);
$items = ModCompetitionGalleryHelper::getPhotoPaths($items, $photo_path);
$all_items = array_merge($all_items, $items);
}
/*
 echo '<pre>';
 print_r($all_items);
 echo '</pre>';
 exit();
 */
 

require JModuleHelper::getLayoutPath('mod_competition_gallery', $params->get('layout', 'default'));

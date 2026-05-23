<?php
/**
 * @package    Mod_Competition_Gallery
 * @license    GNU General Public License version 3 or later; see license.txt
 */
defined('_JEXEC') or die();

use Joomla\Registry\Registry;

JModelLegacy::addIncludePath(JPATH_SITE . '/components/com_competition/models', 'CompetitionModel');
JLoader::discover('Competition', JPATH_SITE . '/components/com_competition/libraries');

/**
 * The helper class for module
 *
 * @since 1.0
 */
abstract class ModCompetitionGalleryHelper
{

  
    /**
     * This finds all items in a single competition. maybe take out the stuff to do with ordering as I don't think we care?
     *
     * @param unknown $db
     * @param unknown $competitionId
     * @param unknown $groups
     */
    public static function getItemsForSingleCompetition($db, $competition_id, $award_names)
    {

        $query = $db->getQuery(true);
        
  
        $query->select([
            $db->quoteName('a.id'),
            $db->quoteName('a.competition_id'),
            $db->quoteName('a.title'),
            $db->quoteName('b.photo'),
            $db->quoteName('d.value', 'name'),
            'GROUP_CONCAT(' . $db->quoteName('e.value') . ' SEPARATOR \',\') AS ' . $db->quoteName('award')
        ])
        ->from($db->quoteName('#__competition_participants', 'a'))
        ->join('LEFT', $db->quoteName('#__competition_participants_photos', 'b'), $db->quoteName('a.id') . ' = ' . $db->quoteName('b.participant_id'))
        ->join('LEFT', $db->quoteName('#__competition_participants_fields', 'd'), $db->quoteName('a.id') . ' = ' . $db->quoteName('d.participant_id') . ' AND ' . $db->quoteName('d.field_id') . ' = ' . $db->quote('8'))
        ->join('LEFT', $db->quoteName('#__competition_participants_fields', 'e'), $db->quoteName('a.id') . ' = ' . $db->quoteName('e.participant_id') . ' AND ' . $db->quoteName('e.field_id') . ' = ' . $db->quote('13'))
        ->where($db->quoteName('a.competition_id') . ' = ' . $db->quote($competition_id))
        ->group($db->quoteName('a.id'));
        
        $db->setQuery($query);
        $results = $db->loadAssocList();
        
        foreach ($results as &$result) {
            $awardValues = $result['award'] ? explode(',', $result['award']) : [];
            $result['award'] = array_map(fn($val) => $award_names[$val] ?? $val, $awardValues);
           
        }
        
        return $results;
    }
    
    public static function getPhotoPaths($items, $photo_path) {
        foreach ($items as &$item) {
            $item['full_path_photo'] = $photo_path . $item['competition_id'] . "/" . $item['id'] . "/" . "big_" . $item['photo'];
        }
        unset($item); // important - break the reference after the loop
        return $items;
      
    }
    public static function getAwardTitles ($db) {
        $query = $db->getQuery(true)
        ->select('*')
        ->from($db->quoteName('#__competition_fields'))
        ->where($db->quoteName('id') . ' = ' . $db->quote(13));
        
        $db->setQuery($query);
        $row = $db->loadAssoc();
        $attribs = json_decode($row['attribs'], true);
        
        $awards = [];
        foreach ($attribs['options'] as $option) {
            $awards[$option['value']] = $option['text'];
        }
        return $awards;
    }

}

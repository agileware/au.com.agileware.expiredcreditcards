<?php

require_once 'expiredcreditcards.civix.php';
use CRM_Expiredcreditcards_ExtensionUtil as E;

/**
 * Implements hook_civicrm_config().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_config
 */
function expiredcreditcards_civicrm_config(&$config) {
  _expiredcreditcards_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_xmlMenu().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_xmlMenu
 */
function expiredcreditcards_civicrm_xmlMenu(&$files) {
  _expiredcreditcards_civix_civicrm_xmlMenu($files);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_install
 */
function expiredcreditcards_civicrm_install() {
  _expiredcreditcards_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_postInstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_postInstall
 */
function expiredcreditcards_civicrm_postInstall() {
  _expiredcreditcards_civix_civicrm_postInstall();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_uninstall
 */
function expiredcreditcards_civicrm_uninstall() {
  _expiredcreditcards_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_enable
 */
function expiredcreditcards_civicrm_enable() {
  _expiredcreditcards_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_disable
 */
function expiredcreditcards_civicrm_disable() {
  _expiredcreditcards_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_upgrade
 */
function expiredcreditcards_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _expiredcreditcards_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_managed().
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_managed
 */
function expiredcreditcards_civicrm_managed(&$entities) {
  $entities[] = array(
    'module' => 'au.com.agileware.expiredcreditcards',
    'name' => 'find_expired_credit_cards',
    'entity' => 'Job',
    'update' => 'never', // Ensure local changes are kept, eg. setting the job active
    'params' => array(
      'version' => 3,
      'run_frequency' => 'Daily',
      'name' => 'Find Expired Credit Cards',
      'description' => 'Check all recurring contributions and find attached payment tokens with expired credit cards.',
      'api_entity' => 'PaymentToken',
      'api_action' => 'findexpired',
      'parameters' => "",
      'is_active' => '1',
    ),
  );
  $entities[] = array(
    'module' => 'au.com.agileware.expiredcreditcards',
    'name' => 'expired_credit_cards_activity_type',
    'entity' => 'OptionValue',
    'update' => 'never',
    'params' => array(
      'version' => 3,
      'option_group_id' => "activity_type",
      'label' => "Credit Card Expired",
      'description' => "Credit card expired to process recurring contribution",
      'is_reserved' => 1,
    ),
  );
  _expiredcreditcards_civix_civicrm_managed($entities);
}

/**
 * Implements hook_civicrm_caseTypes().
 *
 * Generate a list of case-types.
 *
 * Note: This hook only runs in CiviCRM 4.4+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_caseTypes
 */
function expiredcreditcards_civicrm_caseTypes(&$caseTypes) {
  _expiredcreditcards_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implements hook_civicrm_angularModules().
 *
 * Generate a list of Angular modules.
 *
 * Note: This hook only runs in CiviCRM 4.5+. It may
 * use features only available in v4.6+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_angularModules
 */
function expiredcreditcards_civicrm_angularModules(&$angularModules) {
  _expiredcreditcards_civix_civicrm_angularModules($angularModules);
}

/**
 * Implements hook_civicrm_alterSettingsFolders().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_alterSettingsFolders
 */
function expiredcreditcards_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
  _expiredcreditcards_civix_civicrm_alterSettingsFolders($metaDataFolders);
}

/**
 * Implements hook_civicrm_entityTypes().
 *
 * Declare entity types provided by this module.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_entityTypes
 */
function expiredcreditcards_civicrm_entityTypes(&$entityTypes) {
  _expiredcreditcards_civix_civicrm_entityTypes($entityTypes);
}

/**
 * Implements hook_civicrm_tokens().
 */
function expiredcreditcards_civicrm_tokens(&$tokens) {
  $tokens['activity'] = array(
    'activity.source_record' => ts("Activity Source Record"),
  );
}

/**
 * Implements hook_civicrm_tokenValues().
 */
function expiredcreditcards_civicrm_tokenValues(&$values, $cids, $job = NULL, $tokens = array(), $context = NULL) {
  if (!is_array($cids)) {
    $values['activity.source_record'] = "[activitySourceRecord]";
  }
  else {
    foreach ($cids as $cid) {
      $values[$cid]['activity.source_record'] = "[activitySourceRecord]";
    }
  }
}

/**
 * Implements hook_civicrm_alterMailParams().
 */
function expiredcreditcards_civicrm_alterMailParams(&$params, $context) {
  if (isset($params['token_params'])) {
    if (isset($params['token_params']['entityTable']) && $params['token_params']['entityTable'] == 'civicrm_activity' && isset($params['token_params']['entity_id']) && !empty($params['token_params']['entity_id'])) {
      $activityId = $params['token_params']['entity_id'];

      try {
        $activity = civicrm_api3('Activity', 'getsingle', array(
          'id' => $activityId,
        ));

        $sourceRecordId = $activity['source_record_id'];

        $params['html'] = str_replace("[activitySourceRecord]", $sourceRecordId, $params['html']);
        $params['subject'] = str_replace("[activitySourceRecord]", $sourceRecordId, $params['subject']);
        $params['text'] = str_replace("[activitySourceRecord]", $sourceRecordId, $params['text']);

      }
      catch (CiviCRM_API3_Exception $e) {

      }

    }
  }
}

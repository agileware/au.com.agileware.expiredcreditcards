<?php
use CRM_Expiredcreditcards_ExtensionUtil as E;

/**
 * Collection of upgrade steps.
 */
class CRM_Expiredcreditcards_Upgrader extends CRM_Extension_Upgrader_Base {

  /**
   * Update 100 function
   *
   * @return TRUE on success
   * @throws Exception
   */
  public function upgrade_100() {
    $this->ctx->log->info('Applying update 100 - Fix incorrect option value: Credit Card Expired');
    // Fix some CiviCRM sites which have the incorrect name set for this option
    CRM_Core_DAO::executeQuery('UPDATE `civicrm_option_value` SET `name` = "Credit_Card_Expired" WHERE `name` = "Credit Card Expired"');

    return TRUE;
  }

}

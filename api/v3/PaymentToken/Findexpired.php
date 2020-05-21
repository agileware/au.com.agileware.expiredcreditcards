<?php
use CRM_Expiredcreditcards_ExtensionUtil as E;

/**
 * PaymentToken.Findexpired API specification (optional)
 * This is used for documentation and validation.
 *
 * @param array $spec description of fields supported by this API call
 * @return void
 * @see http://wiki.civicrm.org/confluence/display/CRMDOC/API+Architecture+Standards
 */
function _civicrm_api3_payment_token_Findexpired_spec(&$spec) {

}

/**
 * PaymentToken.Findexpired API
 *
 * @param array $params
 * @return array API result descriptor
 * @see civicrm_api3_create_success
 * @see civicrm_api3_create_error
 * @throws API_Exception
 */
function civicrm_api3_payment_token_Findexpired($params) {
  $expiredCreditCards = civicrm_api3('PaymentToken', 'get', [
    'sequential' => 1,
    'options' => ['limit' => 0]
  ]);
  $expiredCreditCards = $expiredCreditCards['values'];

  foreach ($expiredCreditCards as $expiredCreditCard) {
    $activity = civicrm_api3('Activity',
      'get',
      [
        'source_contact_id' => $expiredCreditCard['contact_id'],
        'activity_type_id'  => "Credit Card Expired",
        'source_record_id'  => $expiredCreditCard['id'],
      ]);
    $expiredDate = new DateTime($expiredCreditCard['expiry_date']);
    $expiredDate->modify('first day of next month');
    $expiredDate->setTime(0, 0, 0);
    $expiredDate = $expiredDate->format('Y-m-d H:i:s');
    if (!$activity['count']) {
      $activity = civicrm_api3('Activity',
        'create',
        [
          'source_contact_id'   => $expiredCreditCard['contact_id'],
          'activity_type_id'    => "Credit Card Expired",
          'source_record_id'    => $expiredCreditCard['id'],
          'activity_date_time'  => $expiredDate,
          'priority_id'         => "Urgent",
          'is_test'             => 0,
          'is_deleted'          => 0,
          'is_star'             => 0,
          'is_current_revision' => 1,
          'subject'             => "Credit card expired for recurring card token (ID : "
                                   . $expiredCreditCard['id'] . ')',
          'status_id'           => "Scheduled",
          'target_id'           => $expiredCreditCard['contact_id'],
        ]);
    }
    $activity = array_shift($activity['values']);
    // update the date if not matched
    if ($activity['activity_date_time'] != $expiredDate) {
      $activity['activity_date_time'] = $expiredDate;
      civicrm_api3('Activity', 'create', $activity);
    }
  }

  $response = [
    'expired' => count($expiredCreditCards),
  ];

  return civicrm_api3_create_success($response, $params, 'PaymentToken', 'Findexpired');
}

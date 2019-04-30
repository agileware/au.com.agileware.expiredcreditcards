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
  $today = new DateTime();
  $today->setTime(0, 0, 0);

  $expiredCreditCards = civicrm_api3('ContributionRecur', 'get', [
    'sequential'                   => 1,
    'return'                       => ["id", "contact_id"],
    'payment_token_id.expiry_date' => ['<' => $today->format("Y-m-d H:i:s")],
    'contribution_status_id'       => ['IN' => ["Pending", "In Progress", "Failed"]],
  ]);

  $expiredCreditCards = $expiredCreditCards['values'];

  foreach ($expiredCreditCards as $expiredCreditCard) {
    $today = new DateTime();
    civicrm_api3('Activity', 'create', [
      'source_contact_id'  => $expiredCreditCard['contact_id'],
      'activity_type_id'   => "Credit Card Expired",
      'source_record_id'   => $expiredCreditCard['id'],
      'activity_date_time' => $today->format('Y-m-d H:i:s'),
      'priority_id'        => "Urgent",
      'subject'            => "Credit card expired for recurring contribution (ID : " . $expiredCreditCard['id'] . ')',
      'status_id'          => "Completed",
      'target_id'          => $expiredCreditCard['contact_id'],
    ]);
  }

  $response = array(
    'expired' => count($expiredCreditCards),
  );

  return civicrm_api3_create_success($response, $params, 'PaymentToken', 'Findexpired');
}

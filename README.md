# Expired Credit Cards (au.com.agileware.expiredcreditcards)

This is a [CiviCRM](https://civicrm.org) extension that helps you notice and follow up recurring
contributions whose stored credit card is about to expire, or has already expired.

Contributions collected on a recurring schedule rely on the underlying credit card token remaining
valid. When a card's expiry date passes, the recurring payment will start failing. This extension
automatically creates a **Credit Card Expired** Activity for the Contact associated with each
stored payment token, dated the 1st day of the month after the card's expiry date, so that staff
(or an automated Scheduled Reminder) can follow up before the card actually stops working.

The extension is licensed under [AGPL-3.0](LICENSE.txt).

## Usage

* A daily **Scheduled Job**, "Find Expired Credit Cards", is installed and enabled automatically.
  It calls the `PaymentToken.Findexpired` API action, which checks every stored
  [Payment Token](https://docs.civicrm.org/dev/en/latest/financial/paymentToken/) (i.e. every
  stored recurring-contribution credit card) and, for each one, creates or updates a
  **Credit Card Expired** Activity for the token's Contact:
  * The Activity's Activity Date is set to the 1st day of the month following the card's expiry
    date.
  * The Activity Status is set to **Scheduled**.
  * The Activity's Source Record is linked to the Payment Token record.
  * If a **Credit Card Expired** Activity already exists for that Payment Token, it is updated
    rather than duplicated (its date is corrected if the token's expiry date has since changed).
  * You can also run `PaymentToken.Findexpired` manually via the CiviCRM API Explorer or `cv api`
    if you want to trigger the check outside of the daily schedule.
* A reserved Activity Type, **Credit Card Expired**, is installed for use with the Activities
  created above.
* The **Credit Card Expired** Activity can then be used to configure a
  [Scheduled Reminder](https://docs.civicrm.org/user/en/latest/email/scheduled-reminders/) to
  automatically notify the Contact that their credit card is about to expire or has expired. When
  setting up the Scheduled Reminder, select:
  * **Credit Card Expired** as the Activity Type.
  * **Scheduled** as the Activity Status, so that the reminder is effectively cancelled if the
    Activity is later closed off.
  * An **Activity Source Record** token is also available for use in the reminder's message
    (`{activity.source_record}` is substituted with the Payment Token ID at send time), which can
    be useful if you need to trace the reminder back to the specific stored card token.

## Special configuration requirements

None. The extension does not require any API keys, OAuth credentials, or settings page — once
installed it schedules its own Job and Activity Type automatically. The only setup step is
enabling and reviewing the **Find Expired Credit Cards** Scheduled Job under *Administer > System
Settings > Scheduled Jobs* (it is enabled by default), and, optionally, configuring a Scheduled
Reminder as described above.

## Requirements

* CiviCRM 5.51+
* A payment processor that stores recurring-contribution cards as
  [Payment Tokens](https://docs.civicrm.org/dev/en/latest/financial/paymentToken/) with an expiry
  date (most tokenizing payment processors do).

## Installation (Web UI)

Learn more about installing CiviCRM extensions in the [CiviCRM Sysadmin
Guide](https://docs.civicrm.org/sysadmin/en/latest/customize/extensions/).

## About the Authors

CiviCRM Priceset Frequency was developed by the team at [Agileware](https://agileware.com.au).

[Agileware](https://agileware.com.au) provide a range of CiviCRM services including:

  * CiviCRM migration
  * CiviCRM integration
  * CiviCRM extension development
  * CiviCRM support
  * CiviCRM hosting
  * CiviCRM remote training services
  * And of course, CiviContact development and support

Support your Australian [CiviCRM](https://civicrm.org) developers, [contact Agileware](https://agileware.com.au/contact) today!

![Agileware](logo/agileware-logo.png)



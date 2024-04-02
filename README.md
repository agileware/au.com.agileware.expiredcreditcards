# au.com.agileware.expiredcreditcards

This is a [CiviCRM](https://civicrm.org) extension that automatically creates a new Activity, **Credit Card Expired** based on the Credit Card Expiry Date for a stored credit card token.

* The Status of the Activity is set to **Scheduled**.
* The Activity Date for the Activity is set to the 1st day of the month after the Credit Card Expiry Date.

The Credit Card Expired, Activity can then be used to set up Scheduled Reminders to notify the Contact that their credit card is about to expire or has expired.

When setting up the Scheduled Reminder, select:

* **Credit Card Expired** as the Activity Type
* **Scheduled** as the Activity Status, so that the credit card reminder can be effectively cancelled when required.

## License

The extension is licensed under [AGPL-3.0](LICENSE.txt). 

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



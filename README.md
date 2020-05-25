# au.com.agileware.expiredcreditcards

Extension that automatically creates a new Activity, Credit Card Expired based on the Credit Card Expiry Date for a stored credit card token.
The Activity Date for the Activity is set to the 1st day of the month after the Credit Card Expiry Date.
The Credit Card Expired, Activity can then be used to set up Scheduled Reminders to notify the Contact that their credit card is about to expire or has expired.

## Before
Credit card details expire, token based payments simply stop working.
Users have no way of updating their credit card details on the website and keeping the recurring Contribution current.

## After
Users and organisation are notified about upcoming credit card expiry.
User are sent a link to a page where they can securely update their credit card details.
Token used by CiviCRM is updated and recurring Contributions continue using the existing schedule.

## Implementation
This functionality should be implemented as a new type of Scheduled Reminder event trigger and new tokens for inclusion in the email template.  


The extension is licensed under [AGPL-3.0](LICENSE.txt).

## Installation (Web UI)

This extension has not yet been published for installation via the web UI.

## Installation (CLI, Zip)

Sysadmins and developers may download the `.zip` file for this extension and
install it with the command-line tool [cv](https://github.com/civicrm/cv).

```bash
cd <extension-dir>
cv dl au.com.agileware.expiredcreditcards@https://github.com/FIXME/au.com.agileware.expiredcreditcards/archive/master.zip
```

## Installation (CLI, Git)

Sysadmins and developers may clone the [Git](https://en.wikipedia.org/wiki/Git) repo for this extension and
install it with the command-line tool [cv](https://github.com/civicrm/cv).

```bash
git clone https://github.com/FIXME/au.com.agileware.expiredcreditcards.git
cv en expiredcreditcards
```

## Usage

Apply this [patch](https://bitbucket.org/agileware/au.com.agileware.expiredcreditcards/src/master/civicrm-core-mail-tokens.patch) for the schedule task.



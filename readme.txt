=== WP Survey And Quiz Tool ===
Contributors: Fubra,Backie,olliea95
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=99WUGVV4HY5ZE&lc=GB&item_name=CATN%20Plugins&item_number=catn&currency_code=GBP&bn=PP%2dDonationsBF%3abtn_donateCC_LG%2egif%3aNonHosted 
Tags: Quiz,test,exam,survey,results,email,quizzes,charts,google charts,wpsqt,tool,poll,polling,polls
Requires at least: 3.1
Tested up to: 3.2.1
Stable tag: 2.7.2
A highly customisable Quiz, Survey and Poll plugin to which allows for unlimited questions and sections.

== Description ==

Allows users to create quizzes, surveys or polls hosted on their WordPress install.

There will be bugs and faults - hopefully not too many. Bug reports are crucial to improving the plugin. Please report all bugs and issues you find to the <a href="https://github.com/fubralimited/WP-Survey-And-Quiz-Tool/issues?sort=created&direction=desc&state=open">GitHub issue tracking page</a>. If you are not able to report the issue there then please use the <a href="http://wordpress.org/tags/wp-survey-and-quiz-tool?forum_id=10">forum</a>.

For full changelog and development history, see the <a href="https://github.com/fubralimited/WP-Survey-And-Quiz-Tool">GitHub repo</a>.

All documentation can be found on the <a href="https://github.com/fubralimited/WP-Survey-And-Quiz-Tool/wiki/_pages">GitHub Wiki</a>.

**Features**

* Unlimited Quizzes.
* Unlimited Surveys.
* Unlimited Polls.
* Unlimited number of sections for quizzes, surveys and polls.
* Auto marking for quizzes with all multiple choice questions.
* Ability to limit quizzes and surveys to one submission per IP address.
* Ability to send customised notification emails.
* Ability to send notification emails to a single email address, multiple email addresses or a group of WordPress users.
* Ability to have notification emails only be sent if the user got a certain score.
* Ability to have surveys and quizzes be taken by registered WordPress members only.
* Ability to have quizzes and surveys with or without contact forms.
* Ability to have custom contact forms.
* Ability to export and import quizzes,surveys and questions.
* Ability to have PDF certifications using <a href="http://www.docraptor.com">DocRaptor</a>

**Requirements**

* PHP 5.2+
* WordPress 3.1
* Sessions
* cURL

**Developer Features**

Currently 30+ filters and hooks to use throughout the plugin to help extend it without editing the plugin. 

Custom pages allows for the theming of the plugin pages without editing the plugin.

Developed by <a href="http://www.catn.com">PHP Hosting Experts CatN</a>.

**For those having issues with results not saving**

If you have upgraded from a version 1.x.x and nothing appears to be saving, please follow these instructions.

1. Make sure you have the latest version of the plugin
1. Deactivate plugin
1. Activate plugin
1. In the WPSQT menu click Maintenance
1. Select the Upgrade tab
1. Click the Upgrade button
1. Repeat all previous steps once more

Any further issues then feel free to create a thread on the <a href="http://wordpress.org/tags/wp-survey-and-quiz-tool?forum_id=10">forum</a>.

== ChangeLog ==

= 2.7.3 =

* Added ability to add a timer for a quiz
* Addressed several layout issues

= 2.7.2 =

* Fixed deleting survey results when they contain a free text, dropdown or multiple question
* Added some spacing after dropdown boxes

= 2.7.1 =

* Fix capability issue

= 2.7 =

* Added labels to the pie charts
* Added ability to change likert scale
* Added option to choose which role is required to admin WPSQT
* Added limit to one submission per WP user
* Fixed survey result deleting
* Changed the text of the next button to 'Submit' if on the last section
* Removed titles from within chart
* Moved all of the documentation to the <a href="https://github.com/fubralimited/WP-Survey-And-Quiz-Tool/wiki/_pages">GitHub Wiki</a>

= 2.6.6 =

* Fixed poll results view failing
* Fixed fatal error on PDF creation
* Fixed likert results on single and total views
* Add ability to set a different quiz finish message for pass

= 2.6.5 =

* Added limit to one submission for surveys
* Fixed multisite issues
* Fixed issues with section names containing quotes

= 2.6.4 =

* Updated the menu so it's hopefully more user friendly
* Fixed the total survey results page when there's a free text question
* Fixed issue where URLs were being encoded in additional text field and not decoded

= 2.6.3 =

* Proofread documentation
* Tidied up the update checker
* Updated the database backup feature
* Add option to run all previous upgrades
* Rolled out limit to IP for quizzes
* Allow longer quiz/survey/poll name

= 2.6.2 =

* Fixed sent from email field in Options page not working
* Fixed poll limit to one submission per IP
* Amended documentation
* Issues should now be reported on GitHub

= 2.6.1 =

* Included update checker
* Included legacy upgrade script - versions pre 2.1 should now work when updated

= 2.6 =

* Optimised the upgrade checking so the database isn't being written to on every page load
* Fixed an issue with the version comparing
* Fixed issue viewing total results on a survey when there are no results

= 2.5.9 =

* Changed the upgrade script so deactivation/activation isn't required after update

= 2.5.8 =

* Re added XSS protection

= 2.5.7 =

* Removed all the uses of htmlentities as it was encoding as ISO to a UTF8 table

= 2.5.6 =

* Various bug fixes

= 2.5.5 =

* Added option for custom survey finish message

= 2.5.4 =

* Fixed install script to install a correct database

= 2.5.3 =

* Update the URL in the email notification to point to the correct resultid
* Remove htmlentities and stripslashes on the additional text field so HTML can actually be used

= 2.5.2 =

* Made the maintenance menu more informative
* Once again fixed the poll results display
* Added a date taken column to the results page of quizzes, any results pre this update will not have a date

= 2.5.1 =

* Slight change to the upgrade script

= 2.5 =

* Quizzes now auto approve if passed
* Pass/Fail column now works as intended
* Removed the 'date viewed' column as that was misleading
* Finally fixed the upgrade script - please now use this if prompted

= 2.4.3 =

* Updated the documentation
* Fixed poll results not showing when the poll name isn't capitalised

= 2.4.2 =

* Changed default database collation to UTF8 - will not update old tables
* Fixed poll finish to show results if set
* Increased the size of the question title field - will not update old tables
* Fixed most notices and warnings

= 2.4.1 =

* Minor poll related bugs

= 2.4 =

* Added ability to create polls
* Fixed a couple of minor bugs

= 2.3 =

* Added widget for displaying top scores
* Added a pass mark feature - doesn't do anything yet
* Various bug fixes
* Conflicts with other plugins solved

= 2.2.3 =

* Added new shortcode to be able to display the results for a user

= 2.2.2 =

* Yet again fixed the positioning of a quiz/survey - all fixed and its not being touched again!
* Fixed the marking of quizzes unable for auto mark
* Added ability to backup the WPSQT databases - will be improved in a later release

= 2.2.1 =

* Temporarily removed the upgrade notice as it was misleading
* Add 'date viewed' to the results table of a quiz
* Many changes to the survey results page - including fixes and clarifications

= 2.2 =

* Fixed plugin stopping Super Cache from working correctly
* Fixed multiple choice questions occasionally appearing with radio buttons

= 2.1.1 =

* Final fix to the positioning of the quiz/survey

= 2.1 =

* Fixed free text questions not displaying in results
* Fixed email system when the user is logged in
* Fixed marking free text questions
* Fixed positioning of quiz/survey, the quiz/survey will now display wherever you place the shortcode, any content before/after will be placed accordingly
* Fixed token replacement in the finish message
* Quiz review page fixed - no longer repeats results many times and correctly displays free text answers
* Many spelling/grammatical errors fixed
* Some styling changes to the admin pages to make them look prettier

= 2.0-beta2 = 

* Added scores and percentage columns to quiz result list#
* Added ability to send notification email 
* Added navbar linking system for easier navigation throughout the plugin.
* Added image option for quizzes
* Added action in display question.
* Fixed PDF feature
* Fixed quiz review
* Fixed quiz roles not appearing
* Fixed various bugs


= 2.0-beta =

* Added Admin Bar menu
* Added Notifications per quiz and survey
* Added PDF functionality
* Added ability to have default answer choices on multiple choice questions
* Fixed design flaws with custom forms.
* Added image field for questions 
* Added filters and improved extendibility
* Whole bunch of other stuff

== Upgrade Notice ==

= 2.5.2 =
Fixes for new poll system, doc updates, general bug fixes. Worth updating!

= 2.4 =
Lots of new features, mainly polls.

= 2.2.1 =
Almost completely stable and loads of improvements over the beta release.

= 2.1 =
A lot more stable than beta releases. There is still going to be a few bugs, please report them on the <a href="http://wordpress.org/tags/wp-survey-and-quiz-tool?forum_id=10">support forums</a>.

== Installation ==

* Download/upload plugin to wp-content/plugins directory
* Activate Plugin within Admin Dashboard.
* Run the upgrade script if prompted to

== Screenshots ==

1. Picture of contact details form.
2. Picture of multiple choice
3. Picture of free text area
4. Picture of the main page of the plugin admin section
5. Question List in Admin section
6. Edit Question in Admin section
7. Edit quiz in Admin section
8. Result list
9. Very limited mark result page
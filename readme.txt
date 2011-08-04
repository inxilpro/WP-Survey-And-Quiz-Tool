=== WP Survey And Quiz Tool ===
Contributors: Fubra,Backie,olliea95
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=99WUGVV4HY5ZE&lc=GB&item_name=CATN%20Plugins&item_number=catn&currency_code=GBP&bn=PP%2dDonationsBF%3abtn_donateCC_LG%2egif%3aNonHosted 
Tags: Quiz,test,exam,survey,results,email,quizzes,charts,google charts,wpsqt,tool,poll,polling
Requires at least: 3.1
Tested up to: 3.2.1
Stable tag: 2.4.2

A highly customisable Quiz and Survey plugin to which allows for unlimited questions and sections.

== Description ==

Allows users to create quizzes or surveys hosted on their WordPress install.

There will be bugs and faults - hopefully not too many. Bug reports are crucial to improving the plugin.

**Features**

* Unlimited Quizzes.
* Unlimited Surveys.
* Unlimited Polls.
* Unlimited number of sections for quizzes, surveys and polls.
* Auto marking for quizzes with all multiple choice questions.
* Ability to limit quizzes and surveys to one submission per IP address.
* Ability to send customised notification emails.
* Ability to send notification emails to a single email address,multiple email addresses or a group of WordPress users.
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

Developed by <a href="http://www.catn.com">PHP Hosting Experts CatN</a>

== ChangeLog ==

= 2.4.2 =

* Changed default database collation to UTF8 - will not update old tables
* Fixed poll finish to show results if set
* Increased the size of the question title field - will not update old tables
* Fixed most notices and warnnings

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

= 2.2.1 =
Almost completely stable and loads of improvements over the beta release.

= 2.1 =
A lot more stable than beta releases. There is still going to be a few bugs, please report them on the <a href="http://wordpress.org/tags/wp-survey-and-quiz-tool?forum_id=10">support forums</a>.

== Installation ==

* Download/upload plugin to wp-content/plugins directory
* Activate Plugin within Admin Dashboard.

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
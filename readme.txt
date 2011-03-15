=== WP Survey And Quiz Tool ===
Contributors: Fubra,Backie
Tags: Quiz,test,exam,survey,results,email,quizzies,charts,google charts
Tested up to: 3.1
Stable tag: 1.3.32
Requires At Least: 3.0
Donate Link: https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=99WUGVV4HY5ZE&lc=GB&item_name=CATN%20Plugins&item_number=catn&currency_code=GBP&bn=PP%2dDonationsBF%3abtn_donateCC_LG%2egif%3aNonHosted 

A plugin to allow users to generate quizes, exams, tests and surveys for their wordpress site.

== Description ==

This plugin is designed to allow wordpress blog owners to create their own quiz, questionaire, test, exam or survey. If you want to ask people a series of questions and record or mark the results, then this plugin can help. Shows survey results using google charts.

Editable options for quizes are

* Take users contact details
* Completion notification (Instant, Batched - hourly or daily or not at all)
* Name
* Quiz sections

Editable options for quiz sections are

* Type -  Multiple choice or Text input.
* Difficulty - Easy, medium, hard or mixed which is even number of each difficulty unless the number is odd then the remainder from dividing by 3 is added to one difficulty randomly.
* Number of Questions
* Name

Editable options for surveys

* Name
* Take users contact details

Editable options for survey sections are

* Type - Multiple choice or scalable 1-10 
* Number of questions 
* Name

Developed by <a href="http://www.catn.com">PHP Hosting Experts CatN</a>

== Installation ==

1. Upload `wp-survey-and-quiz-tool` folder to `/wp-content/plugins/` directory
2. Go to Plugins and activate `WP Survey And Quiz Tool` 
3. Go to `WP Survey And Quiz Tool` then `Quiz/Surveys`
4. Click `Create a Quiz`
5. Fill out details.
6. Go back to Quiz/Surveys click edit sections
7. Fill out details.
8. Go back to Quiz/Surveys click edit questions
9. Click add questions and proceed.
10. Create new page and insert shortcode [wpsqt_quiz name=""] with name having the quiz name of the quiz you wish to have on the page 
10. OR Create new page and insert shortcode [wpsqt_survey name=""] with name having the survey name of the survey you wish to have on the page 
  
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

== ChangeLog == 

= 1.3.31 =

* [15/03/2011 - 09:41] Changed main url from url to wpurl. 

= 1.3.30 =

* [14/03/2011 - 09:56] Fixed issue with limit to one submission
* [14/03/2011 - 10:42] Removed potential XSS hole

= 1.3.29 =

* [21/02/2011 - 08:15] Fixed tag issue

= 1.3.28 =

* [20/02/2011 - 22:15] Fixed SQL table issues.

= 1.3.27 =

* [17/02/2011 - 15:41] Added limit to one submission

= 1.3.26 = 

* [15/02/2011 - 15:16] Fixed MySQL error which causes additional text to change from text to varchar 255
* [15/02/2011 - 15:24] Added stripslashes to create/edit question form input
* [15/02/2011 - 15:33] Added notice that an empty answer is correct choice will result in answer being deleted.
* [15/02/2011 - 15:38] Fixed multiple typos
* [15/02/2011 - 15:47] Stop add new questions from looking like you're editing the question after submission.

= 1.3.25 =

* [10/02/2011 - 1:55] Readded session start. 

= 1.3.24 =

* [10/02/2011 - 11:16] Fixed upgrade error. 

= 1.3.23 =

* Changed !empty($_POST) to $_SERVERPOST_METHOD? == "POST"
* Fixed fatal error using object as array for quiz filters.
* Fixed contact form jumping sections when failed orignal submission

= 1.3.22 =

* Fixed filter on quiz result page
* Fixed results not working for large quizzes.
* Fixed quiz automarking to represent points and not number of questions.
* Fixed quizzes not using user's display as name when use WordPress user info is enabled.
* Added nonce checks.
* Added DONOTCACHEPAGE constant to shortcode callbacks to stop WP Super Cache potentially breaking quizzes/surveys
* Fixed invalid sql query when custom form fields were empty.

= 1.3.21 = 

* Added support for UTF-8 chars
* Added Dropdown and Likert question types to surveys.
* Fixed %SCORE% not working in email templates.	

= 1.3.20 =
* Fixed survey not using Anonymous as a user's name when none given.
* Fixed survey single review not showing custom form data.
* Fixed survey Name from contact form not being used properly in emails and database and Anonymous not appearing when not given

= 1.3.19 =
* Fixed survey questions not being correct for that survey.
* Fixed constant overriding of survey section data
* Fixed survey section questions not following the order by setting.

= 1.3.18 =
* Fixed editing questions using quiz id as the question id.

= 1.3.17 = 
* Fixed requirements bar not showing

= 1.3.16 =
* Fixed SQL error in creation of survey single table, which resulted in survey listing failure.

= 1.3.15 =
* Fixed display review option showing correct value from the database.
* Fixed output buffering copy & paste error.
* Fixed error caused in custom fields when user names a field the same as a get or post var used by WordPress.

= 1.3.14 =
* Fixed survey/quiz contents appearing above page content

= 1.3.13 =
* Fixed errors caused by silly code to check if quiz exists
* Fixed non answered sections questions not being added up in result display - Thanks jnthnlstr

= 1.3.12 =
* Fixed constant overriding of section data - Thanks jnthnlstr

= 1.3.11 =
* Fixed question additional text not updating.
* Fixed html for question additional being escaped.

= 1.3.9 =
* Fixed Ambiguous error message * is not enabled.
* Fixed pagination back in quiz/survey lists.
* Improved Documention

= 1.3.8 =
* Fixed un-needed,unwanted,pointless var dump in survey.

= 1.3.7 =
* Added multsite support for custom pages

= 1.3.6 =
* Fixed person name being being blank in notification email.

= 1.3.5 =
* Fixed sectionid not being assigned to survey questions resulting in survey questions not appearing

= 1.3.4 = 
* Fixed undefined variable in add new survey.
* Fixed survey section not working
* Fixed survey questions appearing like they aren't updating
* Fixed surveys not deleting
* Fixed surveys section requiring all fields

= 1.3.3 =
* Fixed SQL table structures on install
* Added upgrade call to end of install incase I forget again!
* Fixed broken add new question page on question list

= 1.3.2 =
* Fixed new answers not appearing in quiz question form.
* Added ability to have resulted reviewed for users to see which question they got right and wrong.

= 1.3.1 =
* Fixed new installs not having a link to where creating new quizzes or surveys
* Fixed survey questions not updating on editing
* Fixed survey questions multiple choice answers continually readding on editing
* Added ability to toogle the 'other' field in survey multiple choice questions

= 1.3 = 
* Fixed division by zero warning.
* Fixed quiz status always being enabled when editing.
* Fixed custom forms showing errors upon fresh loading.
* Fixed result deletion wrong page view error.
* Fixed questions showing up for the wrong survey section
* Fixed outdated PHPDoc block for wpsqt_admin_questions_addnew()
* Fixed outdated documention for how to display a quiz.
* Fixed non safe names being used for input names in custom contact forms.
* Fixed custom forms incorrectly saying required information wasn't provided.
* Fixed Survey and quizzes not displaying after the custom contact form.
* Fixed names not showing up in instant email notifications.
* Fixed survey sections not pointing to absolute location of the javascript.
* Removed reflected XSS in page view code.
* Removed warnings for non array varibles in survey results.
* Removed default from email address from email notification.
* Changed main page from lists of quizzes and results to merged survey and quiz list.
* Changed help on create quiz question page to next to fields
* Changed result list to have the same sort of UI that posts&pages lists have.
* Added tips on what each field means in quiz edit/create form.
* Added custom page directory field in the edit quiz form.
* Added back to question lists link on successfull question creation/edit.
* Added explaination for the custom form page.
* Added warning if contact forms weren't enabled when viewing contact form
* Added enabling contact form if custom contact form is submitted.
* Added ability to customize the from email on emails from the plugin.
* Added instant email notifications on survey completion.
* Added global email notification template system
* Added custom email notification template which overrides global if present to Quiz System
* Added custom email notification template which overrides global if present to Survey System
* Added notification emails to all users who have a user role
* Added notification emails group of emails seperated by comma

= 1.2.1 = 
* Added ability to export just people's details to csv
* Added mysql upgrade function

= 1.2 = 
* Removed redunant type from quiz creation and configution form.
* Fixed SQL error on surveys results table.
* Fixed notice and warnings appear when sections are missing results.
* Fixed mixed questions not always showing correct number of questions.
* Fixed user info aways being anonymous when using WordPress user info.
* Fixed warning of undeclared varaible in options page.
* Fixed wrong filepath for survey create file
* Fixed typo in survey list `configure quiz` changed to `configure survey`
* Fixed survey edit and creation options not being in form
* Added custom forms
* Added order by option on to quiz and survey sections
* Added ability to view results for single quizes.
* Added email link on result link name.
* Added html enabled question answers
* Added email notifications on percentage right
* Added export to csv ability

= 1.1.4 = 
* Increased customization ability for single quizzes and surveys.
* Added print.css to admin to allow for easy print off of results.

= 1.1.3 = 
* Fixed table creation error for quiz table
* Fixed options page not showing up.
* Fixed last quiz section not appering.

= 1.1.2 =
* All files actually uploaded this time

= 1.1.1 =
* Fixed missing require_once in quizzes
* Added ability to have custom templates.

= 1.1 = 
* Seperated Surveys and Quizes into two completely seperate sections.
* Added WPSQT_VERSION constant
* Added wordpress install information to contact form.
* Added Google Charts display for survey results.
* Added shortcode for surveys wpsqt_survey
* Added additional text ability to multiple choice questions.
* Fixed admin javascript linking issues.
* Fixed display resuts aways returning 0 corect
* Fixed questions showing up in sections the weren't assigned to.
* Fixed questions being delinked from sections on updating sections.
* Changed sortcode for quizzies to wpsqt_page to wpsqt_quiz

= 1.0.3 =
* Fixed faulty validation in questions creation.
* Fixed quiz list pages from being a fixed 20 items per page to those set in the plugin options page.
* Fixed quiz showing up when status is disabled.

= 1.0.2 = 
* Workaround to deal with register_action error

= 1.0.1 =
* Fixed error in display non mixed sections

== Upgrade Notice ==

= 1.3.22 =

Bug fixes and *security* fix.

= 1.3.2 = 
Bug fix and new features

= 1.3 =
Security fix, New user interface and bunch of new features!

= 1.2 = 
Bug fixes and new features!!!

= 1.1.2 = 
All files actually added this time!

= 1.1 =

Bugfixes, better survey ability and quiz tweaks.

= 1.0.3 =
Yet another bug fix release!

= 1.0.2 = 
Another bug fix release!

= 1.0.1 =
Bug fix release

== Frequently Asked Questions ==

= If I deactivate will all my results be lost? =

No, to stop accidental deletion of data we don't delete data on the plugins deactivation.

= Is there a maximum amount of questions a quiz can have? =
 
Not within the plugin it's self thou your hosting provider may set mysql limits which may limit the plugin.

= Does this plugin require any specific php modules? =

No it should work along as wordpress it able to work.

= Is their a limit on the number of quizes I can have? = 

Not within the plugin it's self thou your hosting provider may set mysql limits which may limit the plugin.

= Is this plugin compatible with Multisite? = 

Yes it has been tested and shown to be functional on a multisite install.

= A quiz section doesn't always show the correct number of questions whys this? =

You will have set the difficulty to mixed. This is only to be used when there is an even number of questions for each difficulty and is advised to only be used when there are more questions than the question number.

= Is it possible to have html for the questions? = 

HTML is enabled for the `additional` field but not the actual question question.

= My Quiz/Survey is enabled but when I goto the page it says it doesn't exist! =

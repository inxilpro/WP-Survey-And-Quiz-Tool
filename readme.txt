=== WP Survey And Quiz Tool ===
Contributors: Fubra
Tags: Quiz,test,exam,survey,results,email
Tested up to: 3.1
Stable tag: 1.0
Requires At Least: 2.9.2

A plugin to allow users to generate quizes and surveys for their wordpress site.

== Description ==

This plugin is designed to allow wordpress blog owners to create their own quizzes and surveys.

Editable options for quizes and surveys are

* Take users contact details
* Completion notification (Instant, Batched - hourly or daily or not at all)
* Name
* Quiz sections

Editable options for quiz sections are

* Type -  Multiple choice or Text input.
* Difficulty - Easy, medium, hard or mixed which is even number of each difficulty unless the number is odd then the remainder from dividing by 3 is added to one difficulty randomly.
* Number of Questions
* Name

== Installation ==

1. Upload `wp-survey-and-quiz-tool` folder to `/wp-content/plugins/` directory
2. Go to Plugins and activate `WP Survey And Quiz Tool` 
3. Go to `WP Survey And Quiz Tool` then `Quiz/Surveys`
4. Click `Add New Quiz`
5. Fill out details.
6. Go back to Quiz/Surveys click edit sections
7. Fill out details.
8. Go back to Quiz/Surveys click edit questions
9. Click add questions and proceed.
10. Create new page and insert shortcode [wpsqt_page name=""] with name having the quiz name of the quiz you wish to have on the page 
  
== Screenshots ==

1. Picture of contact details form.
2. Main Plugin Page
3. Question List
4. Create question form
5. Results list

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
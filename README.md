# Post your Google+ Posts to Facebook
This script runs via a cronjob to periodically check for new Google+ Posts

## Requirements
* PHP 5.3+ (for namespaces)
* Any server that can run a cronjob (Tested on CentOS 6)

## Setup
* Go to https://developers.facebook.com/ and Create a new Facebook App
  * Click `Add Platform` and select website. you'll need a Site URL for authorization
  * You need your Facebook Account to authorize the App to post for you. Simply plugin the values to the following link.
  * `https://www.facebook.com/dialog/oauth?client_id=[APP ID]&redirect_uri=[Website]&scope=publish_actions`
* Go to https://cloud.google.com/console and Create a new Project
  * Create a new OAuth client and select `Service Account`. This will generate a private key for you to download.
  * Put your private key in the `/private` directory
* Copy `/private/config.sample.php` to `/private/config.php` and fill in appropriate values.
* Setup the cronjob. I like to run it every minute to be speedy, but obviously you can adjust this to your liking.
`* * * * * mbarany /usr/bin/php -f /home/mbarany/googleplus-to-facebook/run.php >> /home/mbarany/optional_log.log`

## Some implementation details
* The first time you run the script, it will cache the current date so that it only posts items that are newer than that date.
* It uses a small file cache in the `/cache` directory, so make sure it's writable otherwise the script will complain.
* Note that each time you run the script you use one of your Google API requests in your quota. I think the default quota is 10,000 requests per day, but if you use your Google Project for other things you should keep this in mind.

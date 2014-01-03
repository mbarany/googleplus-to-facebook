# googleplus-to-facebook
* Setup a new Facebook App
** Click "Add Platform" and select website. you'll need a Site URL for authorization
* Create a new Project in the Google API Console
* Copy `/private/config.sample.php` to `/private/config.php` and fill in appropriate values.

## Facebook Authorization
```
https://www.facebook.com/dialog/oauth?client_id=[APP ID]&redirect_uri=[Website]&scope=publish_actions
``

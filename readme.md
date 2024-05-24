=== Automated Emails: Send custom emails on actions like post is published or updated  ===
Contributors: neblabs
Tags: email, automation, notification
Requires at least: 4.7
Tested up to: 6.3
Stable tag: 1.0.0
Requires PHP: 7.2
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Send custom emails when an action happens on your site, like when a new post is published.

== Description ==

This plugin does one simple thing: it sends custom emails when something happens on your site, like when a new post has been published or when an existing post has been moved to the trash.

In addition, it lets you add conditions so that your custom emails are only sent on specific cases, like when a post has a specific status or when the post author has a specific role.

**Features**

* 2 events: 
    * Post Status Change - when the status of a post has changed.
    * Post Updated - when a post has been updated in the database.
* 4 conditions:
    * (post) Status
    * (post) Categories
    * (user) Roles
    * (user) Type (w/account or guest)
* Multiple recipients: Send to multiple recipients, like the post author or the user making the cahnges
* Smart placeholders: Add post or user data in your custom emails (subject and body)
    * 6 post values: title, title (raw), content, content (raw), id, url
    * 3 user values: public name, email, id

**Adding Data to the subject and body**
This plugin allows you to add the data for current post and/or user to the email subject and body. To do so, you have to use the format: ((dataType.value | DataID))
    For example:
    Hello, John Doe! would be written as: Hello, ((user.nameDisplay | PostAuthor))

    Here are the available values:
        * post title: ((post.title | UpdatedPost))
        * post title, unfiltered: ((post.titleRaw | UpdatedPost))
        * post content: ((post.content | UpdatedPost))
        * post content, unfiltered: ((post.contentRaw | UpdatedPost))
        * post id: ((post.id | UpdatedPost))
        * post url: ((post.url | UpdatedPost))

        * user public name: ((user.nameDisplay | PostAuthor))
        * user id: ((user.id | PostAuthor))
        * user email: ((user.email | PostAuthor))

== Frequently Asked Questions ==

= My custom emails are not being sent =

Automated Emails uses core WordPress functions for sending emails, make sure that your site is sending regular emails without this plugin.

= Does this plugin use an external service? =

No! Automated Emails uses WordPress' wp_mail() function to send the emails.

== Changelog ==

= 1.0 =
* Initial release. 12+ months in the making!
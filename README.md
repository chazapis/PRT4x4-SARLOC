# Search and rescue locator for the Panhellenic 4x4 Rescue Team

Based on [an idea by Russell Hore](https://sarloc.russ-hore.co.uk/): *When someone contacts the SAR team for help, they send over a link via an SMS. The link opens a page which uses the mobile phone's GPS to get the user's coordinates and send them over to a database which members of the SAR team can access online.*

This project was built for the [Panhellenic 4x4 Rescue Team](https://www.facebook.com/groups/68070748304/about/) of volunteers. Frontend text is in Greek.

There are 3 pages:
* `locate.php` is what is sent to the person in need of rescue. It is a minimal HTML file, with no JavaScript libraries. Use `locate.php?id=...` or `locate.php?...` to log an identifier along with location information.
* `process.php` is what `locate.php` calls to log the information. `locate.php` uses POST, but it can also be used with GET, to easily inject rows in the database from a browser.
* `view.php` shows a table with database contents and a link to a map. Newer entries show up at the top. A button allows you to clear all database contents, provided you enter the correct passcode.

## Installing

Copy all files in a folder served over HTTPS.

Edit the `config.php` to set your database options and the delete passcode. You need a database with a single table:
```
CREATE TABLE `data` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `args` varchar(256) NOT NULL,
 `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
 `latitude` double NOT NULL,
 `longitude` double NOT NULL,
 `notes` text NOT NULL,
 PRIMARY KEY (`id`)
)
```

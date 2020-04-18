# Search and rescue locator for the Panhellenic 4x4 Rescue Team

Based on [an idea by Russell Hore](https://sarloc.russ-hore.co.uk/): *When someone contacts the SAR team for help, they send over a link via an SMS. The link opens a page which uses the mobile phone's GPS to get the user's coordinates and send them over to a database which members of the SAR team can access online.*

This project was built for the [Panhellenic 4x4 Rescue Team](https://www.facebook.com/groups/68070748304/about/) of volunteers. Some text is in Greek.

## Installing

Copy all files in a folder served over HTTPS.

Edit the PHP files to set your database options. You need a database with a single table:
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

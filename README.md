# Nemo Ocean Angle
## Fishackthon 2016

### Proposal
Gear location should be visible on an app compatible with both android and iphones The app or
program would need to update the gear’s location in real time since fishers often move the same trap
to a different location to follow lobster migration throughout the fishing season.

### Scenario
We design a system that can monitor gear location and real-time tracking on map. If some trouble happened, for instance, the buoy is lose, our device would emit a backup one.

### Challenges
+ Underwater communication problem
+ Shared data v.s. private data
+ Fishing gear tracking

### How Nemo Ocean Angle Helps
+ Stragightly and quickly recycle fishing gear.
+ Avoid collision between boat and fishing gear and help track ghost fishing, for example, the Bay of Fundy.

### Demo
https://drive.google.com/open?id=0B82h-op4KKAyTnVSWjl0R3N4M0E


Note that you need to create database in mysql.

> CREATE TABLE INFO \(
> num INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
> id INT UNSIGNED NOT NULL,
> type INT UNSIGNED NOT NULL,
> text VARCHAR\(255\),
> picture BLOB,
> ext VARCHAR\(10\),
> update_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
> \);
>
> CREATE TABLE MAP \(
> id INT UNSIGNED NOT NULL,
> latitude DOUBLE NOT NULL,
> longitude DOUBLE NOT NULL,
> uid INT UNSIGNED NOT NULL,
> private INT UNSIGNED NOT NULL
> \);
>
> CREATE TABLE USER \(
> num INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
> name VARCHAR\(255\) NOT NULL,
> password VARCHAR\(255\) NOT NULL
> );

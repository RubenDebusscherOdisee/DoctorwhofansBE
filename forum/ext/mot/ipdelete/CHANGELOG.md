# Change Log
All changes to `IP Address Deletion` (aka `ipdelete`) will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/)
and this project adheres to [Semantic Versioning](http://semver.org/).

## [1.0.3] - 2021-01-06

## Added

## Changed
-	IP addresses of deleted users will be overwritten with an empty string instead of an invalid IP address (0:0:0:0 was used).

## Fixed

## Removed

  
## [1.0.2] - 2020-11-24

## Added

## Changed

## Fixed

## Removed
-	Removed the `banlist`, `sessions_keys` and `users` tables from the array of tables to be processed since user related content is already deleted by
	phpBB's `user_delete` function or since there is no user related content within the `banlist' table
  
  
## [1.0.1] - 2020-10-01

### Added

### Changed
-	The array containing the table data is now defined in the function which uses it and no longer as a object property in the `__constructor`

### Fixed

### Removed

  
## [1.0.0] - 2020-09-30

### Added
-	Added files: `CHANGELOG.md`, `composer.json`, `license.txt`, `phpBB-3.2.x_kl.jpg`, `phpBB-3.3.x_kl.jpg`, `README.md`, `config/services.yml` and `event/main_listener.php` 

### Changed

### Fixed

### Removed

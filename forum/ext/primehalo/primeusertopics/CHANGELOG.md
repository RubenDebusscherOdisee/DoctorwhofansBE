# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](http://semver.org/spec/v2.0.0.html).

## [1.1.3] - 2018-05-16
### Added
- Added French and Spanish (formal & casual) translations

## [1.1.2] - 2018-05-12
### Changed
- Changed the L_ prefix to LA_ for language values used in JavaScript so they get properly escaped
- Used a simple replace method for changing '&amp;' back to '&' rather than the textarea value method

## [1.1.1] - 2018-04-24
### Changed
- Updated the JQuery code to make the extension backwards compatible with phpBB 3.1's prosilver style

## [1.1.0] - 2018-04-23
### Added
- CHANGELOG.md, license.txt, and README.md files
- subsilver2 support

### Changed
- Updated for phpBB 3.2
- Combined the JavaScript into a single HTML file: overall_footer_after.html
- Used JQuery to simplify the JavaScript
- Changed the styles subfolder from 'all' to 'prosilver'
- Changed the wording "Search your topics" to "Show your topics" to keep it consistent with phpBB 3.2's wording
- Used service containers instead of global variables in the listener.php file

### Removed
- The three HTML files that previously held the needed JavaScript code: memberlist_view_user_statistics_after.html, navbar_header_quick_links_after.html, overall_footer_content_after.html

## [1.0.0] - 2014-12-15
- First release for phpBB 3.1, ported from the Prime Links extension for phpBB 3.0
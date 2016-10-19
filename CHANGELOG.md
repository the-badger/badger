# Change Log
All notable changes to this project will be documented in this file.
This project adheres to [Semantic Versioning](http://semver.org/).

## [Unreleased]

### Changed
- Drop Semantic UI on admin side. (#107)

## [0.6.1] - 2016-10-04
### Fixed
- Adventure completed/available was not correctly displayed depending on user (GIT-127)

## [0.6.0] - 2016-09-19
### Added
- New Adventures feature! Adventures are step by step journey to unlock rewards & badges.
- Add search functionality on users. You can now search users by their usernames!

### Removed
- Configuration. (Introduced in 0.4.3)

## [0.5.3] - 2016-09-19
### Fixed
- Fix the Slack notifier to correctly send the request to the Slack webhook

## [0.5.2] - 2016-06-09
### Fixed
- Fix fatal error on new user registration
- Fix memory consumption on "give a badge" / "remove a badge" page requests
- Fix displayed remaining days for quests

## [0.5.1] - 2016-06-07
### Fixed
- Quests were not available anymore if at least one user completed it ([GIT-85](https://github.com/akeneo/badger/issues/85))

## [0.5.0] - 2016-06-02
### Added
- Quests. A new Badger mechanics, quests are special events created by admins. Users can complete them to gain nuts and help the community.
- Nuts. Nuts is the virtual money on the Badger application, for now you can only gain nuts with quests. They aren't used yet, but soon!
- Mobile support. Woohoo, the application is no more ugly on smart phone & small screens!

## [0.4.5] - 2016-05-14
### Changed
- Our new and official logo is live \o/ Plus an overall UI refresh.

## [0.4.4] - 2016-04-18
### Fixed
- Fixed a fatal error on user edit during save

## [0.4.3] - 2016-04-18
### Added
- Configuration. Personalize your Badger instance with configuration variables.

## [0.4.2] - 2016-04-04
### Fixed
- Fix routing for claimed badges (admin)

## [0.4.1] - 2016-04-01
### Fixed
- Fixed a fatal error on the tag creation form (admin)

## [0.4.0] - 2016-04-01
### Changed
- Update namespace to Badger instead of Ironforge

### Added
- Tags. User & badges now belong to tags, they are kind of "groups" to better organize your community!
- Admin interface to view users & delete them (just in case, don't worry!)
- Admin CRUD for tags

## [0.3.1] - 2016-02-29
### Changed
- Update displayed application version on login screen

## [0.3.0] - 2016-02-29
### Added
- User can claim a badge
- Admin interface to refuse/accept claimed badges

## [0.2.0] - 2016-02-15
### Added
- User can now click on profile picture instead of the name
- Introduce leaderboard view
- Admin interface to remove given badges

## 0.1.0 - 2016-02-05
### Added
- oAuth login with Github & Google
- Admin CRUD interface for badges
- Admin interface to give badges
- Badge list
- User list
- User profile, with all unlocked badges
- Badge info view, with obtention percentage and user list who have it
- Feedview with recent unlocks

[Unreleased]: https://github.com/akeneo/badger/compare/v0.6.1...HEAD
[0.6.1]: https://github.com/akeneo/badger/compare/v0.6.0...v0.6.1
[0.6.0]: https://github.com/akeneo/badger/compare/v0.5.3...v0.6.0
[0.5.3]: https://github.com/akeneo/badger/compare/v0.5.2...v0.5.3
[0.5.2]: https://github.com/akeneo/badger/compare/v0.5.1...v0.5.2
[0.5.1]: https://github.com/akeneo/badger/compare/v0.5.0...v0.5.1
[0.5.0]: https://github.com/akeneo/badger/compare/v0.4.5...v0.5.0
[0.4.5]: https://github.com/akeneo/badger/compare/v0.4.4...v0.4.5
[0.4.4]: https://github.com/akeneo/badger/compare/v0.4.3...v0.4.4
[0.4.3]: https://github.com/akeneo/badger/compare/v0.4.2...v0.4.3
[0.4.2]: https://github.com/akeneo/badger/compare/v0.4.1...v0.4.2
[0.4.1]: https://github.com/akeneo/badger/compare/v0.4.0...v0.4.1
[0.4.0]: https://github.com/akeneo/badger/compare/v0.3.1...v0.4.0
[0.3.1]: https://github.com/akeneo/badger/compare/v0.3.0...v0.3.1
[0.3.0]: https://github.com/akeneo/badger/compare/v0.2.0...v0.3.0
[0.2.0]: https://github.com/akeneo/badger/compare/v0.1.0...v0.2.0

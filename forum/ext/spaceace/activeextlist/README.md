# Active Extensions List

## Description

Shows total number of active extensions installed in the forum statistics with a link to a new page to a list of the installed extensions with their versions and descriptions.

## Install

1. Download the latest release.
2. Unzip the downloaded release, and change the name of the folder to `activeextlist`.
3. In the `ext` directory of your phpBB board, create a new directory named `spaceace` (if it does not already exist).
4. Copy the `activeextlist` folder to `/ext/spaceace/` (if done correctly, you'll have the main extension class at (your forum root)/ext/spaceace/activeextlist/composer.json).
5. Navigate in the ACP to `Customise -> Manage extensions`.
6. Look for `Active Extensions List` under the Disabled Extensions list, and click its `Enable` link.

## Uninstall

1. Navigate in the ACP to `Customise -> Extension Management -> Extensions`.
2. Look for `Active Extensions List` under the Enabled Extensions list, and click its `Disable` link.
3. To permanently uninstall, click `Delete Data` and then delete the `/ext/spaceace/activeextlist` folder.

## License
[GNU General Public License v2](http://opensource.org/licenses/GPL-2.0)

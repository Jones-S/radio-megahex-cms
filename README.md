# Setup
- `$ composer install`
- setup local host pointing to `/public`
- [Locally]: create a symlink to `/storage/media` within `/public`. On the remote this folder is symlinked to a shared folder!
To do so use this command `$ ln -s /path/to/original /path/to/link` -> if you are in the root folder of the project use: 
`$ ln -s /Users/USER/PATH/radio-megahex-cms/storage/media ./public/media ./public/media`. Using a relative path does not work... 🤷‍♂️
- [Locally]: Rename `.htaccess.example` to `.htaccess` and move it into `/public`.

Now when visiting `cms.megahex.test/panel` you are prompted with a call to install kirby. You can either do that or copy some files from an existing installation
  - `/media/pages`
  - `/storage/accounts` (when copying from remote this is found in `/shared/storage/accounts`. Copy this to `/storage/accounts`)
  - `/storage/content` (when copying from remote this is found in `/shared/storage/content`. Copy this to `/storage/content`)

- Visit the panel. All content should be there

## API
- add `/public/proxy/auth.php` by copying `/public/proxy/auth.example.php`











# Kirby Plainkit

Kirby is a file-based CMS.
Easy to setup. Easy to use. Flexible as hell.

## Trial

You can try Kirby on your local machine or on a test
server as long as you need to make sure it is the right
tool for your next project.

## Buy a license

You can purchase your Kirby license at
<https://getkirby.com/buy>

A Kirby license is valid for a single domain. You can find
Kirby's license agreement here: <https://getkirby.com/license>

## The Plainkit

Kirby's Plainkit is the most minimal setup you can get started with.
It does not include any content, styles or other kinds of decoration,
so it's perfect to use this as a starting point for your own project.

## The Panel

You can find the login for Kirby's admin interface at
http://yourdomain.com/panel. You will be guided through the signup
process for your first user, when you visit the panel
for the first time.

## Installation

Kirby does not require a database, which makes it very easy to
install. Just copy Kirby's files to your server and visit the
URL for your website in the browser.

**Please check if the invisible .htaccess file has been
copied to your server correctly**

### Requirements

Kirby runs on PHP 7.1+, Apache or Nginx.

### Download

You can download the latest version of the Plainkit
from https://github.com/getkirby/plainkit/archive/master.zip

### With Git

If you are familiar with Git, you can clone Kirby's
Plainkit repository from Github.

    git clone https://github.com/getkirby/plainkit.git

## Documentation

<https://getkirby.com/docs>

## Issues

If you have a Github account, please report issues
directly on Github: <https://github.com/getkirby/kirby/issues>

Otherwise you can use Kirby's forum: https://forum.getkirby.com
or send us an email: <support@getkirby.com>

## Ideas & Feature Requests

If you have ideas for new features, please submit a ticket in our ideas repository:
<https://github.com/getkirby/kirby/ideas>

## Support

<https://getkirby.com/support>

## Copyright

© 2009-2019 Bastian Allgeier (Bastian Allgeier GmbH)
<https://getkirby.com>

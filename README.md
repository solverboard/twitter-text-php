# Twitter Text (PHP Edition) #

A library of PHP classes that provide auto-linking and extraction of usernames,
lists, hashtags and URLs from tweets.  Originally created from twitter-text-rb
and twitter-text-java projects by Matt Sanford and ported to PHP by Mike
Cochrane, this library has been improved and made more complete by Nick Pope.

[![Build Status](https://travis-ci.org/nojimage/twitter-text-php.png?branch=master)](https://travis-ci.org/nojimage/twitter-text-php)
[![Coverage Status](https://coveralls.io/repos/nojimage/twitter-text-php/badge.png)](https://coveralls.io/r/nojimage/twitter-text-php)

## Features ##

### Autolink ##

 - Add links to all matching Twitter usernames (no account verification).
 - Add links to all user lists (of the form @username/list-name).
 - Add links to all valid hashtags.
 - Add links to all URLs.
 - Support for international character sets.

### Extractor ###

 - Extract mentioned Twitter usernames (from anywhere in the tweet).
 - Extract replied to Twitter usernames (from start of the tweet).
 - Extract all user lists (of the form @username/list-name).
 - Extract all valid hashtags.
 - Extract all URLs.
 - Support for international character sets.

### Hit Highlighter ###

 - Highlight text specifed by a range by surrounding with a tag.
 - Support for highlighting when tweet has already been autolinked.
 - Support for international character sets.

### Validation ###

 - Validate different twitter text elements.
 - Support for international character sets.

## Examples ##

For examples, please see `tests/example.php` which you can view in a browser or
run from the command line.

## Conformance ##

You'll need the test data which is in YAML format from the following
repository:

    https://github.com/twitter/twitter-text-conformance

    https://github.com/symfony/Yaml

Both requirements already included in `composer.json` and `git submodule`, so you should just need to run:

    curl -s https://getcomposer.org/installer | php
    php composer.phar install --dev
    git submodule update --init

There are a couple of options for testing conformance:

- Run `phpunit` in from the root folder of the project.

## Thanks & Contributions ##

The bulk of this library is from the heroic efforts of:

 - Matt Sanford (https://github.com/mzsanford): For the orignal Ruby and Java implementions.
 - Mike Cochrane (https://github.com/mikenz): For the initial PHP code.
 - Nick Pope (https://github.com/ngnpope): For the bulk of the maintenance work to date.
 - Takashi Nojima (https://github.com/nojimage): For ongoing maintenance work.
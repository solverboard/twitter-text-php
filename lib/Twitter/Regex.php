<?php
/**
 * @author     Mike Cochrane <mikec@mikenz.geek.nz>
 * @author     Nick Pope <nick@nickpope.me.uk>
 * @copyright  Copyright © 2010, Mike Cochrane, Nick Pope
 * @license    http://www.apache.org/licenses/LICENSE-2.0  Apache License v2.0
 * @package    Twitter
 */

/**
 * Twitter Regex Abstract Class
 *
 * Used by subclasses that need to parse tweets.
 *
 * Originally written by {@link http://github.com/mikenz Mike Cochrane}, this
 * is based on code by {@link http://github.com/mzsanford Matt Sanford} and
 * heavily modified by {@link http://github.com/ngnpope Nick Pope}.
 *
 * @author     Mike Cochrane <mikec@mikenz.geek.nz>
 * @author     Nick Pope <nick@nickpope.me.uk>
 * @copyright  Copyright © 2010, Mike Cochrane, Nick Pope
 * @license    http://www.apache.org/licenses/LICENSE-2.0  Apache License v2.0
 * @package    Twitter
 */
abstract class Twitter_Regex {

  /**
   * Expression to match characters that may come before a URL.
   *
   * @var  string
   */
  const REGEX_URL_CHARS_BEFORE = '(?:[^/\"\':!=]|^|\\:)';

  /**
   * Expression to match the domain portion of a URL.
   *
   * @var  string
   */
  const REGEX_URL_DOMAIN = '(?:[\\.-]|[^\\p{P}\\s])+\\.[a-z]{2,}(?::[0-9]+)?';

  /**
   * Expression to match characters that may come in the URL path.
   *
   * @var  string
   */
  const REGEX_URL_CHARS_PATH = '[a-z0-9!\\*\'\\(\\);:&=\\+\\$/%#\\[\\]\\-_\\.,~@]';


  /**
   * Expression to match characters that may come at the end of the URL path.
   *
   * Valid end-of-path chracters (so /foo. does not gobble the period).
   *   1. Allow ) for Wikipedia URLs.
   *   2. Allow =&# for empty URL parameters and other URL-join artifacts.
   *
   * @var  string
   */
  const REGEX_URL_CHARS_PATH_END = '[a-z0-9\\)=#/]';

  /**
   * Expression to match characters that may come in the URL query string.
   *
   * @var  string
   */
  const REGEX_URL_CHARS_QUERY = '[a-z0-9!\\*\'\\(\\);:&=\\+\\$/%#\\[\\]\\-_\\.,~]';

  /**
   * Expression to match characters that may come at the end of the URL query 
   * string.
   *
   * @var  string
   */
  const REGEX_URL_CHARS_QUERY_END = '[a-z0-9_&=#]';

  /**
   * Expression to match a username followed by a list.
   *
   * @var  string
   */
  const REGEX_USERNAME_LIST = '$([^a-z0-9_]|^)([@|＠])([a-z0-9_]{1,20})(/[a-z][a-z0-9\x80-\xFF-]{0,79})?$i';

  /**
   * Expression to match a username mentioned anywhere in a tweet.
   *
   * @var  string
   */
  const REGEX_USERNAME_MENTION = '/(^|[^a-zA-Z0-9_])[@＠]([a-zA-Z0-9_]{1,20})(?=(.|$))/';

  /**
   * Expression to match a hashtag.
   *
   * @var  string
   *
   * @todo  Match latin characters with accents.
   */
  const REGEX_HASHTAG = '$(^|[^0-9A-Z&/]+)([#＃]+)([0-9A-Z_]*[A-Z_]+[a-z0-9_üÀ-ÖØ-öø-ÿ]*)$i';

  /**
   * Expression to match whitespace.
   *
   * Single byte whitespace characters
   *   0x0009-0x000D White_Space # Cc # <control-0009>..<control-000D>
   *   0x0020        White_Space # Zs # SPACE
   *   0x0085        White_Space # Cc # <control-0085>
   *   0x00A0        White_Space # Zs # NO-BREAK SPACE
   * Mutli byte whitespace characters
   *   0x1680        White_Space # Zs # OGHAM SPACE MARK
   *   0x180E        White_Space # Zs # MONGOLIAN VOWEL SEPARATOR
   *   0x2000-0x200A White_Space # Zs # EN QUAD..HAIR SPACE
   *   0x2028        White_Space # Zl # LINE SEPARATOR
   *   0x2029        White_Space # Zp # PARAGRAPH SEPARATOR
   *   0x202F        White_Space # Zs # NARROW NO-BREAK SPACE
   *   0x205F        White_Space # Zs # MEDIUM MATHEMATICAL SPACE
   *   0x3000        White_Space # Zs # IDEOGRAPHIC SPACE
   *
   * @var  string
   */
  const REGEX_WHITESPACE = '[\x09-\x0D\x20\x85\xA0]|\xe1\x9a\x80|\xe1\xa0\x8e|\xe2\x80[\x80-\x8a,\xa8,\xa9,\xaf\xdf]|\xe3\x80\x80';

  /**
   * Contains the complete valid URL pattern string.
   *
   * This should be generated the first time the constructor is called.
   *
   * @var  string  The regex pattern for a valid URL.
   */
  protected static $REGEX_VALID_URL = null;

  /**
   * Contains the reply username pattern string.
   *
   * This should be generated the first time the constructor is called.
   *
   * @var  string  The regex pattern for a reply username.
   */
  protected static $REGEX_REPLY_USERNAME = null;

  /**
   * The tweet to be used in parsing.  This should be populated by the 
   * constructor of all subclasses.
   *
   * @var  string
   */
  protected $tweet = '';

  /**
   * This constructor is used to populate some variables.
   *
   * @param  string  $tweet  The tweet to parse.
   */
  protected function __construct($tweet) {
    if (is_null(self::$REGEX_VALID_URL)) {
      self::$REGEX_VALID_URL = '$('               # $1 Complete match
        . '('.self::REGEX_URL_CHARS_BEFORE.')'    # $2 Preceding character
        . '('                                     # $3 Complete URL
        . '(https?://|www\\.)'                    # $4 Protocol (or www)
        . '('.self::REGEX_URL_DOMAIN.')'          # $5 Domain(s) (and port)
        . '(/'.self::REGEX_URL_CHARS_PATH.'*'     # $6 URL Path
        . self::REGEX_URL_CHARS_PATH_END.'?)?'
        . '(\\?'.self::REGEX_URL_CHARS_QUERY.'*'  # $7 Query String
        . self::REGEX_URL_CHARS_QUERY_END.')?'
        . ')'
        . ')$i';
    }
    if (is_null(self::$REGEX_REPLY_USERNAME)) {
      self::$REGEX_REPLY_USERNAME = '/^('.self::REGEX_WHITESPACE.')*[@＠]([a-zA-Z0-9_]{1,20})/';
    }
    $this->tweet = $tweet;
  }

}
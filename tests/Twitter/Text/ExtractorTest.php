<?php

/**
 * @author     Nick Pope <nick@nickpope.me.uk>
 * @copyright  Copyright © 2010, Mike Cochrane, Nick Pope
 * @license    http://www.apache.org/licenses/LICENSE-2.0  Apache License v2.0
 * @package    Twitter.Text
 */

namespace Twitter\Text;

use Twitter\Text\Extractor;
use Symfony\Component\Yaml\Yaml;

/**
 * Twitter Extractor Class Unit Tests
 *
 * @author     Nick Pope <nick@nickpope.me.uk>
 * @copyright  Copyright © 2010, Mike Cochrane, Nick Pope
 * @license    http://www.apache.org/licenses/LICENSE-2.0  Apache License v2.0
 * @package    Twitter.Text
 * @param      Extractor $extractor
 */
class ExtractorTest extends \PHPUnit_Framework_TestCase
{

    protected function setUp()
    {
        parent::setUp();
        $this->extractor = Extractor::create();
    }

    protected function tearDown()
    {
        unset($this->extractor);
        parent::tearDown();
    }

    /**
     * A helper function for providers.
     *
     * @param  string  $test  The test to fetch data for.
     *
     * @return  array  The test data to provide.
     */
    protected function providerHelper($test)
    {
        $data = Yaml::parse(DATA . '/extract.yml');
        return isset($data['tests'][$test]) ? $data['tests'][$test] : array();
    }

    /**
     * @group conformance
     * @group Extractor
     * @dataProvider  extractMentionedScreennamesProvider
     */
    public function testExtractMentionedScreennames($description, $text, $expected)
    {
        $extracted = $this->extractor->extractMentionedScreennames($text);
        $this->assertSame($expected, $extracted, $description);
    }

    /**
     * @group conformance
     * @group Extractor
     * @group deprecated
     * @dataProvider  extractMentionedScreennamesProvider
     */
    public function testExtractMentionedUsernames($description, $text, $expected)
    {
        $extracted = Extractor::create($text)->extractMentionedUsernames();
        $this->assertSame($expected, $extracted, $description);
    }

    /**
     *
     */
    public function extractMentionedScreennamesProvider()
    {
        return $this->providerHelper('mentions');
    }

    /**
     * @group conformance
     * @group Extractor
     * @dataProvider  extractReplyScreennameProvider
     */
    public function testExtractReplyScreenname($description, $text, $expected)
    {
        $extracted = $this->extractor->extractReplyScreenname($text);
        $this->assertSame($expected, $extracted, $description);
    }

    /**
     * @group conformance
     * @group Extractor
     * @group deprecated
     * @dataProvider  extractReplyScreennameProvider
     */
    public function testExtractRepliedUsernames($description, $text, $expected)
    {
        $extracted = Extractor::create($text)->extractRepliedUsernames();
        $this->assertSame($expected, $extracted, $description);
    }

    /**
     *
     */
    public function extractReplyScreennameProvider()
    {
        return $this->providerHelper('replies');
    }

    /**
     * @group conformance
     * @group Extractor
     * @dataProvider  extractURLsProvider
     */
    public function testExtractURLs($description, $text, $expected)
    {
        $extracted = $this->extractor->extractURLs($text);
        $this->assertSame($expected, $extracted, $description);
    }

    /**
     *
     */
    public function extractURLsProvider()
    {
        return $this->providerHelper('urls');
    }

    /**
     * @group conformance
     * @group Extractor
     * @dataProvider  extractHashtagsProvider
     */
    public function testExtractHashtags($description, $text, $expected)
    {
        $extracted = $this->extractor->extractHashtags($text);
        $this->assertSame($expected, $extracted, $description);
    }

    /**
     *
     */
    public function extractHashtagsProvider()
    {
        return $this->providerHelper('hashtags');
    }

    /**
     * @group conformance
     * @group Extractor
     * @dataProvider  extractHashtagsWithIndicesProvider
     */
    public function testExtractHashtagsWithIndices($description, $text, $expected)
    {
        $extracted = $this->extractor->extractHashtagsWithIndices($text);
        $this->assertSame($expected, $extracted, $description);
    }

    /**
     *
     */
    public function extractHashtagsWithIndicesProvider()
    {
        return $this->providerHelper('hashtags_with_indices');
    }

    /**
     * @group conformance
     * @group Extractor
     * @dataProvider  extractCashtagsProvider
     */
    public function testExtractCashtags($description, $text, $expected)
    {
        $extracted = $this->extractor->extractCashtags($text);
        $this->assertSame($expected, $extracted, $description);
    }

    /**
     *
     */
    public function extractCashtagsProvider()
    {
        return $this->providerHelper('cashtags');
    }

    /**
     * @group conformance
     * @group Extractor
     * @dataProvider  extractCashtagsWithIndicesProvider
     */
    public function testExtractCashtagsWithIndices($description, $text, $expected)
    {
        $extracted = $this->extractor->extractCashtagsWithIndices($text);
        $this->assertSame($expected, $extracted, $description);
    }

    /**
     *
     */
    public function extractCashtagsWithIndicesProvider()
    {
        return $this->providerHelper('cashtags_with_indices');
    }

    /**
     * @group conformance
     * @group Extractor
     * @dataProvider  extractURLsWithIndicesProvider
     */
    public function testExtractURLsWithIndices($description, $text, $expected)
    {
        $extracted = $this->extractor->extractURLsWithIndices($text);
        $this->assertSame($expected, $extracted, $description);
    }

    /**
     *
     */
    public function extractURLsWithIndicesProvider()
    {
        return $this->providerHelper('urls_with_indices');
    }

    /**
     * @group conformance
     * @group Extractor
     * @dataProvider  extractMentionedScreennamesWithIndicesProvider
     */
    public function testExtractMentionedScreennamesWithIndices($description, $text, $expected)
    {
        $extracted = $this->extractor->extractMentionedScreennamesWithIndices($text);
        $this->assertSame($expected, $extracted, $description);
    }

    /**
     * @group conformance
     * @group Extractor
     * @group deprecated
     * @dataProvider  extractMentionedScreennamesWithIndicesProvider
     */
    public function testExtractMentionedUsernamesWithIndices($description, $text, $expected)
    {
        $extracted = Extractor::create($text)->extractMentionedUsernamesWithIndices();
        $this->assertSame($expected, $extracted, $description);
    }

    /**
     *
     */
    public function extractMentionedScreennamesWithIndicesProvider()
    {
        return $this->providerHelper('mentions_with_indices');
    }

    /**
     * @group conformance
     * @group Extractor
     * @dataProvider  extractMentionsOrListsWithIndicesProvider
     */
    public function testExtractMentionsOrListsWithIndices($description, $text, $expected)
    {
        $extracted = $this->extractor->extractMentionsOrListsWithIndices($text);
        $this->assertSame($expected, $extracted, $description);
    }

    /**
     * @group conformance
     * @group Extractor
     * @group deprecated
     * @dataProvider  extractMentionsOrListsWithIndicesProvider
     */
    public function testExtractMentionedUsernamesOrListsWithIndices($description, $text, $expected)
    {
        $extracted = Extractor::create($text)->extractMentionedUsernamesOrListsWithIndices();
        $this->assertSame($expected, $extracted, $description);
    }

    /**
     *
     */
    public function extractMentionsOrListsWithIndicesProvider()
    {
        return $this->providerHelper('mentions_or_lists_with_indices');
    }

    /**
     * @group Extractor
     */
    public function testExtractURLsWithoutProtocol()
    {
        $extracted = Extractor::create('text: example.com http://foobar.example.com')->extractUrlWithoutProtocol(false)->extractURLs();
        $this->assertSame(array('http://foobar.example.com'), $extracted, 'Unextract url without protocol');
    }

    /**
     * @group Extractor
     */
    public function testExtractURLsWithIndicesWithoutProtocol()
    {
        $extracted = Extractor::create('text: example.com')->extractUrlWithoutProtocol(false)->extractURLsWithIndices();
        $this->assertSame(array(), $extracted, 'Unextract url without protocol');
    }
}

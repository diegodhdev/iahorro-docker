<?php

declare(strict_types=1);

namespace App\Http\Controllers\Tests\Features;

use Behat\Gherkin\Node\PyStringNode;
use Illuminate\Support\Facades\DB;
use RuntimeException;
use Soulcodex\Behat\Addon\Context;

final class GenericContext extends Context
{

    /**
     * @Given I send a GET request to :url:
     */
    public function iSendAGetRequestTo($url): void
    {
        $this->visitPath($url);
    }

    /**
     * @Given I send a POST request to :url with body:
     */
    public function iSendAPostRequestTo($url, PyStringNode $body): void
    {
        DB::beginTransaction();
        $this->getSession()->getDriver()->getClient()->request(
            'POST',
            $url,
            json_decode($body->getRaw(), true, 512, JSON_THROW_ON_ERROR)
        );
        DB::rollBack();
    }

    /**
     * @Given I send a PUT request to :url with body:
     */
    public function iSendAPutRequestTo($url, PyStringNode $body): void
    {
        DB::beginTransaction();

        $this->getSession()->getDriver()->getClient()->request(
            'PUT',
            $url,
            json_decode($body->getRaw(), true, 512, JSON_THROW_ON_ERROR)
        );
        DB::rollBack();
    }

    /**
     * @Then the response status code should be :expectedResponseCode
     */
    public function theResponseStatusCodeShouldBe(mixed $expectedResponseCode): void
    {
        if ($this->session()->getStatusCode() !== (int)$expectedResponseCode) {
            throw new RuntimeException(
                sprintf(
                    'The status code <%s> does not match the expected <%s>',
                    $this->session()->getStatusCode(),
                    $expectedResponseCode
                )
            );
        }
    }

    /**
     * @Then I for sure should see :string
     */
    public function iShouldSee($string): void
    {
        $this->assertSession()->pageTextContains($string);
    }

    /**
     * @Then I should see selector :selector with a value of :value
     */
    public function iShouldSeeSelector($selector, $value): void
    {
        $page = $this->session()->getPage();
        $node = $page->find('named', [$selector, $value]);

        if (!$node) {
            throw new RuntimeException(
                sprintf(
                    'Selector <%s> / <%s> not found',
                    $selector,
                    $value
                )
            );
        }
    }
}

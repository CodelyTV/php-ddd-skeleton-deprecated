<?php

declare(strict_types = 1);

namespace CodelyTv\Tests\Shared\Infrastructure\Behat;

use Behat\Gherkin\Node\PyStringNode;
use Behat\Mink\Session;
use Behat\MinkExtension\Context\RawMinkContext;
use CodelyTv\Tests\Shared\Infrastructure\Mink\MinkHelper;
use CodelyTv\Tests\Shared\Infrastructure\Mink\MinkSessionRequestHelper;

final class ApiRequestContext extends RawMinkContext
{
    private $request;

    public function __construct(Session $session)
    {
        $this->request = new MinkSessionRequestHelper(new MinkHelper($session));
    }

    /**
     * @Given I send a :method request to :url
     */
    public function iSendARequestTo($method, $url): void
    {
        $this->request->sendRequest($method, $this->locatePath($url));
    }

    /**
     * @Given I send a :method request to :url with body:
     */
    public function iSendARequestToWithBody($method, $url, PyStringNode $body): void
    {
        $this->request->sendRequestWithPyStringNode($method, $this->locatePath($url), $body);
    }
}

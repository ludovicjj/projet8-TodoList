<?php

use Behat\MinkExtension\Context\MinkContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

/**
 * Defines application features from the specific context.
 */
class FeatureContext extends MinkContext
{
    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
    }

    /**
     * Finds link with specified locator.
     *
     * @param string $locator link id, title, text or image alt
     *
     * @Then I should see link :locator
     */
    public function iShouldSeeLink($locator)
    {
        $session = $this->getSession();
        $element = $session->getPage()->findLink($locator);
        if (null == $element) {
            throw new InvalidArgumentException(sprintf('Cannot find link: "%s"', $locator));
        }
    }

    /**
     * @param string $locator link id, title, text or image alt
     *
     * @Then I not should see link :locator
     */
    public function iNotShouldSeeLink($locator)
    {
        $session = $this->getSession();
        $element = $session->getPage()->findLink($locator);
        if (null !== $element) {
            throw new InvalidArgumentException(sprintf('Expected cannot find link: "%s" but link found', $locator));
        }
    }
}

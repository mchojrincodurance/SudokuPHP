<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use function PHPUnit\Framework\assertEquals;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{
    private string $testDataDir;
    private array $output = [];

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     * @param string $testDataDir
     */
    public function __construct(string $testDataDir)
    {
        $this->testDataDir = $testDataDir;
    }

    /**
     * @Given there is a file called :arg1, which contains:
     */
    public function thereIsAFileCalledWhichContains(string $filename, TableNode $table): void
    {
        $file = fopen($this->testDataDir.DIRECTORY_SEPARATOR.$filename, "w");
        foreach ($table->getRows() as $row) {
            fputcsv($file, $row, ",", '"', '\\', ','.PHP_EOL);
        }
        fclose($file);
    }

    /**
     * @Then I should get :arg1
     */
    public function iShouldGet(string $message): void
    {
        assertEquals($message, current($this->output));
    }

    /**
     * @When /^I ask the checker to check the file "([^"]*)"$/
     */
    public function iAskTheCheckerToCheckTheFile(string $filename): void
    {
        exec("php check_solution.php ".$this->testDataDir.DIRECTORY_SEPARATOR.$filename, $this->output);
    }
}

<?php


namespace App\Codebook;



class MetaDataExchangeModell extends AbstractJsonSerializeModell
{
    private $variables;

    private function __construct()
    {
        $this->variables = [];
    }

    public function getVariables()
    {
        return $this->variables;
    }

    public function addVariable($addedVariable)
    {
        $this->variables[] = $addedVariable;
    }

    public function removeVariable($removedVariable)
    {
        return array_diff($this->variables, [$removedVariable]);
    }

    public static function createFrom(array $variables ): MetaDataExchangeModell
    {
        $exchangeModell = new MetaDataExchangeModell();

        foreach ($variables as $variable) {
            if ($variable instanceof VariableModell) {
                $exchangeModell->addVariable($variable);
            }
        }

        return $exchangeModell;
    }

    public static function createEmpty(): MetaDataExchangeModell
    {
        return new MetaDataExchangeModell();
    }

    public function getJsonString(): string
    {
        // TODO: Implement getJsonString() method.
        return 'unimplemented';
    }

    public static function createFromJson(string $jsonString)
    {
        // TODO: Implement createFromJson() method.
    }
}
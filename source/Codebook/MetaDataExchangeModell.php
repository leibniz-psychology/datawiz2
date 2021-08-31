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
        $this->variables = array_diff($this->variables, [$removedVariable]);
    }

    public static function createFrom(array $variables): MetaDataExchangeModell
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
        $modell = new MetaDataExchangeModell();

        // $modell->addVariable(VariableModell::createEmpty("1"));
        // $modell->addVariable(VariableModell::createEmpty("2"));
        // $modell->addVariable(VariableModell::createEmpty("3"));

        for ($i = 1; $i <= 30; $i++) {
            $modell->addVariable(VariableModell::createEmpty("$i"));
        }
        return $modell;
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }

    public function getJsonString(): string
    {
        // TODO: Implement getJsonString() method.
        return json_encode($this);
    }

    public static function createFromJson(string $jsonString)
    {
        // TODO: Implement createFromJson() method.
    }
}

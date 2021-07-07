<?php


namespace App\Domain\Definition;




trait MetaDataRetrievable
{
    public function getMetaDataMap(): array
    {
        $reflection = new \ReflectionClass(self::class);

        $metaDataArray = array();
        $retrieveMethods = array_filter(
            $reflection->getMethods(\ReflectionMethod::IS_PUBLIC),
            function (\ReflectionMethod $method) {
                return str_starts_with($method->getName(), 'retrieve');
        });
        foreach ($retrieveMethods as $retriever) {
            $metaDataArray[] = $retriever->invoke($this);
        }

        return $metaDataArray;
    }
}
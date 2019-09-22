<?php


namespace app\common;


class ProxyFileCSV extends ProxyFile
{
    public const COLUMN_DELIMITER = ';';
    public const SKIP_VOID_STRINGS = true;

    public function getAllProxy(): array
    {
        $allProxy = [];
        $handle = fopen($this->fullFileName,'r');
        $columnOrder = self::getColumnOrder();
        while ( ($proxyData = fgetcsv($handle, 0, self::COLUMN_DELIMITER) ) !== FALSE ) {
            if ( null === $proxyData ) {
                throw new Exception('Invalid file handle');
            }

            if ( self::SKIP_VOID_STRINGS && null === $proxyData[0]  && 1 === count($proxyData) ) {
                continue;
            }

            $this->validateProxyDataRow($proxyData);
            $proxyDataWithLabel = array_combine($columnOrder, $proxyData);
            $allProxy[] = $proxyDataWithLabel;
        }
        return $allProxy;
    }

    private static function getColumnOrder(): array
    {
        return ['ip', 'port'];
    }
    private function validateProxyDataRow($proxyData)
    {
        $columnOrder = self::getColumnOrder();
        if ( count($proxyData)  !== count($columnOrder) ) {
            throw new Exception('Invalid count column in ' . print_r($proxyData) );
        }
    }
}
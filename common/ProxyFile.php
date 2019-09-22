<?php


namespace app\common;


use yii\web\UploadedFile;

abstract class ProxyFile
{
    protected $fullFileName;

    /**
     * ProxyFile constructor.
     * @param string $fullFileName
     * @throws \Exception
     */
    public function __construct(string $fullFileName)
    {
        if ( !file_exists($fullFileName) ) {
            throw new \Exception("File not found $fullFileName");
        }
        $this->fullFileName = $fullFileName;
    }

    /**
     * @return array
     */
    abstract public function getAllProxy(): array ;
}
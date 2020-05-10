<?php
/**
 * Created by PhpStorm.
 * User: jonathan
 * Date: 2020/2/8
 */

namespace Leading\Lib\Traits;

use SimpleXMLElement;

/**
 * Trait XMLSerializer
 * @package LarAnt\Lib\Traits
 */
trait XMLSerializer
{
    /**
     * @param $contents
     * @return array
     */
    public function str2Array($contents): array
    {
        if (is_array($contents)) {
            return $contents;
        }

        return \GuzzleHttp\json_decode($contents, true);
    }

    /**
     * @param $xml
     * @return array
     */
    public function xml2Array($xml)
    {
        return \GuzzleHttp\json_decode(
            \GuzzleHttp\json_encode($xml),
            true
        );
    }

    /**
     * @param $contents
     * @return SimpleXMLElement
     */
    public function toSimpleXMLElement($contents)
    {
        // 简单的解决命名空间的问题
        $contents = str_replace('xmlns=', 'ns=', $contents);
        $contents = str_replace(['ns2:'], '', $contents);

        return simplexml_load_string($contents);
    }

    /**
     * @param SimpleXMLElement $element
     * @param $path
     * @param mixed $default
     * @return string|mixed
     */
    public function findXMLValue(SimpleXMLElement $element, $path, $default = null)
    {
        $e = $this->findXMLElement($element, $path);

        return $e ? strval($e) : $default;
    }


    /**
     * @param SimpleXMLElement $element
     * @param string $path
     * @param int $index
     * @return SimpleXMLElement|false
     */
    public function findXMLElement(SimpleXMLElement $element, $path, $index = 0)
    {
        $es = $this->findXMLElements($element, $path);

        return $es[$index] ?? false;
    }

    /**
     * @param SimpleXMLElement $element
     * @param string $path (relative path to root)
     * @return SimpleXMLElement[]
     */
    public function findXMLElements(SimpleXMLElement $element, $path)
    {
        return $element->xpath($path);
    }

    /**
     * @param SimpleXMLElement $element
     * @param string $attr
     * @return string|null
     */
    public function findXMLAttr(SimpleXMLElement $element, string $attr)
    {
        if (isset($element[$attr])) {
            return strval($element[$attr]);
        }
        return null;
    }

}
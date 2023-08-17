<?php

namespace FormKit;

class Parser
{

    static function Parse(string $html)
    {
        $nodes = [];

        $dom = new \DOMDocument();
        $dom->loadHTML($html);
        $root = $dom->documentElement;


        foreach ($root->childNodes as $node) {

            if ($node->nodeType === XML_TEXT_NODE) {
                $nodes[] = new Text();
                //  $nodes[] = $node->nodeValue;
            } elseif ($node->nodeType === XML_ELEMENT_NODE) {
                $name = $node->nodeName;
                $attrs = [];
                foreach ($node->attributes as $attr) {
                    $attrs[$attr->name] = $attr->value;
                }
                $children = [];
                foreach ($node->childNodes as $child) {
                    if ($child->nodeType === XML_ELEMENT_NODE) {
                        $children[] = self::Parse($child);
                    } elseif ($child->nodeType === XML_TEXT_NODE) {
                        $children[] = $child->nodeValue;
                    }
                }
                $nodes[] = new ElementNode($name, $attrs, $children);
            }
        }
        return $nodes;
    }
}

<?php
Class AionXMLReader
{

    private $reader;
    private $tag;

    // if $ignoreDepth == 1 then will parse just first level, else parse 2th level too

    private function parseBlock($name, $ignoreDepth = 1) {
        if ($this->reader->name == $name && $this->reader->nodeType == XMLReader::ELEMENT) {
            $result = array();
            while (!($this->reader->name == $name && $this->reader->nodeType == XMLReader::END_ELEMENT)) {
                //echo $this->reader->name. ' - '.$this->reader->nodeType." - ".$this->reader->depth."\n";
                switch ($this->reader->nodeType) {
                    case 1:
                        if ($this->reader->depth > 3 && !$ignoreDepth) {
                            $result[$nodeName] = (isset($result[$nodeName]) ? $result[$nodeName] : array());
                            while (!($this->reader->name == $nodeName && $this->reader->nodeType == XMLReader::END_ELEMENT)) {
                                $resultSubBlock = $this->parseBlock($this->reader->name, 1);

                                if (!empty($resultSubBlock))
                                    $result[$nodeName][] = $resultSubBlock;

                                unset($resultSubBlock);
                                $this->reader->read();
                            }
                        }
                        $nodeName = $this->reader->name;
                        if ($this->reader->hasAttributes) {
                            $attributeCount = $this->reader->attributeCount;

                            for ($i = 0; $i < $attributeCount; $i++) {
                                $this->reader->moveToAttributeNo($i);
                                $result['attr'][$this->reader->name] = $this->reader->value;
                            }
                            $this->reader->moveToElement();
                        }
                        break;

                    case 3:
                    case 4:
                        $result[$nodeName] = $this->reader->value;
                        $this->reader->read();
                        break;
                }

                $this->reader->read();
            }
            return $result;
        }
    }

    public function parse_item($filename) {
        $items = array();

        if (!$filename) return $items;

        $this->reader = new XMLReader();
        $this->reader->open($filename);

        // begin read XML
        while ($this->reader->read()) {
            if ($this->reader->name == 'client_item') {
                // while not found end tag read blocks
                while (!($this->reader->name == 'client_item' && $this->reader->nodeType == XMLReader::END_ELEMENT)) {
                    $store_category = $this->parseBlock('client_item');
                    if (isset($store_category['id'])) {
                        $items[(int)$store_category['id']] == array(
                            'name' => $store_category['desc'],
                            'name_obj' => $store_category['name'],
                            'add_name' => '',
                            'description' => isset($store_category['desc_long']) ? $store_category['desc_long'] : '',
                            'icon' => isset($store_category['icon_name']) ? $store_category['icon_name'] : '',
                            'icon_panel' => $store_category[''],
                            'grade' => isset($store_category['level']) ? (int) $store_category['level'] : 0,
                            'type' => isset($store_category['armor_type']) ? 'armor' : (isset($store_category['weapon_type']) ? 'weapon' : 'misc'),
                            'stackable' => isset($store_category['max_stack_count']) ? 1 : 0,
                        );
                    }
                    $this->reader->read();
                }
                $this->reader->read();
            }

        } // while

        return $items;
    } // func
}
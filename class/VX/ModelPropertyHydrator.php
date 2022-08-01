<?php

namespace VX;

use Laminas\Hydrator\ObjectPropertyHydrator;

class ModelPropertyHydrator extends ObjectPropertyHydrator
{
    public function extract(object $object): array
    {
        if ($object instanceof Model) {

            $data = [];
            foreach ($object->__fields() as $fields) {
                $data[$fields] = $object->$fields;
            }


            $filter = $this->getFilter();

            foreach ($data as $name => $value) {
                // Filter keys, removing any we don't want
                if (!$filter->filter($name)) {
                    unset($data[$name]);
                    continue;
                }

                // Replace name if extracted differ
                $extracted = $this->extractName($name, $object);

                if ($extracted !== $name) {
                    unset($data[$name]);
                    $name = $extracted;
                }

                $data[$name] = $this->extractValue($name, $value, $object);
            }

            return $data;
        }

        return parent::extract($object);
    }
}

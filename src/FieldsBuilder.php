<?php

namespace Understory\Fields;

class FieldsBuilder
{
    private $config = [];
    private $fields = [];

    public function __construct($name, $groupConfig = [])
    {
       $this->configure($name, $groupConfig);
    }

    public function configure($name, $groupConfig = [])
    {
        $config = array_merge(
            $this->config, 
            [
                'key' => 'group_'.$name,
                'title' => $this->createLabel($name),
            ], 
            $groupConfig
        );

        $this->config = $config;
        return $this;
    }

    public function build()
    {
        return array_merge($this->config, [
            'fields' => $this->fields,        
        ]);
    }

    public function addField($name, $args = [])
    {
        $field = array_merge([
            'key' => 'field_'.$name,
            'name' => $name,
            'label' => $this->createLabel($name),
        ], $args);

        $this->pushField($field);

        return $this;
    }

    protected function addFieldType($name, $type, $args = [])
    {
        return $this->addField($name, array_merge([
            'type' => $type,
        ], $args));
    } 

    public function addText($name, $args = [])
    {
        return $this->addFieldType($name, 'text', $args);
    }

    public function addTextarea($name, $args = [])
    {
        return $this->addFieldType($name, 'textarea', $args);
    }

    public function addNumber($name, $args = [])
    {
        return $this->addFieldType($name, 'number', $args);
    }

    public function addEmail($name, $args = [])
    {
        return $this->addFieldType($name, 'email', $args);
    }

    public function addUrl($name, $args = [])
    {
        return $this->addFieldType($name, 'url', $args);
    }

    public function addPassword($name, $args = [])
    {
        return $this->addFieldType($name, 'password', $args);
    }

    public function addWysiwyg($name, $args = [])
    {
        return $this->addFieldType($name, 'wysiwyg', $args);
    }

    public function addOembed($name, $args = [])
    {
        return $this->addFieldType($name, 'oembed', $args);
    }

    public function addImage($name, $args = [])
    {
        return $this->addFieldType($name, 'image', $args);
    }

    public function addFile($name, $args = [])
    {
        return $this->addFieldType($name, 'file', $args);
    }

    public function addGallery($name, $args = [])
    {
        return $this->addFieldType($name, 'gallery', $args);
    }

    public function addTrueFalse($name, $args = [])
    {
        return $this->addFieldType($name, 'true_false', $args);
    }

    public function addSelect($name, $args = [])
    {
        return $this->addFieldType($name, 'select', $args);
    }

    public function addRadio($name, $args = [])
    {
        return $this->addFieldType($name, 'radio', $args);
    }

    public function addCheckbox($name, $args = [])
    {
        return $this->addFieldType($name, 'checkbox', $args);
    }

    public function addChoice($choice, $label = null)
    {
        $field = $this->popLastField();

        array_key_exists('choices', $field) ?: $field['choices'] = [];
        $label ?: $label = $choice;

        $field['choices'][$choice] = $label;
        $this->pushField($field);

        return $this;
    }

    public function setDefault($value)
    {
        return $this->setConfig('default_value', $value);
    }

    public function setConfig($key, $value)
    {
        $field = $this->popLastField();
        $field['default_value'] = $value;
        $this->pushField($field);

        return $this;
    }

    protected function popLastField()
    {
        return array_pop($this->fields);
    }

    protected function pushField($field)
    {
        $this->fields[] = $field;
    }

    protected function createLabel($name)
    {
        return ucwords(str_replace("_", " ", $name));
    }
}

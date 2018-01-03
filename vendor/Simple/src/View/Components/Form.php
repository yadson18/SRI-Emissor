<?php
    namespace Simple\View\Components;
    
    class Form
    {
        private static $tags = [
            'button' => [
                'options' => ['type' => 'submit', 'class' => 'btn btn-default'],
                'tag' => '<button %options%>%name%</button>'
            ],
            'input' => [
                'options' => ['type' => 'text', 'class' => 'form-control'],
                'tag' => '<input %options%/>'
            ],
            'select' => [
                'options' => ['class' => 'form-control'],
                'tag' => '<select %options%>%tags%</select>'
            ],
            'option' => ['tag' => '<option value="%value%">%name%</option>'],  
            'label' => ['tag' => '<label>%name%</label>'],
            'formStart' => ['tag' => '<form %options%>'],
            'formEnd' => ['tag' => '</form>']
        ];

        public function input(string $labelName, array $options = [])
        {
            return $this->label($labelName) . 
                $this->replaceProperties('input', [
                    '%options%' => $this->mountOptions($this->mixOptions(
                        'input', array_merge([
                            'name' => strtolower($labelName),
                            'id' => strtolower($labelName)
                        ], $options)
                    ))
                ]);
        }

        public function select(string $labelName, array $options = [])
        {
            if (isset($options['options'])) {
                $optionsTags = '';

                foreach ($options['options'] as $name => $value) {
                    $optionsTags .= $this->option($name, $value);
                }
                unset($options['options']);

                return $this->label($labelName) . 
                    $this->replaceProperties('select', [
                        '%tags%' => $optionsTags,
                        '%options%' => $this->mountOptions($this->mixOptions(
                            'select', array_merge([
                                'name' => strtolower($labelName),
                                'id' => strtolower($labelName)
                            ], $options)
                        ))
                    ]);
            }

        }

        protected function option($name, $value)
        {
            return $this->replaceProperties('option', [
                '%value%' => $value,
                '%name%' => $name
            ]);
        }

        public function button(string $buttonName, array $options = [])
        {
            return $this->replaceProperties('button', [
                '%name%' => $buttonName,
                '%options%' => $this->mountOptions($this->mixOptions(
                    'button', array_merge([
                        'id' => strtolower($buttonName)
                    ], $options)
                ))
            ]);
        }

        public function start(array $options = [])
        {
            return $this->replaceProperties('formStart', [
                '%options%' => $this->mountOptions($options)
            ]);
        }

        public function end()
        {
            return $this->replaceProperties('formEnd', []);
        }

        protected function label(string $name)
        {
            return $this->replaceProperties('label', ['%name%' => $name]);
        }

        protected function mixOptions(string $elementName, array $options)
        {
            return array_merge($this->getOptions($elementName), $options);
        }

        protected function getOptions(string $elementName)
        {
            if (isset(static::$tags[$elementName]['options'])) {
                return static::$tags[$elementName]['options'];
            }
        }

        protected function mountOptions(array $options)
        {
            $elementOptions = '';

            foreach ($options as $attribute => $value) {
                if (is_string($attribute)) {
                    $elementOptions .= ' ' . $attribute . '="' . $value . '"';
                }
            }
            return substr($elementOptions, 1);
        }

        protected function replaceProperties(string $tag, array $properties)
        {
            if (isset(static::$tags[$tag]['tag'])) {
                return replaceRecursive(static::$tags[$tag]['tag'], $properties);
            }
        }
    }
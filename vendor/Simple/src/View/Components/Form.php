<?php
    namespace Simple\View\Components;
    
    class Form
    {
        private static $defaultAttributes = [
            'input' => [
                'class' => 'form-control input-sm text-uppercase',
                'required' => true,
                'type' => 'text'
            ],
            'select' => [
                'class' => 'form-control input-sm text-uppercase'
            ],
            'button' => [
                'class' => 'btn btn-default',
                'type' => 'submit'
            ],
            'form' => [
                'method' => 'POST'
            ]
        ];

        public function input(string $labelName, array $options = [])
        {
            if (!isset($options['id'])) {
                $options['id'] = $this->formatTagId($labelName);
            }
            if (!isset($options['name'])) {
                $options['name'] = $this->formatTagId($labelName);
            }

            return implode([
                $this->buildTag('<label></label>', [], $labelName),
                $this->buildTag('<input>', $options)
            ]);
        }

        public function select(string $labelName, array $optionsValue, array $options = [])
        {
            $optionsTags = [];

            if (!isset($options['id'])) {
                $options['id'] = $this->formatTagId($labelName);
            }
            if (!isset($options['name'])) {
                $options['name'] = $this->formatTagId($labelName);
            }

            foreach ($optionsValue as $name => $value) {
                $attributes = [];

                if (isset($options['selected']) && $options['selected'] === $value) {
                    $attributes['selected'] = true;
                    unset($options['selected']);
                }

                $optionsTags[] = $this->option($name, $value, $attributes);
            }

            return implode([
                $this->buildTag('<label></label>', [], $labelName),
                $this->buildTag('<select></select>', $options, implode($optionsTags))
            ]);
        }

        protected function option(string $name, $value, array $options = [])
        {
            $options['value'] = $value;

            return $this->buildTag('<option></option>', $options, $name);
        }

        public function button(string $text, array $options = [])
        {
            if (!isset($options['id'])) {
                $options['id'] = $this->formatTagId($text);
            }

            return $this->buildTag('<button></button>', $options, $text);
        }

        public function start($entity = null, array $options = [])
        {
            return $this->buildTag('<form>', $options);
        }

        public function end()
        {
            return $this->buildTag('</form>');
        }

        protected function buildTag(string $tag, array $attrs = [], string $content = null)
        {
            $tagName = substr($tag, 1, (strpos($tag, '>') - 1));
            $tagPatternOne = '/<[a-zA-Z1-6]+>(.*)<\/[a-zA-Z1-6]+>/';
            $tagPatternTwo = '/<[a-zA-Z1-6]+>/';
            $tagPatternThree = '/<\/[a-zA-Z1-6]+>/';

            if (isset(static::$defaultAttributes[$tagName])) {
                $attrs = $this->mergeAttributes($attrs, static::$defaultAttributes[$tagName]);
            }

            $attrs = $this->mountAttributes($attrs);

            if (preg_match($tagPatternOne, $tag) || preg_match($tagPatternTwo, $tag) ||
                preg_match($tagPatternThree, $tag) 
            ) {
                $tagSplit = str_split($tag);
                array_splice($tagSplit, array_search('>', $tagSplit), 0, [$attrs]);

                if (preg_match($tagPatternOne, $tag)) {
                    array_splice(
                        $tagSplit, (array_search('>', $tagSplit) + 1), 0, [$content]
                    );
                }

                return implode($tagSplit);
            }
        }

        protected function mergeAttributes(array $attrsOne = [], array $attrsTwo = [])
        {
            return array_merge($attrsTwo, $attrsOne);
        }

        protected function mountAttributes(array $attributes)
        {
            $attrs = implode(' ', array_map(function($attribute, $values) {
                    if (!is_array($values)) {
                        if ($values !== false) {
                            return $attribute . '="' . $values . '"';
                        }
                    }
                }, 
                array_keys($attributes), array_values($attributes)
            ));

            return (!empty($attrs)) ? ' ' . $attrs : '';
        }

        protected function formatTagId(string $id)
        {
            return str_replace(' ', '-', sanitize(strtolower($id)));
        }
    }
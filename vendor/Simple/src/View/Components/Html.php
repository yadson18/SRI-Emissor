<?php  
    namespace Simple\View\Components;
    
    class Html
    {
        private static $tags = [
            'meta' => '<meta charset="%encode%"/>',
            'link' => '<link rel="stylesheet/%type%" type="text/css" href="%href%"/>',
            'script' => '<script type="text/javascript" src="/js/%script%"></script>'
        ];

        private static $encode;

        public function encoding()
        {
            return $this->replaceProperties('meta', ['%encode%' => static::$encode]);
        }

        public function css(string $cssName)
        {
            if (is_file(CSS . $cssName)) {
                return $this->replaceProperties('link', [
                    '%href%' => '/css/' . $cssName,
                    '/%type%' => ''
                ]);
            }
    	}

        public function font(string $fontName)
        {
            if (is_file(FONT . $fontName)) {
                return $this->replaceProperties('link', [
                    '%href%' => '/css/' . $fontName,
                    '/%type%' => ''
                ]);
            }
            return $this->replaceProperties('link', [
                '%href%' => 'https://fonts.googleapis.com/css?family=' . $fontName,
                '/%type%' => ''
            ]);
        }

        public function script(string $scriptName)
        {
            if (is_file(JS . $scriptName)) {
                return $this->replaceProperties('script', [
                    '%script%' => $scriptName
                ]);
            }
        }

        public function less(string $lessName)
        {
            if (is_file(LESS . $lessName)) {
                return $this->replaceProperties('link', [
                    '%href%' => '/less/' . $lessName,
                    '%type%' => 'less'
                ]);
            }
        }

        protected function replaceProperties(string $tag, array $properties)
        {
            if (isset(static::$tags[$tag])) {
                return replaceRecursive(static::$tags[$tag], $properties);
            }
        }

        public static function configEncode(string $encode)
        {
            static::$encode = $encode;
        }
	}
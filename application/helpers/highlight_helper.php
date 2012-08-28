<?php
	$text = 'Lorem ipsum dolor sit amet, consectetuer
	adipiscing elit. Vestibulum blandit mollis risus.';
	
	class highlight
	{
		public $output_text;
			
		function __construct($text, $words)
		{
			$split_words = explode( " " , $words );
			foreach ($split_words as $word)
			{
				$color= '#FFFF00';
				$text = preg_replace("|($word)|Ui", "$1", $text);
			}
		$this->output_text = $text;
		}
	}
	$highlight = new highlight($text , ‘lorem dolor blandit ipsu’);
	echo $highlight->output_text;
?>
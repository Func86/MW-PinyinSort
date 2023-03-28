<?php
namespace MediaWiki\Extension\PinyinSort;

class PinyinCollation extends \Collation {

	/** @var bool */
	private $noPrefix;

	/** @var bool */
	private $withKana;

	public function __construct( $noPrefix = false, $withKana = false ) {
		$this->noPrefix = $noPrefix;
		$this->withKana = $withKana;
	}

	/**
	 * TODO: Use native title parsing provided by the core?
	 */
	private function trimPrefix($string) {
		if (strpos($string, "\n") !== false) {
			return $string;
		} else {
			$parts = explode(':', $string, 2);
			if (!isset($parts[1]) || !$parts[1]) {
				return $string;
			} else {
				return $parts[1] . "\n" . $string;
			}
		}
	}

	private function preprocess( &$str ) {
		if ( $this->noPrefix ) {
			$str = $this->trimPrefix( $str );
		}
		if ( $this->withKana ) {
			$str = Converter::kana2Romaji( $str );
		}
	}

	public function getSortKey($string) {
		$this->preprocess($string);
		if (strpos($string, "\n") === false) {
			$key = $string;
			$original = $string;
		} else {
			$parts = explode("\n", $string, 2);
			$key = $parts[0];
			$original = $parts[1];
		}

		$key = ucfirst(Converter::zh2pinyin($key));

		return $key . "\n" . $original;
	}

	public function getFirstLetter($string) {
		$this->preprocess($string);
		$firstChar = mb_substr($string, 0, 1, 'UTF-8');
		$pinyin = Converter::zh2pinyin($firstChar);
		return ucfirst($pinyin[0]);
	}
}

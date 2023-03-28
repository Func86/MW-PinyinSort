<?php
namespace MediaWiki\Extension\PinyinSort;

class Hooks {

	private const VALID_COLLATIONS = [
		'pinyin',
		'pinyin-noprefix'
	];

	public static function onCollation__Factory( $collationName, &$collationObj ) {
		if ( in_array( $collationName, self::VALID_COLLATIONS ) ) {
			$collationObj = new PinyinCollation(
				$collationName === 'pinyin-noprefix'
			);
		}
		return true;
	}

}

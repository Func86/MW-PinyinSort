<?php
namespace MediaWiki\Extension\PinyinSort;

class Hooks {

	private const SUPPORTED_PARAM = [
		'noprefix',
		'withkana',
	];

	public static function onCollation__Factory( $collationName, &$collationObj ) {
		if ( str_starts_with( $collationName, 'pinyin' ) ) {
			$params = array_slice( explode( '-', $collationName ), 1 );
			// With unsupported collation surfix.
			if ( array_diff( $params, self::SUPPORTED_PARAM ) ) {
				return true;
			}
			$collationObj = new PinyinCollation(
				in_array( self::SUPPORTED_PARAM[0], $params ),
				in_array( self::SUPPORTED_PARAM[1], $params )
			);
		}
		return true;
	}

}

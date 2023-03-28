<?php
namespace MediaWiki\Extension\PinyinSort;

class Hooks {

	public static function onCollation__Factory($collationName, &$collationObj) {
		if ($collationName === 'pinyin') {
			$collationObj = new PinyinCollation();
		} else if ($collationName === 'pinyin-noprefix') {
			$collationObj = new PinyinCollationNoPrefix();
		}
		return true;
	}

}

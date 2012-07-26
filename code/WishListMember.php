<?php
class WishListMember extends DataObjectDecorator {
	function extraStatics() {
		return array(
			'many_many' => array(
				'WishListItems' => 'Page'
			)
		);
	}
}
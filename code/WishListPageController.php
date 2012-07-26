<?php
class WishListPageController extends Extension{
	
	public static $allowed_actions = array (
		'AddToWishListForm',
		'removeFromWishList'
	);
	
	
	public function AddToWishListForm(){
		
		if(($member = Member::currentUser()) && ($wishlistitems = $member->WishListItems("PageID = ".$this->owner->ID)) && $wishlistitems->exists()){
			$fields = new FieldSet(
		    	new HiddenField('PageID','',$this->owner->ID)
			);
		    $actions = new FieldSet(
				new FormAction('removeFromWishList', 'Remove from wish list')
		    );
			$validator = new RequiredFields();
				
			SecurityToken::disable(); // have to do this so once logged in the form still works :{
			$Form = new Form($this->owner, 'AddToWishListForm', $fields, $actions, $validator);	
			
		 	return $Form;
		}else{
			$fields = new FieldSet(
		    	new HiddenField('PageID','',$this->owner->ID)
			);
		    $actions = new FieldSet(
				new FormAction('addToWishList', 'Add to wish list')
		    );
			$validator = new RequiredFields();
				
			SecurityToken::disable(); // have to do this so once logged in the form still works :{
			$Form = new Form($this->owner, 'AddToWishListForm', $fields, $actions, $validator);	
			
		 	return $Form;
		}
	}
	
	
	public function addToWishList($data,$form){
		
		if(isset($data['PageID'])){
			Session::set('WishListItemID', $data['PageID']);
		}
		
		if($member = Member::currentUser()){
			if($page = DataObject::get_by_id("Page", Session::get('WishListItemID'))){
				Session::clear('WishListItemID');
				$member->WishListItems()->add($page);
			}
			Director::redirectBack("?added_wishlist=1");
		}else{
			$messages = array(
				'default' => '<p>Please login or create an account to save items to your wish list</p>',
				'logInAgain' => 'You have been logged out. If you would like to log in again, please do so below.'
			);
			Security::permissionFailure($this->owner, $messages);
		}
	}
	
	public function WishListSuccess(){
		return isset($_REQUEST['added_wishlist']) && $_REQUEST['added_wishlist'] == "1";
	}
	
	public function removeFromWishList($data,$form){
		
		if(($member = Member::currentUser()) && ($wishListItems = $member->WishListItems("PageID = ".$data['PageID'])) &&  $wishListItems->exists()){
			
			foreach ($wishListItems as $wishListItem){
				$member->WishListItems()->remove($wishListItem);
			}
		}
		//$page = DataObject::get_by_id("Page", $data['PageID']);
		Director::redirectBack("?removed_wishlist=1");
	}
	
	public function WishListRemoveSuccess(){
		return isset($_REQUEST['removed_wishlist']) && $_REQUEST['removed_wishlist'] == "1";
	}
}
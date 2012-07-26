<?php
class WishListDecorator extends DataObjectDecorator {
	
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
}
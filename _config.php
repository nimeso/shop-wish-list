<?php
DataObject::add_extension('Member', 'WishListMember');
Object::add_extension("Page_Controller","WishListPageController");
Object::add_extension("Page","WishListDecorator");
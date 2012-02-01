<?php
// ------------------------------------------------------
// AUTHOR: 	AARON KNOLL
// DATE:	2/1/2012
// ABOUT:	Base plugin file that adds/removed rather static
// 			item type to omeka database
//
// MUSIC:	Lana Del Rey - "Born to Die"
// ------------------------------------------------------
add_plugin_hook('install', 'TeachingImageItemTypePlugin::install');
add_plugin_hook('uninstall', 'TeachingImageItemTypePlugin::uninstall');

class TeachingImageItemTypePlugin
{
    private $_db;
    
    public function __construct()
    {
        $this->_db = get_db();
    }
    
    public static function install()
    {
        $teachwithme	 = new TeachingImageItemTypePlugin;
        $teachwithme->_modifyitemtypesTable();
    }
    
    public static function uninstall()
    {
    	$stopteachwithme	 = new TeachingImageItemTypePlugin;
        $stopteachwithme->_removeassocitemtypesTable();
    }
	
	private function _removeassocitemtypesTable()
    {
    	// Be careful. Chnage the titles of this fields and
    	// they won't go away. 
    	$namesgoaway = array(
    					'Original Viewing Context',
    					'Historical Context',
    					'Visual Culture Context',
    					'Bibliographic Information');
		//step 1, delete fields for all of these names
		foreach ($namesgoaway as $item)
			{
			$sql = "DELETE FROM `{$this->_db->prefix}elements`
					WHERE `name` = '$item'";
			$this->_db->query($sql);
			}
		// step 2 find the ID for the teaching image item type
		$sql = "SELECT id FROM `{$this->_db->prefix}item_types`
				WHERE `name` = 'Teaching Image'";
		$lonelyid	=	$this->_db->query($sql);
		while($row = $lonelyid->fetch())
		 {
   			 echo $row['id'];
			 $lonelyidrow = $row['id'];
		}
		//--- and delete				
		$sql = "DELETE FROM `{$this->_db->prefix}item_types`
				WHERE `name` = 'Teaching Image'";
		$this->_db->query($sql);
		// step 3, delete all entries from the elements/items with the id of the teaching image
		$sql = "DELETE FROM `{$this->_db->prefix}item_types_elements`
				WHERE `item_type_id` = '$lonelyidrow'";
		$this->_db->query($sql);
		//	
	}
    
    private function _modifyitemtypesTable()
    {
    	$lastelementname = array(); //the id of each element insert is populated in this array
    	
    	//static function to add the specific item_type into the 
    	//Omeka list of item types. 
    	//This stuff is all editable via the admin panel
    	//of Omeka anyway. 
 		$sql = "
            INSERT INTO `{$this->_db->prefix}item_types` (
                `name` ,
                `description`
            ) VALUES ('Teaching Image', 'An image with specific fields added for pedagogical structuring')";
        $this->_db->query($sql);
		$lastrow_itemname	=	$this->_db->lastInsertId();
		
		//okay, we now know what the latest auto_increment id
		// for our new field is. Now let's insert the associated
		// 1:1 fields and harvest those id's. 
		
		//BETA NOTES: I do see how this could be more elegantly
		// performed in the long term. Make a loop and a couple arrays
		// of the fields, to save code.
		
		//BETA NOTES: the text in the values, hard coded below
		// should be moved to an external text entry file
		// to facilitate internationalization etc. 
		
		$sql = "INSERT INTO `{$this->_db->prefix}elements` (
                `record_type_id` ,
                `data_type_id` ,
                `element_set_id` ,
                `order` ,
                `name` ,
                `description`
            ) VALUES ('2', '1', '3', '1', 'Original Viewing Context', 'The original viewing context' )";

	    $this->_db->query($sql);
		$lastelementname[0]	=	$this->_db->lastInsertId();
		
		$sql = "
            INSERT INTO `{$this->_db->prefix}elements` (
                `record_type_id` ,
                `data_type_id` ,
                `element_set_id` ,
                `order` ,
                `name` ,
                `description`
            ) VALUES ('2', '1', '3', '2', 'Historical Context', 'Historical Context' )";
        $this->_db->query($sql);
		$lastelementname[1]	=	$this->_db->lastInsertId();
		
		$sql = "
            INSERT INTO `{$this->_db->prefix}elements` (
                `record_type_id` ,
                `data_type_id` ,
                `element_set_id` ,
                `order` ,
                `name` ,
                `description`
            ) VALUES ('2', '1', '3', '3', 'Visual Culture Context', 'Visual Culture Context' )";
        $this->_db->query($sql);
		$lastelementname[2]	=	$this->_db->lastInsertId();
		
		$sql = "
            INSERT INTO `{$this->_db->prefix}elements` (
                `record_type_id` ,
                `data_type_id` ,
                `element_set_id` ,
                `order` ,
                `name` ,
                `description`
            ) VALUES ('2', '1', '3', '4', 'Bibliographic Information', 'Bibliographic Information' )";
        $this->_db->query($sql);
		$lastelementname[3]	=	$this->_db->lastInsertId();
		// BETA NOTES: see what I mean? 
		
		//now let's insert the relationships....
		 		$sql = "
            INSERT INTO `{$this->_db->prefix}item_types_elements` (
                `item_type_id` ,
                `element_id`,
                `order`
            ) VALUES 
            	('$lastrow_itemname', '$lastelementname[0]', '1'),
            	('$lastrow_itemname', '$lastelementname[1]', '2'),
            	('$lastrow_itemname', '$lastelementname[2]', '3'),
            	('$lastrow_itemname', '$lastelementname[3]', '4')
            ";
        $this->_db->query($sql);
		
    }
   }
?>
<?php
// ------------------------------------------------------
// AUTHOR: 	AARON KNOLL
// DATE:	2/1/2012, 4/27/2012
// ABOUT:	Base plugin file that adds/removed rather static
// 			item type to omeka database
//
// MUSIC:	Lana Del Rey - "Born to Die"
// ------------------------------------------------------
add_plugin_hook('install', 'TeachingImageItemTypePlugin::install');
add_plugin_hook('uninstall', 'TeachingImageItemTypePlugin::uninstall');

//this function is a special function called by the aas
// theme . it makes an alternate version of the items/show view
// which contains lots of sleek little graphical javascript things
//and arranges omeka's content fields in a total novel fashion. 
// this FUNCTIONALITY of this plugin ONLY WORKS
// if you have the corresponding theme.
// you can still add the item type without the theme, it just
// won't display in the crazy different way. 
function specialItemShowPage($item)
{
?>	
    
 <script type="text/javascript">
jQuery(document).ready(function(){
   jQuery('.show_hide').showHide({			 
		speed: 300,  // speed you want the toggle to happen	
		changeText: 1, // if you dont want the button text to change, set this to 0
		easing: 'swing',
		showText: 'Show',// the button text to show when a div is closed
		hideText: 'Hide' // the button text to show when a div is open					 
	}); 
});

</script>


        <?php foreach (item('Dublin Core', 'Description', 'all') as $title): ?>
           <blockquote>
           <?php echo $title; ?>
           </blockquote>
        <?php endforeach ?>

	<?php //include 'fields_sort.php'; ?>
	<!--  The following function prints all the the metadata associated with an item: Dublin Core, extra element sets, etc. See http://omeka.org/codex or the examples on items/browse for information on how to print only select metadata fields. -->
	<?php //echo show_item_metadata(); ?>


	<!-- The following returns all of the files associated with an item. -->
	<div id="itemfiles" class="element">
			<div class="element-text">
				<div id="parlortrick">			
				</div>
				<div id="parlortricktop">
					
				<?php
				foreach ($item->Files as $file) 
				{
				$filemime=$file->getMimeType();
				//$ourtitleis = $file->original_filename;
				$ouroldtitleis = $file->archive_filename;
				$originalsize = $file->size;
				}
				$highreslink	=	''. WEB_FILES . '/' .$ouroldtitleis;
				$regularlink	=	''. WEB_FULLSIZE .'/' .$ouroldtitleis;
				?>
				<?php echo plugin_append_to_items_show(); ?>
				<div class="highresdl">
					<a href="<?php echo $highreslink; ?>" title="download High-res <?php echo $originalsize; ?>"">
					<img src="<?php echo WEB_PUBLIC_THEME; ?>/aastheme2/images/highres.png">
					</a>	
				</div>
				
				<div class="zoomlinker">
					<a href="#zoom-section" id="zoom-section" title="View using Cloud Zoom"">
					<img src="<?php echo WEB_PUBLIC_THEME; ?>/aastheme2/images/zoom2.png">
					</a>	
				</div>
<div class="hidering">
    <div class="zoom-section">
      <div class="zoom-small-image"><a href='<?php echo $highreslink; ?>' class = 'cloud-zoom' title="Your caption here" rel="softFocus: true, position:'anypos', smoothMove:2">       
        <img src="<?php echo $regularlink; ?>" alt='' /></a></div>
        <div class="zoom-desc" style="position:relative">
      <div id="anypos" style="position:absolute;top:-128px; left: 128px;width:256px; height:256px;"></div>
        <h3>Soft Focus</h3>
        <p>Apply a subtle soft-focus effect to the small image.</p>
        <p>In this example, the zoom window position is specified as a div target which can be positioned anywhere. The movement smoothness is set to a lower value for a snappier feel.</p>
      </div>
    </div>
 </div>

		<script type="text/javascript">
				jQuery(document).ready(function() {
				jQuery("#zoom-section").fancybox({
					
				});
				});
	</script>
				
			</div>
			
			
				<?php echo display_files_for_item(
						$options=array(imageSize=>'fullsize'),
						$wrapperAttributes = array('class'=>'cloud-zoom')); 
				?>
			</div>
			
			
		</div>



<div class="imagewidth">
	 <a href="#" class="show_hide" rel="#slidingDiv_2">
	 	<img src="../../themes/aastheme2/images/imagedown.png" alt="Show" />
	 </a>
	<h2>Who would make a Picture like this?</h2>
</div>	  	
	<div id="slidingDiv_2">
		<!---  This is going to ceate the dropdown of things associated with the "who" -->
			<!-- CREATOR / dCORE -->
			<?php foreach (item('Dublin Core', 'Creator', 'all') as $creatoress): ?>
				<h3>Creator</h3>
					<dl>
						<dt><?php echo $creatoress; ?></dt>
						<?php 
						$def = findDefinition($creatoress); 
						if($def){
							?><dd><?php echo $def; ?></dd><?php
							}
						unset($def);
						?>
					</dl>
		   <?php endforeach ?>
	</div>

<div class="imagewidth">
 	<a href="#" class="show_hide" rel="#slidingDiv_3">
 		<img src="../../themes/aastheme2/images/imagedown.png" alt="Show" />
 	</a>
	<h2>Why was this Picture Made?</h2>	  
 </div>	
	<div id="slidingDiv_3">	
	<!-- This is ging to create the drop down for the when and why -->
		<!-- Date / dCORE -->
		<?php foreach (item('Dublin Core', 'Date', 'all') as $datae): ?>
				<h3>Date</h3>
	           <p><?php echo $datae; ?></p>
	   <?php endforeach ?>
	
		<!-- Historical Context / Teaching Images -->
		<?php foreach (item('Item Type Metadata', 'Historical Context', 'all') as $creatoress): ?>
	          <h3>Historical Context</h3>
	           <p><?php echo $creatoress; ?></p>
	   <?php endforeach ?>
	</div>

<div class="imagewidth">
 	<a href="#" class="show_hide" rel="#slidingDiv_4">
 		<img src="../../themes/aastheme2/images/imagedown.png" alt="Show" />
 	</a>
	<h2>How and Where did People see this Picture?</h2>	   
</div>
	<div id="slidingDiv_4">		  
	<!--  This is going to create the drop down for the where did people see this picture -->
		<!-- Publisher / dCORE -->
		<?php foreach (item('Dublin Core', 'Publisher', 'all') as $publishinghouse): ?>
				<h3>Publisher</h3>
					<dl>
						<dt><?php echo $publishinghouse; ?></dt>
						<?php 
						$def = findDefinition($publishinghouse); 
						if($def){
							?><dd><?php echo $def; ?></dd><?php
							}
						unset($def);
						?>
					</dl>
	   <?php endforeach ?>
	   
	   	<!-- Format / dCORE -->
		<?php foreach (item('Dublin Core', 'Format', 'all') as $djformat): ?>
				<h3>Format</h3>
					<dl>
						<dt><?php echo $djformat; ?></dt>
						<?php 
						$def = findDefinition($djformat); 
						if($def){
							?><dd><?php echo $def; ?></dd><?php
							}
						unset($def);
						?>
					</dl>
	   <?php endforeach ?>
	   
	   	<!-- Coverage / dCORE -->
		<?php foreach (item('Dublin Core', 'Coverage', 'all') as $blankets): ?>
				<h3>Coverage</h3>
	           <p><?php echo $blankets; ?></p>
	   <?php endforeach ?>
	   
		<!-- Orig Viewing Context / Teaching Images -->
		<?php foreach (item('Item Type Metadata', 'Original Viewing Context', 'all') as $creatoress): ?>
	          	<h3>Original Viewing Context</h3>
	           <p><?php echo $creatoress; ?></p>
	   <?php endforeach ?>
	</div>

<div class="imagewidth">
 	<a href="#" class="show_hide" rel="#slidingDiv_5">
 		<img src="../../themes/aastheme2/images/imagedown.png" alt="Show" />
 	</a>
	<h2>What other Pictures or Documents are Like This?</h2>
</div>
	<div id="slidingDiv_5">			   
	<!-- This is ging to create the drop down for the when and why -->
		<!-- Relation / dCORE -->
		<?php foreach (item('Dublin Core', 'Relation', 'all') as $datae): ?>
			 	<h3>Images Like This One</h3>
	           <p><?php echo $datae; ?></p>
	   <?php endforeach ?>
	
		<!-- Bibliography / Teaching Images -->
		<?php foreach (item('Item Type Metadata', 'Bibliography', 'all') as $creatoress): ?>
	           	<h3>Bibliography</h3>
	           <p><?php echo $creatoress; ?></p>
	   <?php endforeach ?>	  
	 </div> 
	  
	
	<!-- If the item belongs to a collection, the following creates a link to that collection. -->
	<?php if ( item_belongs_to_collection() ): ?>
        <div id="collection" class="element">
            <h3>Collection</h3>
            <div class="element-text"><p><?php echo link_to_collection_for_item(); ?></p></div>
        </div>
    <?php endif; ?>

    <!-- The following prints a list of all tags associated with the item -->
	<?php if (item_has_tags()): ?>
	<div id="item-tags" class="element">
		<h3>Tags</h3>
		<div class="element-text"><?php echo item_tags_as_string(); ?></div> 
	</div>
	<?php endif;?>
	

	<ul class="item-pagination navigation">
	<li id="previous-item" class="previous">
		<?php echo link_to_previous_item('<img src="'. WEB_PUBLIC_THEME .'/aastheme2/images/goback.png" alt="Previous" style="vertical-align:middle;"/> Previous'); ?>
	</li>
	<li id="next-item" class="next">
		<?php echo link_to_next_item('<img src="'. WEB_PUBLIC_THEME .'/aastheme2/images/goforward.png" alt="Previous" style="vertical-align:middle;"/> Next'); ?>
	</li>
	</ul>
	<?php
}
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
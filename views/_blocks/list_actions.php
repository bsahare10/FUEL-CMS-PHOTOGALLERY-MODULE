<div class="buttonbar" id="action_btns">
	<ul>
		<?php if($page_title != 'Gallery Manager - Gallery Manager'){ ?>
		<li><a href="javascript:" id="action-save" class="ico ico_save save" title="">Save</a></li>
		<?php } ?> 
        <li<?php echo isset($current_page) && $current_page == '' ? ' class="active"' : ''; ?>><a href="<?=fuel_url($nav_selected);?>" id="toggle_tree" class="ico ico_tree" title="">Gallery Manager</a></li>

        <?php if($page_title == 'Gallery Manager - Gallery Manager'){ ?>
        <li style="display: none;" id="MultiDeleteTAB"><a href="javascript:" class="ico ico_delete" id="multi_delete">Delete Multiple</a></li>
		<?php } ?>

        <li<?php echo isset($current_page) && $current_page == 'add_gallery_group' ? ' class="active"' : ''; ?>><a href="<?=fuel_url($nav_selected.'/add_group');?>" id="btn_Add_GalleryGroup" class="ico ico_tree">Create Gallery Group</a></li>
        <li<?php echo isset($current_page) && $current_page == 'add_gallery_images' ? ' class="active"' : ''; ?>><a href="<?=fuel_url($nav_selected.'/add_images');?>" id="btn_Add_GalleryImage" class="ico ico_assets">Create Gallery Images</a></li>
	</ul>
</div>
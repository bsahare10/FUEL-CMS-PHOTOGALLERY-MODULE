<div class="tcounters">
       <p class="ico ico_info">
            <span><?=$group_count;?> group items</span>  
       </p>                
</div>

<div id="list_container">
    <div class="inner_padding">
        <div id="main_content_inner" class="display-flex">        
            <div id="div_gallery" class="gallery-wrapper-main">
                <div id="ajax_galleries" class="ajax_overlay">
                    <div class="ajax_loader"></div>
                </div>
                <h2 class="gallery-group-header">Gallery Groups</h2>
                <div id="gallery_groups" class="supercomboselect" style="">
                    <div id="data_table_container" class="galleryGroup-listing">
                      <?php if(!empty($Group_list)){ ?>  
                        <table cellpadding="0" cellspacing="0" id="data_table" class="data">
                            <thead>
                            <tr>
                                <th class="col1"><a>Title</a></th>
                                <th class="col2"><a>Published</a></th>
                                <th class="col3 display-flex"><a style="width: 36.5%">Actions</a><input type="checkbox" style="margin-top: 4px;" id="checkAll" value="" ></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($Group_list as $group) { ?>
                            <tr class="rowactionGroup" id="data_table_row3" data-id="<?=$group->GroupID; ?>" data-group-text='<?=$group->GroupTitle; ?>'>
                                <td class="col1"><?=$group->GroupTitle; ?></td>
                                <td class="col2"><span class="publish_hover publish_col" style="width: 50px;" data-toggle="<?=$group->Active; ?>" id="toggled" data-table='gallery_groups' data-dbfield='GroupID' ><span class="toggle-here publish_text <?php if($group->Active == 'off'){ echo 'unpublished'; }else{ echo 'published'; } ?> toggle_off"><?=$group->Active; ?></span><span class="publish_action <?php if($group->Active == 'off'){ echo 'unpublished'; }else{ echo 'published'; } ?> hidden">click to toggle</span></span></td>

                                <td class="col3 actions" style="text-align: left;"><a href="javascript:void(0)" class="datatable_action action_edit" data-id="<?=$group->GroupID; ?>" data-group-text='<?=$group->GroupTitle; ?>' >EDIT</a>&nbsp; |  &nbsp;<a href="javascript:" data-table='gallery_groups' id="delete-gallery-group" data-id="<?=$group->GroupID; ?>">DELETE</a>
                                <input type="checkbox" name="delete[<?=$group->GroupID; ?>]" value="" id="<?=$group->GroupID; ?>" data-table='gallery_groups' class="multi_deleteGroup">
                                </td>
                            </tr>
                            <?php } ?>
                            </tbody>
                            <script>
                                $(document).on('click','#delete-gallery-group',function(e){
                                    stop_prapogation(e);   // to stop prapogation and Bubbling
                                    var id = $(this).attr('data-id');
                                    localStorage.setItem("PATH", window.location.href);

                                    window.location.replace('<?=fuel_url($nav_selected.'/deleteGroup/');?>'+id); 
                                });
                            </script>
                        </table>
                      <?php }else{ echo '<div class="nodata">No data to display.</div>'; } ?>
                    </div>
                </div>
            </div>

            <div id="div_gallery" class="gallery-wrapper-main">
                <h2 class="gallery-group-header">Edit Gallery Group</h2>
                <div class="group-edit-box">
                    <div id="edit-box" style="display: none">
                        <span id="remove-edit" class="ico_position ico ico_close"></span>
                        <div class="float_left" style="margin-top: 8px;">
                            <p><label class="gallery_label">Title:<span class="required">*</span></label> <input type="text" id="title" name="GroupTitle" style="width: 250px" /></p>
                            <p><label class="gallery_label">Active:</label> <input type="checkbox" name="Active" checked id="checkbox" /></p>                    
                            <input type="hidden" id="hidden-id" name="hidden-id">
                        </div>

                        <div class="clear"></div>
                        <div id="message_add_group"></div>
                        <div class="clear_10"></div>
                            
                        <div class="buttonbar">
                            <ul>
                                <label class="gallery_label"> </label>
                                <li class="end"><input type="button" name="" value="Save" id="btn_Add_Gallery_group"  style="width: 150px;"></li>
                            </ul>
                        </div>
                    </div>
                    <div class="clear"></div>
                </div>
            </div>
        </div>
    </div>

<div class="tcounters">
    <p class="ico ico_info">
        <span><?=$image_count;?> image items</span>
    </p>
</div>

<div id="gallery-image-listing" class="supercomboselect custom-height" style="height: 400px;">
    <div id="data_table_container">
      <?php if(!empty($Image_list)){ ?>
        <table cellpadding="0" cellspacing="0" id="data_table" class="data">
            <thead>
            <tr>
                <th class="col1"><a>Title</a></th>
                <th class="col2"><a>Discription</a></th>
                <th class="col3"><a>Gallery Group</a></th>
                <th class="col4"><a>Published</a></th>
                <th class="col5"><a>Picture</a></th>
                <th class="col6"><a>Added Date</a></th>
                <th class="col7 display-flex" style="text-align: center;"><a>Actions</a><input type="checkbox" style="margin-top: 4px;" id="checkAll-images" value="" ></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($Image_list as $image) { ?>
            <tr id="data_table_row3" class="rowaction" data-id="<?=$image->PictureID; ?>">
                <td class="col1 first"><?=$image->PictureTitle; ?></td>
                <td class="col2"><?php if(!empty($image->PictureDesc)){ echo $image->PictureDesc; }else{ echo "-"; } ?></td>
                <td class="col3"><?=$image->GroupTitle; ?></td>
                <td class="col4"><span class="publish_hover publish_col" style="width: 50px;" data-toggle="<?=$image->PictureActive; ?>" id="toggled" data-table='gallery_pics' data-dbfield='PictureID' ><span class="toggle-here publish_text <?php if($image->PictureActive == 'off'){ echo 'unpublished'; }else{ echo 'published'; } ?> toggle_off" data-field="published"><?=$image->PictureActive; ?></span><span class="publish_action <?php if($image->PictureActive == 'off'){ echo 'unpublished'; }else{ echo 'published'; } ?> hidden">click to toggle</span></span></td>
                <td class="col5">
                    <img src="<?=site_url(); ?>fuel/modules/gallerymanager/assets/GalleryImages/<?=$image->PictureSRC; ?>" class="gallery-images" >
                </td>
                <td class="col6"><?=$image->AddedDate; ?></td>
                <td class="col7 actions"><a href="javascript:" class="datatable_action image-action_edit" >EDIT</a>&nbsp; |  &nbsp;<a href="javascript:" data-table='gallery_pics' id="gallery-delete" data-id="<?=$image->PictureID; ?>">DELETE</a>
                <input type="checkbox" name="delete[<?=$image->PictureID; ?>]" value="" id="<?=$image->PictureID; ?>" data-table='news_pics' class="multi_delete">
                </td>
            </tr>
            <?php } ?>
            </tbody>
            <script>
                $(document).on('click','#gallery-delete',function(e){

                        stop_prapogation(e);   // to stop prapogation and Bubbling

                        var id = $(this).attr('data-id');
                        localStorage.setItem("PATH", window.location.href);

                        window.location.replace('<?=fuel_url($nav_selected.'/deleteNews/');?>'+id); 
                });
            </script>
        </table>
      <?php }else{ ?>
            <div class="nodata">No data to display.</div>
            <style type="text/css"> .custom-height{ height: auto !important; } </style>
      <?php } ?>
        <input type="hidden" name="offset" id="offset" value="0">
        <input type="hidden" name="order" id="order" value="desc">
        <input type="hidden" name="col" id="col" value="publish_date">
    </div>
</div>
    <div class="loader" id="table_loader" style="display: none;"></div>
</div>

<!-- //for START of DOCUMENT-READY -->
<script>
    $( document ).ready(function() {
        $( "#gallery_groups table tr:odd" ).addClass('alt');
        $( "#gallery-image-listing table tr:odd" ).addClass('alt');
    });
</script>
<!-- **//for END of DOCUMENT-READY -->

<!-- //for START of TOGGLE STATUS -->
<script>    
    $(document).on('click','#toggled',function(e){

        stop_prapogation(e);   // to stop prapogation and Bubbling

        var id = $(this).parent().parent('tr').attr('data-id');
        var action = $(this).data("toggle");
        var action = $(this).data("toggle");
        var table = $(this).data("table");
        var field = $(this).data("dbfield");
        var save_action = '';
        if(action == "on")
        {
            $(this).data("toggle","off");
            $(this).find('.toggle-here').text("off");
            $(this).find('.published').removeClass('published').addClass('unpublished');
        }
        else if(action == "off")
        {
            $(this).data("toggle","on");
            $(this).find('.toggle-here').text("on");
            $(this).find('.unpublished').removeClass('unpublished').addClass('published');
        }

        save_action = $(this).find('.toggle-here').text();
        var notification = $('#fuel_notification');

        $.ajax({
                url  : 'update_status',
                datatype: 'json',
                type : "POST",
                data : {
                            action: save_action, 
                            id: id,
                            field: field,
                            table: table,
                       },
                success: function (data) {
                    var jsonData = $.parseJSON(data);

                    if (jsonData.status == "1") {
                        notification.append(jsonData.html);
                        setTimeout(function(){ 
                            notification.find('.success').remove(); 
                            notification.find('.error').remove(); 
                        }, 1500);
                    } else {
                        notification.append(jsonData.html);
                    }
                },
                error: function (xhr, testStatus, error) {
                    console.log('$.ajax() error: ' + error);
                }
                      
             });
    });
</script>
<!-- **//for END of TOGGLE STATUS -->

<!-- //for START of GROUP SECTION -->
<script>    

    $(document).on('click','.rowactionGroup,.action_edit',function(e){

        $('#edit-box').show();

        var id = $(this).attr('data-id');
        var text = $(this).attr('data-group-text');

        $('input[name=GroupTitle').val(text);
        $('input[name=hidden-id').val(id);
    });

    $(document).on('click','#btn_Add_Gallery_group',function(){

        $('.notification .error').remove();
        $('.notification .success').remove();
                
        var status   = '';
        var title    = $('input[name=GroupTitle]').val();
        var group_id = $('input[name=hidden-id').val();
        var notification = $('#fuel_notification');

        if(group_id == '' || group_id == 'undefined' || group_id == undefined){
            notification.append('<ul class="ico error ico_error" style="background-color: rgb(238, 96, 96); "><li>Please select Gallery Group first.!!</li></ul>');
            return false;
        }

        if ($('#checkbox').is(":checked"))
        {
          status    = 'on';
        }else{
          status    = 'off';
        }

        $.ajax({
            url: "insert_group",
            datatype: 'json',
            type: 'post',
            data: {
                        title: title,
                        status: status,
                        group_id: group_id,
                   },
            success: function (data) {
                var jsonData = $.parseJSON(data);

                if (jsonData.status == "1") {
                    notification.append(jsonData.html);
                    setTimeout(function(){ location.reload(); }, 1500);
                } else {
                    notification.append(jsonData.html);
                }
            },
            error: function (xhr, testStatus, error) {
                console.log('$.ajax() error: ' + error);
            }
        });
    });
</script>   
<!-- **//for END of GROUP SECTION -->

<!-- //for START of GROUP-IMAGES SECTION -->
<script>    
    $(document).on('click','.image-action_edit',function(e){

        stop_prapogation(e);   // to stop prapogation and Bubbling

        var id = $(this).parent().parent().attr('data-id');
        window.location.replace('<?=fuel_url($nav_selected.'/update_image/');?>'+id); 
    });

    $(document).on('click','.rowaction',function(){
        var id = $(this).attr('data-id');
        window.location.replace('<?=fuel_url($nav_selected.'/update_image/');?>'+id);
    });
</script>   
<!-- **//for END of GROUP-IMAGES SECTION -->

<!-- //for START of MULTI-DELETE functionality for Groups -->
<script>    
    $(document).on('click','.galleryGroup-listing table input[type=checkbox]',function(e){
        stop_prapogation(e);   // to stop prapogation and Bubbling
        checkMLTbtn1();
    });

    $(document).on('click','#MultiDeleteTAB-Group',function(){
        var arr = [];
        var id;
        var url = window.location.href;
        var table = 'news_pics';
        $('.galleryGroup-listing table tbody input[type=checkbox]:checked').each(function () {
            id = $(this).attr('id');
            arr.push(id);
        }); 
        localStorage.setItem("PATH", window.location.href);
        
        var encoded_ids = encodeURIComponent(arr);
        window.location.replace('<?=fuel_url($nav_selected.'/delete/grp_');?>'+encoded_ids);
    });

    $(document).on('click','#remove-edit',function(){
        $('#edit-box').hide();
    });

    $(document).on('click','#gallery_groups #checkAll',function(){
        
        $('#gallery_groups input:checkbox').not(this).prop('checked', this.checked);
        checkMLTbtn1();
    });

    function checkMLTbtn1(){
        if($('.galleryGroup-listing table input[type=checkbox]:checked').length == 0) { 
            $("#MultiDeleteTAB-Group").attr("id", "MultiDeleteTAB");
            $('#MultiDeleteTAB').hide(); 
        }else{ 
            $('#MultiDeleteTAB').show(); 
            $("#MultiDeleteTAB").attr("id", "MultiDeleteTAB-Group");
        }
    }
</script> 
<!-- **//for END of MULTI-DELETE functionality for Groups --> 

<!-- //for START of MULTI-DELETE functionality for Group-Images -->
<script>    
    $(document).on('click','#gallery-image-listing table input[type=checkbox]',function(e){
        stop_prapogation(e)
        checkMLTbtn2();
    });

    $(document).on('click','#MultiDeleteTAB',function(){
        var arr = [];
        var id;
        var url = window.location.href;
        var table = 'news_pics';
        $('#gallery-image-listing table tbody input[type=checkbox]:checked').each(function () {
            id = $(this).attr('id');
            arr.push(id);
        }); 
        localStorage.setItem("PATH", window.location.href);
        
        var encoded_ids = encodeURIComponent(arr);
        window.location.replace('<?=fuel_url($nav_selected.'/delete/img_');?>'+encoded_ids);
    });

    $(document).on('click','#gallery-image-listing #checkAll-images',function(){
        $('#gallery-image-listing input:checkbox').not(this).prop('checked', this.checked);
        checkMLTbtn2();
    });

    function checkMLTbtn2(){
        if($('#gallery-image-listing table input[type=checkbox]:checked').length == 0) { $('#MultiDeleteTAB').hide(); }else{ $('#MultiDeleteTAB').show(); }
    }
</script>   
<!-- **//for END of MULTI-DELETE functionality for Group-Images -->

<!-- //START to stop prapogation and Bubbling -->
<script>
    function stop_prapogation(e){
        if (!e) var e = window.event;                // Get the window event
        e.cancelBubble = true;                       // IE Stop propagation
        if (e.stopPropagation) e.stopPropagation();  // Other Broswers
    }
</script>
<!-- **//END to stop prapogation and Bubbling -->

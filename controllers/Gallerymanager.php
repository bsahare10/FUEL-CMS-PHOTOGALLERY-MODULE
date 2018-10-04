<?php  
require_once(FUEL_PATH.'/libraries/Fuel_base_controller.php');

class Gallerymanager extends Fuel_base_controller 
{
    public  $view_location = 'gallerymanager';

    private $gallery_path;
	public  $nav_path;
    public  $nav_title;
    private $page_title;
    private $vars;

	function __construct()
	{
		parent::__construct();

        $this->load->helper('ajax');
        $this->load->model('Gallery_model');
        $this->load->library('session');      
        
        $this->page_title = "Gallery Manager - ";   

        $this->gallery_path = $this->fuel->gallerymanager->config('path');
        $this->nav_path     = $this->fuel->gallerymanager->config('nav_path');
        $this->nav_title    = $this->fuel->gallerymanager->config('nav_title');
        
        $this->vars['nav_selected'] = $this->nav_path;
	}

    function index()
    {        
        $vars = $this->vars;

        $vars['page_title']      = $this->page_title."Gallery Manager";                
        $vars['Image_list']      = $this->Gallery_model->GetData_list('gallery_pics');
        $vars['group_count']     = $this->Gallery_model->GetCount('gallery_groups');
        $vars['image_count']     = $this->Gallery_model->GetCount('gallery_pics');
        $vars['Group_list']      = $this->Gallery_model->GetData_list('gallery_groups');
        
        // load actions
        $vars['current_page'] = '';
        $actions = $this->load->module_view(GALLERYMANAGER_FOLDER, '_blocks/list_actions', $vars, TRUE);
        $vars['actions'] = $actions; 

        $crumbs = array($this->nav_path => $this->nav_title, '' => 'Gallery Manager');
        $this->fuel->admin->set_titlebar($crumbs, 'ico_gallerymanager');
        $this->fuel->admin->render('gallery_manager', $vars);
    }

    function add_group() 
    {
        $vars = $this->vars;
        $vars['page_title'] = $this->page_title."Add Gallery Group";                

        // load actions
        $vars['current_page'] = 'add_gallery_group';
        $actions = $this->load->module_view(GALLERYMANAGER_FOLDER, '_blocks/list_actions', $vars, TRUE);
        $vars['actions'] = $actions;    

        $return = array(
            "Status" => "0",
            "html"   => ""
        );  

        $crumbs = array($this->nav_path => $this->nav_title, '' => 'Gallery Manager');
        $this->fuel->admin->set_titlebar($crumbs, 'ico_gallerymanager');
        $this->fuel->admin->render('add_group', $vars);
    }

    function add_images() 
    {
        $vars = $this->vars;
        $vars['groups']  = $this->Gallery_model->GetGalleryGroups();
        $vars['page_title'] = $this->page_title."Add Gallery Images";

        // load actions
        $vars['current_page'] = 'add_gallery_images';
        $actions = $this->load->module_view(GALLERYMANAGER_FOLDER, '_blocks/list_actions', $vars, TRUE);
        $vars['actions'] = $actions;      

        $crumbs = array($this->nav_path => $this->nav_title, '' => 'Gallery Manager');
        $this->fuel->admin->set_titlebar($crumbs, 'ico_gallerymanager');
        $this->fuel->admin->render('add_images',$vars);
    }

    function update_image($id) 
    {
        $vars = $this->vars;
        $vars['groups']  = $this->Gallery_model->GetGalleryGroups();
        $vars['image_data']  = $this->Gallery_model->GetGalleryImage($id);
        $vars['page_title'] = $this->page_title."Add Gallery Images";

        // load actions
        $actions = $this->load->module_view(GALLERYMANAGER_FOLDER, '_blocks/list_actions', $vars, TRUE);
        $vars['actions'] = $actions;      

        $crumbs = array($this->nav_path => $this->nav_title, '' => 'Gallery Manager');
        $this->fuel->admin->set_titlebar($crumbs, 'ico_gallerymanager');
        $this->fuel->admin->render('add_images',$vars);
    }

    function insertImages() 
    {
        $return = array(
            "status" => "0",
            "html"   => "Failed"
        );

        if(empty($_POST['GroupID']))
        {
            $return = array(
                "status" => "0",
                "html"   => '<ul class="ico error ico_error" style="background-color: rgb(238, 96, 96); "><li>Please fill out the required field "group".</li></ul>'
            );
            echo json_encode($return);
            exit; 
        }

        if($_POST['status'] == 'false')
        {
            $return = array(
                "status" => "0",
                "html"   => '<ul class="ico error ico_error" style="background-color: rgb(238, 96, 96); "><li>Please check field "image".</li></ul>'
            );
            echo json_encode($return);
            exit; 
        }

        if(empty($_FILES['GroupImage']['name']) && empty($_POST['hidden-image-name']))
        {
            $return = array(
                "status" => "0",
                "html"   => '<ul class="ico error ico_error" style="background-color: rgb(238, 96, 96); "><li>Please fill out the required field "image".</li></ul>'
            );               
            echo json_encode($return);
            exit; 
        }

        if(empty($_POST['ImageTitle']))
        {
            $return = array(
                "status" => "0",
                "html"   => '<ul class="ico error ico_error" style="background-color: rgb(238, 96, 96); "><li>Please fill out the required field "title".</li></ul>'
            );
            echo json_encode($return);
            exit; 
        }
        
        if(!empty($_FILES['GroupImage']['name'])){

            $config['upload_path'] = 'fuel/modules/gallerymanager/assets/GalleryImages/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif';            
            $this->load->library('upload',$config);
            $this->upload->initialize($config);

            if (!is_dir($config['upload_path'])){
                mkdir($config['upload_path'], 0777, TRUE);
            }
            $config['file_name'] = $_FILES['GroupImage']['name'];
            $picture = '';

            if($this->upload->do_upload('GroupImage'))
            {
               $uploadData = $this->upload->data();
               $picture = $uploadData['file_name'];
            }
        }else{
            $picture = $_POST['hidden-image-name'];
        }

        if(isset($_POST['Active'])){ $Active = $_POST['Active'];}else{ $Active = 'off'; }

        if(!empty($_POST['hidden-image-id'])){
            $data = array('PictureSRC'=> $picture,'PictureTitle'=> $_POST['ImageTitle'],'PictureDesc'=> $_POST['ImageDesc'],'GroupID'=> $_POST['GroupID'],'PictureActive'=> $Active,'AddedDate'=> date('Y-m-d H:i:s'));
            $where = $_POST['hidden-image-id'];
            $return = $this->Gallery_model->update_images($data,$where);
        }else{
            $data = array('PictureSRC'=> $picture,'PictureTitle'=> $_POST['ImageTitle'],'PictureDesc'=> $_POST['ImageDesc'],'GroupID'=> $_POST['GroupID'],'PictureActive'=> $Active,'AddedDate'=> date('Y-m-d H:i:s'));
            $return = $this->Gallery_model->insert_images($data);
        }

        echo json_encode($return);
    }

    function update_status() 
    {
        $return = array(
            "status" => "0",
            "html"   => "Failed"
        );

        $field = $_POST['field'];
        if($field == 'PictureID'){
            $field_cond = 'PictureActive';
        }else{
            $field_cond = 'Active';
        }

        $where = $_POST['id'];
        $table = $_POST['table'];
        $data = array($field_cond=> $_POST['action']);
        $return = $this->Gallery_model->update_status($data,$where,$table,$field);
        
        echo json_encode($return);
    }


    function insert_group() 
    {
        $return = array(
            "status" => "0",
            "html"   => "Failed"
        );

        $title      = $_POST['title'];
        $status     = $_POST['status'];   

        $regex = '~^[a-zA-Z0-9-_ ]+$~';   
        if(!empty($title) && preg_match($regex, $title))
        {
            if(isset($_POST['group_id'])){
                $return = $this->Gallery_model->update_group($_POST['group_id'],$title,$status);
            }else{
                $return = $this->Gallery_model->insert_group($title,$status);
            }
        }else{
            $return = array(
                "status" => "0",
                "html"   => '<ul class="ico error ico_error" style="background-color: rgb(238, 96, 96); "><li>Please fill out the required field "title" or field not contain any special charector except ( space , - , _ ).</li></ul>'
            );
        } 
        echo json_encode($return);
    }

    public function deleteGroup($id){
        $vars = $this->vars;
        $vars['table'] = 'gallery_groups';
        $where = 'GroupID';
        $vars['delete_data']  = $this->Gallery_model->GetDeleteRecord($id,$vars['table'],$where);
        $vars['delete_id'] = $vars['delete_data'][0]->GroupID;
        $vars['delete_name'] = $vars['delete_data'][0]->GroupTitle;
        $vars['instructions'] = "You are about to delete the group item, it will also delete relative gallery image items:";
        
        $crumbs = array($this->nav_path => $this->nav_title, '' => $vars['delete_name']);
        $this->fuel->admin->set_titlebar($crumbs, 'ico_blog_posts');
        $this->fuel->admin->render('delete',$vars);
    }

    public function deleteNews($id){
        $vars = $this->vars;
        $vars['table'] = 'gallery_pics';
        $where = 'PictureID';
        $vars['delete_data'] = $this->Gallery_model->GetDeleteRecord($id,$vars['table'],$where);
        $vars['delete_id'] = $vars['delete_data'][0]->PictureID;
        $vars['delete_name'] = $vars['delete_data'][0]->PictureTitle;
        $vars['instructions'] = "You are about to delete the news item:";
    
        $crumbs = array($this->nav_path => $this->nav_title, '' => $vars['delete_data'][0]->PictureTitle);
        $this->fuel->admin->set_titlebar($crumbs, 'ico_blog_posts');
        $this->fuel->admin->render('delete',$vars);
    }

    public function delete_process()
    {
        $return = array(
            "status" => "0",
            "html"   => "Failed"
        );

        try {
            $id = $_POST['item_id'];
            $table = $_POST['table'];
            $return = $this->Gallery_model->DeleteItem($id,$table);      
        }
        catch (Exception $ex) {
            $return = array(
                "status" => "0",
                "html"   => '<ul class="ico error ico_error" style="background-color: rgb(238, 96, 96); "><li>Error occured while deleting, please try again.!!</li></ul>'
            );            
        }        
        echo json_encode($return);
        exit;
    }

    function delete($id)
    {   
        $ids = explode("_", $id);
        $id  = urldecode($ids[1]);
        if($ids[0] == 'grp'){
            $table = 'gallery_groups';
        }else{
            $table = 'gallery_pics';
        }
        // $ids = urldecode($id);
        $return = $this->Gallery_model->MultiDeleteItem($id,$table);

        if($ids[0] == 'grp'){
            foreach ($return['html'] as $key => $value) {
                $pic_ids[] = $value->GroupID;
                $pic_names[] = $value->GroupTitle;
            }
        }else{
            foreach ($return['html'] as $key => $value) {
                $pic_ids[] = $value->PictureID;
                $pic_names[] = $value->PictureTitle;
            }
        }

        $vars['multiple'] = 'TRUE';
        $vars['table'] = $table;
        $vars['delete_id'] = implode(', ', $pic_ids);
        $vars['delete_name'] = implode(', ', $pic_names);

        $vars['instructions'] = "You are about to delete the news items:";
        $crumbs = array($this->nav_path => $this->nav_title, '' => $vars['delete_name']);
        $this->fuel->admin->set_titlebar($crumbs, 'ico_blog_posts');

        $this->fuel->admin->render('delete',$vars);
    }

}
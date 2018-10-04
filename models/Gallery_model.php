<?php 

class Gallery_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

    function insert_group($title,$status){      

        try {
            $data = array(
               'GroupTitle'  => $title,
               'Active' => $status,
            );

            $this->db->insert('gallery_groups', $data); 
            $this->db->close();   

            $return = array(
                "status" => "1",
                "html"   => '<div class="success ico ico_success" style="background-color: rgb(220, 255, 184); ">Data has been saved.</div>'
            );         
        }
        catch (Exception $ex) {
            $return = array(
                "status" => "0",
                "html"   => "Fail: " . $ex->Message
            );   
        }    
        
        return $return;
    }

    function update_group($where,$title,$status) {    

        try {
            $data = array(
               'GroupTitle'  => $title,
               'Active' => $status,
            );

            $this->db->where('GroupID',$where); 
            $this->db->update('gallery_groups', $data); 
            $this->db->close();   

            $return = array(
                "status" => "1",
                "html"   => '<div class="success ico ico_success" style="background-color: rgb(220, 255, 184); ">Data has been saved.</div>'
            );         
        }
        catch (Exception $ex) {
            $return = array(
                "status" => "0",
                "html"   => "Fail: " . $ex->Message
            );   
        }    
        
        return $return;
    }

    function insert_images($data) {      

        try {

            $this->db->insert('gallery_pics', $data); 
            $last_id = $this->db->insert_id();
            $this->db->close();   

            $return = array(
                "status" => "1",
                "inserted_id" => $last_id,
                "html"   => '<div class="success ico ico_success" style="background-color: rgb(220, 255, 184); ">Data has been saved.</div>'
            );         
        }
        catch (Exception $ex) {
            $return = array(
                "status" => "0",
                "html"   => "Fail: " . $ex->Message
            );   
        }    
        
        return $return;
    }

    function update_images($data,$where) { 

         try {
            
            $this->db->where('PictureID',$where); 
            $this->db->update('gallery_pics', $data); 
            $this->db->close();   

            $return = array(
                "status" => "1",
                "html"   => '<div class="success ico ico_success" style="background-color: rgb(220, 255, 184); ">Data has been saved.</div>'
            );         
        }
        catch (Exception $ex) {
            $return = array(
                "status" => "0",
                "html"   => "Fail: " . $ex->Message
            );   
        }    
        
        return $return;
    }

    function update_status($data,$where,$table,$field) {      

        try {

            $this->db->where($field,$where); 
            $this->db->update($table, $data); 
            $this->db->close();   

            $return = array(
                "status" => "1",
                "html"   => '<div class="success ico ico_success" style="background-color: rgb(220, 255, 184); ">Data has been saved.</div>'
            );         
        }
        catch (Exception $ex) {
            $return = array(
                "status" => "0",
                "html"   => "Fail: " . $ex->Message
            );   
        }    
        
        return $return;
    }

    function GetGalleryGroups() {    

        $this->load->database();
        $query = $this->db->where('Active','on');
        $query = $this->db->get('gallery_groups');

        $groups = array();
        foreach($query->result() as $row) {
            $groups[] = $row;
        }

        $this->db->close();
        $this->db->initialize(); 

        return $groups;               
    }

    function GetData_list($table){

        $this->load->database();
        if($table == 'gallery_pics')
        {
            $this->db
            ->select('gp.*,gg.GroupTitle')
            ->from('gallery_pics as gp')
            ->join('gallery_groups as gg', 'gp.GroupID = gg.GroupID')
            ->where('gp.GroupID = gg.GroupID', NULL)
            ->order_by("gg.GroupTitle", "asc");          
        }else{
            $this->db->order_by("GroupTitle", "asc");
            $this->db->from("gallery_groups");
        }

        $query = $this->db->get();
        $News = array();
        foreach($query->result() as $row) {
            $News[] = $row;
        }

        $this->db->close();
        $this->db->initialize();  

        return $News;
    }

    function GetGalleryImage($id) {      

        $this->load->database();
        $this->db->where('PictureID',$id);
        $query = $this->db->get('gallery_pics');

        $pic = array();
        foreach($query->result() as $row) {
            $pic[] = $row;
        }

        $this->db->close();
        $this->db->initialize();  

        return $pic;               
    }

    function GetCount($table) {

        $query = $this->db->query("SELECT * FROM $table");
        $count = $query->num_rows();     
        return $count;
    }

    function GetDeleteRecord($id,$table,$where) {

        $this->load->database();

        $this->db->where($where,$id);
        $query = $this->db->get($table);
        $result = $query->result();
        
        $this->db->close();
        $this->db->initialize();  
        return $result; 
    }

    function DeleteItem($id,$table) {        

        try {

            $this->load->database();
                
            if($table == 'gallery_groups'){
                // remove Group from db
                $query = $this->db->query("DELETE FROM $table WHERE `GroupID` IN  ($id)");
                // remove Group-Images related above-group
                $this->db->where_in('GroupID', $id);
                $this->db->delete('gallery_pics');    
            }else{
                // remove images
                $query = $this->db->query("DELETE FROM `gallery_pics` WHERE `PictureID` IN  ($id)");    
            }

            $this->db->close();
            $this->db->initialize();

            $return = array(
                "status" => "1",
                "html"   => '<div class="success ico ico_success" style="background-color: rgb(220, 255, 184); ">Data has been deleted.</div>'
            );                                     
        }
        catch (Exception $ex) {
            $return = array(
                "status" => "0",
                "html"   => "Fail: " . $ex->Message
            );              
        }

        return $return;
    }

    public function MultiDeleteItem($ids,$table){

        try {
            $this->load->database();
            if($table == 'gallery_groups')
            {
                $query = $this->db->query("SELECT `GroupID`, `GroupTitle` FROM $table WHERE `GroupID` IN ($ids)");
            }else{
                $query = $this->db->query("SELECT `PictureID`, `PictureTitle` FROM $table WHERE `PictureID` IN ($ids)");      
            }
            $result = $query->result();

            $this->db->close();
            $this->db->initialize();
            // echo $this->db->debug_query();
            $return = array(
                "status" => "1",
                "html"   => $result,
            );                               
        }
        catch (Exception $ex) {
            $return = array(
                "status" => "0",
                "html"   => "Fail: " . $ex->Message
            );              
        }

        return $return;
    }
}
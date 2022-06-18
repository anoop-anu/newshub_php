     <?php
require APPPATH . 'libraries/REST_Controller.php';     
class Api extends REST_Controller {    

   public function __construct() {
      header('Access-Control-Allow-Origin: *');
      header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
       parent::__construct();
       $this->load->database('default',TRUE);
       //$this->load->model("ProductModel", "product");
       $this->load->model('Admin_model');
       $this->db2=$this->load->database('db2',TRUE);
       $this->load->library('form_validation');
   }
   //------------------------------all GET------------------------------/
    public function flashnews_get() 
    {  
        $data = $this->Admin_model->flashnews();
        if(!empty($data)){$this->response(($data) , 200);}
        else{ $this->response(array("status" => 0,"message" => "No data found") , 400); }
    }
    public function category_list_get() 
    {  
        $data = $this->Admin_model->category_list();
        if(!empty($data)){$this->response(($data) , 200);}
        else{ $this->response(array("status" => 0,"message" => "No data found") , 400); }
    }
    public function breaking_news_get() 
    {  
        $data = $this->Admin_model->allbreakingNewsdisplay();
        if(!empty($data)){$this->response(($data) , 200);}
        else{ $this->response(array("status" => 0,"message" => "No data found") , 400); }
    }
    public function all_news_get() 
    {  
      $limits=$this->input->get('limits');
      if(empty($limits))
      {  
        $this->response(array("status" => "error","message" => "limits  required") , 400);
      }
      if(!empty($limits))
      {
        $data = $this->Admin_model->all_news($limits);
        if(!empty($data)){$this->response(($data) , 200);}
        else{ $this->response(array("status" => 0,"message" => "No data found") , 400); }
      }
    }
    public function latest_news_get() 
    {   
        $data = $this->Admin_model->latest_news();
        if(!empty($data)){$this->response(($data) , 200);}
        else{ $this->response(array("status" => 0,"message" => "No data found") , 400); }
    }
    public function newscategory_get() 
    { 
      $categoryid=$this->input->get('categoryid'); 
      if(empty($categoryid))
      {  
        $this->response(array("status" => "error","message" => "categoryid  required") , 400);
      }
      if(!empty($categoryid))
      {
        $data = $this->Admin_model->newscategory_news($categoryid);
        if(!empty($data)){$this->response(($data) , 200);}
        else{ $this->response(array("status" => 0,"message" => "No data found") , 400); }
      }
    }
    public function video_category_list_get() 
    { 
        $data = $this->Admin_model->newscategory_list();
        if(!empty($data)){$this->response(($data) , 200);}
        else{ $this->response(array("status" => 0,"message" => "No data found") , 400); }
    }
    public function video_list_get() 
    { 
        $data = $this->Admin_model->video_list();
        if(!empty($data)){$this->response(($data) , 200);}
        else{ $this->response(array("status" => 0,"message" => "No data found") , 400); }
    }
    public function news_by_id_get() 
    { 
       $newsId=$this->input->get('newsId'); 
       if(empty($newsId))
       {  
            $this->response(array("status" => "error","message" => "newsId  required") , 400);
       }
       if(!empty($newsId))
       {
            $newsids = $this->Admin_model->newsidcheck($newsId);
            if(empty($newsids))
            {
              $this->response(array("status" => "error",'message ' =>"Invalid newsId") ,400); 
            }
            else
            {
                $data = $this->Admin_model->newsbyid($newsId);
                if(!empty($data)){$this->response(($data) , 200);}
                else{ $this->response(array("status" => "error","message" => "No data found") , 400); }
            }
        }
    }
    public function all_journalist_get() 
    {
     $data = $this->Admin_model->alljournalistdata();
     if(!empty($data)){$this->response(($data) , 200);}
     else{ $this->response(array("status" => "error","message" => "No data found") , 400); }
    }
    public function channel_list_get() 
    {  
       $usertoken=$this->input->get('token');
       if(empty($usertoken))
       { 
         $this->response(array("status" => "error","token" =>"The token feild is required") ,400); 
       }
       else
       {
            $result = $this->Admin_model->journalist_tokencheck($usertoken);
            if(empty($result))
            {
               $this->response(array("status" => "error","message" =>"Invalid token") ,400); 
            }
            else
            {
                $data = $this->Admin_model->channel_list($usertoken);
                if(!empty($data)){$this->response(($data) , 200);}
                else{ $this->response(array("status" => 0,"message" => "No data found") , 400); }
            }            
        }
    }
    public function user_profile_get() 
    {  
       $usertoken=$this->input->get('token');
       if(empty($usertoken))
       { 
         $this->response(array("status" => "error","token" =>"The token feild is required") ,400); 
       }
       else
       {
            $result = $this->Admin_model->tokencheck($usertoken);
            if(empty($result))
            {
               $this->response(array("status" => "error","message" =>"Invalid token") ,400); 
            }
            else
            {
                $data = $this->Admin_model->user_profile($usertoken);
                if(!empty($data)){$this->response(($data) , 200);}
                else{ $this->response(array("status" => 0,"message" => "No data found") , 400); }
            }            
        }
    }
    public function user_post_list_get() 
    { 
      $usertoken=$this->input->get('token');
      if(empty($usertoken))
      {  
        $this->response(array("status" => "error","message" => "token  required") , 400);
      }
      else
      {
          $result = $this->Admin_model->tokencheck($usertoken);
          if(empty($result))
          {
            $this->response(array("status" => "error","data" =>  array('token ' =>"Invalid token")) ,400); 
          }
          else
          {
            $data = $this->Admin_model->user_post_list($usertoken);
            if(!empty($data)){$this->response(($data) , 200);}
            else{ $this->response(array("status" => 0,"message" => "No data found") , 400); }   
          }
        }
    }
    public function saved_news_list_get() 
    {      
        $savednews=$this->input->get('savedNewsId');
        if(empty($savednews))
        {  
            $this->response(array("status" => "error","message" => "savedNewsId  required") , 400);
        }
        else
        {
             $data = $this->Admin_model->news_id_list_details($savednews);
             if(!empty($data)){$this->response(($data) , 200);}
             else{ $this->response(array("status" => 0,"message" => "No data found") , 400); } 
        }  
    }
    public function shared_post_list_get() 
    { 
        $userToken=$this->input->get('token');
        if(empty($userToken))
        {  
            $this->response(array("status" => "error","message" => "token  required") , 400);
        }
        else 
        {       
            //$userToken = $this->input->get('userToken', TRUE);
            $result = $this->Admin_model->tokencheck($userToken);
            if(empty($result))
            {
               $this->response(array("status" => "error","message" =>"Invalid token") ,400); 
            }
            else
            {
             $data = $this->Admin_model->shared_post_list($userToken);
             if(!empty($data)){$this->response(($data) , 200);}
             else{ $this->response(array("status" => 0,"message" => "No data found") , 400); } 
            }
        }
    }
    public function liked_post_list_get() 
    { 
        $userToken=$this->input->get('token');
        if(empty($userToken))
        {  
            $this->response(array("status" => "error","message" => "token  required") , 400);
        }
        else 
        {       
            //$userToken = $this->input->get('userToken', TRUE);
            $result = $this->Admin_model->tokencheck($userToken);
            if(empty($result))
            {
               $this->response(array("status" => "error","data" =>  array('token ' =>"Invalid token")) ,400); 
            }
            else
            {   
                 $data = $this->Admin_model->liked_post_list($userToken);
                 if(!empty($data)){$this->response(($data) , 200);}
                 else{ $this->response(array("status" => 0,"message" => "No data found") , 400); } 
            }
        }
    }
    public function saved_post_list_get() 
    { 
        $userToken=$this->input->get('token');
        if(empty($userToken))
        {  
            $this->response(array("status" => "error","message" => "token  required"
            ) , 400);
        }
        else 
        {       
            //$userToken = $this->input->get('userToken', TRUE);
            $result = $this->Admin_model->tokencheck($userToken);
            if(empty($result))
            {
               $this->response(array("status" => "error","data" =>  array('token ' =>"Invalid token")) ,400); 
            }
            else
            {
                 $data = $this->Admin_model->saved_post_list($userToken);
                 if(!empty($data)){$this->response(($data) , 200);}
                 else{ $this->response(array("status" => 0,"message" => "No data found") , 400); } 
            }
        }
    }
    public function masterlogin_get() 
    {  
      $this->db2->select('*');
      $this->db2->from('tbl_login');
      $this->db2->order_by('id','desc');
     // $this->db->where("status","0");
      $this->db2->group_by('id');
      $query = $this->db2->get();
      $result = $query->result_array();
      if(!empty($result)){$this->response(($result) , 200);}
       //if(!empty($result)){echo json_encode($result);}
      else{ $this->response(array("status" => 0,"message" => "No data found") , 400); }
    }
    public function exact_location_list_get()
    {
        $this->db->select('l.*,r.*')
        ->from('master_login.tbl_login as l')->from('iconnect.tbl_registration as r')->
        where('l.token=r.token')->where('r.userType=1') ->group_by('l.id');
        $query = $this->db->get();
        $result = $query->result_array();
        foreach($result as $value){
         $data[]  = array('latitude'=> (float)$value['latitude'],
                             'longitude'=>(float) $value['longitude'],);}
        $array["users"]=$data;
        $this->db->select('latitude,longitude');
        $this->db->from('tbl_anonymous_user');
        $this->db->group_by('id');
        $query = $this->db->get();
        $result = $query->result_array();
        foreach($result as $value){
        $data1[]  = array('latitude'=> (float)$value['latitude'],
                             'longitude'=>(float) $value['longitude'],);}
        $array["auser"]=$data1;
        $arrays["users"] = array_merge($data,$data1);

        $this->db->select('l.*,r.*')
        ->from('master_login.tbl_login as l')->from('iconnect.tbl_registration as r')->
        where('l.token=r.token')->where('r.userType=2') ->group_by('l.id');
        $query = $this->db->get();
        $result = $query->result_array();
        foreach($result as $value){
         $data3[]  = array( 'latitude'=> (float)$value['latitude'],
                             'longitude'=>(float) $value['longitude'],
                             'userName'=>$value['userName'],
                             'location'=>$value['location'],
                             'journalistBio'=>$value['journalistBio'],
                             'token'=>$value['token'],
                             'imageName'=>$value['imageName'],
                         );}
        $arrays["journalist"]=$data3;
        if(!empty($result)){$this->response(($arrays) , 200);}
        else{ $this->response(array("status" => "error","message" => "No data found") , 400); }
    }
    public function interest_list_get() 
    {  
      $this->db->select('id,interest');
      $this->db->from('tbl_interest');
      $query = $this->db->get();
      $result = $query->result_array();
        foreach($result as $value)
         {
            $data[]  = array('id'=> (int)$value['id'],
                             'interest'=> $value['interest'],
                          );
         }
         if(!empty($result)){$this->response(($data) , 200);}
         else{ $this->response(array("status" => "error","message" => "No data found") , 400); }
    }
    public function followerslist_get() 
    {  
        $usertoken=$this->input->get('token');
        if(empty($usertoken))
        { 
         $this->response(array("status" => "error","data" =>  array('token ' =>"The token feild is required")) ,400); 
        }
        else
        {
            $result = $this->Admin_model->tokencheck($usertoken);
            if(empty($result))
            {
               $this->response(array("status" => "error","data" =>  array('token ' =>"Invalid token")) ,400); 
            }
            else
            {

            $this->db->select ("iconnect.tbl_followers.*");
               $this->db->from('iconnect.tbl_followers');
              $this->db->where('iconnect.tbl_followers.userToken', $usertoken);
               $query = $this->db->get();
               //echo $this->db->last_query();exit;
               $result = $query->result_array();
               if(!empty($result)){$this->response(($result) , 200);}
                  else{ $this->response(array("status" => 0,"message" => "No data found") , 400); }
            }
        }
    }
    public function commented_post_list_get() 
    { 
        $userToken=$this->input->get('token');
        if(empty($userToken))
        {  
            $this->response(array("status" => "error","message" => "token  required") , 400);
        }
        else 
        {       
            //$userToken = $this->input->get('userToken', TRUE);
            $result = $this->Admin_model->tokencheck($userToken);
            if(empty($result))
            {
               $this->response(array("status" => "error","data" =>  array('token ' =>"Invalid token")) ,400); 
            }
            else
            {
             $this->db->select('tbl_news_category.*,tbl_news.*,tbl_usercomment.*');
             $this->db->from('tbl_news_category');
             $this->db->join('tbl_news','tbl_news.categoryId=tbl_news_category.id','left');
             $this->db->join('tbl_usercomment','tbl_news.id=tbl_usercomment.newsId','left');
             $this->db->where('tbl_usercomment.token',$userToken);
             $this->db->order_by('tbl_usercomment.created_at','desc');
             //$this->db->limit($limits);
             $this->db->group_by('tbl_usercomment.id'); 
             $query = $this->db->get();
             //echo $this->db->last_query();exit;
             $result = $query->result_array();
             foreach($result as $value)
             {
              $result = $this->Admin_model->newstime($value['addsDate']);
                $data[]  = array(
                                  'id'=> $value['id'],
                                  'newsCategory'=> $value['newsCategory'],
                                  'categoryId'=> $value['categoryId'],
                                  'imageName'=> $value['imageName'],
                                  'location'=> $value['location'],
                                  'newsTitle'=> $value['newsTitle'],
                                  'newsDetails1'=> $value['newsDetails1'],
                                  'newsDetails2'=> $value['newsDetails2'],
                                   'addsDate'=> date("d-m-Y H:i:s", strtotime($value['addsDate'])),
                                  'token'=> $value['token'],
                                  'newstime'=>$result,
                                  'comment'=> $value['comment']
                              );
             }
             if(!empty($result)){$this->response(($data) , 200);}
             else{ $this->response(array("status" => "error","message" => "No data found") , 400); }
            }
        }
    }
    public function suggestion_list_get() 
    {      
        $mobnos=$this->input->get('mobileNos');
        if(empty($mobnos))
        {  
            $this->response(array("status" => "error","message" => "mobileNos  required") , 400);
        }
        else
        {
             $data = $this->Admin_model->suggestions_list_details($mobnos);
             if(!empty($data)){$this->response(($data) , 200);}
             else{ $this->response(array("status" => 0,"message" => "No data found") , 400); } 
        }  
    }
  //---------------------------------------all POST------------------------------/
   public function addfollowers_post()
   {
        $_POST = $this->security->xss_clean($_POST);
        # Form Validation
        $this->form_validation->set_rules('userToken', 'User Token', 'required');
        $this->form_validation->set_rules('followerToken', 'Follower Token', 'required');
        $userToken = $this->input->post('userToken', TRUE);
        $followerToken = $this->input->post('followerToken', TRUE);
         if ($this->form_validation->run() == FALSE)
         {
            // Form Validation Errors
            $message = array(
                    'status' => 'error',
                    'data' => $this->form_validation->error_array(),                
            );
            $this->response($message, 502);
         }
         else 
         { 
             if(!empty($userToken) && !empty($followerToken)  )
             { 
               $token=0;$tokens=0;
               $this->db->select('master_login.tbl_login.token');
               $this->db->from('master_login.tbl_login');
               $this->db->where('master_login.tbl_login.token',$userToken);
               $query = $this->db->get();
               //echo $this->db->last_query();exit;
               $resultuserToken = $query->row_array();
               //if(!empty($result)){echo json_encode($result);}
               if(!empty($resultuserToken)){$resultuserToken;$token=1;}
               else{ $this->response(array("status" => "error","data" =>  array('message' =>"Invalid User Token")) ,400); }

               $this->db->select('master_login.tbl_login.token');
               $this->db->from('master_login.tbl_login');
               $this->db->where('master_login.tbl_login.token',$followerToken);
               $query1 = $this->db->get();
               //echo $this->db->last_query();exit;
               $resultfollowerToken = $query1->row_array();
               //if(!empty($result)){echo json_encode($result);}
               if(!empty($resultfollowerToken)){$resultfollowerToken;$tokens=1;}
               else{ $this->response(array("status" => "error","data" =>  array('message' =>"Invalid follower Token")) ,400);}
               if($token==1 && $tokens==1 )
               {
                  $this->db->select('*');
                  $this->db->from('tbl_followers');
                  $this->db->where('userToken',$userToken );
                  $this->db->where('followersToken',$followerToken );
                  $query = $this->db->get();
                  //echo $this->db->last_query();exit;
                  $resultuserToken = $query->row_array();
                  if(!empty($resultuserToken))
                     {$this->response(array("status" => "error","data" =>  array('message' =>"This User already followed this ID")) ,400);}
                  else{ 
                        $data=array(
                              'userToken'=> $userToken,
                              'followersToken'=> $followerToken,
                              'created_at'=>date('Y-m-d H:i:s')
                          );
                        $query=$this->db->insert('tbl_followers', $data);  
                        if($query){ $this->response(array("status" => "success","data" =>  array('message' =>"This User  followed this ID")) ,200);}
                        else{ $this->response(array("status" => "error","data" =>  array('message' =>"This User can't followed this ID")) ,400);}
                  }
               }                  
            }
         }
   }
   public function add_userfollowing_post()
   {

        $_POST = $this->security->xss_clean($_POST);
        # Form Validation
        $this->form_validation->set_rules('userToken', 'User Token', 'required');
        $this->form_validation->set_rules('followingToken', 'Following Token', 'required');
        $userToken = $this->input->post('userToken', TRUE);
        $followerToken = $this->input->post('followingToken', TRUE);
         if ($this->form_validation->run() == FALSE)
         {
            // Form Validation Errors
            $message = array(
                    'status' => 'error',
                    'data' => $this->form_validation->error_array(),                
            );
            $this->response($message, 502);
         }
         else 
         { 
             if(!empty($userToken) && !empty($followerToken)  )
             { 
               $token=0;$tokens=0;
               $this->db->select('master_login.tbl_login.token');
               $this->db->from('master_login.tbl_login');
               $this->db->where('master_login.tbl_login.token',$userToken);
               $query = $this->db->get();
               //echo $this->db->last_query();exit;
               $resultuserToken = $query->row_array();
               //if(!empty($result)){echo json_encode($result);}
               if(!empty($resultuserToken)){$resultuserToken;$token=1;}
               else{ $this->response(array("status" => "error","data" =>  array('message' =>"Invalid User Token")) ,400); }

               $this->db->select('master_login.tbl_login.token');
               $this->db->from('master_login.tbl_login');
               $this->db->where('master_login.tbl_login.token',$followerToken);
               $query1 = $this->db->get();
               //echo $this->db->last_query();exit;
               $resultfollowerToken = $query1->row_array();
               //if(!empty($result)){echo json_encode($result);}
               if(!empty($resultfollowerToken)){$resultfollowerToken;$tokens=1;}
               else{ $this->response(array("status" => "error","data" =>  array('message' =>"Invalid follower Token")) ,400);}
               if($token==1 && $tokens==1 )
               {
                  $this->db->select('*');
                  $this->db->from('tbl_following');
                  $this->db->where('userToken',$userToken );
                  $this->db->where('followersToken',$followerToken );
                  $query = $this->db->get();
                  //echo $this->db->last_query();exit;
                  $resultuserToken = $query->row_array();
                  if(!empty($resultuserToken))
                     {$this->response(array("status" => "error","data" =>  array('message' =>"This User already followed this ID")) ,400);}
                  else{ 
                        $data=array(
                              'userToken'=> $userToken,
                              'followersToken'=> $followerToken,
                              'created_at'=>date('Y-m-d H:i:s')
                          );
                        $query=$this->db->insert('tbl_followers', $data);  
                        if($query){ $this->response(array("status" => "success","data" =>  array('message' =>"This User  followed this ID")) ,200);}
                        else{ $this->response(array("status" => "error","data" =>  array('message' =>"This User can't followed this ID")) ,400);}
                  }

               }                  
            }
         }
   }
   public function user_profile_post()
   {
        header("Access-Control-Allow-Origin: *");
        $token = $this->input->post('token', TRUE);
        $_POST = $this->security->xss_clean($_POST);
        # Form Validation
        $this->form_validation->set_rules('token', 'Token', 'required');
        $this->form_validation->set_rules('accountHolderName', 'Account Holder Name', 'required');
        $this->form_validation->set_rules('bankName', 'Bank Name', 'required');
        $this->form_validation->set_rules('accountNumber', 'accountNumber', 'required');
        $this->form_validation->set_rules('ifsc', 'IFSC', 'required');
        $this->form_validation->set_rules('aadharName', 'aadhar name', 'required');
        $this->form_validation->set_rules('aadarNumber', 'aadarNumber', 'required');
        $this->form_validation->set_rules('userType', 'userType', 'required');
        if (empty($_FILES['passbookPath']['name']))
         {
             $this->form_validation->set_rules('passbookPath', 'Image', 'required');
         }
         if (empty($_FILES['aadharImagePath1']['name']))
         {
             $this->form_validation->set_rules('aadharImagePath1', 'Image', 'required');
         }
         if (empty($_FILES['aadharImagePath2']['name']))
         {
             $this->form_validation->set_rules('aadharImagePath2', 'Image', 'required');
         }
        /* if (!empty($_FILES['passbookPath']['name']))
         {
             $file1= $_FILES['passbookPath']['name'];
             echo json_encode($file1);
         }*/
      if ($this->form_validation->run() == FALSE)
      {
            // Form Validation Errors
            $message = array(
                    'status' => 'error',
                    'data' => $this->form_validation->error_array(),                
            );
            $this->response($message, 502);
      }
      else
      {
         $result = $this->Admin_model->tokencheck($token);
         if(empty($result))
         {
            $this->response(array("status" => "error","data" =>  array('token ' =>"Invalid token")) ,400); 
         }
         else
         {

            $this->db->select('token,accountHolderName,bankName,ifsc,accountNumber,passbookPath,aadarNumber,aadharName,aadharImageName1,aadharImagePath1,aadharImageName2,aadharImagePath2,userType,journalistDescription,idImage');
            $this->db->from('tbl_registration');
            $this->db->where('token',$token);
            $this->db->group_by('id');
            $query = $this->db->get();
            //echo $this->db->last_query();exit;
            $result1 = $query->row_array();
            if(!empty($result1))
            {
               $this->response(array("status" => "error","message" => "The token has already been registered ","data" =>  $result1) ,400); 
            }
            else
            {
                  $files = $_FILES;
                   $name = $_FILES['passbookPath']['name'];
                   $name1 = $_FILES['aadharImagePath1']['name'];
                  $name2 = $_FILES['aadharImagePath2']['name'];

               if($name!='' && $name1!='' && $name2!='')
               {
                  $imageup=0;
                  $filename = trim(addslashes($_FILES['passbookPath']['name']));
                  $filename = str_replace(' ', '_', $filename);
                  $filename = preg_replace('/\s+/', '_', $filename);
                  $new_name=$filename;
                  $flag = rand(1000, 9999);
                  $new_name =$flag. time().'_'.$_FILES["passbookPath"]['name'];
                  $config['file_name'] = $new_name;
                  $file_name  = $_FILES['passbookPath']['name']= $files['passbookPath']['name'];
                  $_FILES['passbookPath']['type']= $files['passbookPath']['type'];
                  $_FILES['passbookPath']['tmp_name']= $files['passbookPath']['tmp_name'];
                  $_FILES['passbookPath']['error']= $files['passbookPath']['error'];
                  $_FILES['passbookPath']['size']= $files['passbookPath']['size'];
                  $config['upload_path']   = './uploads/userimage/'; 
                     $config['allowed_types'] = 'gif|jpg|png|jpeg'; 
                     $config['max_size']      = 0; 
                     $config['max_width']     = 2000; 
                     $config['max_height']    = 2000;
                     //$config['min_width']     = 1500; 
                     //$config['min_height']    = 381;
                     $this->load->helper(array('form','url'));
                     $this->load->library('upload', $config);
                     $this->upload->initialize($config);
                      //$this->upload->do_upload('userfile');
                      //var_dump($result1);exit();
                     if ( $this->upload->do_upload('passbookPath')) 
                        {
                           $passbookPath = base_url().'uploads/userimage/'.$new_name;
                           $passbookPathName=$new_name;
                           $imageup=1;
                         } 
                     else
                        {
                           $this->response(array("status" => "error","data" =>  array('message' =>"passbook Image uplod error")) ,400);
                        }
                  if($imageup==1)
                  {
                     $filename = trim(addslashes($_FILES['aadharImagePath1']['name']));
                     $filename = str_replace(' ', '_', $filename);
                     $filename = preg_replace('/\s+/', '_', $filename);
                     $new_name=$filename;
                     $flag1 = rand(1000, 9999);
                     $new_name = $flag1.time().'_'.$_FILES["aadharImagePath1"]['name'];
                     $config['file_name'] = $new_name;
                     $file_name  = $_FILES['aadharImagePath1']['name']= $files['aadharImagePath1']['name'];
                     $_FILES['aadharImagePath1']['type']= $files['aadharImagePath1']['type'];
                     $_FILES['aadharImagePath1']['tmp_name']= $files['aadharImagePath1']['tmp_name'];
                     $_FILES['aadharImagePath1']['error']= $files['aadharImagePath1']['error'];
                     $_FILES['aadharImagePath1']['size']= $files['aadharImagePath1']['size'];
                     $config['upload_path']   = './uploads/userimage/'; 
                        $config['allowed_types'] = 'gif|jpg|png|jpeg'; 
                        $config['max_size']      = 0; 
                        $config['max_width']     = 2000; 
                        $config['max_height']    = 2000;
                        //$config['min_width']     = 1500; 
                        //$config['min_height']    = 381;
                        $this->load->helper(array('form','url'));
                        $this->load->library('upload', $config);
                        $this->upload->initialize($config);
                      //$this->upload->do_upload('userfile');
                      //var_dump($result1);exit();
                         if ( $this->upload->do_upload('aadharImagePath1')) 
                         {

                           $aadharImagePath1 = base_url().'uploads/userimage/'.$new_name;
                           $aadharImagePath1name=$new_name;
                           $imageup=2;

                         } 
                         else
                         {
                           $this->response(array("status" => "error","data" =>  array('message' =>"aadharImagePath1 Image uplod error")) ,400);
                         }
                  }
                  if($imageup==2)
                  {
                     $filename = trim(addslashes($_FILES['aadharImagePath2']['name']));
                     $filename = str_replace(' ', '_', $filename);
                     $filename = preg_replace('/\s+/', '_', $filename);
                     $new_name=$filename;
                     $flag1 = rand(1000, 9999);
                     $new_name = $flag1.time().'_'.$_FILES["aadharImagePath2"]['name'];
                     $config['file_name'] = $new_name;
                     $file_name  = $_FILES['aadharImagePath2']['name']= $files['aadharImagePath2']['name'];
                     $_FILES['aadharImagePath2']['type']= $files['aadharImagePath2']['type'];
                     $_FILES['aadharImagePath2']['tmp_name']= $files['aadharImagePath2']['tmp_name'];
                     $_FILES['aadharImagePath2']['error']= $files['aadharImagePath2']['error'];
                     $_FILES['aadharImagePath2']['size']= $files['aadharImagePath2']['size'];
                     $config['upload_path']   = './uploads/userimage/'; 
                        $config['allowed_types'] = 'gif|jpg|png|jpeg'; 
                        $config['max_size']      = 0; 
                        $config['max_width']     = 2000; 
                        $config['max_height']    = 2000;
                        //$config['min_width']     = 1500; 
                        //$config['min_height']    = 381;
                        $this->load->helper(array('form','url'));
                        $this->load->library('upload', $config);
                        $this->upload->initialize($config);
                      //$this->upload->do_upload('userfile');
                      //var_dump($result1);exit();
                         if ( $this->upload->do_upload('aadharImagePath2')) 
                         {

                           $aadharImagePath2 = base_url().'uploads/userimage/'.$new_name;
                           $aadharImagePath2name=$new_name;
                           $imageup=3;

                         } 
                         else
                         {
                           $this->response(array("status" => "error","data" =>  array('message' =>"aadharImagePath2 Image uplod error")) ,400);
                         }
                  }
                  if($imageup==3)
                  {
                  $accountHolderName = $this->input->post('accountHolderName', TRUE);
                  $bankName = $this->input->post('bankName', TRUE);
                  $ifsc = $this->input->post('ifsc', TRUE);
                  $accountNumber = $this->input->post('accountNumber', TRUE);
                  //$passbookPath = $this->input->post('passbookPath', TRUE);
                  $aadharName = $this->input->post('aadharName', TRUE);
                  $aadarNumber = $this->input->post('aadarNumber', TRUE);
                  //$aadharImagePath1 = $this->input->post('aadharImagePath1', TRUE);
                  // $aadharImagePath2 = $this->input->post('aadharImagePath2', TRUE);
                  $userType = $this->input->post('userType', TRUE);
                  $data=array(
                              'token'=> $token,
                              'accountHolderName'=> $accountHolderName,
                              'bankName'=> $bankName,
                              'accountNumber'=> $accountNumber,
                              'ifsc'=> $ifsc,
                              'aadarNumber'=>$aadarNumber, 
                              'passbookPath'=>$passbookPath,
                              'passbookPathName'=>$passbookPathName,
                              'aadharName'=>$aadharName,
                              'aadharImageName1'=>$aadharImagePath1name,
                              'aadharImagePath1'=>$aadharImagePath1 ,
                              'aadharImageName2'=>$aadharImagePath2name,
                              'aadharImagePath2'=>$aadharImagePath2,
                              'userType'=>$userType,
                              'status'=>'0',
                              'created_at'=>date('Y-m-d H:i:s')
                          );
                  $query=$this->db->insert('tbl_registration', $data);  
                  if($query){ $this->response(array("status" => "success") ,200);}
                           else{ $this->response(array(
                              "status" => "error",
                             "message" =>"Failed to create User") ,500);}
                  } 
               }
               else{ $this->response(array(
                              "status" => "error",
                           "message" =>"Failed to create User") ,500);}
            }
         }
      }
    }

    public function shared_post_post() 
    { 
        $_POST = $this->security->xss_clean($_POST);
        # Form Validation
        $this->form_validation->set_rules('newsId', 'newsId ', 'required');
        $this->form_validation->set_rules('userToken', 'userToken', 'required');
        if ($this->form_validation->run() == FALSE)
         {
            // Form Validation Errors
            $message = array(
                    'status' => 'error',
                    'data' => $this->form_validation->error_array(),                
            );
            $this->response($message, 502);
         }
         else 
         { 
            

            $newsId = $this->input->post('newsId', TRUE);
            $userToken = $this->input->post('userToken', TRUE);
            $result = $this->Admin_model->tokencheck($userToken);
            $newsids = $this->Admin_model->newsidcheck($newsId);
            if(empty($result))
            {
               $this->response(array("status" => "error","data" =>  array('token ' =>"Invalid token")) ,400); 
            }
            else if(empty($newsids))
            {
               $this->response(array("status" => "error","data" =>  array('newsId ' =>"Invalid newsId")) ,400); 
            }
            else
            {
                $query1 = $this->Admin_model->sharecheck($newsId,$userToken);
                if($query1)
                {
                   $this->response(array("status" => "error","data" =>  array('message ' =>"This post already shared by this user")) ,400); 
                }
                else
                {
                 $data=array(
                              'newsId'=> $newsId ,
                              'userToken'=> $userToken,
                              'created_at'=>date('Y-m-d H:i:s')
                          );
                   $query=$this->db->insert('tbl_shared_news', $data);  
                   if($query){ $this->response(array("status" => "success") ,200);}
                           else{ $this->response(array(
                              "status" => "error",
                             "message" =>"Failed to share post") ,500);} 
                }     
            }
        }
    }
    public function like_post_post() 
    { 
        $_POST = $this->security->xss_clean($_POST);
        # Form Validation
        $this->form_validation->set_rules('newsId', 'newsId ', 'required');
        $this->form_validation->set_rules('userToken', 'userToken', 'required');

        if ($this->form_validation->run() == FALSE)
         {
            // Form Validation Errors
            $message = array(
                    'status' => 'error',
                    'data' => $this->form_validation->error_array(),                
            );
            $this->response($message, 502);
         }
         else 
         { 
            

            $newsId = $this->input->post('newsId', TRUE);
            $userToken = $this->input->post('userToken', TRUE);
            $result = $this->Admin_model->tokencheck($userToken);
            $newsids = $this->Admin_model->newsidcheck($newsId);
            if(empty($result))
            {
               $this->response(array("status" => "error","data" =>  array('token ' =>"Invalid token")) ,400); 
            }
            else if(empty($newsids))
            {
               $this->response(array("status" => "error","data" =>  array('newsId ' =>"Invalid newsId")) ,400); 
            }
            else
            {
                $query1 = $this->Admin_model->likedpostcheck($newsId,$userToken);
                if($query1)
                {
                   $this->response(array("status" => "error","data" =>  array('message ' =>"This post already liked by this user")) ,400); 
                }
                else
                {
                 $data=array(
                              'newsId'=> $newsId ,
                              'userToken'=> $userToken,
                              'created_at'=>date('Y-m-d H:i:s')
                          );
                   $query=$this->db->insert('tbl_liked_news', $data);  
                   if($query){ $this->response(array("status" => "success") ,200);}
                           else{ $this->response(array(
                              "status" => "error",
                             "message" =>"Failed to like post") ,500);} 
                }     
            }
        }
    }
    public function comment_post_post() 
    { 
        $_POST = $this->security->xss_clean($_POST);
        # Form Validation
        $this->form_validation->set_rules('newsId', 'newsId ', 'required');
        $this->form_validation->set_rules('userToken', 'userToken', 'required');
        $this->form_validation->set_rules('comment', 'comment', 'required');

        if ($this->form_validation->run() == FALSE)
         {
            // Form Validation Errors
            $message = array(
                    'status' => 'error',
                    'data' => $this->form_validation->error_array(),                
            );
            $this->response($message, 502);
         }
         else 
         { 
            
            $newsId = $this->input->post('newsId', TRUE);
            $userToken = $this->input->post('userToken', TRUE);
            $comment = $this->input->post('comment', TRUE);
            $result = $this->Admin_model->tokencheck($userToken);
            $newsids = $this->Admin_model->newsidcheck($newsId);
            if(empty($result))
            {
               $this->response(array("status" => "error","data" =>  array('token ' =>"Invalid token")) ,400); 
            }
            else if(empty($newsids))
            {
               $this->response(array("status" => "error","data" =>  array('newsId ' =>"Invalid newsId")) ,400); 
            }
            else
            {
                 $data=array(
                              'newsId'=> $newsId ,
                              'token'=> $userToken,
                              'comment'=> $comment,
                              'parentId'=>0,
                              'created_at'=>date('Y-m-d H:i:s')
                          );
                   $query=$this->db->insert('tbl_usercomment', $data);  
                   if($query){ $this->response(array("status" => "success") ,200);}
                           else{ $this->response(array(
                              "status" => "error",
                             "message" =>"Failed to like post") ,500);}   
            }
        }
    }
    public function reply_post_post() 
    { 
        $_POST = $this->security->xss_clean($_POST);
        # Form Validation
        //$userToken = $this->input->post('userToken', TRUE);
        $this->form_validation->set_rules('token', 'token', 'required');
        $this->form_validation->set_rules('commentId', 'commentId', 'required');
        $this->form_validation->set_rules('reply', 'reply', 'required');

        if ($this->form_validation->run() == FALSE)
         {
            // Form Validation Errors
            $message = array(
                    'status' => 'error',
                    'data' => $this->form_validation->error_array(),                
            );
            $this->response($message, 502);
         }
         else 
         { 
            $userToken = $this->input->post('token', TRUE);
            $commentId = $this->input->post('commentId', TRUE);
            $reply = $this->input->post('reply', TRUE);

            $result = $this->Admin_model->tokencheck($userToken);
            $commentIds = $this->Admin_model->commentidcheck($commentId);
            if(empty($result))
            {
               $this->response(array("status" => "error","data" =>  array('token ' =>"Invalid token")) ,400); 
            }
            else if(empty($commentIds))
            {
               $this->response(array("status" => "error","data" =>  array('newsId ' =>"Invalid commentId")) ,400); 
            }
            else
            {
                           $data=array(
                              'newsId'=> 0,
                              'token'=> $userToken,
                              'comment'=> $reply,
                              'parentId'=>$commentId,
                              'created_at'=>date('Y-m-d H:i:s')
                        );
                   $query=$this->db->insert('tbl_usercomment', $data);  
                   if($query){ $this->response(array("status" => "success", "message" =>"reply posted successfully") ,200);}
                           else{ $this->response(array(
                              "status" => "error",
                             "message" =>"Failed to  add reply") ,500);}   
            }
        }
    }


    public function saved_post_list_post() 
    {
        $_POST = $this->security->xss_clean($_POST);
        $this->form_validation->set_rules('token', 'token ', 'required');
        $this->form_validation->set_rules('newsId', 'newsId', 'required');

        $newsId = $this->input->post('newsId', TRUE);
        $userToken = $this->input->post('token', TRUE);
        if ($this->form_validation->run() == FALSE)
        {
            $message = array(
                    'status' => 'error',
                    'data' => $this->form_validation->error_array(),                
            );
            $this->response($message, 502);
        }
        else 
        { 
            $result = $this->Admin_model->tokencheck($userToken);
            $result1 = $this->Admin_model->newsidcheck($newsId);
            $result2 = $this->Admin_model->saved_check($newsId,$userToken);
            if($result2)
            {
                $this->response(array("status" => "error","data" =>  array('message ' =>"This post already saved by this user")) ,400); 
            }
            else if(empty($result))
            {
                $this->response(array("status" => "error","message" => "Invalid token"),400); 
            }
            else if(empty($result1))
            {
                $this->response(array("status" => "error","message" => "Invalid newsId"),400); 
            }
            else
            {
                $data=array(
                        'token'=>$userToken,
                        'newsId'=>$newsId,
                        'created_at'=>date('Y-m-d H:i:s'));
                    $query1=$this->db->insert('tbl_saved_news', $data);
                     if($query1){$this->response(array("status" => "success","token" => $userToken) , 200);}
                     else
                     {$this->response(array("status" => "error","message" => "Internal Server Error") , 500); }    
            }
            
            
        }
    }
    //anonymous user
    public function user_tempid_post() 
    { 
      $_POST = $this->security->xss_clean($_POST);
      $this->form_validation->set_rules('location', 'location ', 'required');
      $this->form_validation->set_rules('interest[]', 'interest ', 'required');
      $location = $this->input->post('location', TRUE);
       $interest = $this->input->post('interest', TRUE);
        if ($this->form_validation->run() == FALSE)
         {
            // Form Validation Errors
            $message = array(
                    'status' => 'error',
                    'data' => $this->form_validation->error_array(),                
            );
            $this->response($message, 502);
         }
         else
         {
            $flag = rand(1000, 9999);
            $datatime = time().$flag;
            $token = substr(base_convert(md5($datatime), 16, 36), 0, 8);
            $query =$this->Admin_model->anonymous_tcokecncheck($token);
            if($query!=true)
            {
                if (!empty($interest))
               {
                  $res=0;
                  for($i=0;$i<count($interest);$i++)
                  {
                     $result = $this->Admin_model->interest_idcheck($interest[$i]);
                     if(empty($result)){
                        $res++;
                     }
                  }
                  if(!empty($res)){
                     $this->response(array("status" => "error","data" =>  array('interestId' =>"Invalid interestId")) ,400);
                  }
                  else
                  {          
                     $data=array(
                        'token'=>$token,
                        'location'=>$location,
                        'created_at'=>date('Y-m-d H:i:s'));
                     $query1=$this->db->insert('tbl_anonymous_user', $data);
                     if($query1)
                     {
                        $userId =$this->db->insert_id();
                        for($i=0;$i<count($interest);$i++)
                           {
                              $data1=array(
                                 'userId '=> $userId,
                                 'anInterestId '=> $interest[$i],
                                 'created_at'=>date('Y-m-d H:i:s'),
                                 );
                              $query2=$this->db->insert('tbl_anms_user_interest', $data1); 
                           }
                           $this->db->trans_complete(); 
                           if($query2){ $this->response(array("status" => "success","token" => $token) , 200);}
                           else{$this->response(array("status" => "error","message" => "Internal Server Error") , 500);}
                     }
                     else
                     {$this->response(array("status" => "error","message" => "Internal Server Error") , 500); }                     
                  }
               }
            }
         }
    }
    /* journalist*/
    public function add_flash_news_post() 
    { 
        $_POST = $this->security->xss_clean($_POST);
        # Form Validation
        $this->form_validation->set_rules('token', 'token ', 'required');
        $this->form_validation->set_rules('flashNews', 'flashNews', 'required');

        if ($this->form_validation->run() == FALSE)
         {
            // Form Validation Errors
            $message = array(
                    'status' => 'error',
                    'data' => $this->form_validation->error_array(),                
            );
            $this->response($message, 502);
         }
         else 
         { 
            
            $flashNews = $this->input->post('flashNews', TRUE);
            $userToken = $this->input->post('token', TRUE);

            $result = $this->Admin_model->journalist_tokencheck($userToken);
            if(empty($result))
            {
               $this->response(array("status" => "error","data" =>  array('token ' =>"Invalid token")) ,400); 
            }
            else
            {
                $data=array(
                              'token'=> $userToken ,
                              'flashNews'=> $flashNews,
                              'created_at'=>date('Y-m-d H:i:s')
                          );
                   $query=$this->db->insert('tbl_flashnews', $data);  
                   if($query){ $this->response(array("status" => "success") ,200);}
                           else{ $this->response(array(
                              "status" => "error",
                             "message" =>"Failed to post flashnews") ,500);}                    
            }
        }
    }
    public function add_interest_post() 
    { 
      $_POST = $this->security->xss_clean($_POST);
      $this->form_validation->set_rules('interest', 'interest', 'required');
        if ($this->form_validation->run() == FALSE)
         {
            // Form Validation Errors
            $message = array(
                    'status' => 'error',
                    'data' => $this->form_validation->error_array(),                
            );
            $this->response($message, 502);
         }
         else 
         {             
            $interest = $this->input->post('interest', TRUE);
            $result = $this->Admin_model->interest_check($interest);
            if(!empty($result))
            {
               $this->response(array("status" => "error","data" =>  array('message ' =>"interest alredy exist")) ,400); 
            }
            else
            {
               $data=array(
                           'interest'=> $interest ,
                           'created_at'=>date('Y-m-d H:i:s')
                          );
               $query=$this->db->insert('tbl_interest', $data);  
               if($query){ $this->response(array("status" => "success") ,200);}
               else{ $this->response(array(
                              "status" => "error",
                             "message" =>"Failed to add interest") ,500);}                    
            }
        }
   }

   public function add_news_post()
   {
        $token = $this->input->post('token', TRUE);
        $_POST = $this->security->xss_clean($_POST);
        # Form Validation
        $this->form_validation->set_rules('token', 'Token', 'required');
        $this->form_validation->set_rules('breakingNewsId', 'breakingNewsId', 'required');
        $this->form_validation->set_rules('newsTitle', 'newsTitle', 'required');
        $this->form_validation->set_rules('newsDetails1', 'newsDetails1', 'required');
        $this->form_validation->set_rules('newsDetails2', 'newsDetails2', 'required');
        $this->form_validation->set_rules('categoryId', 'categoryId', 'required');
        $this->form_validation->set_rules('interest[]', 'interest', 'required');
        if (empty($_FILES['newsImage']['name']))
         {
             $this->form_validation->set_rules('newsImage', 'Image', 'required');
         }

      if ($this->form_validation->run() == FALSE)
      {
            // Form Validation Errors
            $message = array(
                    'status' => 'error',
                    'data' => $this->form_validation->error_array(),                
            );
            $this->response($message, 502);
      }
      else
      {
         $categoryId = $this->input->post('categoryId', TRUE);
         $breakingNewsId = $this->input->post('breakingNewsId', TRUE);
         $newsTitle = $this->input->post('newsTitle', TRUE);
         $newsDetails1 = $this->input->post('newsDetails1', TRUE);
         $newsDetails2 = $this->input->post('newsDetails2', TRUE);
         $interest = $this->input->post('interest', TRUE);
         $result = $this->Admin_model->journalist_tokencheck($token);
         $result1 = $this->Admin_model->categorycheck($categoryId);
          if (! ($breakingNewsId == 1 || $breakingNewsId == 0) )
         {
            $this->response(array("status" => "error","data" =>  array('breakingNewsId' =>"Invalid breakingNewsId")) ,400); 
         }
         else if(empty($result))
         {
            $this->response(array("status" => "error","data" =>  array('token ' =>"Invalid token")) ,400); 
         }
         else if(empty($result1))
         {
            $this->response(array("status" => "error","data" =>  array('newsId ' =>"Invalid categoryId")) ,400); 
         }
         else
         { 
            if (!empty($interest))
            {
               $res=0;
               for($i=0;$i<count($interest);$i++)
               {
                  $result = $this->Admin_model->interest_idcheck($interest[$i]);
                  if(empty($result)){
                     $res++;
                  }
               }
               if(!empty($res)){
                  $this->response(array("status" => "error","data" =>  array('interestId' =>"Invalid interestId")) ,400);
               }
               else
               {
           
                        $files = $_FILES;
                        $name = $_FILES['newsImage']['name'];
                        if($name!='')
                        {
                              $imageup=0;
                              $filename = trim(addslashes($_FILES['newsImage']['name']));
                              $filename = str_replace(' ', '_', $filename);
                              $filename = preg_replace('/\s+/', '_', $filename);
                              $new_name=$filename;
                              $flag = rand(1000, 9999);
                              $new_name =$flag. time().'_'.$_FILES["newsImage"]['name'];
                              $config['file_name'] = $new_name;
                              $file_name  = $_FILES['newsImage']['name']= $files['newsImage']['name'];
                              $_FILES['newsImage']['type']= $files['newsImage']['type'];
                              $_FILES['newsImage']['tmp_name']= $files['newsImage']['tmp_name'];
                              $_FILES['newsImage']['error']= $files['newsImage']['error'];
                              $_FILES['newsImage']['size']= $files['newsImage']['size'];
                              $config['upload_path']   = './uploads/news/'; 
                                 $config['allowed_types'] = 'gif|jpg|png|jpeg'; 
                                 $config['max_size']      = 0; 
                                 $config['max_width']     = 2000; 
                                 $config['max_height']    = 2000;

                                 //$config['min_width']     = 1500; 
                                 //$config['min_height']    = 381;
                                 $this->load->helper(array('form','url'));
                                 $this->load->library('upload', $config);
                                 $this->upload->initialize($config);
                                 //$this->upload->do_upload('userfile');
                                 //var_dump($result1);exit();
                                 if ( $this->upload->do_upload('newsImage')) 
                                    {
                                       $newsImagePath = base_url().'uploads/news/'.$new_name;
                                       $newsImageName=$new_name;
                                       $this->db->trans_start();
                                       $data=array(
                                          'categoryId'=> $categoryId,
                                          'imageName'=> $new_name,
                                          'location'=> $newsImagePath,
                                          'newsTitle'=> $newsTitle,
                                          'newsDetails1'=> $newsDetails1,
                                          'newsDetails2'=> $newsDetails2,
                                          'addsDate'=>date('Y-m-d H:i:s'),
                                          'token'=> $token,
                                          'flag'=>$breakingNewsId,);
                                          $query=$this->db->insert('tbl_news', $data);  
                                          if($query){ 
                                             $newsids=$this->db->insert_id();
                                             for($i=0;$i<count($interest);$i++)
                                             {
                                                //echo $interest[$i]; echo "\n";
                                                $data1=array(
                                                   'newsId'=> $newsids,
                                                   'interestId '=> $interest[$i],
                                                );
                                                $query1=$this->db->insert('tbl_news_interest', $data1); 
                                             }
                                             $this->db->trans_complete(); 
                                             if($query1){ 
                                              $this->response(array("status" => "success","data" =>  array('message' =>"News has been posted successfully")) ,200);}
                                          }
                                          else{ $this->response(array("status" => "error","data" =>  array('message' =>"This news can't post")) ,400);}

                                    } 
                                 else
                                    {
                                       $this->response(array("status" => "error","data" =>  array('message' =>"newsImage uplod error")) ,400);
                                    }
                           }
                           else{ $this->response(array(
                                          "status" => "error",
                                       "message" =>"Failed to create User") ,500);}
               }
            }
         }
      }
    }
    public function journalist_nearest_location_list_post()
    {
  
        $this->form_validation->set_rules('latitude', 'latitude', 'required');
        $this->form_validation->set_rules('longitude', 'longitude', 'required');
        $this->form_validation->set_rules('distance', 'distance', 'required');
        $lat = $this->input->post('latitude', TRUE);
        $lon = $this->input->post('longitude', TRUE);
        $distance =$this->input->post('distance', TRUE);
        //$km=($distance*0.62137119) ;

        if ($this->form_validation->run() == FALSE)
        {
            // Form Validation Errors
            $message = array(
                    'status' => 'error',
                    'data' => $this->form_validation->error_array(),                
            );
            $this->response($message, 502);
        }
        else 
        {
            //echo $km=$distance * 1.609344;exit;
             $km=$distance / 1.609344;
          $this->db->select("*, ( 3959 * acos( cos( radians(".$lat.") ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(".$lon.") ) + sin( radians(".$lat.") ) * sin( radians( latitude ) ) ) ) AS distance") 
            ->having('distance <=',$km)
            ->from('master_login.tbl_login as l')->from('iconnect.tbl_registration as r')->where('l.token=r.token') 
            ->where('r.userType=',2) ->order_by('distance');
              $query = $this->db->get();
               // echo $this->db->last_query();exit;
            $result = $query->result_array();
            foreach($result as $value)
            {
                $data[]  = array( 'latitude'=> (float)$value['latitude'],
                                 'longitude'=>(float) $value['longitude'],
                                 'userName'=>$value['userName'],
                                 'location'=>$value['location'],
                                 'journalistBio'=>$value['journalistBio'],
                                 'token'=>$value['token'],
                                 'imageName'=>$value['imageName']
                             );
            }
            if(!empty($result)){$this->response(($data) , 200);}
            else{ $this->response(array("status" => 0,"message" => "No data found") , 400); }  
        }       
    }
     //---------------------------------------all TEST-----------------------------/
    public function timeyear_get() 
    { 
      /* $post_date = strtotime('2021-03-05 14:35:10');
         $now = time();
            // will echo "2 hours ago" (at the time of this post)
            echo timespan($post_date, $now) . ' ago';*/

         $timestamp = strtotime('2022-05-05 15:08:10');
         $difference = time()- $timestamp;
         $periods = array("sec", "min", "hour", "day", "week", "month", "year", "decade");
         $lengths = array("60", "60", "24", "7", "4.35", "12", "10");
         if ($difference > 0) { // this was in the past time
            $ending = "ago";
         } else { // this is in the future time
            $difference = -$difference;
            $ending = "to go";
         }
      
         for ($j = 0; $difference >= $lengths[$j]; $j++)
            $difference /= $lengths[$j];
         $difference = round($difference);
         if ($difference > 1)
            $periods[$j].= "s";
         $text = "$difference $periods[$j] $ending";
         echo $text;
   }
    public function test_post()
    {
 
    echo $jsonArray = file_get_contents('php://input') ; 
    $data =  $this->input->post();
    var_dump($data);
//header('Content-Type: application/json; charset=utf-8');
//echo strval($data);
//echo json_encode($data);
        // $json = file_get_contents('php://input');   
        // echo $first = $this->input->post('second', TRUE);

        // //$data = json_decode($json, true);
        //  echo $json;

    }
    public function show_posts_get()
    {

      $this->db->select('*');
      $this->db->from('tbl_comment');
      $this->db->where('parent_comment_id',0);
      $this->db->order_by('comment_id ','asc');
      $this->db->group_by('comment_id');
      $query = $this->db->get();
      //$this->db->last_query();exit;
      $result = $query->result_array();
      //$i=0;
        foreach($result as $value)
        {
            $data[]  = array( 'comment_id'=>$value['comment_id'],
                                 'comment'=>$value['comment']);
            $data[]  =$this->show_comment($value['comment_id']);
            //$i++; 

        }
        $this->response(($data) , 200);
        //var_dump($data);

    /*if(!empty($result)){$this->response(($data) , 200);}
    else{ $this->response(array("status" => 0,"message" => "No data found") , 400); } */
    
    //$commentQuery = "SELECT id, parent_id, comment, sender, date FROM comment WHERE parent_id = '0' ORDER BY id DESC";
   }
   public function show_comment($id)
   {
     $this->db->select('*');
      $this->db->from('tbl_comment');
      $this->db->where('parent_comment_id',$id);
      $this->db->order_by('comment_id ','asc');
      $this->db->group_by('comment_id');
      $query = $this->db->get();
      //$this->db->last_query();exit;
      $result = $query->result_array();
      $i=0;
        foreach($result as $value)
        {
            $data[$i]  =$this->show_comment($value['comment_id']);
            $i++; 
        }
        return $result;  
    }
    public function smstest_post()
    {
        /*--
            {"warnings":[{"code":3,"message":"Invalid number"}],"errors":[{"code":4,"message":"No recipients specified"}],"status":"failure"}

            {"balance":15,"batch_id":2509678969,"cost":1,"num_messages":1,"message":{"num_parts":1,"sender":"iBIX","content":"Welcome to iBix. Your OTP for mobile verification is 1212 - iBix Solutions"},"receipt_url":"","custom":"","messages":[{"id":"13451316504","recipient":919895598316}],"status":"success"}

            https://api.textlocal.in/docs/sendsms
        */
        // Account details
        $apiKey = urlencode('NzE0NTQ1NjU0NDcxNDE0NDU3NTk0MzYzNjEzNDYzNDY=');
        
        // Message details
        $numbers = array(9198955983162);
        $sender = urlencode('iBIX');
        $message = rawurlencode('Welcome to iBix. Your OTP for mobile verification is  - iBix Solutions');
        $numbers = implode(',', $numbers);
     
        // Prepare data for POST request
        $data = array('apikey' => $apiKey, 'numbers' => $numbers, "sender" => $sender, "message" => $message);
     
        // Send the POST request with cURL
        $ch = curl_init('https://api.textlocal.in/send/');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        // Process your response here

        //echo $response;
        $result = json_decode($response);
            if ($result->status == 'success') {
                echo 'It worked...';
                echo $response;
            } else {
                echo "It didn't work.";
                echo $response;
            }
    }



 //$str1="'Welcome to iBix. Your OTP for mobile verification is 1212 - iBix Solutions $otp'";
}
<?php 
 $GLOBALS['a']="abcd";
class Admin_model extends CI_Model {
//var $moduletab1;

   function __construct()
   {
        parent::__construct();
        $this->load->library('table');
        $this->load->helper('date');
   }
   public function flashnews() 
   {  
      $this->db->select('*');
      $this->db->from('tbl_flashnews');
      $this->db->order_by('id','desc');
      $this->db->where("status","0");
      $this->db->group_by('id');
      $query = $this->db->get();
      //echo $this->db->last_query();exit;
      $result = $query->result_array();
      if(!empty($result)){
          foreach($result as $value)
           {
               $data[]  = array('id'=> $value['id'],
                                'flashNews'=> $value['flashNews']);
            }
      }
      if(!empty($result)){return $data;}
      else{return false; }
   }
   public function category_list() 
   {  
         $this->db->select('*');
      $this->db->from('tbl_news_category');
      $query = $this->db->get();
      //echo $this->db->last_query();exit;
      $result = $query->result_array();
      if(!empty($result)){return $result;}
      else{return false; }
   }
	public function projet_details()
	{
	   $this->db->select('tbl_news_category.*,tbl_news.*');
	 	$this->db->from('tbl_news_category');
		$this->db->join('tbl_news','tbl_news.categoryId=tbl_news_category.id','left');
		$this->db->group_by('tbl_news.id'); 
		$query = $this->db->get();
		//echo $this->db->last_query();exit;
		$result = $query->result_array();
		if(!empty($result))
			return $result;
		else
			return false; 	
	}
   public function insert_loginregister($data = array()){
		$query=$this->db->insert('tbl_login', $data);
		if($query){ return true; }
		else{return false;}	
	}
	public function tokencheck($token)
	{
		$this->db->select("master_login.tbl_login.token");
      $this->db->from('master_login.tbl_login');
      $this->db->where('master_login.tbl_login.token', $token);
      $query = $this->db->get();
            //echo $this->db->last_query();exit;
      $result = $query->row_array();
      if($result){return true;}
      else{return false;}
	}
	public function newstime($timest) 
   	{ 
      /* $post_date = strtotime('2021-03-05 14:35:10');
         $now = time();
            // will echo "2 hours ago" (at the time of this post)
            echo timespan($post_date, $now) . ' ago';*/

         $timestamp = strtotime($timest);
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
         return $text;
   }
   public function alljournalistdata() 
   {
         $this->db->select('b.*,c.*')
            ->select('(select count(iconnect.tbl_news.token) from iconnect.tbl_news where iconnect.tbl_news.token = b.token) as postCount',FALSE)
          ->select('(select count(iconnect.tbl_followers.followersToken) from iconnect.tbl_followers where iconnect.tbl_followers.userToken = b.token) as followersCount',FALSE)
          ->select('(select count(iconnect.tbl_following.followingToken) from iconnect.tbl_following where iconnect.tbl_following.userToken = b.token) as followingCount',FALSE)
          ->from('master_login.tbl_login as b')->from('iconnect.tbl_registration as c')->where('b.token=c.token') ->where('c.userType=',2) -> group_by('c.id');
               $query = $this->db->get();
              // echo $this->db->last_query();exit;
         $result = $query->result_array();
         if(!empty($result))
         {
               foreach($result as $value)
              {
                  $data[]=array(
                                    'firstName'=> $value['firstName'],
                                    'lastName'=> $value['lastName'],
                                    'email'=> $value['email'],
                                    'userName'=> $value['userName'],
                                    'phoneNumber'=> $value['phoneNumber'],
                                    'imageName'=> $value['imageName'],
                                    'location'=>$value['location'],
                                    'gender'=> $value['gender'],
                                    'earnings'=>(float) $value['earnings'],
                                    'token'=> $value['token'],
                                    'isVerified'=> (bool)$value['isVerified'],
                                    'followersCount'=> (int)$value['followersCount'],
                                    'followingCount'=>(int) $value['followingCount'],
                                    'bankName'=> $value['bankName'],
                                    'accountNumber'=> $value['accountNumber'],
                                    'ifsc'=> $value['ifsc'],
                                    'passbookPath'=> $value['passbookPath'],
                                    'aadharName'=> $value['aadharName'],
                                    'aadarNumber'=> $value['aadarNumber'],
                                    'aadharImagePath1'=> $value['aadharImagePath1'],
                                    'aadharImagePath2'=> $value['aadharImagePath2'],
                                    'userType'=> $value['userType'],
                                    'createdAt'=> date("d-m-Y H:i:s", strtotime($value['created_at'])),
                                    'postCount'=> $value['postCount'],
                                    'journalistDescription  '=> $value['journalistDescription'],
                                    'idImage'=> $value['idImage'],
                                );
              }
         }
            if(!empty($result))
               return $data;
            else
               return false; 
   }
   public function newsidcheck($id)
   {
      $this->db->select("id");
         $this->db->from('tbl_news');
         $this->db->where('id', $id);
        $query = $this->db->get();
            //echo $this->db->last_query();exit;
        $result = $query->row_array();
        if($result){return true;}
        else{return false;}
   }
   public function sharecheck($newsId,$userToken)
   {
      $this->db->select("*");
      $this->db->from('tbl_shared_news');
      $this->db->where('newsId', $newsId);
      $this->db->where('userToken', $userToken);
        $query = $this->db->get();
            //echo $this->db->last_query();exit;
        $result = $query->row_array();
        if($result){return true;}
        else {return false;}
   }
   public function likedpostcheck($newsId,$userToken)
   {
      $this->db->select("*");
      $this->db->from('tbl_liked_news');
      $this->db->where('newsId', $newsId);
      $this->db->where('userToken', $userToken);
        $query = $this->db->get();
            //echo $this->db->last_query();exit;
        $result = $query->row_array();
        if($result){return true;}
        else {return false;}
   }
   public function commentpostcheck($newsId,$userToken)
   {
      $this->db->select("*");
      $this->db->from('tbl_comment_post');
      $this->db->where('newsId', $newsId);
      $this->db->where('userToken', $userToken);
        $query = $this->db->get();
            //echo $this->db->last_query();exit;
        $result = $query->row_array();
        if($result){return true;}
        else {return false;}
   }
   public function journalist_tokencheck($token)
   {
       $this->db->select('r.token,l.token')
          ->from('master_login.tbl_login as l')->from('iconnect.tbl_registration as r')->where('l.token=r.token') ->where('r.userType!=',1) -> where('r.token=',$token) ;
               $query = $this->db->get();
              // echo $this->db->last_query();exit;
               $result = $query->result_array();
            if(!empty($result))
               return $result;
            else
               return false; 
   }
   public function anonymous_tcokecncheck($id)
   {
      $this->db->select("token");
         $this->db->from('tbl_anonymous_user');
         $this->db->where('token', $id);
        $query = $this->db->get();
            //echo $this->db->last_query();exit;
        $result = $query->row_array();
        if($result){return true;}
        else{return false;}
   }
   public function interest_check($id)
   {
      $this->db->select("interest");
         $this->db->from('tbl_interest');
         $this->db->where('interest', $id);
        $query = $this->db->get();
          //  echo $this->db->last_query();exit;
        $result = $query->row_array();
        if($result){return true;}
        else{return false;}
   }
   public function categorycheck($categoryId)
	{
		$this->db->select("*");
      $this->db->from('tbl_news_category');
      $this->db->where('id', $categoryId);
      $query = $this->db->get();
      //echo $this->db->last_query();exit;
      $result = $query->row_array();
      if($result){return true;}
      else{return false;}
	}
   public function interest_idcheck($id)
   {
      $this->db->select("interest");
         $this->db->from('tbl_interest');
         $this->db->where('id', $id);
        $query = $this->db->get();
          //  echo $this->db->last_query();exit;
        $result = $query->row_array();
        if($result){return true;}
        else{return false;}
   }
   public function commentidcheck($commentid)
	{
		$this->db->select("id");
      $this->db->from('tbl_usercomment');
      $this->db->where('id', $commentid);
      $query = $this->db->get();
            //echo $this->db->last_query();exit;
      $result = $query->row_array();
      if($result){return true;}
      else{return false;}
	}
   public function saved_check($newsId,$userToken)
   {
      $this->db->select("*");
      $this->db->from('tbl_saved_news');
      $this->db->where('newsId', $newsId);
      $this->db->where('token', $userToken);
        $query = $this->db->get();
            //echo $this->db->last_query();exit;
        $result = $query->row_array();
        if($result){return true;}
        else {return false;}
   }
   public function news_id_list_details($newsId) 
   {
      $pattern = '/[;,[,{,","}]/';
      $myArray= preg_split( $pattern, $newsId);
      //$myArray = explode(',', $newsId);
      foreach($myArray as $key => $value1)
      {
        $newsids = $this->newsidcheck($value1);
         if(!empty($newsids))
         {
           $this->db->select('iconnect.tbl_news_category.*,iconnect.tbl_news.*,master_login.tbl_login.imageName as userProfilePic,master_login.tbl_login.userName');
            $this->db->from('iconnect.tbl_news_category');
            $this->db->join('iconnect.tbl_news','iconnect.tbl_news.categoryId=iconnect.tbl_news_category.id','left');
            $this->db->join('master_login.tbl_login','iconnect.tbl_news.token=master_login.tbl_login.token','left');
            $this->db->where('iconnect.tbl_news.id',$value1);
            $this->db->group_by('iconnect.tbl_news.id'); 
            $query = $this->db->get();
            //echo $this->db->last_query();exit;
            $result = $query->result_array();
            foreach($result as $value)
            {
             $result = $this->newstime($value['addsDate']);
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
                                 'userName'=> $value['userName'],
                                 'userProfilePic'=> $value['userProfilePic'],  
                             );
            }
         }
      }
      if(!empty($result)){return $data;}
      else{ return false; }    
   }
   public function newscategory_list() 
   {  
    $this->db->select('*');
      $this->db->from('tbl_livenews');
      $this->db->order_by('id','asc');
      $this->db->group_by('liveCatId');
      $query = $this->db->get();
      //echo $this->db->last_query();exit;
      $result = $query->result_array();
      foreach($result as $value)
      {
         $this->db->select('tbl_livenews.*,tbl_livenews_category.category');
         $this->db->from('tbl_livenews');
         $this->db->join('tbl_livenews_category','tbl_livenews_category.id =tbl_livenews.liveCatId','left');
         $this->db->where('tbl_livenews.liveCatId',$value['liveCatId']);
         $this->db->group_by('tbl_livenews.id');
         $this->db->limit(2);
         $query1 = $this->db->get();
         $result1 = $query1->result_array();
            foreach($result1 as $value)
            {
               $data[$value['category']][]  = array(                   
                                    'channelName'=> $value['newsChannelName'],
                                    'videoLink'=> $value['videoLink'] );

            }
      }
      //  print_r($data);
      if(!empty($result)){return $data;}
      else{ return false; }
   }
   public function video_list() 
   {  
    $this->db->select('*');
      $this->db->from('tbl_livenews');
      $this->db->order_by('id','asc');
      $this->db->group_by('liveCatId');
      $query = $this->db->get();
      //echo $this->db->last_query();exit;
      $result = $query->result_array();
      foreach($result as $value)
      {
         $this->db->select('tbl_livenews.*,tbl_livenews_category.category');
         $this->db->from('tbl_livenews');
         $this->db->join('tbl_livenews_category','tbl_livenews_category.id =tbl_livenews.liveCatId','left');
         $this->db->where('tbl_livenews.liveCatId',$value['liveCatId']);
         $this->db->group_by('tbl_livenews.id');
         //$this->db->limit(2);
         $query1 = $this->db->get();
         $result1 = $query1->result_array();
            foreach($result1 as $value)
            {
               $data[$value['category']][]  = array(                   
                                    'channelName'=> $value['newsChannelName'],
                                    'videoLink'=> $value['videoLink'] );
            }
      }
      //  print_r($data);
      if(!empty($result)){return $data;}
      else{ return false; }
   }
   public function all_news($limits) 
   {  
      $this->db->select('iconnect.tbl_news_category.*,iconnect.tbl_news.*,master_login.tbl_login.imageName as userProfilePic,master_login.tbl_login.userName');
      $this->db->from('iconnect.tbl_news_category');
      $this->db->join('iconnect.tbl_news','iconnect.tbl_news.categoryId=iconnect.tbl_news_category.id','left');
      $this->db->join('master_login.tbl_login','iconnect.tbl_news.token=master_login.tbl_login.token','left');
      //$this->db->where('tbl_news.flag',0);
      $this->db->order_by('iconnect.tbl_news.id','desc');
      $this->db->limit($limits);
      $this->db->group_by('iconnect.tbl_news.id'); 
      $query = $this->db->get();
      //echo $this->db->last_query();exit;
      $result = $query->result_array();
      foreach($result as $value)
      {
         $result = $this->newstime($value['addsDate']);
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
                             'userName'=> $value['userName'],
                              'userProfilePic'=> $value['userProfilePic']);
      }
      if(!empty($result)){return $data;}
      else{ return false; }
   }
   public function latest_news() 
   {   
      $this->db->select('iconnect.tbl_news_category.*,iconnect.tbl_news.*,master_login.tbl_login.imageName as userProfilePic,master_login.tbl_login.userName');
      $this->db->from('iconnect.tbl_news_category');
      $this->db->join('iconnect.tbl_news','iconnect.tbl_news.categoryId=iconnect.tbl_news_category.id','left');
      $this->db->join('master_login.tbl_login','iconnect.tbl_news.token=master_login.tbl_login.token','left');
            //$this->db->where('tbl_news.flag',0);
      $this->db->order_by('iconnect.tbl_news.id','desc');
      $this->db->limit(10);
      $this->db->group_by('iconnect.tbl_news.id'); 
         $query = $this->db->get();
      // $query = $this->db->get();
      //echo $this->db->last_query();exit;
      $result = $query->result_array();
      foreach($result as $value)
         {
          $result = $this->newstime($value['addsDate']);
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
                              'userName'=> $value['userName'],
                              'userProfilePic'=> $value['userProfilePic'],  
                          );
         }
         if(!empty($result)){return $data;}
         else{ return false; }
   }
   public function newscategory_news($categoryid) 
   { 

        $this->db->select('iconnect.tbl_news_category.*,iconnect.tbl_news.*,master_login.tbl_login.imageName as userProfilePic,master_login.tbl_login.userName');
         $this->db->from('iconnect.tbl_news_category');
         $this->db->join('iconnect.tbl_news','iconnect.tbl_news.categoryId=iconnect.tbl_news_category.id','left');
         $this->db->join('master_login.tbl_login','iconnect.tbl_news.token=master_login.tbl_login.token','left');
         $this->db->where('iconnect.tbl_news.categoryId',$categoryid);
         $this->db->group_by('iconnect.tbl_news.id'); 
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
                              'userName'=> $value['userName'],
                              'userProfilePic'=> $value['userProfilePic'],  
                          );
         }
         if(!empty($result)){return $data;}
         else{ return false; }  
   }
   public function allbreakingNewsdisplay()
   {
       $this->db->select('iconnect.tbl_news_category.*,iconnect.tbl_news.*,master_login.tbl_login.imageName as userProfilePic,master_login.tbl_login.userName');
      $this->db->from('iconnect.tbl_news_category');
      $this->db->join('iconnect.tbl_news','iconnect.tbl_news.categoryId=iconnect.tbl_news_category.id','left');
      $this->db->join('master_login.tbl_login','iconnect.tbl_news.token=master_login.tbl_login.token','left');
      $this->db->where('tbl_news.flag',1);
      $this->db->order_by('iconnect.tbl_news.id','desc');
      $this->db->group_by('iconnect.tbl_news.id'); 
         $query = $this->db->get();
      // $query = $this->db->get();
      //echo $this->db->last_query();exit;
      $result = $query->result_array();
      foreach($result as $value)
         {
          $result = $this->newstime($value['addsDate']);
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
                              'userName'=> $value['userName'],
                              'userProfilePic'=> $value['userProfilePic'],  
                          );
         }
         if(!empty($result)){return $data;}
         else{ return false; }
   }
   public function newsbyid($newsId) 
   {
       $this->db->select('iconnect.tbl_news_category.*,iconnect.tbl_news.*,master_login.tbl_login.imageName as userProfilePic,master_login.tbl_login.userName');
         $this->db->from('iconnect.tbl_news_category');
         $this->db->join('iconnect.tbl_news','iconnect.tbl_news.categoryId=iconnect.tbl_news_category.id','left');
         $this->db->join('master_login.tbl_login','iconnect.tbl_news.token=master_login.tbl_login.token','left');
         $this->db->where('iconnect.tbl_news.id',$newsId);
         $this->db->group_by('iconnect.tbl_news.id'); 
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
                              'userName'=> $value['userName'],
                              'userProfilePic'=> $value['userProfilePic'],  
                          );
         }
          if(!empty($result)){return $data;}  
         else
            return false;
   }
   public function user_profile($usertoken) 
   {
       $this->db->select('b.*,c.*')
            ->select('(select count(iconnect.tbl_news.token) from iconnect.tbl_news where iconnect.tbl_news.token = b.token) as postCount',FALSE)
          ->select('(select count(iconnect.tbl_followers.followersToken) from iconnect.tbl_followers where iconnect.tbl_followers.userToken = b.token) as followersCount',FALSE)
          ->select('(select count(iconnect.tbl_following.followingToken) from iconnect.tbl_following where iconnect.tbl_following.userToken = b.token) as followingCount',FALSE)
          ->from('master_login.tbl_login as b')->from('iconnect.tbl_registration as c')->where('b.token=',$usertoken) ->where('c.token=',$usertoken) -> group_by('b.id');
               $query = $this->db->get();
               //echo $this->db->last_query();exit;
               $result = $query->row_array();
              // if(!empty($result)){echo json_encode($result);}
               if(!empty($result)){
                $data=array(
                              'firstName'=> $result['firstName'],
                              'lastName'=> $result['lastName'],
                              'email'=> $result['email'],
                              'userName'=> $result['userName'],
                              'phoneNumber'=> $result['phoneNumber'],
                              'imageName'=> $result['imageName'],
                              'location'=>$result['location'],
                              'gender'=> $result['gender'],
                              'earnings'=>(float) $result['earnings'],
                              'token'=> $result['token'],
                              'isVerified'=> (bool)$result['isVerified'],
                              'followersCount'=> (int)$result['followersCount'],
                              'followingCount'=>(int) $result['followingCount'],
                              'bankName'=> $result['bankName'],
                              'accountNumber'=> $result['accountNumber'],
                              'ifsc'=> $result['ifsc'],
                              'passbookPath'=> $result['passbookPath'],
                              'aadharName'=> $result['aadharName'],
                              'aadarNumber'=> $result['aadarNumber'],
                              'aadharImagePath1'=> $result['aadharImagePath1'],
                              'aadharImagePath2'=> $result['aadharImagePath2'],
                              'userType'=> $result['userType'],
                              'createdAt'=> date("d-m-Y H:i:s", strtotime($result['created_at'])),
                              'postCount'=> $result['postCount'],
                              'journalistDescription  '=> $result['journalistDescription'],
                              'idImage'=> $result['idImage'],
                          );
               }
            if(!empty($result)){return $data;}  
            else
               return false;
   }
   public function user_post_list($usertoken) 
   {
       $this->db->select('tbl_news_category.*,tbl_news.*');
             $this->db->from('tbl_news_category');
             $this->db->join('tbl_news','tbl_news.categoryId=tbl_news_category.id','left');
             $this->db->where('tbl_news.token',$usertoken);
             $this->db->order_by('tbl_news.id','desc');
             //$this->db->limit($limits);
             $this->db->group_by('tbl_news.id'); 
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
                                  'newstime'=>$result 
                              );
             }
             if(!empty($result)){return $data;}  
            else
               return false;
   }
   public function shared_post_list($userToken)
   {
      $this->db->select('tbl_news_category.*,tbl_news.*,tbl_news.id as newsIds,tbl_shared_news.*');
             $this->db->from('tbl_news_category');
             $this->db->join('tbl_news','tbl_news.categoryId=tbl_news_category.id','left');
             $this->db->join('tbl_shared_news','tbl_news.id=tbl_shared_news.newsId','left');
             $this->db->where('tbl_shared_news.userToken',$userToken);
             $this->db->order_by('tbl_shared_news.created_at','desc');
             //$this->db->limit($limits);
             $this->db->group_by('tbl_news.id'); 
             $query = $this->db->get();
             //echo $this->db->last_query();exit;
             $result = $query->result_array();
             if(!empty($result)){
                foreach($result as $value)
                {
                 $result = $this->Admin_model->newstime($value['addsDate']);
                   $data[]  = array(
                                     'id'=> $value['newsIds'],
                                     'newsCategory'=> $value['newsCategory'],
                                     'categoryId'=> $value['categoryId'],
                                     'imageName'=> $value['imageName'],
                                     'location'=> $value['location'],
                                     'newsTitle'=> $value['newsTitle'],
                                     'newsDetails1'=> $value['newsDetails1'],
                                     'newsDetails2'=> $value['newsDetails2'],
                                      'addsDate'=> date("d-m-Y H:i:s", strtotime($value['addsDate'])),
                                     'token'=> $value['token'],
                                     'newstime'=>$result 
                                 );
                }
                return $data;
             }else
            return false;
   }
   public function liked_post_list($userToken)
   {
      $this->db->select('tbl_news_category.*,tbl_news.*,tbl_news.id as newsIds,tbl_liked_news.*');
             $this->db->from('tbl_news_category');
             $this->db->join('tbl_news','tbl_news.categoryId=tbl_news_category.id','left');
             $this->db->join('tbl_liked_news','tbl_news.id=tbl_liked_news.newsId','left');
             $this->db->where('tbl_liked_news.userToken',$userToken);
             $this->db->order_by('tbl_liked_news.created_at','desc');
             //$this->db->limit($limits);
             $this->db->group_by('tbl_news.id'); 
             $query = $this->db->get();
             //echo $this->db->last_query();exit;
             $result = $query->result_array();
             if(!empty($result)){
                foreach($result as $value)
                {
                 $result = $this->Admin_model->newstime($value['addsDate']);
                   $data[]  = array(
                                     'id'=> $value['newsIds'],
                                     'newsCategory'=> $value['newsCategory'],
                                     'categoryId'=> $value['categoryId'],
                                     'imageName'=> $value['imageName'],
                                     'location'=> $value['location'],
                                     'newsTitle'=> $value['newsTitle'],
                                     'newsDetails1'=> $value['newsDetails1'],
                                     'newsDetails2'=> $value['newsDetails2'],
                                      'addsDate'=> date("d-m-Y H:i:s", strtotime($value['addsDate'])),
                                     'token'=> $value['token'],
                                     'newstime'=>$result 
                                 );
                }
                return $data;
             }else
            return false;
   }
   public function saved_post_list($userToken)
   {
      $this->db->select('tbl_news_category.*,tbl_news.*,tbl_news.id as newsIds,tbl_saved_news.*');
             $this->db->from('tbl_news_category');
             $this->db->join('tbl_news','tbl_news.categoryId=tbl_news_category.id','left');
             $this->db->join('tbl_saved_news','tbl_news.id=tbl_saved_news.newsId','left');
             $this->db->where('tbl_saved_news.token',$userToken);
             $this->db->order_by('tbl_saved_news.created_at','desc');
             //$this->db->limit($limits);
             $this->db->group_by('tbl_news.id'); 
             $query = $this->db->get();
             //echo $this->db->last_query();exit;
             $result = $query->result_array();
             if(!empty($result)){
                foreach($result as $value)
                {
                 $result = $this->Admin_model->newstime($value['addsDate']);
                   $data[]  = array(
                                     'id'=> $value['newsIds'],
                                     'newsCategory'=> $value['newsCategory'],
                                     'categoryId'=> $value['categoryId'],
                                     'imageName'=> $value['imageName'],
                                     'location'=> $value['location'],
                                     'newsTitle'=> $value['newsTitle'],
                                     'newsDetails1'=> $value['newsDetails1'],
                                     'newsDetails2'=> $value['newsDetails2'],
                                      'addsDate'=> date("d-m-Y H:i:s", strtotime($value['addsDate'])),
                                     'token'=> $value['token'],
                                     'newstime'=>$result 
                                 );
                }
                return $data;
             }else
            return false;
   } 
   public function suggestions_list_details($newsId) 
   {
      $pattern = '/[;,[,{,","}]/';
      $myArray= preg_split( $pattern, $newsId);
      //$myArray = explode(',', $newsId);
      foreach($myArray as $key => $value1)
      {
         if(!empty($value1))
         {
           $this->db->select('*');
            $this->db->from('master_login.tbl_login');
           // $this->db->where('iconnect.tbl_news.id',$value1);
            $this->db->where('master_login.tbl_login.phoneNumber',$value1);
            $this->db->group_by('master_login.tbl_login.id'); 
            $query = $this->db->get();
            //echo $this->db->last_query();
            $result = $query->result_array();
            foreach($result as $value)
            {
               $data[]  = array(
                                 'userProfilePic'=> $value['imageName'],
                                 'token'=> $value['token'],
                                 'userName'=> $value['userName']);
            }
         }
         
      }
      if(!empty($data)){return $data;}
      else{ return false; }    
   }

   public function channel_list($usertoken) 
   {
       $this->db->select('b.*,c.*')
            ->select('(select count(iconnect.tbl_news.token) from iconnect.tbl_news where iconnect.tbl_news.token = b.token) as postCount',FALSE)
          ->select('(select count(iconnect.tbl_followers.followersToken) from iconnect.tbl_followers where iconnect.tbl_followers.userToken = b.token) as followersCount',FALSE)
          ->select('(select count(iconnect.tbl_following.followingToken) from iconnect.tbl_following where iconnect.tbl_following.userToken = b.token) as followingCount',FALSE)
          ->from('master_login.tbl_login as b')->from('iconnect.tbl_registration as c')->where('b.token=',$usertoken) ->where('c.token=',$usertoken) -> group_by('b.id');
               $query = $this->db->get();
               //echo $this->db->last_query();exit;
               $result = $query->row_array();
              // if(!empty($result)){echo json_encode($result);}
               if(!empty($result)){
                $data=array(
                              'userName'=> $result['userName'],
                              'imageName'=> $result['imageName'],
                              'token'=> $result['token']
                          );
               }
            if(!empty($result)){return $data;}  
            else
               return false;
   }

   


   

  
}
?>
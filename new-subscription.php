<?php
//error_reporting(E_ALL);
//ini_set('display_errors', '1');
if (isSet($_POST['register'])) {
  // Enter data
  // Create db connection
//print_r($_POST); exit;

$years = explode(",", $_POST['years_subscribed']);
 $years_subscribed = json_encode(array('years_subscribed'=>$years));
 $db = JFactory::getDbo();
 $update_status = updateUserData($_POST['user_name'],$_POST['password'],$_POST['name'],$_POST['company'],$_POST['address'],$_POST['postal'],$_POST['phone'],$_POST['email'],$_POST['user_id'], $_POST['usertype'], $db , $years_subscribed);

 if(!$update_status)
 echo "User AlReady Created";
}
function updateUserData($user_name, $password, $name, $comp_nmae, $comp_address, $postal_address, $phone_no, $email,$user_id, $usertype, $db , $years_subscribed)
{
                 $sql="SELECT `username` FROM `#__users` WHERE `username` = '".$user_name."' ";
                 $db->setQuery($sql);
                 $count = $db->loadResult();
                 if($count)
                 {
                 return false;
                 }
                 else
                 {
                    $object = new stdClass();
                    $object->id = null;
                    $object->name = $name;
                    $object->comp_nmae = $comp_nmae;
                    $object->comp_address = $comp_address;
                    $object->postal_address = $postal_address;
                    $object->phone_no = $phone_no;
                    $object->username = $user_name;
                    $object->email = $email;
                    $object->password = md5($password);                    
                    $object->block = '0';
                    $object->sendEmail = '0';
                    $object->gid = '1';
                    $object->registerDate = '';
                    $object->lastvisitDate = '';
                    $object->activation = '';
                    $object->params = '';        
                    
                    
                    $db->insertObject('#__users',$object);
                    $userid = $db->insertid();
                     if($userid)
                     {
                         $sql1="INSERT INTO `#__user_usergroup_map`(`user_id`, `group_id`) VALUES ('".$userid."',2)";
                         $db->setQuery($sql1);
                         $db->query();
                        
                         $sql="INSERT INTO `#__wk_indices_subscription` (`years_subscribed`, `id`) VALUES('".$years_subscribed."','".$userid."')";
                         $db->setQuery($sql);
                            if( $db->query())
                            echo "Record Added";
                            else
                            echo "Record Not Added";
                        
                        
                        
                         return true;
                     }
                    else
                     return false;
                     }
                    
}
echo "<h3> Registration form</h3>";
echo "<p> <FORM method='post' Action=''> ";
echo "<p>  <input type='text' name='name' placeholder='Name'/>";
echo "<p> <input type='text' name='company' placeholder='Company'/> ";
echo "<p> <input type='text' name='address' placeholder='Company Address'/> ";
echo "<p> <textarea cols=50 rows=4  name='postal' placeholder='Postal Address'></textarea> ";
echo "<p> <input type='text' name='phone' placeholder='Phone Number'/> ";
echo "<p> <input type='text' name='email' placeholder='Email Address'/> ";
echo "<p> <input type='text' name='user_name' placeholder='User Name'/> ";
echo "<p> <input type='text' name='password' placeholder='Password'/> ";
echo "<p> <input type='text' name='years_subscribed' placeholder='Years Subscribed'/> ";
echo "<p> <input type='submit'/> <input type='reset'/> ";
echo "<input type='hidden' value='1' name='register'/>";
echo "<p> </FORM> ";
?>
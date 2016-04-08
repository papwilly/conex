<?php
/**
* @package   CIEIG Database Search
* @copyright Copyright (C) 2011-2014 CIEIG Ltd. All rights reserved.
* @license   GNU/GPL, see LICENSE.php
*/
echo '<script src="//code.jquery.com/jquery-1.10.2.js"></script>';
$user = JFactory::getUser();
if(in_array("8",$user->get('groups')))
{
$db = JFactory::getDbo();
$sql = "SELECT `index_yr` FROM `#__wk_index_hist` WHERE 1";
$db->setQuery($sql);
$years= $db->loadColumn();
 
$sql2 = "SELECT `id` , `name` FROM `#__users` WHERE 1 ORDER BY name";
$db->setQuery($sql2);
$names= $db->loadObjectList();

 $sql3 = "SELECT `id` ,`years_subscribed` FROM `#__wk_indices_subscription` WHERE 1";
$db->setQuery($sql3);
$select_years= $db->loadAssocList();  
 /*   echo "<pre>";
print_r(json_decode($select_years['0']['years_subscribed'])->years_subscribed);
echo "</pre>";
   
 */
 echo '<script type="text/javascript">
function checkField(chackedvalue)
{
$.post("http://constructionexchangegh.com/makeover/ajax.php?validate="+chackedvalue,function(response){
                 $("#Years_Subscribed").html(response);
            })
}
</script>';
 
//echo $result;
 

 
// Create the dropdown for years subscribed
echo "<FORM method='post' action='' >";
echo " Name: <SELECT name='name' onchange='checkField(this.value)'>";
foreach ($names as $name) {
echo "<OPTION value=$name->id> $name->name </OPTION>";
}
echo "</SELECT>";
echo '<p> </p>';
 
//Create dropdown for Months
 
echo "Years Subscribed : <span id='Years_Subscribed'><SELECT  name='Years_Subscribed' >";

   echo "<OPTION value=>Select Name</OPTION>";
 
echo "</SELECT></span>";
echo '<p> </p>';
 

 echo " Update Years Subscribed: <SELECT multiple name='items[]'>";
 foreach($years as $year) {
   echo "<OPTION value='$year'> $year </OPTION>";   
   }
echo "</SELECT>";
 
echo '<p> </p>';
 
echo "<input type='hidden' value='1' name='validator'/>";
 
echo "<input type='submit' value = 'Submit'/ > </FORM>";
 
 
if (isSet($_POST["validator"])) {
//$selectedItems = implode(“,”, $_POST[‘items’]);
//$selectedItems = implode(",", $_POST['items']);
 
//print_r($_POST[‘items’]);
 
//print_r($_POST);
$name = $_POST['name'];
$Years_Subscribe = $_POST['Years_Subscribed'];

$years =  $_POST['items'];
 $years_subscribed = json_encode(array('years_subscribed'=>$years));
 
 $db = JFactory::getDbo();
 if($years)
 {
 $query = "UPDATE `#__wk_indices_subscription` SET `years_subscribed`='".$years_subscribed."' WHERE `id` ='".$name."'";
 }
 else
 {
  $query = "UPDATE `#__wk_indices_subscription` SET `years_subscribed`='".$Years_Subscribe."' WHERE `id` ='".$name."'";
  }

$db->setQuery($query);
if($db->query())
echo "Record Updated";
else
echo "Record Not Updated";


//echo "selected year: ". $selectedYear;
//echo "selected month: ". $selectedMonth;
 
//Query for item index

 
}
}
else
{
header( 'Location: http://constructionexchangegh.com/makeover/index.php?option=com_users&view=login' ) ;
}
 
?>
 
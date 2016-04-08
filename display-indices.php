<?php
/**
* @package   CIEIG Database Search
* @copyright Copyright (C) 2011 CIEIG Ltd. All rights reserved.
* @license   GNU/GPL, see LICENSE.php
*/

//defined("_JEXEC") or die("Restricted access");
//$user =& JFactory::getUser(); //gets user object

if(array_key_exists('_submit_check', $_POST)){

//get the data from the form post
//$work_category = $_POST["filter_catid"];
$work_item = $_POST["filter_wkitem"];
$index_year = $_POST["filter_idxyear"];
$index_month = $_POST["filter_idxmonth"];

/** query database here
*    $db =& JFactory::getDBO();   
*    $query5 = "
*    SELECT ".$db->nameQuote('item_index')."
*    FROM ".$db->nameQuote('#__wk_cost_index')."
*    WHERE ".$db->nameQuote('wk_cat_code')." = ".$db->quote($work_category)." AND ".$db->nameQuote('item_code')." = ".$db->quote($work_item)." AND ".$db->nameQuote('yr_code')." = ".$db->quote($index_year)." AND ".$db->nameQuote('month_code')." = ".$db->quote($index_month).";
* ";
*    $db->setQuery($query5);
*    $result = $db->loadResult();
*/

//query database here
$db =& JFactory::getDBO();   
   $query5 = "
  SELECT ".$db->nameQuote('item_index')."
    FROM ".$db->nameQuote('#__wk_cost_index')."
    WHERE ".$db->nameQuote('item_code')." = ".$db->quote($work_item)." AND ".$db->nameQuote('yr_code')." = ".$db->quote($index_year)." AND ".$db->nameQuote('month_code')." = ".$db->quote($index_month).";
";
$db->setQuery($query5);
$result = $db->loadResult();

//Check to ensure record field has data and display message if data is not present
$message = "The Cost Index for your search criteria is: ";
$nodataMessage = "Sorry, there is no data available for your search criteria.";
$searchagainMessage = '<a href="index.php?option=com_content&view=article&id=69&Itemid=197">SEARCH AGAIN</a>';

if ($result == 0.000) {
echo "<h3>" .$nodataMessage. "</h3>";
echo '<p> </p>';
echo "<h4>" .$searchagainMessage. "</h4>";
}
else {
echo "<h3>" . $message . $result ."</h3>";
echo '<p> </p>';
echo '<p> </p>';
echo "<h4>" .$searchagainMessage. "</h4>";
}


}


?>

<?php
/**
* @package   CIEIG Database Search
* @copyright Copyright (C) 2011-2014 CIEIG Ltd. All rights reserved.
* @license   GNU/GPL, see LICENSE.php
*/
 
// Get the user id;
$user =& JFactory::getUser();
$userId = $user->id;
//echo $userId;
 
// Get a DB connection
$db = JFactory::getDbo();
 
// Create a Subscribed Years query object.
$subscribedYearsQuery = $db->getQuery(true);
 
// Retrieve all the years that this user has signed up for:
//$subscribedYearsQuery = 'SELECT years_subscribed FROM #__wk_indices_subscription WHERE user_id = $userId';
 
$subscribedYearsQuery->select($db->quoteName('years_subscribed'));
$subscribedYearsQuery->from($db->quoteName('#__wk_indices_subscription'));
$subscribedYearsQuery->where($db->quoteName('id')." = ".$userId);
 
$db->setQuery($subscribedYearsQuery);
 
$result = $db->loadResult();
 
//echo $result;
 
$yearsSubscribed = json_decode($result,true);
//echo $yearsSubscribed;
 
// Create an array from the results
 
$years = $yearsSubscribed["years_subscribed"];
//echo $years;
 
// Create the dropdown for years subscribed
echo "<FORM method='post' action='' >";
 
echo " Select Index Year: <SELECT multiple name='year[]'>";
foreach ($years as $year) {
echo "<OPTION value=$year> $year </OPTION>";
}
echo "</SELECT>";
echo '<p> </p>';
 
//Create dropdown for Months
 
echo "Select a Month: <SELECT multiple name='month[]' >";
$months = array("January","February","March","April","May","June","July","August","September","October","November","December");
 
foreach($months as $month) {
   echo "<OPTION value='&quot;$month&quot;'>$month</OPTION>";
   }
echo "</SELECT>";
echo '<p> </p>';
 
// Create a Work Items query object.
$workItemsQuery = $db->getQuery(true);
 
// Retrieve all available work items
 
/*
$workItemsQuery->select($db->quoteName('item_description'));
$workItemsQuery->from($db->quoteName('#__wk_item'));
$workItemsQuery->order('item_code');
 
$db->setQuery($workItemsQuery);
 
$items = $db->loadColumn();
 
//echo $items;
*/
 
$workItemsQuery->select($db->quoteName(array('item_code','item_description')));
 
$workItemsQuery->from($db->quoteName('#__wk_item'));
$workItemsQuery->order('item_code');
 
$db->setQuery($workItemsQuery);
 
$items = $db->loadAssocList();
 
//print_r ($items);
 
// Create the dropdown for Work Items
 
 
echo " Select a Construction Work Item: <SELECT multiple name='items[]'>";
 
 
foreach ($items as $item) {
   $item_code = $item['item_code'];
   $item_description = $item['item_description'];
   echo "<OPTION value='&quot;$item_code&quot;'> $item_description </OPTION>";
   }
echo "</SELECT>";
 
echo '<p> </p>';
 
echo "<input type='hidden' value='1' name='validator'/>";
 
echo "<input type='submit' value = 'Search'/ > </FORM>";
 
 
if (isSet($_POST["validator"])) {
//$selectedItems = implode(“,”, $_POST[‘items’]);
//$selectedItems = implode(",", $_POST['items']);
 
//print_r($_POST[‘items’]);
 
//print_r($_POST);
$selectedYear = implode(",", $_POST['year']);
$selectedMonth = implode(",", $_POST['month']);
$selectedItems = implode(",", $_POST['items']);
//echo "selected year: ". $selectedYear;
//echo "selected month: ". $selectedMonth;
 
//Query for item index
$itemIndexQuery = $db->getQuery(true);
 
if(($selectedYear!="")&&($selectedMonth!="")&&($selectedItems!=""))
{
 
$itemIndexQuery ="SELECT B.year, B.month, A.item_description, B.item_index FROM bnk82_wk_cost_index AS B, bnk82_wk_item AS A  WHERE A.`item_code` = B.`item_code`  AND  B.`item_code` IN ( $selectedItems ) AND B.`year` IN ( $selectedYear ) AND B.`month` IN ( $selectedMonth ) ";
 
}
else if(($selectedYear!="")&&($selectedMonth!=""))
{
$itemIndexQuery ="SELECT B.year, B.month, A.item_description, B.item_index FROM bnk82_wk_cost_index AS B, bnk82_wk_item AS A  WHERE A.`item_code` = B.`item_code`  AND B.`year` IN ( $selectedYear ) AND B.`month` IN ( $selectedMonth ) ";
}
else if(($selectedYear!="")&&($selectedItems!=""))
{
$itemIndexQuery ="SELECT B.year, B.month, A.item_description, B.item_index FROM bnk82_wk_cost_index AS B, bnk82_wk_item AS A  WHERE A.`item_code` = B.`item_code`  AND  B.`item_code` IN ( $selectedItems ) AND B.`year` IN ( $selectedYear )  ";
}
else if(($selectedMonth!="")&&($selectedItems!=""))
{
$itemIndexQuery ="SELECT B.year, B.month, A.item_description, B.item_index FROM bnk82_wk_cost_index AS B, bnk82_wk_item AS A  WHERE A.`item_code` = B.`item_code`  AND  B.`item_code` IN ( $selectedItems ) AND B.`month` IN ( $selectedMonth ) ";
}
 
else if(($selectedYear!=""))
{
$itemIndexQuery ="SELECT B.year, B.month, A.item_description, B.item_index FROM bnk82_wk_cost_index AS B, bnk82_wk_item AS A  WHERE A.`item_code` = B.`item_code`  AND B.`year` IN ( $selectedYear )  ";
 
}
 
else if(($selectedMonth!=""))
{
$itemIndexQuery ="SELECT B.year, B.month, A.item_description, B.item_index FROM bnk82_wk_cost_index AS B, bnk82_wk_item AS A  WHERE A.`item_code` = B.`item_code`  AND B.`month` IN ( $selectedMonth ) ";
 
}
 
else if(($selectedItems!=""))
{
 
$itemIndexQuery ="SELECT B.year, B.month, A.item_description, B.item_index FROM bnk82_wk_cost_index AS B, bnk82_wk_item AS A  WHERE A.`item_code` = B.`item_code`  AND  B.`item_code` IN ( $selectedItems ) ";
}
else
{
 
}
 
 
$db->setQuery($itemIndexQuery);
 
$itemIndexQueryResult = $db->loadAssocList();
//echo $itemIndexQueryResult;
 
 
// Display search results in a table
echo '<p> </p>';
echo '<p> </p>';
echo '<p> </p>';
echo "SEARCH RESULTS";
echo "<table border=1>";
 
echo "<tr><th>Year</th><th>Month</th><th>Item Description</th><th>Cost Index</th></tr>";
 
$len =  count($itemIndexQueryResult);
 
for($i = 0; $i < $len; $i++) {
 
$row = $itemIndexQueryResult[$i];
 
 echo "<tr><td>" . $row["year"]. "</td>";
 
 echo "<td>" . $row["month"] . "</td>";
 
 echo "<td>" . $row["item_description"] . "</td>";
 
 echo "<td>" . $row["item_index"] . "</td></tr>";
 
}
 
echo "</table>";
 
}
 
?>
 
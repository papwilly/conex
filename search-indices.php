<?php
/**
* @package   CIEIG Database Search
* @copyright Copyright (C) 2011 CIEIG Ltd. All rights reserved.
* @license   GNU/GPL, see LICENSE.php
*/

//defined("_JEXEC") or die("Restricted access");
//$user =& JFactory::getUser(); //gets user object



echo "<form name='adminForm' action='index.php?option=com_content&view=article&id=70' method='post'>";

/** CREATE AND POPULATE WORK CATEGORY DROPDOWN
*   $lists = array(); 
*   $db =& JFactory::getDBO();    
*   $query = 'SELECT  wk_cat_code AS id_value, wk_category AS text  FROM  #__wk_category ORDER BY wk_cat_code'; 
*   $db->setQuery($query); 
*   $results[] = JHTML::_('select.option', '', JText::_( ' ' ), 'id_value', 'text' ); 
*   $results=array_merge($results, $db->loadObjectList()) ; 
*
*
*   $lists['catid'] = JHTML::_('select.genericList', $results, 'filter_catid', 'class="inputbox" size="1"','id_value','text',null); 
*
*   echo 'Select a Work Category: ', $lists['catid']; 
*
**   echo '<p> </p>';

*/


//CREATE AND POPULATE WORK ITEM DROP DOWN BOX
$db =& JFactory::getDBO();    
$query2 = 'SELECT  item_code AS id_value2, item_description AS text2  FROM  #__wk_item ORDER BY item_code'; 
$db->setQuery($query2); 
$results2[] = JHTML::_('select.option', '', JText::_( ' ' ), 'id_value2', 'text2' ); 
$results2=array_merge($results2, $db->loadObjectList()) ; 


$lists['catid'] = JHTML::_('select.genericList', $results2, 'filter_wkitem', 
'class="inputbox" size="1"','id_value2','text2',null); 

echo 'Select a Work Item: ', $lists['catid']; 
echo '<p> </p>';


//CREATE AND POPULATE WORK INDEX YEAR DROP DOWN BOX
$db =& JFactory::getDBO();    
$query3 = 'SELECT  yr_code AS id_value3, index_yr AS text3  FROM  #__wk_index_hist ORDER BY index_yr';  
$db->setQuery($query3); 
$results3[] = JHTML::_('select.option', '', JText::_( ' ' ), 'id_value3', 'text3' ); 
$results3=array_merge($results3, $db->loadObjectList()) ; 


$lists['catid'] = JHTML::_('select.genericList', $results3, 'filter_idxyear', 
'class="inputbox" size="1"','id_value3','text3',null); 

echo 'Select an Index Year: ', $lists['catid']; 
echo '<p> </p>';

//CREATE AND POPULATE WORK INDEX MONTH DROP DOWN BOX
$db =& JFactory::getDBO();    
$query4 = 'SELECT  month_code AS id_value4, index_month AS text4  FROM  #__wk_month';  
$db->setQuery($query4); 
$results4[] = JHTML::_('select.option', '', JText::_( ' ' ), 'id_value4', 'text4' ); 
$results4=array_merge($results4, $db->loadObjectList()) ; 


$lists['catid'] = JHTML::_('select.genericList', $results4, 'filter_idxmonth', 
'class="inputbox" size="1"','id_value4','text4',null); 

echo 'Select an Index Month: ', $lists['catid']; 

//submit button
echo '<input type="hidden" value="1" name="_submit_check" />';
echo '<p> </p>';
echo '<input type="submit" value="Search" />';
echo '</form>';

?>
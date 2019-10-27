<?php
/*
* ============================================================================
*
* @name ExcelXMLWorkbook.php
*
* @author andrew.aculana
* @version 2.0
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
* @date 2006-07-03
*
* ============================================================================
*
* License:	GNU Lesser General Public License (LGPL)
*
* Copyright (c) 2004 LINK2SUPPORT INC.  All rights reserved.
*
* This file is part of the L2S Online Application Framework
*
* This library is free software; you can redistribute it and/or
* modify it under the terms of the GNU Lesser General Public
* License as published by the Free Software Foundation; either
* version 2.1 of the License, or (at your option) any later version.

* This library is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
* Lesser General Public License for more details.

* You should have received a copy of the GNU Lesser General Public
* License along with this library; if not, write to the Free Software
* Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*
* ============================================================================
*/

/**
 * @package ExcelXMLParser
 * @subpackage ExcelXMLParser
 */
 
include_once 'ExcelXMLArrayIterator.php';
include_once 'ExcelXMLWorksheet.php';
include_once 'ExcelXMLDocumentProperties.php';
	 
class ExcelXMLWorkbook{
	
	/**
	 * Excel XML Workbook Attributes
	 * @var Associative Array $Worksheet
	 * @var Worksheet $Worksheet
	 * @var Document $Document
	 * @var Iterator $Iterator
	 * @var Associative Array &Data
	 * @var Integer $WorksheetIndex
	 * @var String $Encoding
	 */
	var $Worksheet;
	var $Document;
	var $Iterator;
	var $Data;
	var $WorksheetIndex;
	var $Encoding;
	
#-----------------------------------------------------------------------------#

	/**
	 * class constructor - initialize attributes
	 * 
	 * @author Andrew A. Aculana
	 * @version 2.0
	 * @copyright 2006-07-03
	 * @return null
	 */
	function ExcelXMLWorkbook(&$Data,&$Encoding){
		/* handle to worksheet array */
		$this->Worksheet =& $Data['Workbook'][0]['children']['Worksheet'];
		/* handle to Document object */
		$this->Document	 = new ExcelXMLDocumentProperties($Data);
		/* handle to Iterator object */
		$this->Iterator  = new ExcelXMLArrayIterator($this->Worksheet);
		$this->Data		 =& $Data;
		$this->Encoding  =& $Encoding;
	}
#-----------------------------------------------------------------------------#

	/**
	 * get worksheet count
	 * 
	 * @author Andrew A. Aculana
	 * @version 2.0
	 * @copyright 2006-07-03
	 * @return int
	 */
	function getWorksheetCount(){
		
		return $this->Iterator->length();
	}
#-----------------------------------------------------------------------------#

	/**
	 * get the active worksheet
	 * 
	 * @author Andrew A. Aculana
	 * @version 2.0
	 * @copyright 2006-07-03
	 * @return long - pointer to a worksheet
	 */
	function &getActiveWorksheet(){
		$active =& $this->Iterator->current();
		if($active){
			$Worksheet = new ExcelXMLWorksheet($active,$this->Encoding);
			return $Worksheet;
		}else{
			return NULL;
		}
	}
#-----------------------------------------------------------------------------#

	/**
	 * get next worksheet
	 * 
	 * @author Andrew A. Aculana
	 * @version 2.0
	 * @copyright 2006-07-03
	 * @return long - pointer to the next worksheet
	 */
	function &getNextWorksheet(){
		$next =& $this->Iterator->next();
		if($next){
			$Worksheet = new ExcelXMLWorksheet($next,$this->Encoding);
			return $Worksheet;
		}else{
			return NULL;
		}
	}
#-----------------------------------------------------------------------------#

	/**
	 * get first worksheet
	 * 
	 * @author Andrew A. Aculana
	 * @version 2.0
	 * @copyright 2006-07-03
	 * @return long - pointer to the first worksheet
	 */
	function &getFirstWorksheet(){
		$top =& $this->Iterator->top();
		if($top){
			$Worksheet = new ExcelXMLWorksheet($top,$this->Encoding);
			return $Worksheet;
		}else{
			return NULL;
		}
	}
#-----------------------------------------------------------------------------#

	/**
	 * get last worksheet
	 * 
	 * @author Andrew A. Aculana
	 * @version 2.0
	 * @copyright 2006-07-03
	 * @return long - pointer to the last worksheet
	 */	
	function &getLastWorksheet(){
		$bottom =& $this->Iterator->bottom();
		if($bottom){
			$Worksheet = new ExcelXMLWorksheet($bottom,$this->Encoding);
			return $Worksheet;
		}else{
			return NULL;
		}
	}
#-----------------------------------------------------------------------------#

	/**
	 * get worksheet by worksheet name
	 * 
	 * @author Andrew A. Aculana
	 * @version 2.0
	 * @copyright 2006-07-03
	 * @param String $WorksheetName
	 * @return long - pointer to a worksheet
	 */
	function &getWorksheetByName($WorksheetName = ""){
		foreach($this->Worksheet as $key => $val){
			$value =& $this->Worksheet[$key];
			$WName = "";
			if(isset($val['attrs']['ss:Name'])){
				$WName = $val['attrs']['ss:Name'];
			}elseif($val['attrs']['Name']){
				$WName = $val['attrs']['Name'];
			}
			if(trim($WName) == trim($WorksheetName)){
				$Worksheet = new ExcelXMLWorksheet($value,$this->Encoding);
				return $Worksheet;
			}
		}
		return NULL;
	}
#-----------------------------------------------------------------------------#

	/**
	 * set active worksheet
	 * 
	 * @author Andrew A. Aculana
	 * @version 2.0
	 * @copyright 2006-07-03
	 * @param Integer $WorksheetIndex
	 * @return NULL
	 */
	function setActiveSheet($WorksheetIndex = 0){
		if(isset($this->Data['Workbook'][0]['children']['ExcelWorkbook'][0]['children']['ActiveSheet'][0]['values'][0])){
			$this->Data['Workbook'][0]['children']['ExcelWorkbook'][0]['children']['ActiveSheet'][0]['values'][0] = $WorksheetIndex;
		}
	}
#-----------------------------------------------------------------------------#

	/**
	 * get active worksheet
	 * 
	 * @author Andrew A. Aculana
	 * @version 2.0
	 * @copyright 2006-07-03
	 * @return Integer
	 */
	function getActiveSheet(){
		if(isset($this->Data['Workbook'][0]['children']['ExcelWorkbook'][0]['children']['ActiveSheet'][0]['values'][0])){
			return $this->Data['Workbook'][0]['children']['ExcelWorkbook'][0]['children']['ActiveSheet'][0]['values'][0];
		}
		return NULL;
	}
#-----------------------------------------------------------------------------#

	/**
	 * set first visible worksheet
	 * 
	 * @author Andrew A. Aculana
	 * @version 2.0
	 * @copyright 2006-07-03
	 * @param Integer $WorksheetIndex
	 * @return NULL
	 */
	function setFirstVisibleSheet($WorksheetIndex = 0){
		if(isset($this->Data['Workbook'][0]['children']['ExcelWorkbook'][0]['children']['FirstVisibleSheet'][0]['values'][0])){
			$this->Data['Workbook'][0]['children']['ExcelWorkbook'][0]['children']['FirstVisibleSheet'][0]['values'][0] = $WorksheetIndex;
		}
	}
#-----------------------------------------------------------------------------#

	/**
	 * get first visible worksheet
	 * 
	 * @author Andrew A. Aculana
	 * @version 2.0
	 * @copyright 2006-07-03
	 * @return Integer
	 */
	function getFirstVisibleSheet(){
		if(isset($this->Data['Workbook'][0]['children']['ExcelWorkbook'][0]['children']['FirstVisibleSheet'][0]['values'][0])){
			return $this->Data['Workbook'][0]['children']['ExcelWorkbook'][0]['children']['FirstVisibleSheet'][0]['values'][0];
		}
		return NULL;
	}
#-----------------------------------------------------------------------------#
}
?>
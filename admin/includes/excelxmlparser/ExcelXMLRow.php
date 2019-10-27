<?php
/*
* ============================================================================
*
* @name ExcelXMLRow.php
*
* @author Andrew A. Aculana
* @version 2.0
* @license		http://opensource.org/licenses/gpl-license.php GNU Public License
* @date 2006-05-22
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
 
include_once 'ExcelXMLCell.php';

class ExcelXMLRow{
	
	/**
	 * Excel XML Row Attributes
	 * @var Associative Array $Cells
	 * @var Iterator $Iterator
	 */	
	var $Cells;
	var $Iterator;
	var $Encoding;
#-----------------------------------------------------------------------------#
	/**
	 * class constructor - initialize attributes
	 * 
	 * @author Andrew A. Aculana
	 * @access Public
	 * @version 2.0
	 * @copyright 2006-05-22
	 * @return null
	 */
	function ExcelXMLRow(&$Data,&$Encoding){
 		if(!isset($Data['children']['Cell'])){
 			$Data['children']['Cell'] = array();
 		}
		$this->Cells    =& $Data['children']['Cell'];
		$this->Iterator = new ExcelXMLArrayIterator($this->Cells);
		$this->Encoding =& $Encoding;
	}
#-----------------------------------------------------------------------------#
	/**
	 * get the cell count
	 * 
	 * @author Andrew A. Aculana
	 * @access Public
	 * @version 2.0
	 * @copyright 2006-05-22
	 * @return int
	 */
	function getCellCount(){
		
		return $this->Iterator->length();
	}
#-----------------------------------------------------------------------------#
	/**
	 * get the active cell
	 * 
	 * @author Andrew A. Aculana
	 * @access Public
	 * @version 2.0
	 * @copyright 2006-05-22
	 * @return long - pointer to an object
	 */
	function &getActiveCell(){
		$active =& $this->Iterator->current();
		if($active){
			$Cell = new ExcelXMLCell($active,$this->Encoding);
			return $Cell;
		}else{
			return NULL;
		}
	}
#-----------------------------------------------------------------------------#
	/**
	 * get the next cell
	 * 
	 * @author Andrew A. Aculana
	 * @access Public
	 * @version 2.0
	 * @copyright 2006-05-22
	 * @return long - pointer to an object
	 */
	function &getNextCell(){
		$next =& $this->Iterator->next();
		if($next){
			$Cell = new ExcelXMLCell($next,$this->Encoding);
			return $Cell;
		}else{
			return NULL;
		}
	}
#-----------------------------------------------------------------------------#
	/**
	 * get the first cell
	 * 
	 * @author Andrew A. Aculana
	 * @access Public
	 * @version 2.0
	 * @copyright 2006-05-22
	 * @return long - pointer to an object
	 */
	function &getFirstCell(){
		$top =& $this->Iterator->top();
		if($top){
			$Cell = new ExcelXMLCell($top,$this->Encoding);
			return $Cell;
		}else{
			return NULL;
		}
	}
#-----------------------------------------------------------------------------#
	/**
	 * get the last cell
	 * 
	 * @author Andrew A. Aculana
	 * @access Public
	 * @version 2.0
	 * @copyright 2006-05-22
	 * @return long - pointer to an object
	 */
	function &getLastCell(){
		$bottom =& $this->Iterator->bottom();
		if($bottom){
			$Cell = new ExcelXMLCell($bottom,$this->Encoding);
			return $Cell;
		}else{
			return NULL;
		}
	}
#-----------------------------------------------------------------------------#
	/**
	 * get the cell by cell index
	 * 
	 * @author Andrew A. Aculana
	 * @access Public
	 * @version 2.0
	 * @copyright 2006-05-22
	 * @param int $ColumnIndex
	 * @return long - pointer to an object
	 */
	function &getCell($ColumnIndex = 0){
		$current =& $this->Iterator->current();
		if($current){
			$Cell = new ExcelXMLCell($current,$this->Encoding);
			return $Cell;
		}else{
			return NULL;
		}
	}
#-----------------------------------------------------------------------------#
}
?>
<?php
/*
* ============================================================================
*
* @name ExcelXMLTable.php
*
* @author andrew.aculana
* @version 2.0
* @license	http://opensource.org/licenses/gpl-license.php GNU Public License
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
 
include_once 'ExcelXMLRow.php';
include_once 'ExcelXMLCell.php';

class ExcelXMLTable{
	
	/**
	 * Excel XML Table Attributes
	 * @var Associative Array $Rows
	 * @var Iterator $Iterator
	 */
	var $Rows;
	var $Iterator;
	var $Encoding;
#-----------------------------------------------------------------------------#

	/**
	 * class constructor - initialize attributes
	 * 
	 * @author Andrew A. Aculana
	 * @access Public
	 * @version 2.0
	 * @copyright 2006-07-03
	 * @return null
	 */	
	function ExcelXMLTable(&$Data,$Encoding){
		$this->Rows		 =& $Data[0]['children']['Row'];
		$this->Iterator  = new ExcelXMLArrayIterator($this->Rows);
		$this->Encoding  =& $Encoding;
	}
#-----------------------------------------------------------------------------#

	/**
	 * get the row count
	 * 
	 * @author Andrew A. Aculana
	 * @access Public
	 * @version 2.0
	 * @copyright 2006-07-03
	 * @return int
	 */	
	function getRowCount(){
		
		return $this->Iterator->length();
	}
#-----------------------------------------------------------------------------#

	/**
	 * get the active row
	 * 
	 * @author Andrew A. Aculana
	 * @access Public
	 * @version 2.0
	 * @copyright 2006-07-03
	 * @return long - pointer to the active row
	 */
	function &getActiveRow(){
		$active =& $this->Iterator->current();
		if($active){
			$Row = new ExcelXMLRow($active,$Encoding);
			return $Row;
		}else{
			return NULL;
		}
	}
#-----------------------------------------------------------------------------#

	/**
	 * get the next row
	 * 
	 * @author Andrew A. Aculana
	 * @access Public
	 * @version 2.0
	 * @copyright 2006-07-03
	 * @return long - pointer to the next row
	 */
	function &getNextRow(){
		$next =& $this->Iterator->next();
		if($next){
			$Row = new ExcelXMLRow($next,$Encoding);
			return $Row;
		}else{
			return NULL;
		}
	}
#-----------------------------------------------------------------------------#

	/**
	 * get the first row
	 * 
	 * @author Andrew A. Aculana
	 * @access Public
	 * @version 2.0
	 * @copyright 2006-07-03
	 * @return long - pointer to the first row
	 */
	function &getFirstRow(){
		$top =& $this->Iterator->top();
		if($top){
			$Row = new ExcelXMLRow($top,$Encoding);
			return $Row;
		}else{
			return NULL;
		}
	}
#-----------------------------------------------------------------------------#

	/**
	 * get the last row
	 * 
	 * @author Andrew A. Aculana
	 * @access Public
	 * @version 2.0
	 * @copyright 2006-07-03
	 * @return long - pointer to the next row
	 */
	function &getLastRow(){
		
		$bottom =& $this->Iterator->bottom();
		if($bottom){
			$Row = new ExcelXMLRow($bottom,$Encoding);
			return $Row;
		}else{
			return NULL;
		}
	}
#-----------------------------------------------------------------------------#

	/**
	 * get row
	 * 
	 * @author Andrew A. Aculana
	 * @access Public
	 * @version 2.0
	 * @copyright 2006-07-03
	 * @param int $RowIndex
	 * @return long - pointer to the next row
	 */
	function &getRow($RowIndex = 0){
		
		return $this->Rows[$RowIndex];
	}
#-----------------------------------------------------------------------------#

	/**
	 * get the cell by row col
	 * 
	 * @author Andrew A. Aculana
	 * @access Public
	 * @version 2.0
	 * @copyright 2006-07-03
	 * @param int $RowIndex
	 * @param int $ColIndex
	 * @return long - pointer to cell
	 */
	function &getCellByRowCol($RowIndex = 1,$ColIndex = 1){
		$celladdress = Utils::RowColToCell($RowIndex-1,$ColIndex-1);
		$rowcolcell =& $this->Rows[--$RowIndex]['children']['Cell'];
 		foreach($rowcolcell as $key => $val){
	 		$celldata =& $rowcolcell[$key];
	 		$Cell =new ExcelXMLCell($celldata,$Encoding);
 			if(trim($celladdress) == trim($Cell->getCellAddress())){
 				return $Cell;
			}
 		}
 		return NULL;
	}
#-----------------------------------------------------------------------------#

	/**
	 * get the cell by Cell Address Notation
	 * 
	 * @author Andrew A. Aculana
	 * @access Public
	 * @version 2.0
	 * @copyright 2006-07-03
	 * @param String $Address - cell address notation ("eg. A1B1")
	 * @return long - pointer to cell
	 */
	function &getCellByAddress($Address = ""){
		preg_match("/([A-Za-z]*)?([0-9]*)/i",$Address,$RowCol);
		$Row 		= (int)$RowCol[2];
		$Col 		= $RowCol[1];
		$offset1 =0;
		if(strlen($Col) == 2){
			
			$offset1 = ord($Col[1])-65;
			$offset2  = (((ord($Col[0])-65)+1)*26)+$offset1;
		}else{
			$offset2  = ord($Col[0])-65;
		}
		return $this->getCellByRowCol($Row,$offset2+1);
	}
#-----------------------------------------------------------------------------#
}
?>
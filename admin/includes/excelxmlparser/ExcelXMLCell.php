<?php
/*
* ============================================================================
*
* @name ExcelXMLCell.php
*
* @author Andrew A. Aculana
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
 
class ExcelXMLCell{
	
	/**
	 * Excel XML Cell Attributes
	 * @var String $data
	 */
	 
	var $data;
	var $value;
	var $celladdress;
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
	function ExcelXMLCell(&$Data,&$Encoding){
		$this->data =& $Data;
		$this->Encoding =& $Encoding;
	}
#-----------------------------------------------------------------------------#

	/**
	 * set the cell value
	 * 
	 * @author Andrew A. Aculana
	 * @access Public
	 * @version 2.0
	 * @copyright 2006-07-03
	 * @param int $Column
	 * @return null
	 */
	function setValue($value = ""){
		if(isset($this->data['children']['Data'][0]['values'][0])){
			if(isset($this->data['children']['Data'][0]['attrs']['ss:Type'])){
				$ExistingType = $this->data['children']['Data'][0]['attrs']['ss:Type'];
			}elseif(isset($this->data['children']['Data'][0]['attrs']['ss:Type'])){
				$ExistingType = $this->data['children']['Data'][0]['attrs']['Type'];
			}
			switch($ExistingType){
				case 'String':
					break;
				case 'Number':
					if(!is_numeric($value)){
						ExcelXMLError::raiseError("Invalid Value for Cell ".$this->getCellAddress()." of type ".$ExistingType,E_USER_WARNING);
					}
					break;
				case 'Boolean':
					if(!is_int($value)){
						ExcelXMLError::raiseError("Invalid Value for Cell ".$this->getCellAddress()." of type ".$ExistingType,E_USER_WARNING);
					}
					break;
				case 'DateTime':
					/* date */
					if(preg_match("/-/i", $value)){
						$Date = date('Y-m-d',strtotime($value));
						$value = $Date."T00:00:00.000";
					/* time */
					}elseif(preg_match("/:/i", $value)){
						$value = "1900-01-01T".date('H:i:s.000',strtotime($value));
					}else{
						/* invalid cell value for datetime */
						ExcelXMLError::raiseError("Invalid Value for Cell ".$this->getCellAddress()." of type ".$ExistingType,E_USER_WARNING);
					}
					break;
			}
			$this->data['children']['Data'][0]['values'][0] = $value;
		}else{
			/* unknown cell or cell does not exist */
			ExcelXMLError::raiseError("Error: Cell ".$this->getCellAddress()." does not exist",E_USER_WARNING);
		}
		$this->value =& $value;
	}
#-----------------------------------------------------------------------------#

	/**
	 * get the current cell value
	 * 
	 * @author Andrew A. Aculana
	 * @access Public
	 * @version 2.0
	 * @copyright 2006-07-03
	 * @return int
	 */
	function &getValue(){
		if(isset($this->data['children']['Data'][0]['values'][0])){
			$this->value =& $this->data['children']['Data'][0]['values'][0];
		}else{
			/* unknown cell format */
			return "";
		}
		return $this->value;
	}
#-----------------------------------------------------------------------------#

	/**
	 * get the current cell address
	 * 
	 * @author Andrew A. Aculana
	 * @access Public
	 * @version 2.0
	 * @copyright 2006-07-03
	 * @return int
	 */
	function getCellAddress(){
		if(isset($this->data['CellAddress']['A1'])){
			$this->celladdress = $this->data['CellAddress']['A1'];
		}else{
			ExcelXMLError::raiseError("Error: Cell ".$this->getCellAddress()." does not exist",E_USER_WARNING);
		}
		return $this->celladdress;
	}
}
?>
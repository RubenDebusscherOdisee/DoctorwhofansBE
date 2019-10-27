<?php
/*
* ============================================================================
*
* @name ExcelXMLWorksheet.php
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
 	
include_once 'ExcelXMLTable.php';

class ExcelXMLWorksheet{
	
	/**
	 * Excel XML Worksheet Attributes
	 * @var String $Name
	 * @var Table $Table
	 * @var Associative Array $data
	 * @var Integer $Encoding
	 */
	var $Name;
	var $Table;
	var $data;
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
	function ExcelXMLWorksheet(&$Data,$Encoding){
		$this->Table		  = new ExcelXMLTable($Data['children']['Table'],$Encoding);
		$this->Name      	  = "";
		$this->data			  =& $Data;
		$this->Encoding		  =& $Encoding;
	}
#-----------------------------------------------------------------------------#

	/**
	 * set the worksheet name
	 * 
	 * @author Andrew A. Aculana
	 * @version 2.0
	 * @copyright 2006-07-03
	 * @param String $Name
	 * @return null
	 */
	function setName($Name = ""){
		if(isset($this->data['attrs']['ss:Name'])){
			$this->data['attrs']['ss:Name'] = $Name;
		}elseif(isset($this->data['attrs']['Name'])){
			$this->data['attrs']['Name'] = $Name;
		}else{
			/* unknown worksheet format */
		}
		$this->Name = $Name;
	}
#-----------------------------------------------------------------------------#

	/**
	 * get worksheet name
	 * 
	 * @author Andrew A. Aculana
	 * @version 2.0
	 * @copyright 2006-07-03
	 * @return String
	 */
	function getName(){
		if(isset($this->data['attrs']['ss:Name'])){
			return $this->data['attrs']['ss:Name'];
		}elseif(isset($this->data['attrs']['Name'])){
			return $this->data['attrs']['Name'];
		}else{
			/* unknown worksheet format */
			return "";
		}
		return $this->Name;
	}
#-----------------------------------------------------------------------------#
}
?>
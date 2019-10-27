<?php
/*
* ============================================================================
*
* @name ExcelXMLDocumentProperties.php
*
* @author Andrew A. Aculana
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

class ExcelXMLDocumentProperties{
	
	/**
	 * Excel XML Document Properties Attributes
	 * @var Associative Array $DocumentProperties
	 * @var Iterator $Iterator
	 */
	var $Data;
#-----------------------------------------------------------------------------#

	/**
	 * class constructor
	 * 
	 * @author Andrew A. Aculana
	 * @access Public
	 * @version 2.0
	 * @copyright 2006-07-03
	 * @return null
	 */	
	function ExcelXMLDocumentProperties(&$Data){
		$this->Data =& $Data;
	}
#-----------------------------------------------------------------------------#
	/**
	 * set the property
	 * 
	 * @author Andrew A. Aculana
	 * @access Public
	 * @version 2.0
	 * @copyright 2006-07-03
	 * @param String $PropertyName
	 * @param String $Value
	 * @return NULL
	 */
	function &setProperty($PropertyName = "",$Value){
		$this->Data["Workbook"][0]["children"]["DocumentProperties"][0]['children'][$PropertyName][0]['values'][0] = $Value;
	}
#-----------------------------------------------------------------------------#

	/**
	 * get the property
	 * 
	 * @author Andrew A. Aculana
	 * @access Public
	 * @version 2.0
	 * @copyright 2006-07-03
	 * @return long - pointer to an object
	 */
	function &getProperty($PropertyName = ""){
		return $this->Data["Workbook"][0]["children"]["DocumentProperties"][0]['children'][$PropertyName][0]['values'][0];
	}
#-----------------------------------------------------------------------------#
}
?>
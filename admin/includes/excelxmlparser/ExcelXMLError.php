<?php
/*
* ============================================================================
*
* @name ExcelXMLError.php
*
* @author Andrew A. Aculana
* @version 2.0
* @license		http://opensource.org/licenses/gpl-license.php GNU Public License
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
 
class ExcelXMLError{
	
	/**
	 * Excel XML Error Attributes
	 * @var String $ErrorMessage
	 */	
	var $ErrorMessage;
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
	function ExcelXMLError(){
		$this->ErrorMessage    = "";
		
	}
#-----------------------------------------------------------------------------#

	/**
	 * set the error
	 * 
	 * @author Andrew A. Aculana
	 * @access Public
	 * @version 2.0
	 * @copyright 2006-07-03
	 * @param String $Error
	 * @return null
	 */
	function setErrorMessage($Error = ""){
		$this->ErrorMessage = $Error;
	}
#-----------------------------------------------------------------------------#

	/**
	 * get the last error message
	 * 
	 * @author Andrew A. Aculana
	 * @access Public
	 * @version 2.0
	 * @copyright 2006-07-03
	 * @return String
	 */
	function getErrorMessage(){
		return $this->ErrorMessage;
	}
#-----------------------------------------------------------------------------#
	/**
	 * check if an error type
	 * 
	 * @author Andrew A. Aculana
	 * @access Public
	 * @version 2.0
	 * @copyright 2006-07-03
	 * @param Object $class
	 * @return Bool
	 */
	function isError($class){
 		if(strtoupper(trim(get_class($class))) == 'EXCELXMLERROR')
	    {
		    return true;
	    }else{
		    return false;
	    }
	}
#-----------------------------------------------------------------------------#

	/**
	 * raise error message
	 * 
	 * @author Andrew A. Aculana
	 * @access Public
	 * @version 2.0
	 * @copyright 2006-07-03
	 * @return Boolean
	 */
	function raiseError($ErrorMessage = NULL,$Type = E_USER_ERROR){
		if($ErrorMessage !== NULL){
			trigger_error($ErrorMessage,$Type);
		}
		if(trim($this->ErrorMessage) != ""){
			trigger_error($this->ErrorMessage,$Type);
		}
		return false;
	}
#-----------------------------------------------------------------------------#
}
?>
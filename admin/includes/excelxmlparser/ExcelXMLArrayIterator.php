<?php
/*
* ============================================================================
*
* @name ExcelXMLArrayIterator.php
*
* @author Andrew A. Aculana
* @version 2.1
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
 * @package ExcelXMLArrayIterator
 * @subpackage ExcelXMLParser
 */
 
/**
 * A wrapper for array iteration
 *
 * @author		Andrew Aculana <andrew.aculana@link2support.com>
 * @copyright	Copyright &copy; 2006, Andrew Aculana
 * @version		1.0
 *
 */
class ExcelXMLArrayIterator{

	/**
	 * @var Array(mixed) $Data - Data container to hold the value to iterate
	 * @var int $index index used in data iteration
	 * @var Array $keys - Data key Container
	 */
	var $Data;
	var $index;
	var $keys;
#-----------------------------------------------------------------------------#

	/**
	 * class constructor - initialize attributes
	 * 
	 * @author Andrew A. Aculana
	 * @access Public
	 * @version 2.0
	 * @copyright 2006-07-03
	 * @param Array(mixed) - a reference to an array
	 * @return null
	 */
	function ExcelXMLArrayIterator(&$Data){
		$this->Data  =& $Data;
		$this->index = 0;
		$this->keys  = array();
	}
#-----------------------------------------------------------------------------#

	/**
	 * get the index
	 * 
	 * @author Andrew A. Aculana
	 * @access Public
	 * @version 2.0
	 * @copyright 2006-07-03
	 * @return int
	 */
	function getIndex(){
		return $this->index;
	}
#-----------------------------------------------------------------------------#

	/**
	 * reset iterator index to base
	 * 
	 * @author Andrew A. Aculana
	 * @access Public
	 * @version 2.0
	 * @copyright 2006-07-03
	 * @return null
	 */
	function reset(){
		$this->index = 0;
	}
#-----------------------------------------------------------------------------#

	/**
	 * reinitialize current index
	 * 
	 * @author Andrew A. Aculana
	 * @access Private
	 * @version 2.0
	 * @copyright 2006-07-03
	 * @return null
	 */
	function _reindex(){
		$this->keys = array_keys($this->Data);
	}
#-----------------------------------------------------------------------------#

	/**
	 * get the current value pointed by the current index
	 * 
	 * @author Andrew A. Aculana
	 * @access Public
	 * @version 2.0
	 * @copyright 2006-07-03
	 * @return long - pointer to an object
	 */
	function &current(){
		$this->_reindex();
		return @$this->Data[$this->keys[$this->index]];
	}
#-----------------------------------------------------------------------------#

	/**
	 * get the next value pointed by the current index
	 * 
	 * @author Andrew A. Aculana
	 * @access Public
	 * @version 2.0
	 * @copyright 2006-07-03
	 * @return long - pointer to an object
	 */
	function &next(){
		$this->_reindex();
		if(++$this->index > count($this->keys)){
			$this->index = count($this->keys)-1;
			return NULL;
		}else{
			return $this->current();
		}
	}
#-----------------------------------------------------------------------------#

	/**
	 * get the previous value
	 * 
	 * @author Andrew A. Aculana
	 * @access Public
	 * @version 2.0
	 * @copyright 2006-07-03
	 * @return long - pointer to an object
	 */
	function &prev(){
		$this->_reindex();
		if(--$this->index < 0){
			$this->index = 0;
			return NULL;
		}else{
			return $this->current();
		}
	}
#-----------------------------------------------------------------------------#

	/**
	 * get the top value
	 * 
	 * @author Andrew A. Aculana
	 * @access Public
	 * @version 2.0
	 * @copyright 2006-07-03
	 * @return long - pointer to an object
	 */
	function &top(){
		$this->_reindex();
		$this->index = 0;
		return $this->Data[$this->keys[$this->index]];
	}
#-----------------------------------------------------------------------------#

	/**
	 * get the last value
	 * 
	 * @author Andrew A. Aculana
	 * @access Public
	 * @version 2.0
	 * @copyright 2006-07-03
	 * @return long - pointer to an object
	 */
	function &bottom(){
		$this->_reindex();
		$this->index = count($this->keys)-1;
		return $this->Data[$this->keys[$this->index]];
	}
#-----------------------------------------------------------------------------#

	/**
	 * return the length of the iterator
	 * 
	 * @author Andrew A. Aculana
	 * @access Public
	 * @version 2.0
	 * @copyright 2006-07-03
	 * @return int
	 */	
	function length(){
		return count($this->Data);
	}
#-----------------------------------------------------------------------------#

	/**
	 * append data to the iterator
	 * 
	 * @author Andrew A. Aculana
	 * @access Public
	 * @version 2.0
	 * @copyright 2006-07-03
	 * @return null
	 */
	function append($Data){
		array_push($this->Data,$Data);
	}
#-----------------------------------------------------------------------------#

	/**
	 * remove the last value in the iterator
	 * 
	 * @author Andrew A. Aculana
	 * @access Public
	 * @version 2.0
	 * @copyright 2006-07-03
	 * @return null
	 */
	function pop(){
		array_pop($this->Data,$Data);
	}
#-----------------------------------------------------------------------------#
}
?>
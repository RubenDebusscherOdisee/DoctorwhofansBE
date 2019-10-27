<?php
/*
* ============================================================================
*
* @name Utils.php
*
* @author Andrew A. Aculana
* @version 1.0
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
 * @package ArrayIterator
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
class Utils{
	
	/**
	 *
	 * convert row column notation to A1 notation
	 * @author Andrew A. Aculana
	 * @copyright 2006-07-03
	 * @param Integer $row
	 * @param Integer $col,  $col < 255
	 * @return String
	 */	
	function RowColToCell($row, $col)
	{
		
	    if ($col > 255){
		    /* cell out of range */
	        return "Excel XML Parser Error: Cell Out of Range!";
	    }
	    $int       = (int)($col / 26);
	    $overbound = $col % 26;
	    
	    $CAA = '';
	    if ($int > 0)
	    {
	        $CAA = chr(ord('A') + $int - 1);
	    }
	    $CAB = chr(ord('A') + $overbound);
	    $row++;
	    return $CAA.$CAB.$row;
	}
#-----------------------------------------------------------------------------#
}
?>
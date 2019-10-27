<?php
/*
* ============================================================================
*
* @name ExcelXMLParser.php
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
 
include_once 'ExcelXMLWorkbook.php';
include_once 'ExcelXMLConstants.php';
include_once 'ExcelXMLError.php';
include_once 'Utils.php';

class ExcelXMLParser
{
	/**
	 * Excel XML Parser Attributes
	 * @var Associative Array $data
	 * @var Workbook $Workbook
	 * @var Encoding $Encoding
	 * @var String $XMLFilename
	 */
	var $data;
	var $Workbook;
	var $Encoding;
	var $XMLFileName;
	
	function ExcelXMLParser()
	{
		/* xml data buffer */
		$this->data 		= array();
		/* xml filename */
		$this->XMLFileName 	= "";
		/* handle to workbook */
		$this->Workbook		= NULL;
		
	}
#-----------------------------------------------------------------------------#

	/**
	 * set the default encoding (for future implementation)
	 *
	 * @author Andrew A. Aculana
	 * @version 2.0
	 * @copyright 2006-07-03
	 * @param const int $Encoding
	 * @return null
	 */
	function setEncoding($Encoding = EXCELXML_ENCODING_UTF_8){
		$this->Encoding = $Encoding;
	}
#-----------------------------------------------------------------------------#

	/**
	 * get the default encoding
	 *
	 * @author Andrew A. Aculana
	 * @version 2.0
	 * @copyright 2006-07-03
	 * @return const int
	 */
	function getEncoding(){
		return $this->Encoding;
	}
#-----------------------------------------------------------------------------#

	/**
	 * convert XML to array
	 *
	 * @author Andrew A. Aculana
	 * @version 2.0
	 * @copyright 2006-07-03
	 * @param Associative Array $WorksheetNames
	 * @return Associative Array reference
	 */
	function &XMLToArray($WorksheetNames)
	{
		
		$XMLFileHandle 	 = NULL;
		$XMLParserHandle = NULL;
		
		/* make sure filename was supplied */
		if(trim($this->XMLFileName)==''){
			$Error = new ExcelXMLError();
			$Error->setErrorMessage("Error: Filename not set");
			return $Error;
		}
		/* open xml file */
		if(!($XMLFileHandle=@fopen($this->XMLFileName,"r"))){
			$Error = new ExcelXMLError();
			$Error->setErrorMessage("Error: Failed to open xml file");
			return $Error;			
		}else{
			/* tracked merge cells Accross horizontally*/
			$current_cell_merge_across = 0;
			
			/* create and initialize the xml parser */
			if(!($XMLParserHandle = xml_parser_create())){
				$Error = new ExcelXMLError();
				$Error->setErrorMessage("Error: Failed to create parser handle");
				return $Error;				
			}
			/* get the current file size */
			$FileSize = filesize($this->XMLFileName);
			if($FileSize){
				/* read xml file */
				$XMLString = @fread($XMLFileHandle,$FileSize);
				
				/* initialize parser options */
				xml_parser_set_option($XMLParserHandle, XML_OPTION_CASE_FOLDING, 0);
				xml_parser_set_option($XMLParserHandle, XML_OPTION_SKIP_WHITE, 1);
				/* convert xml string to xml array of elements */
				xml_parse_into_struct($XMLParserHandle, $XMLString, $XMLElements, $index);

				$CurrentWorksheet = "";
				$splice_start     = NULL;
				$splice_length	  = NULL;
				$splice_table = array();
				
				$TotalWorksheet   = 0;
				foreach($XMLElements as $key => $val){
					$value =& $XMLElements[$key];
					$elem  =& $XMLElements;
					if($value['tag'] == 'Worksheet' && $val['type'] == 'open'){
						$TotalWorksheet++;
						if(isset($value['attributes']['ss:Name'])){
							$CurrentWorksheet = $value['attributes']['ss:Name'];
						}elseif(isset($value['attributes']['Name'])){
							$CurrentWorksheet = $value['attributes']['Name'];
						}
						
						$splice_start = $key;
						
						foreach($index['Worksheet'] as $k => $v){
							if($v == $splice_start){
								$splice_length = ($index['Worksheet'][$k+1])-$splice_start;
								break;
							}
						}
						
						if(!in_array($CurrentWorksheet,$WorksheetNames) && count($WorksheetNames)){
							$TotalWorksheet--;
							$splice_table[] = array("START"=>$splice_start,"LENGTH"=>$splice_length);
						}
					}
					
				}
				
				if($TotalWorksheet <= 0){
					$Error = new ExcelXMLError();
					$Error->setErrorMessage("Error: A workbook must contain at least one visible worksheet.");
					return $Error;
				}
				
				
				if(count($WorksheetNames)){
					for($x = count($splice_table)-1;$x >= 0;$x--){
						array_splice($elem,$splice_table[$x]['START'],$splice_table[$x]['LENGTH']+1);
					}
				}
				
				/* free XML Parser Handle */
				xml_parser_free($XMLParserHandle);
				/* unset xml file content buffer */
				unset($XMLString);
				/* temporary stack to hold xml element */					
				$xmlStack 	= array(array());
				/* index to top of stack */
				$topOfStack = 0;
				/* xml array tree */
				$parent 	= array();
				/* current worksheet row */
				$row		= 0;
				$cell_row	= 0;
				$ctr 		= 0;
				$worksheetName = "";
				$processWorksheet = true;
				$tagi		= array();
				$celladdress= "";
				foreach($XMLElements as $vals){
					$val =& $vals;
					$type = $val['type'];
					if($type=='open' && $val['tag']=='Worksheet')
					{
						$worksheetName = $val['attributes']['ss:Name'];
						if(in_array($worksheetName,$WorksheetNames)){
							$processWorksheet = true;
						}else{
							$processWorksheet = false;
						}
					}
					
					if($type=='close' && $val['tag']=='Worksheet')
					{
						$worksheetName = "";
						$processWorksheet = true;
					}
					
					if(!$processWorksheet){
 					}
					
					/* check if this is an open or complete and a table element */
					if(($type=='open' || $type=='complete') && ($val['tag']=='Table')){
						/* reset row and cell to 0 
						   clear celladress string */
						$cell 			= 0;
						$row 			= 0;
						$cell_row 		= 0;
						$celladdress 	= "";
						$rowcol 		= "";
					}
					
					/* check if this is an open or complete and a cell element */
					if(($type=='open' || $type=='complete') && ($val['tag']=='Cell'))
					{
						if(isset($val['attributes']['ss:Index'])){
							$ssColIndex = (int) $val['attributes']['ss:Index'];
						}elseif(isset($val['attributes']['Index'])){
							$ssColIndex = (int) $val['attributes']['Index'];
						}else{
							$ssColIndex = 0;
						}
						
						if($ssColIndex > 0){
							$cell_col = $ssColIndex-1;
						}
						
						/* get number of cells merge accross */
						if(isset($val['attributes']['ss:MergeAcross'])){
							$ssMergeAccross = (int) $val['attributes']['ss:MergeAcross'];
						}elseif(isset($val['attributes']['MergeAcross'])){
							$ssMergeAccross = (int) $val['attributes']['MergeAcross'];
						}else{
							$ssMergeAccross = 0;
						}
					
						$celladdress 	= Utils::RowColToCell($cell_row-1,$cell_col);
						
						$rowcol		 	= array("Row"=>$row-1,"Col"=>$col,"A1"=>$celladdress);
						$cell_col 	   += $ssMergeAccross;
						$cell_col++;
						$col++;
					}
					
					/* check if this is an open or complete and a row element */
					if(($type=='open' || $type=='complete') && ($val['tag']=='Row'))
					{
						/* if index for this row is available set the current row to this index */
						if(isset($val['attributes']['ss:Index'])){
							$ssRowIndex = (int) $val['attributes']['ss:Index'];
						}elseif(isset($val['attributes']['Index'])){
							$ssRowIndex = (int) $val['attributes']['Index'];
						}else{
							$ssRowIndex = 0;
						}
						
						if($ssRowIndex > 0){
							$cell_row = $ssRowIndex;
						}else{
							$cell_row++;
						}
						
						$rowcol 		= "";
						$celladdress 	= "";
						$col			= 0;
						$cell_col		= 0;
						$row++;
					}
					
					/* check if this is an open or completed element*/
					if($type=='open' || $type=='complete')
					{
						
			 			$xmlStack[$topOfStack++] = $tagi;
			 			$tagi = array('tag' => $val['tag']);
			 			if(isset($val['attributes']))  $tagi['attrs'] = $val['attributes'];
			 			if(isset($val['value']))
			 			{
			   				$tagi['values'][] = $val['value'];
		   				}else{
			   				$tagi['children'] = array();
		   				}
	   					
					}
					/* check if this is a complete or closed element*/
					if($type=='complete' || $type=='close')
					{
			 			$tags[] = $oldtagi = $tagi; 
			 			$tagi = $xmlStack[--$topOfStack];
			 			$oldtag = $oldtagi['tag'];
			 			
			 			unset($oldtagi['tag']);
			 			$tagi['children'][$oldtag][] = $oldtagi;
			 			
			 			$lngth = count($tagi['children'][$oldtag]);
			 			
			 			if(trim($celladdress) != '' && $val['tag']=='Cell')
			 			{
				 			$tagi['children'][$oldtag][$lngth-1]['CellAddress'] = $rowcol;
			 			}
			 			$parent =& $tagi;
					}
					/* check if this data value */
					if($type=='cdata')
					{
			 			$tagi['values'][] = $val['value'];
					}
				}
				/* unset XML Element array */
				unset($XMLElements);
				/* unset element stack */
				unset($xmlStack);
			}
		}
		/* close current file handle */
		@fclose($XMLFileHandle);
		return $parent['children'];
	}
#-----------------------------------------------------------------------------#

	/**
	 *
	 * convert xml array to xml string
	 * @author Andrew A. Aculana
	 * @copyright 2006-07-03
	 * @param Associative Array $xml
	 * @return String
	 */
	function ArrayToXML($xml,$root = true)
	{
		/* xml buffer */
		$temp = "";
		/* iterate excel xml */
		foreach ($xml as $key => $value)
		{
			foreach($value as $kk => $xmlvalue)
			{
				if(isset($xmlvalue["children"]))
				{
					$attrs = "";
					if(isset($xmlvalue["attrs"]))
					{
						foreach($xmlvalue["attrs"] as $attrsKey => $attrsValue)
						{
							if(trim($attrs) == "")
							{
						   		$attrs .= " ".$attrsKey."=\"".htmlentities($attrsValue)."\"";
							}else{
								$attrs .= " ".$attrsKey."=\"".htmlentities($attrsValue)."\"";
							}	
						}
					}
					
					if(is_array($xmlvalue["children"]))
					{
					   $temp .= sprintf("<%s%s>", $key,$attrs);
					   $temp .= $this->ArrayToXML($xmlvalue["children"], false);
					   $temp .= sprintf("</%s>\r\n", $key);
					}
				}elseif(isset($xmlvalue["values"])){
					
					$attrs = "";
					if(isset($xmlvalue["attrs"]))
					{
						foreach($xmlvalue["attrs"] as $attrsKey => $attrsValue)
						{
							if(trim($attrs) == "")
							{
						   		$attrs .= " ".$attrsKey."=\"".htmlentities($attrsValue)."\"";
							}else{
								$attrs .= " ".$attrsKey."=\"".htmlentities($attrsValue)."\"";
							}	
						}
					}
					
					if(is_array($xmlvalue["values"]))
					{
					   $temp .= sprintf("<%s%s>", $key,$attrs);
					   $temp .= htmlentities($xmlvalue["values"][0]);
					   $temp .= sprintf("</%s>", $key);
					}
				}
			}
		}
		if ($root) {
		   $temp = "<?xml version=\"1.0\"?>\r\n".$temp;
		}
		return $temp;
	}
#-----------------------------------------------------------------------------#

	/**
	 * open the workbook
	 *
	 * @author Andrew A. Aculana
	 * @version 2.0
	 * @copyrights 2006-07-03
	 * @param String $XMLFilePath - path to xml file
	 * @param Array(String) $WorksheetName - an array of worksheet name
	 * @return bool
	 */
	function OpenWorkbook($XMLFilePath,$WorksheetNames = array())
	{
		if(trim($XMLFilePath)==""){
			$Error = new ExcelXMLError();
			$Error->setErrorMessage("Error: Invalid or File Not found");
			return $Error;			
		}
		
		$this->XMLFileName =& $XMLFilePath;
		$this->data =& $this->XMLToArray($WorksheetNames);
		
		if(ExcelXMLError::isError($this->data)){
			return $this->data;
		}
		
		/* check if parsed some elements */
		if(!count($this->data)){
			$Error = new ExcelXMLError();
			$Error->setErrorMessage("Error: No XML Element found");
			return $Error;
		}
		/* handle to Workbook Object */
		$this->Workbook = new ExcelXMLWorkbook($this->data,$this->Encoding);
		return true;
	}
#-----------------------------------------------------------------------------#

	/**
	 * save the workbook and XML file
	 *
	 * @author Andrew A. Aculana
	 * @version 2.0
	 * @copyrights 2006-07-03
	 * @param String $FilePath - path to output file
	 * @return result
	 */
	function SaveWorkbook($FilePath = "",$Download = false){
		/* check if we have a data to save */
		if(count($this->data)){
			$xmldata = $this->ArrayToXML($this->data);
			if(trim($xmldata)==""){
				$Error = new ExcelXMLError();
				$Error->setErrorMessage("Error: Empty XML Data");
				return $Error;
			}
			$result = $this->writeXMLFile($FilePath,$xmldata);
			if($result && $Download){
				$FileInfo = pathinfo($FilePath);
				// fix for IE catching or PHP bug issue 
				header("Pragma: public"); 
				header("Expires: 0"); // set expiration time 
				header("Cache-Control: must-revalidate, post-check=0, pre-check=0");  
				// browser must download file from server instead of cache 
				// force download dialog 
				header("Content-Type: application/force-download"); 
				header("Content-Type: application/octet-stream"); 
				header("Content-type: application/x-msexcel");
				header("Content-Type: application/download"); 
				// use the Content-Disposition header to supply a recommended filename and  
				// force the browser to display the save dialog.  
				header("Content-Disposition: attachment; filename=".basename($FileInfo["basename"]).";"); 
				header("Content-Transfer-Encoding: binary"); 
				header("Content-Length: ".filesize($FilePath)); 
				@readfile("$FilePath");
				exit();
			}
			return $result;
		}
	}
#-----------------------------------------------------------------------------#

	/**
	 * save the xml back to file
	 *
	 * @access Private
	 * @author Andrew A. Aculana
	 * @version 2.0
	 * @copyrights 2006-07-03
	 * @param String $FilePath - path to output file
	 * @param String $xmlData - xml data
	 * @return Bool
	 */	
	function writeXMLFile($FilePath = "",$xmlData = "")
	{
		if (!$handle = @fopen($FilePath, 'w+')){
			$Error = new ExcelXMLError();
			$Error->setErrorMessage("Error: Failed to create xml file");
			return $Error;
		}
		if (@fwrite($handle, $xmlData) === FALSE){
			$Error = new ExcelXMLError();
			$Error->setErrorMessage("Error: Failed to write xml file");
			return $Error;
		}
		@fclose($handle);
		return true;
	}
}
?>
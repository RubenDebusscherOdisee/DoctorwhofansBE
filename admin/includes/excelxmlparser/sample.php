<?php

	include "ExcelXMLParser.php";
	$ExcelXMLParser = new ExcelXMLParser();	
	
	$result = $ExcelXMLParser->openWorkbook("sample.xml",array());
	
	$StartWork 		= array("D3"=>"8:00 AM","D9"=>"8:30 AM","D10"=>"7:00 AM","D11"=>"7:40 AM","D12"=>"8:30 AM","D13"=>"9:10 AM","D14"=>"10:00 AM");
	$TimeOutLunch 	= array("E8"=>"12:00 PM","E9"=>"11:59 AM","E10"=>"12:01 PM","E11"=>"11:00 AM","E12"=>"01:00 PM","E13"=>"01:30 PM","E14"=>"02:00 PM");
	$TimeInLunch 	= array("F8"=>"12:30 PM","F9"=>"01:00 PM","F10"=>"01:01 PM","F11"=>"02:00 PM","F12"=>"02:15 PM","F13"=>"01:54 PM","F14"=>"02:40 PM");
	$EndWork 		= array("G8"=>"06:00 PM","G9"=>"07:32 PM","G10"=>"05:30 PM","G11"=>"06:54 PM","G12"=>"04:30 PM","G13"=>"06:12 PM","G14"=>"06:01 PM");
	
	if(!ExcelXMLError::isError($result)){
		/* get the document properties for this excel files */
		$Author 	= $ExcelXMLParser->Workbook->Document->getProperty("Author");
		$LastAuthor = $ExcelXMLParser->Workbook->Document->getProperty("LastAuthor");
		$Created 	= $ExcelXMLParser->Workbook->Document->getProperty("Created");
		$Company 	= $ExcelXMLParser->Workbook->Document->getProperty("Company");
		$Version 	= $ExcelXMLParser->Workbook->Document->getProperty("Version");
		$ExcelXMLParser->Workbook->setActiveSheet(0);
		$ExcelXMLParser->Workbook->setFirstVisibleSheet(0);
		/* set a particular cell value */
 		$Ws =& $ExcelXMLParser->Workbook->getWorksheetByName("1-26-2003");
 		$Cl =& $Ws->Table->getCellByAddress("D3");
 		$Cl->setValue("Andrew Aculana");
		
		/* lets traverse our workbook, starting from the first worksheet */
		
		$Worksheet =& $ExcelXMLParser->Workbook->getFirstWorksheet();
		
    	while($Worksheet){
        	$Row =& $Worksheet->Table->getFirstRow();
        	while($Row){
	        	$Cell =& $Row->getFirstCell();
	        	while($Cell){
		        	
		        	$CellAddress = $Cell->getCellAddress();
		        	
 		        	if(in_array($CellAddress,array_keys($StartWork))){
 			        	$Cell->setValue($StartWork[$CellAddress]);
 		        	}
 		        	if(in_array($CellAddress,array_keys($TimeOutLunch))){
 			        	$Cell->setValue($TimeOutLunch[$CellAddress]);
 		        	}
 		        	if(in_array($CellAddress,array_keys($TimeInLunch))){
 			        	$Cell->setValue($TimeInLunch[$CellAddress]);
 		        	}
 		        	if(in_array($CellAddress,array_keys($EndWork))){
 			        	$Cell->setValue($EndWork[$CellAddress]);
 		        	}
		        	
		        	$Cell =& $Row->getNextCell();
	        	}
	        	$Row =& $Worksheet->Table->getNextRow();
        	}

	    	$Worksheet =& $ExcelXMLParser->Workbook->getNextWorksheet();
    	}
    	
    	$result = $ExcelXMLParser->SaveWorkbook("sample.xls",true);
		if(ExcelXMLError::isError($result)){
			$result->raiseError();
		}
	}else{
		$result->raiseError();
		die('x');
	}

?>
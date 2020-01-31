<?php
/*
 * Xataface CKeditor Module v 0.1
 * Copyright (C) 2011  Steve Hannah <steve@weblite.ca>
 * 
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Library General Public
 * License as published by the Free Software Foundation; either
 * version 2 of the License, or (at your option) any later version.
 * 
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Library General Public License for more details.
 * 
 * You should have received a copy of the GNU Library General Public
 * License along with this library; if not, write to the
 * Free Software Foundation, Inc., 51 Franklin St, Fifth Floor,
 * Boston, MA  02110-1301, USA.
 *
 */
class Dataface_FormTool_ckeditor {

     function &buildWidget($record, &$field, $form, $formFieldName, $new=false){
             $widget =& $field['widget'];
             $factory =& Dataface_FormTool::factory();
             $mod = Dataface_ModuleTool::getInstance()->loadModule('modules_ckeditor');
             
             $ckeditorConfig = array();
             if ( @$widget['ckeditor'] ){
                     $ckeditorConfig = $widget['ckeditor'];
             }
             
             if ( $record ){
                     $del = $record->table()->getDelegate();
                     if ( isset($del) and method_exists($del, 'ckeditor_decorateConfig') ){
                             $del->ckeditor_decorateConfig($record, $ckeditorConfig);
                     }
             }       
             
             $atts = array(
                     'class' => 'xf-ckeditor',
                     'data-xf-ckeditor-base-path' => $mod->getBaseURL().'/lib/ckeditor/',
                     'data-xf-ckeditor-config' => json_encode($ckeditorConfig)
             );
             
             $el =& $factory->addElement('textarea', $formFieldName, $widget['label'], $atts);
             if ( PEAR::isError($el) ) return $el;
             $el->setProperties($widget);
             
             $jt = Dataface_JavascriptTool::getInstance();
             $jt->addPath(dirname(__FILE__).DIRECTORY_SEPARATOR.'js',
                     $mod->getBaseURL().'/js');
             
             $ct = Dataface_CSSTool::getInstance();
             $ct->addPath(dirname(__FILE__).DIRECTORY_SEPARATOR.'css',
                     $mod->getBaseURL().'/css');
             //$jt->import('ckeditor.js');
             $jt->import('xataface/modules/ckeditor/ckeditor-widget.js');
             
             
     
             return $el;
     }
}


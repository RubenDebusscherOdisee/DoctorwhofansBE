/*
Copyright (c) 2003-2012, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.addTemplates('default', {
  imagesPath: CKEDITOR.getUrl(CKEDITOR.plugins.getPath('templates') + 'templates/images/'),
  templates: [{
    title: 'Image and Title',
    image: 'template1.gif',
    description: 'One main image with a title and text that surround the image.',
    html: '<h3><img style="margin-right: 10px" height="100" width="100" align="left"/>Type the title here</h3><p>Type the text here</p>'
  }, {
    title: 'Strange Template',
    image: 'template2.gif',
    description: 'A template that defines two colums, each one with a title, and some text.',
    html: '<table cellspacing="0" cellpadding="0" style="width:100%" border="0"><tr><td style="width:50%"><h3>Title 1</h3></td><td></td><td style="width:50%"><h3>Title 2</h3></td></tr><tr><td>Text 1</td><td></td><td>Text 2</td></tr></table><p>More text goes here.</p>'
  }, {
    title: 'Text and Table',
    image: 'template3.gif',
    description: 'A title with some text and a table.',
    html: '<div style="width: 80%"><h3>Title goes here</h3><table style="width:150px;float: right" cellspacing="0" cellpadding="0" border="1"><caption style="border:solid 1px black"><strong>Table title</strong></caption></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></table><p>Type the text here</p></div>'
  },
  {
    title: 'Episode',
    image: 'template3.gif',
    description: 'Default voor een episode tabel. Voeg deze toe aan een bestaande pagina.  Dit voeg de ondertitel Episodes toe en de tabel met koppen, die dan door de applicatie aangevuld kunnen worden.',
    html: '<h2>Episodes</h2><div style="overflow-x:auto"><table align="left" border="1" cellpadding="0" cellspacing="0" id="EpisodeTable"><thead><tr><th scope="col">Episode</th><th scope="col">Title</th><th scope="col">Run Time</th><th scope="col">Original Air date</th><th scope="col">Original Network</th><th scope="col">UK viewers</th><th scope="col">Appreciation Index</th><th scope="col">Status</th></tr></thead><tbody></tbody></table></div>'
  },{
    title: 'Downloads',
    image: 'template3.gif',
    description: 'Default voor een Download list. Voeg deze toe aan een bestaande pagina Onder de voetnoten, maar boven de Quotes.  Dit voeg de ondertitel Downloads toe met de div, die dan door de applicatie aangevuld kunnen worden.',
    html: '<hr /><h2>Downloads</h2><div id="Downloads"></div>'
  },{
    title: 'Quotes',
    image: 'template3.gif',
    description: 'Default voor een Quote tile view. Voeg deze toe aan een bestaande pagina Onder de Downloads.  Dit voeg de ondertitel Quotes toe met de div, die dan door de applicatie aangevuld kunnen worden.',
    html: '<hr /><h2>Quotes</h2><div id="Quotes"></div>'
  },
  {
    title: 'Timeline Default',
    image: 'template3.gif',
    description: 'Default voor een Timeline. Bevat 1 Timelines div, 1 container en 2 contents (1 links 1 rechts, aan te passen door de classes om te switchen) en elk bevat standaard content',
    html: '<div class="timeline"><div class="container right"><div class="content">  <h3>Qui ad mollit commodo officia in et consequat elit dolor eiusmod in est adipisicing proident.</h3> <h4>Magna deserunt enim commodo irure aliqua sint reprehenderit sit fugiat.</h4> <p>Exercitation irure eiusmod do magna tempor proident est in ipsum magna reprehenderit cillum.</p>  </div></div><div class="container left">  <div class="content"> <h3>Qui ad mollit commodo officia in et consequat elit dolor eiusmod in est adipisicing proident.</h3> <h4>Magna deserunt enim commodo irure aliqua sint reprehenderit sit fugiat.</h4> <p>Exercitation irure eiusmod do magna tempor proident est in ipsum magna reprehenderit cillum.</p>  </div></div></div>'
  },{
    title: 'Timeline Left',
    image: 'template3.gif',
    description: 'Voeg een Left item toe aan een bestaande tijdslijn',
    html: '<div class="container left"><div class="content"><h3>Qui ad mollit commodo officia in et consequat elit dolor eiusmod in est adipisicing proident.</h3><h4>Magna deserunt enim commodo irure aliqua sint reprehenderit sit fugiat.</h4><p>Exercitation irure eiusmod do magna tempor proident est in ipsum magna reprehenderit cillum.</p></div></div>'
  },{
    title: 'Timeline Right',
    image: 'template3.gif',
    description: 'Voeg een Right item toe aan een bestaande tijdslijn',
    html: '<div class="container right"><div class="content"><h3>Qui ad mollit commodo officia in et consequat elit dolor eiusmod in est adipisicing proident.</h3><h4>Magna deserunt enim commodo irure aliqua sint reprehenderit sit fugiat.</h4><p>Exercitation irure eiusmod do magna tempor proident est in ipsum magna reprehenderit cillum.</p></div></div>'
  }
]
});
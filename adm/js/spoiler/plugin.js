//require <ckeditor.js>
(function(){
    CKEDITOR.plugins.add('spoiler', {
        init: function (editor) {
            var pluginName = 'spoiler';
            editor.ui.addButton('spoiler', {
                label: 'spoiler',
                command: 'OpenWindow1',
                icon: CKEDITOR.plugins.getPath('spoiler') + 'icons/spoiler.png'
            });
            var cmd = editor.addCommand('OpenWindow1', {
                exec: addSpoiler
            });
        }
    });
});
function addSpoiler(e) {
    var rndId = 'Spoilercontent'+Math.floor((Math.random() * 10000) + 1);
    e.insertHtml(' <button class="Spoiler" data-id="'+rndId+'" name="spoiler1" onclick="Spoilertonen('+rndId+')" type="button">Spoiler!</button> ');
    e.insertHtml('<div class="Spoilercontent" data-id="'+rndId+'" id="'+rndId+'">Select this to add spoilers</div>');
}
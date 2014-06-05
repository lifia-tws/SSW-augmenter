// ==UserScript==
// @name        dvSSW2014
// @namespace   dv
// @include     http://joanpiedra.com/jquery/greasemonkey/
// @require     http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js
// @require     http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js
// @resource    jQueryUICSS http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/smoothness/jquery-ui.css
// @version     1
// @grant       none
// ==/UserScript==

jQuery(document).ready(function()
{
    /* Agregar abstract - BEGIN */
    
    var commonName = jQuery('h1#firstHeading').find('span').html();
    var lang = jQuery('h1#firstHeading').attr('lang');
    
    var url = 'http://dbpedia.org/sparql?default-graph-uri=http%3A%2F%2Fdbpedia.org&query=select+%3Fabstract+where%0D%0A{%0D%0A++%3Fcountry+a+dbpedia-owl%3ACountry+.%0D%0A++%3Fcountry+dbpprop%3AcommonName+%3FcountryName+.%0D%0A++%3Fcountry+dbpedia-owl%3Aabstract+%3Fabstract+.%0D%0A++filter+%28lang%28%3Fabstract%29+%3D+%27' + lang + '%27+%26%26+%3FcountryName+%3D+%22' + commonName + '%22%40' + lang + '%29%0D%0A}&format=application%2Fsparql-results%2Bjson&timeout=30000&debug=on';
    
    jQuery.getJSON(
        url,
        function(json){
        
            var information = 'No se ha encontrado información sobre ' + commonName + '@' + lang + ' en DBpedia.';
            
            if (json["results"]["bindings"].length > 0){
                information = json["results"]["bindings"][0]["abstract"].value;
            }
            
            console.log(json["results"]["bindings"].length);
            
            var abstract = jQuery('<div class="catlinks"></div>');
            
            jQuery('<h3>Agregado desde DBpedia</h3>').appendTo(abstract);
            jQuery('<p>' + information + '</p>').appendTo(abstract);
            
            abstract.prependTo('div#bodyContent');
        }
    );
    
    /* Agregar abstract - END */
    
    /* Agregar categorías sugeridas - BEGIN */

    var suggestedCatlinks = jQuery('<div id="suggested-catlinks" class="catlinks"></div>');
    var suggestedCatlinksContainer = jQuery('<div id="mw-suggested-catlinks" class="mw-suggested-catlinks"></div>');
    var suggestedCatlinksTitle = jQuery('<a href="#">Categorías sugeridas:</a>');
    var suggestedCatlinksList = jQuery('<ul></ul>');
    
    jQuery('<li>Categoría 01 <a title="Agregar Categoría" href="#" class="add_category_action">[+]</a></li>').appendTo(suggestedCatlinksList);
    jQuery('<li>Categoría 02 <a title="Agregar Categoría" href="#" class="add_category_action">[+]</a></li>').appendTo(suggestedCatlinksList);
    jQuery('<li>Categoría 03 <a title="Agregar Categoría" href="#" class="add_category_action">[+]</a></li>').appendTo(suggestedCatlinksList);
    jQuery('<li>Categoría 04 <a title="Agregar Categoría" href="#" class="add_category_action">[+]</a></li>').appendTo(suggestedCatlinksList);
    jQuery('<li>Categoría 05 <a title="Agregar Categoría" href="#" class="add_category_action">[+]</a></li>').appendTo(suggestedCatlinksList);
    
    suggestedCatlinksTitle.appendTo(suggestedCatlinksContainer);
    suggestedCatlinksList.appendTo(suggestedCatlinksContainer);
    
    suggestedCatlinksContainer.appendTo(suggestedCatlinks);
    
    suggestedCatlinks.appendTo('div#bodyContent');
    
    jQuery('.add_category_action').click(function(e)
    {
        e.preventDefault();
        
        if (confirm('Are you sure?'))
        {
            alert('Added!');
        }
    });
    
    /* Agregar categorías sugeridas - END */
});
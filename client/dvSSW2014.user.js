// ==UserScript==
// @name dvSSW2014v2
// @namespace dv
// @include http://joanpiedra.com/jquery/greasemonkey/
// @require http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js
// @require http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js
// @version 1
// @grant none
// ==/UserScript==

var wpEditForm;
var entityArticle = jQuery(location).attr('href');

jQuery.get(
    jQuery('#ca-edit').find('a').attr('href'),
    function(response)
    {
        wpEditForm = jQuery(response).find('form#editform');                                  
        wpTextarea = jQuery(wpEditForm).find('textarea#wpTextbox1');
        wpContent = jQuery(wpTextarea).text();
        
        wpEditForm.hide();
        wpEditForm.appendTo('body');
    }
);

function buildQuery(template, values)
{    
    jQuery.each(values, function(index, value)
               {
                   template = template.replace(String(index), value);
               });
    
    return template.replace('$isPrimaryTopicOf', entityArticle);
}

    // Check if subject is a Person
    
    /*
    
    jQuery.getJSON(
        'http://dbpedia.org/sparql',
        {
            'default-graph-uri': 'http://dbpedia.org',
            'query': 'ask { ?subject foaf:isPrimaryTopicOf <' + jQuery(document).attr('location') + '> . ?subject a dbpedia-owl:Person }',
            'format': 'application/sparql-results+json',
            'timeout': 30000,
            'debug': 'on'
        },
        function(json)
        {
            if (json.boolean)
            {   
                jQuery('<option value="peopleSameAgeSameCountry">People with same birthYear and birthPlace</option>').appendTo(querySelect);
            }
        }
    );
    
    // Check if subject is a Country
    
    jQuery.getJSON(
        'http://dbpedia.org/sparql',
        {
            'default-graph-uri': 'http://dbpedia.org',
            'query': 'ask { ?subject foaf:isPrimaryTopicOf <' + jQuery(document).attr('location') + '> . ?subject a dbpedia-owl:Country }',
            'format': 'application/sparql-results+json',
            'timeout': 30000,
            'debug': 'on'
        },
        function(json)
        {
            if (json.boolean)
            {   
                jQuery('<option value="cities">Cities in this country</option>').appendTo(querySelect);
            }
        }
    );    
    
    */ 

function executeQuery(query, resultContainer)
{
    jQuery.get(
        'http://dbpedia.org/sparql',
        {
            'default-graph-uri': 'http://dbpedia.org',
            'query': query,
            'format': 'application/sparql-results+json',
            'timeout': 30000,
            'debug': 'on'
        },
        function(json)
        {                
            resultContainer.empty();
            
            if (json.results.bindings.length == 0)
            {
                jQuery('<i>No results found.</i>').appendTo(resultContainer);
            }
            else
            {            
                jQuery.each(json.results.bindings, function(index, result)
                {
                    jQuery('<a title="' + result.name.value + '" href="' + result.isPrimaryTopicOf.value + '" target="_blank">' + result.name.value + '</a></br>').appendTo(resultContainer);
                });
                
                jQuery('<a class="ssw-augmenter-query-previous" href="#">Previous</a>')
                   .button({ icons: { primary: "ui-icon-carat-1-w" }, text: false })
                   .click(function(event)
                    {
                        event.preventDefault();

                        query = resultContainer.prev().attr('data-query');
                        offset = Number(resultContainer.attr('data-offset')) - 10;
                        
                        if (offset < 0) return false;                            

                        resultContainer.attr('data-offset', offset);

                        query = buildQuery(query, { '$offset': offset });

                        executeQuery(query, resultContainer);
                   })
                   .appendTo(resultContainer);
                
                jQuery('<a class="ssw-augmenter-query-next" href="#">Next</a>')
                   .button({ icons: { primary: "ui-icon-carat-1-e" }, text: false })
                   .click(function(event)
                    {
                        event.preventDefault();

                        query = resultContainer.prev().attr('data-query');
                        offset = Number(resultContainer.attr('data-offset')) + 10;

                        resultContainer.attr('data-offset', offset);

                        query = buildQuery(query, { '$offset': offset });

                        executeQuery(query, resultContainer);
                   })
                   .appendTo(resultContainer);
            }            
        }
    );
}

function sswQuery(id, label, template)
{
    this.id = id;
    this.label = label;
    this.template = template;
    
    this.build = function() { return jQuery('<span class="ssw-augmenter-query" data-query="' + this.template + '">' + this.label + '</span><div class="ssw-augmenter-query-results" data-offset="0"></div>'); }
}

function sswQueriesWidget()
{
    this.title = 'SSW Augmenter Queries';
    
    this.queries = new Array();
    
    this.add = function(query) { this.queries.push(query); };
    
    this.build = function()
    {        
        queryContainer = jQuery('<div></div>');
    
        jQuery.each(this.queries, function(index, query)
        {                
            jQuery(query.results).on('click', function(event)
            {

            });
            
            query.build().appendTo(queryContainer);
        });
        
        queryContainer.accordion(
        {
            collapsible: true,
            active: false,
            heightStyle: 'content'
        });
        
        queryContainer.find('span.ssw-augmenter-query')
        .click(function()
               {
                   if (jQuery(this).hasClass('ui-accordion-header-active'))
                   {                                           
                       query = buildQuery(jQuery(this).attr('data-query'), { '$offset': jQuery(this).next().attr('data-offset') });
                       resultContainer = jQuery(this).next();
                       
                       executeQuery(query, resultContainer);
                   }
               });
        
        return queryContainer;
    }    
    
    this.render = function()
    {
        (new sswInfoboxWidget(this)).render();        
    }
}

function sswSuggestedCategory(id, label)
{
    this.id = id;
    this.label = label;
    
    this.build = function()
    {     
        suggestedCategoryContainer = jQuery('<li class="ssw-augmenter-suggested-category"></li>');
        suggestedCategoryCheckbox = jQuery('<input type="checkbox" value="' + this.label + '">' + this.label + '</input>');
        suggestedCategoryLikeButton = jQuery('<a href="#">Like</a>');        
        
        jQuery(suggestedCategoryCheckbox)
           .change(function(event)
                  {
                      suggestedCategoryCheckbox = jQuery(event.target);
                      
                      if (suggestedCategoryCheckbox.is(':checked'))
                      {
                         jQuery(suggestedCategoryCheckbox.parent()).addClass('ssw-augmenter-suggested-category-selected');
                      }
                      else
                      {                          
                         jQuery(suggestedCategoryCheckbox.parent()).removeClass('ssw-augmenter-suggested-category-selected');
                      }
                  });
        
        jQuery(suggestedCategoryLikeButton)
           .button({ icons: { primary: "ui-icon-star" }, text: false })
           .click(function(event)
                  {
                      event.preventDefault();
                      
                      button = jQuery(event.currentTarget);
                      
                      jQuery.post('//localhost/app_dev.php/category/like', { entityArticle: jQuery(location).attr('href'), categoryName: jQuery(event.currentTarget).prev().val() })
                      .done(function(response)
                           {
                               if (response.status == 'success')
                               {                           
                                  button.button("disable");
                                   
                                  alert('Like submmited!');       
                               }                        
                               else
                               {
                                  alert(response.data.message);
                               }
                           })
                      .fail(function()
                           {
                              alert('Connection error!') ;
                           });
                  });
        
        jQuery(suggestedCategoryCheckbox).appendTo(suggestedCategoryContainer);
        jQuery(suggestedCategoryLikeButton).appendTo(suggestedCategoryContainer);
        
        return suggestedCategoryContainer;        
    }    
}

function sswInfoboxWidget(widget)
{
    this.widget = widget;
    
    this.render = function()
    {
        widgetContainerTableRow = jQuery('<tr></tr>');
        widgetContainerTableData = jQuery('<td colspan="3"></td>');
        
        jQuery('<span class="ssw-augmenter-widget-title">' + this.widget.title + '</span>').appendTo(widgetContainerTableData);
        jQuery(this.widget.build()).appendTo(widgetContainerTableData);
        
        jQuery(widgetContainerTableData).appendTo(widgetContainerTableRow);
        
        jQuery(widgetContainerTableRow).appendTo(jQuery('table.infobox').children('tbody'));        
    }    
}


function sswSuggestedCategoriesWidget()
{
    this.id = 'ssw-augmenter-suggested-categories-widget';
    this.title = 'SSW Augmenter Suggested Categories';
    this.suggestedCategories = new Array();
    
    this.add = function(suggestedCategory)
    {
        this.suggestedCategories.push(suggestedCategory);
    }
    
    this.build = function()
    {
        suggestedCategoriesContainer = jQuery('<div class="ssw-augmenter-widget"></div>');
        suggestedCategoriesList = jQuery('<ul class="ssw-augmenter-suggested-categories-widget"></ul>');
        
        for (i = 0; i < this.suggestedCategories.length; i++)
        {            
            this.suggestedCategories[i].build().appendTo(suggestedCategoriesList);
        }
        
        suggestedCategoriesAddButton = jQuery('<a href="#">Add to article</a>');
        suggestedCategoriesClearButton = jQuery('<a href="#">Clear</a>');
        
        suggestedCategoriesClearButton
           .button()
           .click(function(event)
                  {                     
                      event.preventDefault();
                      
                      suggestedCategories = jQuery(event.target).parent().parent().find('input');
                      
                      for (i = 0; i < suggestedCategories.length; i++)
                      {
                         jQuery(suggestedCategories[i]).attr('checked', false);                                                   
                         jQuery(suggestedCategories[i]).parent().removeClass('ssw-augmenter-suggested-category-selected');
                      }
                  });                
        
        suggestedCategoriesAddButton
           .button()
           .click(function(event)
                  {
                      event.preventDefault();
                      
                      suggestedCategoriesChecked = jQuery(event.target).parent().parent().find('input[type=checkbox]').filter(':checked');
                      
                      if ((suggestedCategoriesChecked.length > 0) && (confirm('Submit changes?')))
                      {                          
                          wpTextarea = wpEditForm.find('textarea#wpTextbox1');
                          wpContent = wpTextarea.text();
                                                    
                          jQuery.each(suggestedCategoriesChecked, function(index, input)
                          {
                              suggestedCategory = '[[Category:' + jQuery(input).val() + ']]';
                              
                              if (wpContent.indexOf(suggestedCategory))
                              {
                                  wpContent += suggestedCategory + '\n';
                              }
                          });
                          
                          wpTextarea.text(wpContent);                        
                          
                          // We disable the page while submitting changes.
                          jQuery('<div class="ui-widget-overlay ui-front"></div>').appendTo(jQuery('body'));
                          
                          wpEditForm.find('input#wpSave').click();
                      }
                      else
                      {
                          alert('No categories selected!');                          
                      }
                  });        
        
        suggestedCategoryFormNameInput = jQuery('<input type="text"></input>');
        suggestedCategoryFormSubmitButton = jQuery('<a href="#">Submit</a>');
        
        suggestedCategoryFormSubmitButton
           .button({ icons: { primary: "ui-icon-plus" }, text: false })
           .click(function(event)
                 {
                     event.preventDefault();          
                     
                     suggestedCategoryName = jQuery(event.currentTarget).prev().val();
                     
                     if (suggestedCategoryName.length > 0)
                     {   
                         suggestedCategoryFormSubmitButton = jQuery(event.currentTarget);
                         
                         jQuery.post('//localhost/app_dev.php/entity/suggestCategory', { entityArticle: jQuery(location).attr('href'), categoryName: suggestedCategoryName })
                         .done(function(response)
                               {
                                   if (response.status == 'success')
                                   {                                       
                                       suggestedCategoryFormSubmitButton.prev().val('');
                                       
                                       suggestedCategory = new sswSuggestedCategory(response.data.category.name, response.data.category.name);
                                    
                                       // FIXME
                                       suggestedCategory.build().appendTo('ul.ssw-augmenter-suggested-categories-widget');
                                   }                                   
                                   else
                                   {
                                       alert(response.data.message);
                                   }
                               })
                         .fail(function()
                               {
                                   alert('Connection error!');
                               });
                     }
                     else
                     {
                         alert('Empty name!');
                     }
                 });
        
        suggestedCategoryFormSubmitButton.css('display', 'inline-block');
        
        suggestedCategoriesList.appendTo(suggestedCategoriesContainer);
        suggestedCategoriesClearButton.appendTo(suggestedCategoriesContainer);
        suggestedCategoriesAddButton.appendTo(suggestedCategoriesContainer);
        
        suggestedCategoriesList.appendTo(suggestedCategoriesContainer);
        suggestedCategoriesClearButton.appendTo(suggestedCategoriesContainer);
        suggestedCategoriesAddButton.appendTo(suggestedCategoriesContainer);
        suggestedCategoryFormNameInput.appendTo(suggestedCategoriesContainer);
        suggestedCategoryFormSubmitButton.appendTo(suggestedCategoriesContainer);
        
        return suggestedCategoriesContainer;
    }
    
    this.render = function()
    {
        (new sswInfoboxWidget(this)).render();        
    }
}

jQuery(document).ready(function()
{            
    // Adding jQuery UI CSS
    jQuery('<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/ui-lightness/jquery-ui.css" />').appendTo(jQuery('head')); 
    
    // Adding more CSS - BEGIN
    
    sswAugmenterStyle = '<style>';   
    sswAugmenterStyle += '.ssw-augmenter-widget-title { font-weight: bold; }';
    sswAugmenterStyle += '.ssw-augmenter-widget > ul { margin-left: 0; }';
    sswAugmenterStyle += '.ssw-augmenter-suggested-categories-widget { list-style: none; margin-left: 0; !important }';
    sswAugmenterStyle += '.ssw-augmenter-suggested-categories-widget:first-child { border-top: 1px solid #e5e5e5; }';   
    sswAugmenterStyle += '.ssw-augmenter-suggested-category { vertical-align: middle; border-bottom: 1px solid #e5e5e5; margin: 0; padding: 0; }';   
    sswAugmenterStyle += '.ssw-augmenter-suggested-category > input { cursor: pointer; }';       
    sswAugmenterStyle += '.ssw-augmenter-suggested-category-selected { background-color: #ffffcc; }';
    sswAugmenterStyle += '</style>';        
    
    jQuery(sswAugmenterStyle).appendTo(jQuery('head'));
    
    loadSuggestedCategories();
    loadQueries();    
    
    // Adding more CSS - END
    
    /*
        
    jQuery.getJSON(
       '//localhost/app_dev.php/query/all.json',
        {},
        function(json)
        {
            if (json.status == 'success')
            {
                queryContainer = new QueryContainer();
                
                for (i = 0; i < json.data.queries.length; i++)
                {
                    query = json.data.queries[i];
                    
                    queryContainer.add(new Query(query.name, query.label, query.query));
                }            
                
                queryContainer.appendTo('table.infobox');
                
                adjustColspan();
            }
        }
    );
    
    */    
    
    // Add category to wiki source - BEGIN
    
    if (jQuery('#ca-edit').length > 0)
    {
        editLink = jQuery('#ca-edit').find('a').attr('href');
        
        jQuery.get(editLink, function(data)
        {
        });
    }
    
    // Add category to wiki source - END
    
    jQuery('.selectable').selectable();
    
    // Agregar categorías sugeridas - END
    
    /*
    
    jQuery('.ssw-augmenter-query').on('click', function(event)
    {
        currentTarget = jQuery(event.currentTarget);
        
        if (isClosed(currentTarget))
        {
            executeQuery(currentTarget.attr('data-query'), jQuery('#' + currentTarget.attr('id') + '-results'));
        }
    });
    
    */
});

function loadQueries()
{ 
    queries = new sswQueriesWidget();
    
    jQuery.get('//localhost/app_dev.php/entity/queries', { entityArticle: entityArticle })
    .done(function(response)
         {
             if (response.status == 'success')
             {
                 jQuery.each(response.data.queries, function(index, value)
                 {
                     queries.add(new sswQuery(value.slug, value.name, value.template));
                 });                 
             }
             else
             {
                 alert(response.data.message);
             }
             
             queries.render();
         })
    .fail(function()
          {              
              alert('Connection error!');
          });
}

function loadSuggestedCategories()
{    
    suggestedCategories = new sswSuggestedCategoriesWidget();    
    
    jQuery.get('//localhost/app_dev.php/entity/categories', { entityArticle: jQuery(location).attr('href') })
    .done(function(response)
         {
            if (response.status == 'success')
            {
                jQuery.each(response.data.categories, function(index, value)
                {
                    suggestedCategories.add(new sswSuggestedCategory('ssw-suggested-category' + value.name, value.name));   
                });
            }
            else
            {
                alert(response.data.message)                
            }        
             
            suggestedCategories.render();
         })
    .fail(function()
          {
              alert('Connection error!');
          });    
}

function isClosed(section)
{
    return section.attr('aria-selected') == 'true';
}

function adjustColspan()
{
    var maxColspan = 1;
    
    var tableHeaders = jQuery('table.infobox').find('th');
    
    for (i = 0; i < tableHeaders.length; i++)
    {
        var colspan = Number(jQuery(tableHeaders[i]).attr('colspan'));
        
        
        if (colspan > maxColspan)
        {
            maxColspan = colspan;
        }
    }
    
    jQuery('.ssw-max-colspan').attr('colspan', maxColspan);
    return maxColspan;
}
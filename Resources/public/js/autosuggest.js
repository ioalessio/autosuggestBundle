$(document).on('focus', '.ajax-typeahead', function(e) {   
    var el = $(this);
    el.typeahead({ ajax: { url: el.attr('data-link'), triggerLength: 2 }, 
                        itemSelected: function(item, val, text) 
                                        { 
                                            $("#" + el.attr('data-value') ).val(val); 
                                        } 
                      });
});
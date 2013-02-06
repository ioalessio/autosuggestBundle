$(document).on('focus', '.ajax-typeahead', function(e) {   

    $(this).typeahead({ ajax: { url: $('.ajax-typeahead').attr('data-link'), triggerLength: 2 }, 
                        itemSelected: function(item, val, text) 
                                        { 
                                            $("#" + $('.ajax-typeahead').attr('data-value') ).val(val); 
                                        } 
                      });
});
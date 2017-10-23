/* Scripts for the backend of wordpress */
(function($)
{
	$(document).ready(function()
	{
        $('#the-list').sortable({
            update: function(event, ui) {
                
                // Get the new order of items
                var order = [];
                $('#the-list tr').each(function(){
                    var id = $(this).attr('id');
                    id = parseInt(id.replace('post-', ''));
                    order.push(id);
                });

                // Pass this new array of ordered post IDs back to our php
                var data = {
                    'action': 'attorney_profiles_post_order',
                    'order': order
                }
                $.post(php_data.ajax_url, data, function(response){
                    console.log(response);
                });
            }
        });
	});
})(jQuery);
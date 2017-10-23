/* Scripts for the backend of wordpress */
(function($)
{
	$(document).ready(function()
	{
        // Make the current color class active
        var current_color = $('input[name="post-color"]').val();
        $('.color-choice').each(function(){
            if ($(this).attr('data-value') == current_color)
                $(this).addClass('active');
        });

        // Handle selecting of colors
		$('.color-choice').click(function(){
            $('.color-choice').removeClass('active');
            var color = $(this).attr('data-value');
            $(this).addClass('active');
            $('input[name="post-color"]').val(color);
        });
        //Mirror typing in meta description
        $('#yoast_wpseo_metadesc').on('keyup', function(){
            $('#msd_description').val($(this).val());
        });
	});
})(jQuery);
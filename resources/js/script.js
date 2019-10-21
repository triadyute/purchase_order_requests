$(function(){
    $('#groups').on('change', function(){
        var val = $(this).val();
        var sub = $('#sub_groups');
        $('option', sub).filter(function(){
            if ($(this).attr('data-group') === val 
              || $(this).attr('data-group') === 'SHOW') {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });
    $('#groups').trigger('change');
});
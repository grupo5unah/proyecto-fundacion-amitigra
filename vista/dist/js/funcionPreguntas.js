window.onload = function(){
    $(document).on('change','.sel',function(){
      $(this).siblings().find('option[value="'+$(this).val()+'"]').remove();
    });
    
}
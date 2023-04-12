<link rel="stylesheet" href="<?=base_url(); ?>assets/resources/css/menu-desktop.css" media="none" onload="if(media!='all')media='all'">

<script src="<?=base_url(); ?>assets/resources/js/jquery.smartmenus.min.js"></script>

<script>
  $(function() 
  {
    var $mainMenuState = $('#main-menu-state');

    if ($mainMenuState.length) 
    {
      // animate mobile menu
      $mainMenuState.change(function(e) 
      {
        var $menu = $('#main-menu');
        
        if(this.checked)
          $menu.hide().slideDown(250, function() { $menu.css('display', ''); });
        else 
          $menu.show().slideUp(250, function() { $menu.css('display', ''); });
      });

      // hide mobile menu beforeunload
      $(window).on('beforeunload unload', function() 
      {
        if($mainMenuState[0].checked)
          $mainMenuState[0].click();
      });
    }
  });
</script>

<script>

  $(document).ready(function()
  {
    $('ul.dropdown-menu [data-toggle=dropdown]').on('click', function(event) 
    {
      event.preventDefault(); 
      event.stopPropagation(); 
      $(this).parent().siblings().removeClass('open');
      $(this).parent().toggleClass('open');
    });
  });

  var primera_barra = $('.div-header-main');

  $(window).scroll(function(event)
  {
    var primera_barra = $('.div-header-main');
    var st = $(this).scrollTop();  
    var el_menu = $('.incalake-menu');
    
    if(st > primera_barra.height())
      el_menu.addClass('menu_fixed')
    else 
      el_menu.removeClass('menu_fixed');
    
    temp_scroll=st;
  });

</script>
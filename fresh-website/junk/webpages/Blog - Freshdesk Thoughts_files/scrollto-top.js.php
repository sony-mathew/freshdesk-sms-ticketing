(function($) {
   var isTransitioned = true,
       transparent = 0,
       translucent = 0.3,
       opaque = 1;

   var fade = function() {
      if(isTransitioned) {
         isTransitioned = false;
         if(500 < $(document).scrollTop()) {
            $("#stt-gototop-0").show().fadeTo("slow", translucent, function() {
               isTransitioned = true;
            });
         } else {
            $("#stt-gototop-0").fadeTo("slow", transparent, function() {
               isTransitioned = true;
               $(this).hide();
            });
         }
      }
   }

   $(function() {
      $("body").each(function(i) {
         $(this).prepend('<a id="stt-top-' + i + '" class="stt-top">Top</a>\n<a href="#stt-top-' + i + '" id="stt-gototop-' + i + '" class="stt-gototop">Top of page</a>');
      });

      $(".stt-gototop").click(function() {
         $.scrollTo($($(this).attr('href')), 750);

         $(this).fadeOut();

         return false;
      });

      fade();
      $(document).scroll(fade);

      $(".stt-gototop").fadeTo(0, translucent);

      $(".stt-gototop").mouseover(function() {
         if(isTransitioned) {
            $(this).fadeTo("slow", opaque);
         }
      }).mouseout(function() {
         if(isTransitioned) {
            $(this).fadeTo("slow", translucent);
         }
      });
   });
})(jQuery);
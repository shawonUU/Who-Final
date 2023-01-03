  $(document).ready(function(){
  $(".togglediv-header-custom").click(function(){
   // self clicking close
   if($(this).next(".togglediv-body-custom").hasClass("active")){
     $(this).next(".togglediv-body-custom").removeClass("active").slideUp()
   }
 else{
   $(".togglediv-custom .togglediv-body-custom").removeClass("active").slideUp()
   $(this).next(".togglediv-body-custom").addClass("active").slideDown()
  }
  })
})

//Toggle global

    $(document).ready(function(){
    $(".togglediv-header").click(function(){
      console.log('Clicked');
     // self clicking close
     if($(this).next(".togglediv-body").hasClass("active")){
       $(this).next(".togglediv-body").removeClass("active").slideUp()
      $(this).children("span").removeClass("fa-minus").addClass("fa-plus")
     }
   else{
     $(".togglediv .togglediv-body").removeClass("active").slideUp()
     $(".togglediv .togglediv-header span").removeClass("fa-minus").addClass("fa-plus");
     $(this).next(".togglediv-body").addClass("active").slideDown()
      $(this).children("span").removeClass("fa-plus").addClass("fa-minus")
    }
    })
  })


    //Password eye button
    $(".toggle-password").click(function() {
    
    $(this).toggleClass("fa-eye fa-eye-slash");
    var input = $($(this).attr("toggle"));
    if (input.attr("type") == "password") {
      input.attr("type", "text");
    } else {
      input.attr("type", "password");
    }
    });

    $(".toggle-confirm-password").click(function() {
    
    $(this).toggleClass("fa-eye fa-eye-slash");
    var input = $($(this).attr("toggle"));
    if (input.attr("type") == "password") {
      input.attr("type", "text");
    } else {
      input.attr("type", "password");
    }
    });

    function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#imagePreview').css('background-image', 'url('+e.target.result +')');
            $('#imagePreview').hide();
            $('#imagePreview').fadeIn(650);
        }
        $("#avatar-btn").css('display','block');
        reader.readAsDataURL(input.files[0]);
    }
}

//Image upload (Profile image- user)
$("#imageUpload").change(function() {
    readURL(this);
});


// Tab-Pane change function
function tabChange(tab = 'description') {

    $('.cycle-tab-item').removeClass("active");
    $('.tab-pane').removeClass("active");
    if(tab == 'curriculum'){
    $('.tab2').addClass("active");
    $('.tab-content2').addClass("active in");
    } else if(tab == 'faq'){
    $('.tab3').addClass("active");
    $('.tab-content3').addClass("active in");
    }
    else{
      $('.tab1').addClass("active");
      $('.tab-content1').addClass("active in");
    }

// var tabs = $('.nav-tabs > li');
// var active = tabs.filter('.active');
// var next = active.next('li').length? active.next('li').find('a') : tabs.filter(':first-child').find('a');
// next.tab('show');
}

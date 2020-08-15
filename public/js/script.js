$(document).ready(function(){
    $('body').on('click', '.hamburger-menu', function(){
        let that = $(this)

        if(that.hasClass('open')){
            $('#nav-bottom').removeClass('active')
            that.removeClass('open')
        }
        else{
            $('#nav-bottom').addClass('active')
            that.addClass('open')
        }
    })

    $('body').on('click', '.contact', function(){
        $('#nav-bottom').removeClass('active')
        $('.hamburger-menu').removeClass('open')
    })
})

$(document).ready(function () {
    //Side Nav links Click
    $('.side-nav a').click(function () {
        $('.side-nav a').removeClass('active');
        $(this).addClass('active');
    });





    //Date & Time
    function showTime() {
        const date = new Date();
        let day = date.getDate();
        let month = date.getMonth() + 1;
        let year = date.getFullYear();
        let time = date.toLocaleTimeString();

        let currentDateTime = `${day}-${month}-${year} , ${time}`;
        $('#dateTime').text(currentDateTime);
        setTimeout(showTime, 1000);
    }
    showTime();



    //Show Name Field in Add-invoice form
    $('.add-invoice').on('submit', function (e) {
        var phoneNum = $('#phone-number').val();
        e.preventDefault();
        if (phoneNum !== null) {
            $('.name-input-group').show(300);
        }
    })

    //Show value input if check payment method
    $('.pay-method input[type="checkbox"]').on('click', function () {

        if ($(this).prop("checked") == true) {
            $(this).parents('.pay-method').find('.money').css("opacity", "1");
        } else {
            $(this).parent().find('.money').css("opacity", "0");
        }
    })

    //Show Value input in Buy-invoice page
    $('#payment-method').on('change', function () {
        var selectVal = $('#payment-method').val();
        if (selectVal === "cash")
            $('.amount').css("opacity", "1");
        else {
            $('.amount').css("opacity", "0");
        }
    })


    //Additional Recipes
    $('.additional li').on('click', function () {
        var target = $(this).data('target');
        $(target).show(300);
    })

    //Change Direction
    $('.top-nav .ar').click(function () {
        $('body').removeClass('ltr')
    })
    $('.top-nav .en').click(function () {
        $('body').addClass('ltr')
    })


    //Side Nav Toggler
    $('.side-nav-toggler').click(function () {
        $('.side-nav').toggleClass('opened');
    })
})
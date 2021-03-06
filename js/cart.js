$(function () {
    $.ajax({
            type: 'POST',
            url: 'php/cart.php',
            data: {
                action: "list"
            },
            success: function(response) {
//                alert(response);
                $('ul.dropdown-cart').html(response);
                $('.tag').text($('ul.dropdown-cart li').not('.text-xs-center').length);
//                $(response).appendTo('ul.dropdown-cart');
            }
        });
});

function addToCart(btn, id, img, name, price) {
        console.log(id + img + name + price);
        $.ajax({
            type: 'POST',
            url: 'php/cart.php',
            data: {
                action: 'add',
                id: id,
                img: img,
                name: name,
                price: price,
                quantity: 1
            },
            success: function(response) {
//                alert(response);
                $(btn).popover({
                    placement : 'top',
                    html: true,
                    content: '<img src="img/checked.png"/> Added to cart',
                    trigger: 'focus'
                });
                $(btn).popover('show');
                $('ul.dropdown-cart').html(response);
                $('.tag').text($('ul.dropdown-cart li').not('.text-xs-center').length);
//                $(btn).closest('figure').find('img').animate({right:100,bottom:100,width:0,height:0},500, function() {
//                    $(this).attr('style','');
//                    $(this).hide().delay(500).fadeIn(500);
//                });
            }
        });
    }
    
    function delFromCart(id) {
        console.log("del " + id);
        $.ajax({
            type: 'POST',
            url: 'php/cart.php',
            data: {
                action: 'del',
                id: id
            },
            success: function(response) {
//                alert(response);
                $('ul.dropdown-cart').html(response);
                $('.tag').text($('ul.dropdown-cart li').not('.text-xs-center').length);
//                $(response).appendTo('ul.dropdown-cart');
            }
        });
    }
var offset = 0;
var canUpdate = true;
var limit = 30;

$(document).ready(function() {
    updateProducts();
    updateCategories();
    $(window).scroll(function() {
        if($(window).scrollTop() + $(window).height() === $(document).height() && canUpdate) {
            updateProducts();
        }
    });
    $(document).on( 'click', '.add-cart', function() {
        addToCart($(this));
    });
    $(document).on( 'click', '#cart-trigger', function() {
        addToCart($(this));
    });
});

function updateProducts()
{
    $.ajax({
        url: 'ajax/get_products',
        data: {
            'offset': offset,
            'limit': limit,
        },
        type: 'post',
        context: document.body,
        beforeSend: function() {
            canUpdate = false;
        },
        success: function(products) {
            $('.products-listing').append(products);
            offset += limit;
            // to avoid spamming ajax requests
            setInterval(function () {
                canUpdate = true;
            }, 1000);
        },
    });
}

function updateCategories()
{
    $.ajax({
        url: 'ajax/get_categories',
        context: document.body,
        success: function(categories) {
            $('.categories').html(categories);
        }
    });
}

function updateCart()
{
    $.ajax({
        url: 'ajax/get_cart',
        context: document.body,
        success: function(cartData) {
            cartData = JSON.parse(cartData);
            $('#cart-count').text(cartData.length);
        }
    });
}

function addToCart(button)
{
    var sku = button.data('sku');
    var qty = $('#qty-'+sku).val();
    if (qty <= 0) {
        return false;
    }
    $.ajax({
        url: 'ajax/add_cart',
        data: {
            'sku': sku,
            'qty': qty,
        },
        type: 'post',
        context: document.body,
        beforeSend: function() {
            canUpdate = false;
        },
        success: function(products) {
            $('.products-listing').append(products);
            updateCart();
            window.alert('item added to cart');
            // wait for cart update
            setInterval(function () {
                canUpdate = true;
            }, 1000);
        },
    });
}
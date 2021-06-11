var csrftLarVe = $('meta[name="csrf-token"]').attr("content"),
    baseURL = $('meta[name="base-url"]').attr("content"),
    csrfmda = $('meta[name="csrf-mda"]').attr("content"),
    csrfmdac = $('meta[name="csrf-mdac"]').attr("content");

function loadShortNavCart() {
    var SHoppingCartJsonURL = baseURL + '/shoppingCart';
    $.ajax({
        'async': true,
        'type': "GET",
        'global': true,
        'dataType': 'json',
        'url': SHoppingCartJsonURL,
        'data': {
            '_token': csrftLarVe
        },
        'success': function(data) {
            loadMinTopCart(data);
        }
    });
}

loadShortNavCart();

function loadMinTopCart(data) {
    console.log(data);
    var obj = data;
    var specialItemPrice = 0;
    var tax_rate = $(".top-shopping-cart-short").attr('data-tax-amount');
    var tax = 0;
    if (tax_rate) {
        var tax_type = tax_rate.match(/%/g);
        if (tax_type == '%') {
            var actual_rate = parseFloat(tax_rate.replace("%", "")).toFixed(2);
            tax = parseFloat((obj.totalPrice * actual_rate) / 100).toFixed(2);
        } else {
            tax = parseFloat(tax_rate).toFixed(2);
        }
    }
    var discount = 0;
    var discount_rate = 0;
    var limit_check = 0;
    var limit_check = $(".top-shopping-cart-short").attr("data-disamount-limit");
    var discount_rate = $(".top-shopping-cart-short").attr("data-discount");
    if (obj.rec == "Collect") {
        var limit_check = $(".top-shopping-cart-short").attr("data-disamount-limit");
        var discount_rate = $(".top-shopping-cart-short").attr("data-discount");
    } else if (obj.rec == "Delivery") {
        var limit_check = $(".top-shopping-cart-short").attr("data-delivery-disamount-limit");
        var discount_rate = $(".top-shopping-cart-short").attr("data-delivery-discount");
    }
    var discount_rate = $(".top-shopping-cart-short").attr("data-discount");
    var discType = $(".top-shopping-cart-short").attr("data-disamount-type");
    if (discType == "Common") {
        var limit_check = $(".top-shopping-cart-short").attr("data-disamount-limit");
        var discount_rate = $(".top-shopping-cart-short").attr("data-discount");
    }
    if (discount_rate) {
        var discount_type = discount_rate.match(/%/g);
        if (discount_type == '%') {
            if (limit_check > 0 && (obj.totalPrice - specialItemPrice) < limit_check) {
                var amount_to_get_discount = limit_check - (obj.totalPrice - specialItemPrice);
                discount = '0.00';
            } else {
                var actual_discount_rate = parseFloat(discount_rate.replace("%", "")).toFixed(2);
                discount = parseFloat(((obj.totalPrice - specialItemPrice) * actual_discount_rate) / 100).toFixed(2);
            }
        } else {
            if (limit_check > 0 && (obj.totalPrice - specialItemPrice) < limit_check) {
                var amount_to_get_discount = limit_check - (obj.totalPrice - specialItemPrice);
                discount = '0.00';
            } else {
                discount = parseFloat(discount_rate).toFixed(2);
            }
        }
    }
    var extraDeliveryCharge = 0.00;
    if (obj.rec == "Delivery") {
        if (parseFloat(obj.totalPrice) >= parseFloat(csrfmda)) {
            extraDeliveryCharge = 0.00;
            console.log('extraDeliveryCharge=', extraDeliveryCharge);
        } else {
            if (parseFloat(obj.totalPrice) > 0) {
                extraDeliveryCharge = parseFloat(csrfmdac);
            } else {
                extraDeliveryCharge = 0.00;
            }
        }
    }

    var totalSubPrice = ((obj.totalPrice - 0) + (extraDeliveryCharge - 0) - tax) - discount;
    if (parseFloat(totalSubPrice) < 0) {
        totalSubPrice = 0;
    }
    var totalQty = obj.totalQty;
    if (parseFloat(totalQty) < 0) {
        totalQty = 0;
    }
    $(".top-shopping-cart-short").children("a").html(totalQty + " item(s) - £" + parseFloat(totalSubPrice).toFixed(2));
    if ($(".mobileCartMenuShortCartData")) {
        $(".mobileCartMenuShortCartData").html(totalQty + " item(s) - £" + parseFloat(totalSubPrice).toFixed(2));
    }
}
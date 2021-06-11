var csrftLarVe = $('meta[name="csrf-token"]').attr("content"),
    baseURL = $('meta[name="base-url"]').attr("content"),
    csrfmda = $('meta[name="csrf-mda"]').attr("content"),
    csrfmdac = $('meta[name="csrf-mdac"]').attr("content");

var specialItemID = "{{env('SPECIALSETMENUID')}}";

function upgradeCart(opt, itemID) {
    var item_id = itemID;
    $.ajax({
        'async': true,
        'type': "POST",
        'global': true,
        'dataType': 'json',
        'url': baseURL + 'addtocart/adjust',
        'data': {
            'opt': opt,
            'item_id': item_id,
            '_token': csrftLarVe
        },
        'success': function(data) {
            console.log("Processing : " + data);
        }
    });
}

function increasendecrease(item_id, item_index, inclusive, addtoCartURL) {
    $.ajax({
        'async': true,
        'type': "POST",
        'global': false,
        'dataType': 'json',
        'url': addtoCartURL,
        'data': { 'item_id': item_id, 'item_index': item_index, 'inclusive': inclusive, '_token': csrftLarVe },
        'success': function(data) {
            //loadCart(data);
            console.log('cart updated');
        }
    });
}

$(document).ready(function() {

    $("#scFoot").children("tr:eq(1)").fadeOut('fast');
    $("#scFoot").children("tr:eq(2)").fadeOut('fast');

    calculateShoppingCartSummary();
    $(".remove-item").click(function() {
        var RowIndex = $(this).parent().parent().attr("data-index");
        console.log(RowIndex);
        console.log('data removed');
        delRowLi(RowIndex);
    });
    $(".fa-plus-circle").click(function() {
        var RowID = $(this).parent().parent().attr("id");
        var RowPID = $(this).parent().parent().attr("data-id");
        var RowIndex = $(this).parent().parent().attr("data-index");
        var RowExec = $(this).parent().parent().attr("data-exec");
        var inclusive = 1;
        console.log(RowIndex);
        var QTY = $("#" + RowID).find("input").val();
        var newQTY = (QTY - 0) + (1 - 0);
        if (newQTY < 0) {
            newQTY = 0;
        }

        $("#" + RowID).find("input").val(newQTY);
        calculateShoppingCart(newQTY, RowID);

        upgradeCart('+', RowID);

        var addtoCartURL = baseURL + '/order-item/increase-to-cart';
        increasendecrease(RowPID, RowIndex, inclusive, addtoCartURL);
    });

    $(".fa-minus-circle").click(function() {
        var RowID = $(this).parent().parent().attr("id");
        var RowPID = $(this).parent().parent().attr("data-id");
        var RowIndex = $(this).parent().parent().attr("data-index");
        var RowExec = $(this).parent().parent().attr("data-exec");
        var inclusive = 1;
        var QTY = $("#" + RowID).find("input").val();
        var newQTY = (QTY - 1);
        if (newQTY < 0) {
            newQTY = 0;
        }

        $("#" + RowID).find("input").val(newQTY);
        calculateShoppingCart(newQTY, RowID);
        upgradeCart('-', RowID);

        var addtoCartURL = baseURL + '/order-item/deduct-to-cart';
        increasendecrease(RowPID, RowIndex, inclusive, addtoCartURL);
    });
});

function delRowLi(rowID) {
    $.ajax({
        'async': false,
        'type': "POST",
        'global': false,
        'dataType': 'json',
        'url': baseURL + '/order-item/delete-to-cart',
        'data': {
            'lid': rowID,
            '_token': csrftLarVe
        },
        'success': function(data) {
            console.log('Item Removed');
        }
    });

    //$("#" + liID).remove();
}

function calculateShoppingCart(newQTY, RowID) {
    var pr = $("#" + RowID).children("td:eq(2)").children("span").html();
    var prTotal = parseFloat(pr * newQTY).toFixed(2);
    $("#" + RowID).children("td:eq(4)").children("span").html(prTotal);
    calculateShoppingCartSummary();
}

function calculateShoppingCartSummary() {
    var pr = $("#scTab").find("tr");
    var total = 0;
    var specialItemPrice = 0;
    var totalQT = 0;
    $.each(pr, function(key, row) {
        console.log("data-cid", $(row).attr("data-cid"));
        var ptr = $(row).children("td:eq(4)").children("span").html();
        var ptrQT = $(row).children("td:eq(3)").children("input").val();
        total += (ptr - 0);
        totalQT += (ptrQT - 0);
    });

    $.each(pr, function(key, row) {
        var cid = $(row).attr("data-cid");
        if (specialItemID == cid) {
            var ptr = $(row).children("td:eq(4)").children("span").html();
            specialItemPrice += (ptr - 0);
        }
    });
    $("#scFoot").children("tr:eq(0)").children("td:eq(1)").children("span").html(parseFloat(total).toFixed(2));
    var tax_rate = $(".top-shopping-cart-short").attr('data-tax-amount');
    var tax = 0;
    if (tax_rate) {
        var tax_type = tax_rate.match(/%/g);
        if (tax_type == '%') {
            var actual_rate = parseFloat(tax_rate.replace("%", "")).toFixed(2);
            tax = parseFloat((total * actual_rate) / 100).toFixed(2);
            $(".page_tax_rate").html(tax_rate);
        } else {
            tax = parseFloat(tax_rate).toFixed(2);
            $(".page_tax_rate").html(tax_rate);
        }
    }

    if (tax_rate > 0) {
        $("#scFoot").children("tr:eq(1)").fadeIn('slow');
        $("#scFoot").children("tr:eq(1)").children("td:eq(1)").children("span").html(parseFloat(tax).toFixed(2));
    } else {
        $("#scFoot").children("tr:eq(1)").fadeOut('slow');
    }

    var discount = 0;
    var discount_rate = 0;
    var limit_check = 0;
    var limit_check = $(".top-shopping-cart-short").attr("data-disamount-limit");
    var discount_rate = $(".top-shopping-cart-short").attr("data-discount");
    var discType = $(".top-shopping-cart-short").attr("data-disamount-type");
    if (rec == "Collect") {
        var limit_check = $(".top-shopping-cart-short").attr("data-disamount-limit");
        var discount_rate = $(".top-shopping-cart-short").attr("data-discount");
    } else if (rec == "Delivery") {
        var limit_check = $(".top-shopping-cart-short").attr("data-delivery-disamount-limit");
        var discount_rate = $(".top-shopping-cart-short").attr("data-delivery-discount");
    }

    if (discType.trim() == "Common") {
        var limit_check = $(".top-shopping-cart-short").attr("data-disamount-limit");
        var discount_rate = $(".top-shopping-cart-short").attr("data-discount");
    }


    if (discount_rate) {
        var discount_type = discount_rate.match(/%/g);
        if (discount_type == '%') {
            if (limit_check > 0 && (total - specialItemPrice) < limit_check) {
                var amount_to_get_discount = limit_check - (total - specialItemPrice);
                discount = '0.00';
            } else {
                var actual_discount_rate = parseFloat(discount_rate.replace("%", "")).toFixed(2);
                discount = parseFloat(((total - specialItemPrice) * actual_discount_rate) / 100).toFixed(2);
            }
        } else {
            if (limit_check > 0 && (total - specialItemPrice) < limit_check) {
                var amount_to_get_discount = limit_check - (total - specialItemPrice);
                discount = '0.00';
            } else {
                discount = parseFloat(discount_rate).toFixed(2);
            }
        }
    }

    var discType = $(".top-shopping-cart-short").attr("data-disamount-type");
    var discDelType = $(".top-shopping-cart-short").attr("data-delivery-disamount-type");
    var allowDiscount = false;
    if (discType == "Collection" && rec == "Collect") {
        allowDiscount = true;
    } else if (discType == rec) {
        allowDiscount = true;
    } else if (discType == "Common" && (rec == "Collect" || rec == "Delivery")) {
        allowDiscount = true;
    } else if (discType && discDelType && rec == "Collect") {
        allowDiscount = true;
    } else if (discType && discDelType && rec == "Delivery") {
        allowDiscount = true;
    }
    var discount_rate = $(".top-shopping-cart-short").attr("data-discount");
    if (discType && discDelType && rec == "Collect") {
        var discount_rate = $(".top-shopping-cart-short").attr("data-discount");
    } else if (discType && discDelType && rec == "Delivery") {
        var discount_rate = $(".top-shopping-cart-short").attr("data-delivery-discount");
    }

    if (discount > 0) {
        $("#scFoot").children("tr:eq(2)").fadeIn('slow');
        $("#scFoot").children("tr:eq(2)").children("td:eq(1)").children("span").html(parseFloat(discount).toFixed(2));
    } else {
        $("#scFoot").children("tr:eq(2)").fadeOut('slow');
    }


    var extraDeliveryCharge = 0.00;
    if (rec == "Delivery") {
        if (parseFloat(total - specialItemPrice) >= parseFloat(csrfmda)) {
            $("#scFoot").children("tr:eq(3)").children('td:eq(1)').children('span').html(extraDeliveryCharge);
            $("#scFoot").children("tr:eq(3)").hide();
            extraDeliveryCharge = 0.00;
            console.log('extraDeliveryCharge=', extraDeliveryCharge);
        } else {
            if (parseFloat(total - specialItemPrice) > 0) {
                $("#scFoot").children("tr:eq(3)").show();
                extraDeliveryCharge = parseFloat(csrfmdac);
                $("#scFoot").children("tr:eq(3)").children('td:eq(1)').children('span').html(extraDeliveryCharge);
                console.log('extraDeliveryCharge=', extraDeliveryCharge);
            } else {
                $("#scFoot").children("tr:eq(3)").children('td:eq(1)').children('span').html(extraDeliveryCharge);
                $("#scFoot").children("tr:eq(3)").hide();
                extraDeliveryCharge = 0.00;
                console.log('extraDeliveryCharge=', extraDeliveryCharge);
            }

        }
    }

    console.log(total, discount, tax, discount_rate, tax_rate, specialItemPrice);
    var netPayable = ((total - 0) + (extraDeliveryCharge - 0) + (tax - 0) - discount);
    $("#scFoot").children("tr:eq(4)").children("td:eq(1)").children("span").html(parseFloat(netPayable).toFixed(2));

    $(".top-shopping-cart-short").children("a").html(totalQT + " item(s) - £" + parseFloat(netPayable).toFixed(2));
}
function ajaxRequestForm(url, form, onSuccess) {
    let formData = new FormData(form[0]);
    $.ajax({
        url: url,
        type: "POST",
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: onSuccess,
        error: function (xhr, textStatus, errorThrow){
            alert(errorThrow);
        }
    });
}
function ajaxRequest(url, data, onSuccess) {
    $.ajax({
        url: url,
        type: "POST",
        data: data,
        success: onSuccess,
        error: function (xhr, textStatus, errorThrow){
            alert(errorThrow);
        }
    });
}
function onSuccess(response) {
    response = JSON.parse(response);
    if (response.Error != ''){
        $(".message").html(response.Error);
    }
    if (response.Success != ''){
        $(".message").html(response.Success);
    }
    if (response.TableBought != ''){
        $(".product-append").html(response.TableBought);
    }
    if (response.TableBoughtSales != ''){
        $(".sales-append").html(response.TableBoughtSales);
    }
    if (response.Total != ''){
        $(".sales-append-footer").html(response.Total);
    }
}
$(document).ready(function () {
    const form = $("form"),
    formBtn = $("#submit");
    form.onsubmit = (e)=>{
        e.preventDefault();
    }
    formBtn.click(function (event){
        event.preventDefault();
        ajaxRequestForm('inc/product-submit.php', form, onSuccess);
    });
    
});

$(document).ready(function (){
    // product qty section
    let $qty_minus = $(".quantity .minus button");
    let $qty_plus = $(".quantity .plus button");
// let $input = $(".qty .input-number");

// click on qty up button
    $qty_plus.click(function(e){
        let $input = $(`.quantity .input-number[data-id='${$(this).data("id")}']`);
        if($input.val() >= 1){
            $input.val(function(i, oldval){
                return ++oldval;
            });
        }

        });
// click on qty up button
    $qty_minus.click(function(e){
        let $input = $(`.quantity .input-number[data-id='${$(this).data("id")}']`);
        if($input.val() > 1){
            $input.val(function(i, oldval){
                return --oldval;
            });
        }
        });
    });
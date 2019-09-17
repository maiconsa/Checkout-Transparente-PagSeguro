
$("#credit-payment-form").on('submit',function (e) {
e.preventDefault();

var errorDiv =  $("#error-div");
errorDiv.attr('style','visibility: hidden');

var cardNumber = $("#cardNumber");
var cardBrand = $("#brand");
var cardCvv = $("#cardCodeCvv");
var expiMonth = $("#expirationMonth");
var expiYear = $("#expirationYear");

PagSeguroGetCardToken(cardNumber.val(),cardBrand.val(),cardCvv.val(),expiMonth.val(),expiYear.val());
});

$("#selectInstallments").on('change', function () {
$( "#selectInstallments option:selected" ).each(function(index,object) {
    if(object.value == '-1'){
        $("#installmentQuantity").val('-1');
        $("#installmentValue").val('-1');
    }else {
        var values = object.value.split('x');
        $("#installmentQuantity").val(values[0]);
        $("#installmentValue").val(values[1]);
    }

});
}).change();

function  getSessionIdFromBackend(){
$.ajax({
url: "session",
success:function (response) {
    PagSeguroDirectPayment.setSessionId(response);
},
fail:function(response){
    console.log('Erro ao obter PagSeguroSessionID' + response);
},
method : 'POST'
})
}

function PagSegureGetInstallments(amount,brand){
PagSeguroDirectPayment.getInstallments({
amount: amount,
maxInstallmentNoInterest: 3,
brand: brand,
success: function(response){
    var installments = response.installments[brand];
    var selectInstallments = $('#selectInstallments');
    selectInstallments .attr('style','visibility: visible');
    selectInstallments.html(" ");
    selectInstallments.append('<option value="-1" selected> Select the installments</option>');
    $.each(installments,function (index,object) {
       var juros = ((object.interestFree == false) ? ' com juros' : ' sem juros');
       var valueInstallment = parseFloat(object.installmentAmount).toFixed(2);
        selectInstallments.append('<option value="'+object.quantity+'x'+valueInstallment+'"> ' +object.quantity +' vezes '+valueInstallment+ juros+'</option>');
    })
},
error: function(response) {
},
complete: function(response){
}
});


}



function PagSeguroGetSenderHash(){
PagSeguroDirectPayment.onSenderHashReady(function(response){
if(response.status == 'error') {
    setMessageError(response.message);
    return false;
}
var hash = response.senderHash; //Hash estará disponível nesta variável.
 $("#senderHash").val(response.senderHash);

 var args = $("#credit-payment-form").serialize();
$.ajax({
    url:'/credit',
    method:'POST',
    processData:false,
    dataType:'text',
    responseType:'application/xml',
    data:args,
    success: function (response) {
        console.log(response);
    },fail: function (response) {
        console.log(response);
    }

});

});
}

function setMessageError(errors){
var errorDiv =  $("#error-div");
errorDiv.attr('style','visibility: visible');
$.each(errors,function () {
errorDiv.append(this+'<br/>');
})
}
function PagSeguroGetCardToken(number,brand,cvv,expirationMonth,expirationYear){
PagSeguroDirectPayment.createCardToken({
cardNumber: number, // Número do cartão de crédito
brand:brand , // Bandeira do cartão
cvv: cvv, // CVV do cartão
expirationMonth: expirationMonth, // Mês da expiração do cartão
expirationYear: expirationYear, // Ano da expiração do cartão, é necessário os 4 dígitos.
success: function(response) {
    $("#tokenCard").val(response.card.token);
    PagSeguroGetSenderHash();
},
error: function(response) {
    setMessageError(response.errors);

},
complete: function(response) {
    // Callback para todas chamadas.
}
});
}

function PagSeguroGetBrand(number){
var tamanho = number.length;
if(tamanho  < 6){
$("#brandImage").attr('src','views/res/img/empty_brand.png');
$("#brand").val(' ');
$('#selectInstallments').attr('style','visibility: hidden');
}else{
var bin  = number.substring(0,6);
PagSeguroDirectPayment.getBrand({
    cardBin: bin,
    success: function(response) {
        var brand = response.brand.name;
        $("#brandImage").attr('src','https://stc.pagseguro.uol.com.br/public/img/payment-methods-flags/68x30/'+brand+'.png');
        $("#brand").val(brand);
        $.ajax({
            url:'/cart/totalAmount',
            method:'POST',
            success: function (response) {
                var totalAmount = response;
                PagSegureGetInstallments(totalAmount,brand);
            }
        });

    },
    error: function(response) {
        $("#brandImage").attr('src','views/res/img/empty_brand.png');
        $("#brand").val(' ');

    },
    complete: function(response) {
    }
});

}
}

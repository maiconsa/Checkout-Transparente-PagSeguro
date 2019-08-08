<?php if(!class_exists('Rain\Tpl')){exit;}?><h3>Payment with Credit Card </h3>
<form method="post" action="" id="credit-payment-form">
    <div class="form-row">
        <div class="form-group col">
            <label for="cardNumber">Card Number</label>
            <input type="text"  maxlength="16" class="form-control"  id="cardNumber" value="4111111111111111">
        </div>
        <div class="form-group col-lx-1 ">
            <label for="cardNumber">Brand</label>
            <img class="form-control"   src="views/res/img/empty_brand.png" id="brandImage" disabled placeholder="Bandeira"/>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col">
            <label for="cardName">Sender Name</n></label>
            <input type="text" class="form-control" id="cardName" name="creditCardHolderName" placeholder="Nome cartão" value="Comprador Teste">
        </div>
        <div class="form-group col-lx-2">
            <label for="cardCpf">CPF</n></label>
            <input type="text" class="form-control" id="cardCpf" name="creditCardHolderCPF" placeholder="CPF cartão" value="22111944785">
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-lx-5">
            <label for="bithDate">Birth Date</n></label>
            <input type="date" class="form-control" id="bithDate" name="creditCardHolderBirthDate" value="1987-10-27" placeholder="Birth Date" >
        </div>

        <div class="form-group col-lx-2">
            <label for="cardAreaCode">Area Code</n></label>
            <input type="number" value="11" class="form-control" id="cardAreaCode" maxlength="2" name="creditCardHolderAreaCode" placeholder="Area Code" >
        </div>
        <div class="form-group col">
            <label for="cardPhone">Phone</n></label>
            <input type="number" class="form-control" id="cardPhone" maxlength="9" name="creditCardHolderPhone" placeholder="Phone "  value="56273440">
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col">
            <label for="expirationMonth">Exp. Month</n></label>
            <input type="text" class="form-control" maxlength="2"  id="expirationMonth" value="12">
        </div>
        <div class="form-group col">
            <label for="expirationYear">Exp. Year</n></label>
            <input type="text" class="form-control"  maxlength="4"   id="expirationYear" value="2030">
        </div>
        <div class="form-group col">
            <label for="cardCodeCvv">CVV</n></label>
            <input type="text" class="form-control" id="cardCodeCvv" value="123">
        </div>
    </div>
    <div >
        <select  id="selectInstallments"   style="visibility: hidden"  class="browser-default  custom-select col">
            <option selected> Select the installments</option>
        </select>
    </div>
    <br/>
    <input type="hidden" name="creditCardToken" id="tokenCard" value="-1">
    <input type="hidden" name="installmentQuantity" value="-1" id="installmentQuantity"/>
    <input type="hidden" name="installmentValue" value="-1" id="installmentValue"/>
    <input type="hidden" name="senderHash" id="senderHash" value="-1">
    <input type="hidden" name="brand" id="brand" value="" />
    <button type="submit" class="btn btn-primary" id="continueButton">Kepp With Payment</button>


</form>
<br/>
<div class="alert alert-danger" id="error-div" role="alert" style="visibility: hidden">
</div>

<script type="text/javascript">

        $(document).ready(function () {
                getSessionIdFromBackend();
                var cardNumber = $("#cardNumber");
                cardNumber.keyup(function () {
                        PagSeguroGetBrand(cardNumber.val());
                })


        });

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
            method : 'POST'
        });
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
                url:'/credit/transaction',
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


</script>
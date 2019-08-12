<?php if(!class_exists('Rain\Tpl')){exit;}?>

        <div class="container">
            <div class="row"><h3>Payment Methods</h3></div>
                 <div class="row">
                            <div class="col">
                                <div class="form-check">
                                    <a class="btn btn-primary" href="/boleto"   id="boleto" >
                                        Boleto
                                    </a>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-check">
                                    <a class="btn btn-primary"  href="/credit"  id="credito" checked>
                                        Crédito</a>
                                </div>
                            </div>
                            <div class="col">
                                    <div class="form-check">
                                        <a class="btn btn-primary"  href="/debit"  id="debito"  >Débito</a>
                                    </div>
                </div>
    
        </div>

        </div>
         
            <div class="container" id="all-payments">
            </div>


<br/>

<script type="text/javascript">
    $(document).ready(function(){
        $.ajax({
            url: "session",
            success:function (response) {
                console.log(response);
                PagSeguroDirectPayment.setSessionId(response);
                PagSeguroGetPaymentMethods(500);
            },
            method : 'POST'
        });
    });

    function PagSeguroGetPaymentMethods(amount){
            PagSeguroDirectPayment.getPaymentMethods({
                amount: amount,
                success: function(response) {
                    var creditCard = response.paymentMethods.CREDIT_CARD.options;
                    var acceptPayments =   $('#all-payments');
                    acceptPayments.append('<br/>Bandeiras aceitas cartão de crédito');
                    acceptPayments.append('<br/>');
                    $.each(creditCard,function(){
                        var path = 'https://stc.pagseguro.uol.com.br' + this.images.MEDIUM.path;
                        acceptPayments.append("<img src="+path+" />");

                    });

                    var debitOnline = response.paymentMethods.ONLINE_DEBIT.options;
                    acceptPayments.append('<br/>Bandeiras aceitas com débito online');
                    acceptPayments.append('<br/>');
                    $.each(debitOnline,function () {
                        var path = 'https://stc.pagseguro.uol.com.br' + this.images.MEDIUM.path;+
                            acceptPayments.append("<img src="+path+" />");
                    });

                    acceptPayments.append('<br/>Boleto');
                    acceptPayments.append('<br/>');
                    var boleto = response.paymentMethods.BOLETO.options;
                    var path = 'https://stc.pagseguro.uol.com.br' + boleto.BOLETO.images.MEDIUM.path;
                        acceptPayments.append("<img src="+path+" />");


                },
                error: function(response) {
                    // Callback para chamadas que falharam.
                },
                complete: function(response) {
                    // Callback para todas chamadas.
                }
            });

    }

</script>






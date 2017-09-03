$(document).ready(function () {
    $('#payment-check-all').click(function () {
        $('.payment-checkbox').prop('checked', this.checked);    
    });

    $('#create-new-payment').click(function() {
        location.href = '/payment/create';
    });

    $('#split-payments').click(function() {
        let paymentIds = getPaymentIds();
        if (paymentIds.length == 0) {
            flash('You need to select the payments first.', 'warning');
        } else {
            $("#group-split-payment-modal #paymentIds").val(paymentIds);
            $("#group-split-payment-modal").modal();
        }
    });

    getPaymentIds = function() {
        let paymentCheckbox = document.querySelectorAll('.payment-checkbox:checked');

        let paymentIds = [];
        paymentCheckbox.forEach(
            function(element) {
                paymentIds.push(element.value);
            }
        )
        return paymentIds;
    }
});
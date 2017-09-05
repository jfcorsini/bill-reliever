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

    $(".delete-payment-button").click(function () {
        var element = this;
        let paymentId = element.dataset.paymentId;
        let token = element.dataset.token;
        $.ajax({
            url: '/payment/' + paymentId,
            method: 'POST',
            data: {
                _method: 'delete',
                _token: token
            },
            success: function(result) {
                flash('Payment was deleted!');
                element.parentElement.parentElement.remove()
            },
            error: function() {
                flash('There was an error do delete this payment.', 'danger');
            }
        });
    });

    $(".see-bill-button").click(function () {
        let billId = this.dataset .billId;
        $.ajax({
            url: '/bill/' + billId,
            success: function(result) {
                $("#bill-modal").modal();
                $("#bill-modal .modal-body").html(result);
            },
            error: function() {
                flash('There was a problem to show this bill.', 'danger');
            }
        });
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
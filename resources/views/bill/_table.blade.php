<div class="table-responsive">
    <table class="table table-striped table-bordered" id="payment-table">
        <thead>
            <tr>
                <th>Paying</th>
                <th>Receiving</th>
                <th>Value</th>
                <th>Paid</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $transaction)
            <tr>
                <td class="col-md-4">
                    <a href="/user/{{$transaction['debtor']['user']['id']}}">
                        {{ $transaction['debtor']['user']['name'] }}
                    </a>
                </td>
                <td class="col-md-4">
                    <a href="/user/{{ $transaction['creditor']['user']['id']}}">
                        {{ $transaction['creditor']['user']['name'] }}
                    </a>
                </td>
                <td class="col-md-3"> R$ {{ (string) $transaction['value'] }}</td>
                <td class="col-md-1">
                    @if ($transaction['paid'])
                        <button class="btn btn-success btn-xs"><i class="fa fa-thumbs-up "></i></button>
                    @else
                        <button class="btn btn-danger btn-xs pay-transaction-button" data-transaction-id="{{$transaction['id']}}"><i class="fa fa-thumbs-down"></i></button>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
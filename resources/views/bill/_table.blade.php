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
                <td class="col-md-4">{{ $members[$transaction->debtor] }}</td>
                <td class="col-md-4">{{ $members[$transaction->creditor] }}</td>
                <td class="col-md-3"> R$ {{ (string) $transaction->value }}</td>
                <td class="col-md-1">
                    @if ($transaction->paid)
                        <button class="btn btn-success btn-xs"><i class="fa fa-thumbs-up "></i></button>
                    @else
                        <button class="btn btn-danger btn-xs"><i class="fa fa-thumbs-down"></i></button>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
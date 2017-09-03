<div class="modal face" id="group-split-payment-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Splitting payments</h4>
            </div>
            <div class="modal-body">
                <form action="/payment/split" method="POST" class="smart-form">
		            {{ csrf_field() }}

                    <div class="form-group">
                        <label for="identifier">Identifier</label>
                        <input type="text" class="form-control" id="identifier" name="identifier" placeholder="Payments of August 2017">
                    </div>

                    <label for="name">Users splitting</label>

                    @foreach($members as $member)
                        <div class="checkbox">
                            <label><input type="checkbox" name="memberIds[{{ $member->id }}]" value="{{ $member->id }}" checked> {{ $member->user->name }} </label>
                        </div>
                    @endforeach

                    <input type="hidden" name="paymentIds" id="paymentIds">
                    <input type="hidden" name="groupId" value="{{ $group->id }}">

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Split</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal face" id="group-users-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Users</h4>
            </div>
            <div class="modal-body">
                <ul>
                    @foreach($users as $user)
                        <li>
                            <a href="/user/{{$user->id}}">
                                {{ $user->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
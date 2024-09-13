<div class="modal fade" id="possible_diseases_modal">
    <div class="modal-dialog modal-lg" >
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Possible Diseases</h5>
            </div>
            <div class="modal-body">
                <div class="container">
                    <ul class="list-group" >
                        @foreach($possible_diseases as $possible_disease)
                            <li class="list-group-item" >{{$possible_disease->disease->name}}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal" >Close</button>
            </div>
        </div>
    </div>
</div>

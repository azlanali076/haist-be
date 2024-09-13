<div class="modal fade" id="create_symptom_modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('symptoms.store') }}" method="post">
                <div class="modal-header">
                    <h5 class="modal-title">Create Symptom</h5>
                </div>
                <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <label for="category_id">Category</label>
                        <select name="category_id" id="category_id" class="form-control" required>
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mt-2">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" >Cancel</button>
                    <button type="submit" class="btn btn-success" >Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

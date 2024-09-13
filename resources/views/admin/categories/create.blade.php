<div class="modal fade" id="create_category_modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('categories.store') }}" method="post">
                <div class="modal-header">
                    <h5 class="modal-title">Create Category</h5>
                </div>
                <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <label for="category_type">Category Type</label>
                        <select name="category_type" id="category_type" class="form-control" required>
                            <option value="">Select Type</option>
                            <option >{{ \App\Models\Category::SYMPTOM_TYPE }}</option>
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

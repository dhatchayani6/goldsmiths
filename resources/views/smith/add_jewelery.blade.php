@include('smith.smithhome')

<div id="content-wrapper">
    <div class="container mt-4">
        <h1 class="mb-4">Add New Jewelry</h1>

        <!-- Jewelry Form -->
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <form method="POST" action="{{ route('jewel.store') }}" enctype="multipart/form-data">
                            @csrf
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="jewelryName">Jewelry Name</label>
                                    <input type="text" class="form-control" id="jewelryName" name="jewelryName"
                                        placeholder="Enter jewelry name" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="jewelryType">Jewelry Type</label>
                                    <select class="form-control" id="jewelryType" name="jewelryType" required>
                                        <option value="">Select type</option>
                                        <option value="Necklace">Necklace</option>
                                        <option value="Ring">Ring</option>
                                        <option value="Bracelet">Bracelet</option>
                                        <option value="Earrings">Earrings</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="jewelryWeight">Weight (in grams)</label>
                                    <input type="number" class="form-control" id="jewelryWeight" name="jewelryWeight"
                                        placeholder="Enter weight" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="jewelryPrice">Price</label>
                                    <input type="number" class="form-control" id="jewelryPrice" name="jewelryPrice"
                                        placeholder="Enter price" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="jewelryDescription">Description</label>
                                <textarea class="form-control" id="jewelryDescription" name="jewelryDescription" rows="3"
                                    placeholder="Enter jewelry description"></textarea>
                            </div>

                            <div class="form-group">
                                <label for="jewelryImage">Upload Image</label>
                                <input type="file" class="form-control-file" id="jewelryImage" name="jewelryImage" accept="image/*">
                            </div>
                            
                            <button type="submit" class="btn btn-primary">Add Jewelry</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add jQuery and AJAX script here or in a separate JS file -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $('form').on('submit', function (e) {
            e.preventDefault(); // Prevent default form submission

            var formData = new FormData(this);

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                contentType: false, // Important
                processData: false, // Important
                success: function (response) {
                    alert('Jewelry added successfully!');
                    $('form')[0].reset();
                },
                error: function (xhr) {
                    var errors = xhr.responseJSON.errors;
                    var errorHtml = '<ul>';
                    $.each(errors, function (key, value) {
                        errorHtml += '<li>' + value[0] + '</li>';
                    });
                    errorHtml += '</ul>';

                    $('.alert').remove();
                    $('<div class="alert alert-danger">' + errorHtml + '</div>').insertBefore('form');
                }
            });
        });
    });
</script>

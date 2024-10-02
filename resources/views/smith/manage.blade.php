<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Jewels</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        body {
            background-color: #f4f4f4;
            font-family: sans-serif;
        }

        .card {
            transition: transform 0.2s;
            border-radius: 12px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .card:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            cursor: pointer;
        }

        .card-img-top {
            height: 200px;
            object-fit: cover;
        }

        .card-body {
            text-align: center;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .container {
            max-width: 1410px;
        }
        footer{
            position: fixed;
            bottom: 0;
        }
    </style>
</head>

<body>
    @include('smith.navabr')

    <div class="container mt-4">
        <h1 class="text-center">Manage Your Jewels Here</h1>
        <h2 class="mt-4 text-center">Your Jewels</h2>
        <div class="row" id="jewel-container">
            <!-- Jewels will be dynamically inserted here -->
        </div>
    </div>

    <!-- Pagination Links -->
    <div id="pagination-links" class="d-flex justify-content-center mt-3">
        {{ $manageJewels->links() }}
    </div>

    @include('home.footer')

    <!-- Edit Jewel Modal -->
    <div class="modal fade" id="editJewelModal" tabindex="-1" role="dialog" aria-labelledby="editJewelModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editJewelModalLabel">Edit Jewel</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editJewelForm" enctype="multipart/form-data">
                        <input type="hidden" name="jewel_id">
                        <div class="form-group">
                            <label for="jewel-name">Name</label>
                            <input type="text" class="form-control" name="name" id="jewel-name" required>
                        </div>
                        <div class="form-group">
                            <label for="jewel-description">Description</label>
                            <input type="text" class="form-control" name="description" id="jewel-description" required>
                        </div>
                        <div class="form-group">
                            <label for="jewel-price">Price</label>
                            <input type="number" class="form-control" name="price" id="jewel-price" required>
                        </div>
                        <div class="form-group">
                            <label for="jewel-type">Type</label>
                            <input type="text" class="form-control" name="type" id="jewel-type" required>
                        </div>
                        <div class="form-group">
                            <label for="jewel-image">Image</label>
                            <input type="file" class="form-control-file" name="image" id="jewel-image">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="saveJewelBtn">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>

    <script>
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Load jewels when the page is ready
            loadJewels();

            function loadJewels(page = 1) {
                $.ajax({
                    url: `{{ route('fetchjewel') }}?page=${page}`,
                    type: 'GET',
                    success: function (response) {
                        $('#jewel-container').empty();
                        if (response.success && Array.isArray(response.data)) {
                            response.data.forEach(function (jewel) {
                                $('#jewel-container').append(`
                                    <div class="col-md-3 mb-4">
                                        <div class="card">
                                            <img src="${jewel.jewel_image}" class="card-img-top" alt="${jewel.name}">
                                            <div class="card-body">
                                                <h5 class="card-title">${jewel.name}</h5>
                                                <p class="card-text">${jewel.description}</p>
                                                <p class="card-text"><strong>Price: $${jewel.price}</strong></p>
                                                <div class="mt-auto">
                                                    <button class="btn btn-primary edit-jewel" data-id="${jewel.id}">Edit</button>
                                                    <button class="btn btn-danger delete-jewel" data-id="${jewel.id}">Delete</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                `);
                            });

                            $('#pagination-links').html(response.links);
                            bindPagination();
                            bindEditDelete();
                        } else {
                            console.error('Error: response.data is not an array or response.success is false');
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('AJAX Error: ', status, error);
                    }
                });
            }

            function bindPagination() {
                $('.pagination a').click(function (e) {
                    e.preventDefault();
                    const page = $(this).attr('href').split('page=')[1];
                    loadJewels(page);
                });
            }

            function bindEditDelete() {
                $('.edit-jewel').click(function () {
                    const jewelId = $(this).data('id');
                    editJewel(jewelId);
                });

                $('.delete-jewel').click(function () {
                    const jewelId = $(this).data('id');
                    deleteJewel(jewelId);
                });
            }

            function editJewel(id) {
                $.ajax({
                    url: `/jewel/edit/${id}`,
                    type: 'GET',
                    success: function (response) {
                        if (response.success) {
                            $('#editJewelModal input[name="name"]').val(response.data.name);
                            $('#editJewelModal input[name="description"]').val(response.data.description);
                            $('#editJewelModal input[name="price"]').val(response.data.price);
                            $('#editJewelModal input[name="type"]').val(response.data.type);
                            $('#editJewelModal input[name="jewel_id"]').val(response.data.id);
                            $('#editJewelModal').modal('show');
                        } else {
                            alert('Failed to fetch jewel data for editing.');
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('Error fetching jewel for edit:', error);
                        alert('Failed to fetch jewel data for editing.');
                    }
                });
            }

            function deleteJewel(id) {
                if (confirm('Are you sure you want to delete this jewel?')) {
                    $.ajax({
                        url: `/jewel/delete/${id}`,
                        type: 'DELETE',
                        success: function (response) {
                            if (response.success) {
                                alert('Jewel deleted successfully!');
                                loadJewels(); // Reload the jewels
                            } else {
                                alert('Failed to delete the jewel.');
                            }
                        },
                        error: function (xhr, status, error) {
                            console.error('Error deleting jewel:', error);
                            alert('An error occurred while trying to delete the jewel.');
                        }
                    });
                }
            }

            $('#saveJewelBtn').click(function () {
                const formData = new FormData($('#editJewelForm')[0]);
                const jewelId = $('#editJewelModal input[name="jewel_id"]').val();

                $.ajax({
                    url: `/jewel/update/${jewelId}`,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        if (response.success) {
                            $('#editJewelModal').modal('hide');
                            alert('Jewel updated successfully!');
                            loadJewels(); // Reload the jewels after updating
                        } else {
                            alert('Failed to update the jewel.');
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('Error updating jewel:', error);
                        const errors = xhr.responseJSON.errors || {};
                        for (const key in errors) {
                            alert(`${key}: ${errors[key].join(', ')}`);
                        }
                    }
                });
            });
        });
    </script>
</body>

</html>

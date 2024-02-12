<?php
include('header.php');
include('check_session.php');
?>

<div class="container mt-5">
    <h2 class="mb-4">List News</h2>
    <table id="newsTable" class="table table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Title</th>
                <th>Description</th>
                <th>Image</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

<!-- Axios JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
var table = null;

function initTable(initData) {
    table = $('#newsTable').DataTable({
        "data": initData,
        "processing": true,
        "serverSide": false,
        "paging": true,
        "lengthMenu": [10, 25, 50],
        "pageLength": 10,
        "columns": [{
                "data": "no"
            },
            {
                "data": "title"
            },
            {
                "data": "desc"
            },
            {
                "data": "img",
                "render": function(data, type, row) {
                    return '<img src="' + data +
                        '" alt="Image" style="max-width: 100px; max-height: 100px;">';
                }
            },
            {
                "data": null,
                "render": function(data, type, row, meta) {
                    return '<div class="btn-group">' +
                        "<button class='btn btn-danger btn-sm' style='margin-right: 5px;' data-index='" +
                        meta.row + "' onclick='deleteNews(" + row.id + ")'>Delete</button>" +
                        '<form action="edit.php" method="post">' +
                        '<input type="hidden" name="id" value="' + row.id + '" >' +
                        '<button type="submit" class="btn btn-primary btn-sm">Edit</button>' +
                        '</form>' +
                        '</div>';
                }
            }
        ]
    });
}

$(document).ready(function() {
    axios.get('https://ireniusbonanproject.000webhostapp.com/konfigurasi/listnews.php', {
            params: {
                key: ''
            }
        })
        .then(function(response) {
            var data = response.data;
            data.forEach(function(row, index) {
                row.no = index + 1;
                data[index] = row;
            });

            initTable(response.data);
        })
        .catch(function(error) {
            console.log('error', error);
            alert('Error Fetching news data');
        });
});

function deleteNews(id) {
    var formData = new FormData();
    formData.append('idnews', id);

    if (confirm('Are you sure you want to delete this idnews?')) {
        axios.post('https://ireniusbonanproject.000webhostapp.com/konfigurasi/deletenews.php', formData)
            .then(function(response) {
                alert(response.data);
                $('#newsTable').DataTable().ajax.reload();
            })
            .catch(function(error) {
                console.error(error);
                alert('Error delete news');
            });
    }
}
</script>

<?php include 'footer.php'; ?>
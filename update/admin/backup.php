<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="product.css">

</head>
<body class="bg-light">
    <div class="container-fluid">
        <div class="row">
            <?php include 'sidenavbar.html'; ?>
        </div>
    </div>
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <header class="px-2 py-3 mb-4" style="background-color: #800000 !important ;">
            <h2 class="logo text-light p-1" id="company-name">Garahe Food House</h2>
        </header>
        <div class="container">
            <div class="table-responsive">
                <div class="d-flex justify-content-end mb-3 me-4">
                    <button type="button" class="button" id="btnAddNewProduct">
                    <span class="button__text">Add Item</span>
                    <span class="button__icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" viewBox="0 0 24 24" stroke-width="2" stroke-linejoin="round" stroke-linecap="round" stroke="currentColor" height="24" fill="none" class="svg"><line y2="19" y1="5" x2="12" x1="12"></line><line y2="12" y1="12" x2="19" x1="5"></line></svg></span>
                    </button>
                </div>
                <table class="border border-1 border-dark" id="tableProduct">
                    <thead class="text-light" style="background-color: #800000 !important ;">
                        <tr>
                            <th>ID</th>
                            <th>Stocks</th>
                            <th>Quantity</th>
                            <th>Product Name</th>
                            <th>Product Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="border-dark">
                        
                    </tbody>
                </table>
            </div>
        </div>
    </main>
    <footer class="fixed-bottom text-center" style="background-color: #800000 !important ;">
        <div class="text-light" id="copyright">
            <script>document.write(new Date().getFullYear())</script> &copy; All right reserved to the developers of the system.</a> 
        </div>    
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#tableProduct').DataTable({
                "ordering": true,
                "order": [[0, "desc"]],
                "language": {
                    "sortAsc": "<i class='bi bi-sort-alpha-down'></i>",
                    "sortDesc": "<i class='bi bi-sort-alpha-up-alt'></i>"
                },
            });
        });
    </script>
</body>
</html>
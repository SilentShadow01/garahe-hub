<?php 
    include 'addProduct.php';
    session_start();
    if (!isset($_SESSION['admin_name']))
    {
        // Redirect to login page
        echo "<script>window.location.href='../index.php';</script>";
        exit();
    }
?>
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
    <style>
        .font-num {
            font-family: "Times New Roman", Times, serif;
        }
    </style>
</head>
<body style="background-color: #C08261;">
    <header class="navbar sticky-top flex-md-nowrap p-2 shadow" style="background-color: #800000 !important ;">
        <h2 class="logo text-light p-1" id="company-name">Garahe Food House</h2>
    </header>
    <div class="container-fluid">
        <div class="row">
            <?php include 'sidenavbar.php'; ?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4" style="background-color: #F2E8C6;">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom border-dark">
                    <h1 class="h2" id="currentPage"><i class="fa-solid fa-file-signature"></i>&nbsp Products</h1>
                </div>
                <div class="table-responsive mb-5">
                    <div class="d-flex justify-content-end mb-3 me-4">
                        <button class="text-decoration-none" href="#" data-bs-toggle="modal" data-bs-target="#addProductModal" id="btnAddNewProduct">
                            <span class="button__text">Add Product</span>
                            <span class="button__icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" viewBox="0 0 24 24" stroke-width="2" stroke-linejoin="round" stroke-linecap="round" stroke="currentColor" height="24" fill="none" class="svg"><line y2="19" y1="5" x2="12" x1="12"></line><line y2="12" y1="12" x2="19" x1="5"></line></svg></span>
                        </button>
                    </div>
                    <table class="rounded border border-1 border-secondary" id="tableProduct">
                        <thead class="text-light" style="background-color: #800000 !important ;">
                            <tr>
                                <th class="border border-secondary font-num">ID</th>
                                <th class="border border-secondary font-num">Product Name</th>
                                <th class="border border-secondary font-num">Price</th>
                                <th class="border border-secondary font-num">Category</th>
                                <th class="border border-secondary font-num"></th>
                            </tr>
                        </thead>
                        <tbody class="border border-secondary">
                            <?php
                                include '../assets/connection.php';

                                $query = "SELECT * FROM product_tbl";
                                $result = mysqli_query($conn, $query);

                                if (mysqli_num_rows($result) > 0)
                                {
                                    while ($row = mysqli_fetch_assoc($result))
                                    {
                                        $name = $row['productName'];
                                        $imageName = $row['productImage'];
                                        $imagePath = "images/products/" . $imageName; 
                                        ?>
                                        <tr>
                                            <td class="border border-secondary font-num"> <?= $row['productID'] ?> </td>
                                            <td class="border border-secondary font-num"> <?= $row['productName'] ?> </td>
                                            <td class="border border-secondary font-num">₱<?= $row['productPrice'] ?> </td>
                                            <td class="border border-secondary font-num">
                                                <?php
                                                    if($row['productCategory'] === 'mainCourse')
                                                    {
                                                        echo 'Main Course';
                                                    }
                                                    else if($row['productCategory'] === 'beverages')
                                                    {
                                                        echo 'Beverages';
                                                    }
                                                    else if($row['productCategory'] === 'sides')
                                                    {
                                                        echo 'Sides';
                                                    }
                                                ?>
                                            </td>
                                            </td>
                                            <td class="border border-secondary font-num">
                                                <a href="" class="btn btn-outline-dark d-flex justify-content-center" data-bs-toggle="modal" data-bs-target="#actionModal<?= $row['ID']; ?>" id="requestActionBtn">
                                                    <i class="fas fa-info-circle"></i>
                                                </a>
                                            </td>
                                            <!-- Modal -->
                                            <div class="modal fade" id="actionModal<?= $row['ID']; ?>" tabindex="-1" aria-labelledby="actionModal<?= $row['ID']; ?>Label" aria-hidden="true">
                                                <div class="modal-dialog modal-lg modal-dialog-centered">                                
                                                    <div class="modal-content">
                                                        <div class="modal-header" style="background-color: #952323;">
                                                            <h5 class="modal-title text-light" id="actionModal<?= $row['ID']; ?>Label">Product Information</h5>
                                                            <button type="button" class="btn-close bg-light" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body" style="background-color: #F2E8C6;">
                                                            <div class="container">
                                                                <div class="" id="message"></div>
                                                                <form method="POST">
                                                                    <div class="input-group mt-1">
                                                                        <strong class="text-light input-group-text border-dark col-4 font-num" style="background-color: #C08261;">Product ID</strong>
                                                                        <input type="text" class="form-control text-center border-dark font-num" id="editProductID" name="editProductID" value="<?= $row['productID']; ?>" readonly>
                                                                    </div>
                                                                    <div class="input-group mt-1">
                                                                        <strong class="text-light input-group-text border-dark col-4 font-num" style="background-color: #C08261;">Product Name</strong>   
                                                                        <input type="text" class="form-control text-center border-success font-num" id="editProductName" name="editProductName" value="<?= $row['productName']; ?>"> 
                                                                    </div>
                                                                    <!-- <div class="input-group mt-1">
                                                                        <strong class="text-light input-group-text border-dark col-4" style="background-color: #C08261;">Product Description</strong>    
                                                                        <input type="text" class="form-control text-center border-success" id="productDescription" name="productDescription" value="<?= $row['productDescription']; ?>">
                                                                    </div> -->
                                                                    <div class="input-group mt-1">
                                                                        <strong class="text-light input-group-text border-dark col-4 font-num" style="background-color: #C08261;">Price</strong> 
                                                                        <input type="number" class="form-control text-center border-success font-num" id="editProductPrice" name="editProductPrice" value="<?= $row['productPrice']; ?>" min="0">   
                                                                    </div>
                                                                    <div class="input-group mt-1">
                                                                        <strong class="text-light input-group-text border-dark col-4 font-num" style="background-color: #C08261;">Status </strong> 
                                                                        <select class="form-control text-center border-success font-num" name="productCategory" id="productCategory" type="text" value="<?= $row['productCategory']; ?>">
                                                                            <option value="mainCourse" class="bg-info text-dark" <?= $row['productCategory'] == 'mainCourse' ? 'selected' : '' ?>>Main Course</option>
                                                                            <option value="sides" class="bg-info text-dark" <?= $row['productCategory'] == 'sides' ? 'selected' : '' ?>>Sides</option>
                                                                            <option value="beverages" class="bg-info text-dark" <?= $row['productCategory'] == 'beverages' ? 'selected' : '' ?>>Beverages</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="input-group mt-1">
                                                                        <strong class="text-light input-group-text border-dark col-4 font-num" style="background-color: #C08261;">Status </strong> 
                                                                        <select class="form-control text-center border-success font-num" name="editProductStatus" id="editProductStatus" type="text" value="<?= $row['productType']; ?>">
                                                                            <option value="product" class="bg-info text-dark" <?= $row['productType'] == 'product' ? 'selected' : '' ?>>Product</option>
                                                                            <option value="featured" class="bg-warning text-danger" <?= $row['productType'] == 'featured' ? 'selected' : '' ?>>Featured</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="input-group mt-1">
                                                                        <strong class="text-light input-group-text border-dark col-4 font-num" style="background-color: #C08261;">Product Image</strong> 
                                                                            <img src="<?php echo $imagePath; ?>" alt="<?php echo $name; ?>" class="form-control text-center border-dark" alt="No Product Image" height="200px">
                                                                    </div>
                                                                    <div class="modal-footer bg-dark-tertiary btn-group">
                                                                        <button type="submit" class="btn btn-danger delete-btn font-num" name="deleteProductBtn"><i class="fas fa-trash"></i>&nbsp Delete</button>
                                                                        <button type="submit" class="btn btn-success font-num" name="editRequestBtn"><i class="fas fa-save"></i>&nbsp Save</button>
                                                                        <button type="button" class="btn btn-danger font-num" data-bs-dismiss="modal"><i class="fas fa-times"></i>&nbsp Close</button>
                                                                    </div>   
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> 
                                            <!-- END MODAL -->
                                        </tr>
                                    <?php }
                                }
                                else
                                { ?>
                                <?php }
                            ?>
                        </tbody>
                    </table>
                </div>
                <!-- STATIC ADD PRODUCT MODAL -->
                    <div class="modal fade" id="addProductModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content">
                            <div class="modal-header" style="background-color: #952323;">
                                <h1 class="modal-title fs-5 text-light" id="addProductModalLabel">New Product</h1>
                                <button type="button" class="btn-close bg-light" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body" style="background-color: #F2E8C6;">
                                <form class="row g-3" method="POST" enctype="multipart/form-data">
                                    <div class="form-header text-center">
                                        <strong class="form-label fs-5" id="productInfo">PRODUCT INFORMATION</strong>
                                    </div>
                                    <div class="form-group mt-1 text-center text-light mt-3">
                                        <?php
                                            if(isset($error))
                                            {
                                                foreach($error as $error)
                                                {
                                                    echo '<span class="bg-danger p-2 rounded">'.$error.'</span>';
                                                };
                                            };
                                        ?>
                                        <?php
                                            if(isset($success))
                                            {
                                                foreach($success as $success)
                                                {
                                                    echo '<span class="bg-success p-2 rounded">'.$success.'</span>';
                                                };
                                            };
                                        ?>
                                    </div>
                                    <?php
                                        function generateProductID() {
                                            $prefix = "PRDCT";
                                            $randomDigits = str_pad(mt_rand(0, 9999), 4, '0', STR_PAD_LEFT);
                                            return $prefix . $randomDigits;
                                        }                            
                                    ?>
                                    <div class="col-md-6">
                                        <strong for="productID" class="form-label">Product ID<span class="text-danger"> * </span></strong>
                                        <input type="text" class="form-control border-success" id="productID" name="productID" value="<?php echo generateProductID(); ?>" readonly>
                                    </div>
                                    <div class="col-md-6 mt-3">
                                        <strong for="productName" class="form-label">Product Name<span class="text-danger"> * </span></strong>
                                        <input type="text" class="form-control border-success" id="productName" name="productName" required>
                                    </div>
                                    <!-- <div class="col-md-6">
                                        <strong for="productDescription" class="form-label">Product Description<span class="text-danger"> * </span></strong>
                                        <input type="text" class="form-control border-success" id="productDescription" name="productDescription" required>
                                    </div> -->
                                    <div class="col-md-6">
                                        <strong for="productPrice" class="form-label">Product Price<span class="text-danger"> * </span></strong>
                                        <input type="number" class="form-control border-success" id="productPrice" name="productPrice" required>
                                    </div>
                                    <div class="col-md-6">
                                        <strong for="productStatus" class="form-label">Category<span class="text-danger"> * </span></strong>
                                        <select id="productStatus" class="form-select border-success" name="productCategory" required>
                                            <option selected disabled></option>
                                            <option value="mainCourse">Main Course</option>
                                            <option value="sides">Sides</option>
                                            <option value="beverages">Beverages</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <strong for="productStatus" class="form-label">Product Status<span class="text-danger"> * </span></strong>
                                        <select id="productStatus" class="form-select border-success" name="productStatus" required>
                                            <option selected disabled></option>
                                            <option value="product">Product</option>
                                            <option value="featured">Featured</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <strong class="form-label" for="productImage">Product Image<span class="text-danger"> * </span></strong>
                                        <input type="file" class="form-control border-success" id="productImage" name="productImage" required>      
                                    </div>
                                    <div class="mt-5 d-flex justify-content-center">
                                        <button id="createProduct" name="createProduct" type="submit">Create New Product</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- END STATIC MODAL -->
            </main>
            <footer class="fixed-bottom text-center" style="background-color: #800000 !important ;">
                <div class="text-light" id="copyright">
                    <script>document.write(new Date().getFullYear())</script> &copy; All right reserved to the developers of the system.</a> 
                </div>    
            </footer>
        </div>
    </div>
    
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
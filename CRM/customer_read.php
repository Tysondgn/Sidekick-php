<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer List - Sidekick CRM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="p-4">
        <a href="index.html" style="height: auto; width: 20px; ">
            <button class="btn btn-dark rounded-pill">
                Menu </button>
        </a>
        <a href="customer_add.php" style="height: auto; width: 20px; ">
            <button class="btn btn-dark rounded-pill">
                Add </button>
        </a>
    </div>
    <div class="container mt-2">
        <h1 class="text-center mb-4">Customer List</h1>
        <div class="mb-3">
            <input type="text" id="searchBar" class="form-control" placeholder="Search customers...">
        </div>

        <div class="accordion" id="accordionExample">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        Filter
                    </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <!-- filter start -->
                        <div class="row mb-3">
                            <div class="col-md-2">
                                <select id="filterLastContacted" class="form-control">
                                    <option value="">Last Contacted</option>
                                    <!-- Options for filtering -->
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select id="filterSalesRep" class="form-control">
                                    <option value="">Sales Rep</option>
                                    <!-- Options for filtering -->
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select id="filterStatus" class="form-control">
                                    <option value="">Status</option>
                                    <!-- Options for filtering -->
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select id="filterContactPreference" class="form-control">
                                    <option value="">Contact Preference</option>
                                    <!-- Options for filtering -->
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select id="filterRevenue" class="form-control">
                                    <option value="">Revenue</option>
                                    <!-- Options for filtering -->
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select id="filterCompanySize" class="form-control">
                                    <option value="">Company Size</option>
                                    <!-- Options for filtering -->
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select id="filterIndustry" class="form-control">
                                    <option value="">Industry</option>
                                    <!-- Options for filtering -->
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select id="filterCustomerType" class="form-control">
                                    <option value="">Customer Type</option>
                                    <!-- Options for filtering -->
                                </select>
                            </div>
                        </div>
                        <!-- filter end -->
                    </div>
                </div>
            </div>
        </div>



        <div id="customerList" class="table-responsive" style="height: 600px;">
            <!-- Customer data will be dynamically inserted here -->
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script>
        $(document).ready(function () {
            function fetchCustomers() {
                let query = $("#searchBar").val();
                let filters = {
                    last_contacted: $("#filterLastContacted").val(),
                    sales_rep: $("#filterSalesRep").val(),
                    status: $("#filterStatus").val(),
                    contact_preference: $("#filterContactPreference").val(),
                    revenue: $("#filterRevenue").val(),
                    company_size: $("#filterCompanySize").val(),
                    industry: $("#filterIndustry").val(),
                    customer_type: $("#filterCustomerType").val()
                };

                $.ajax({
                    url: "fetch_customers.php",
                    method: "POST",
                    data: { query: query, filters: filters },
                    success: function (data) {
                        $("#customerList").html(data);
                    }
                });
            }

            $("#searchBar").on("input", fetchCustomers);
            $("select").on("change", fetchCustomers);

            fetchCustomers(); // Initial fetch
        });
    </script>
</body>

</html>
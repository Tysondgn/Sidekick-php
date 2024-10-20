<?php
require ('dbconn.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $business_name = $_POST['business_name'];
    $owner_name = $_POST['owner_name'];
    $meeting_purpose = $_POST['meeting_purpose'];
    $business_type = $_POST['business_type'];
    $unique_selling_product = $_POST['unique_selling_product'];
    $phone_contact_1 = $_POST['phone_contact_1'];
    $phone_contact_2 = $_POST['phone_contact_2'];
    $business_location = $_POST['business_location'];
    $address = $_POST['address'];
    $website_url = $_POST['website_url'];
    $business_card = $_POST['business_card'];
    $email = $_POST['email'];
    $customer_type = $_POST['customer_type'];
    $industry = $_POST['industry'];
    $company_size = $_POST['company_size'];
    $annual_revenue = $_POST['annual_revenue'];
    $lead_source = $_POST['lead_source'];
    $contact_preference = $_POST['contact_preference'];
    $notes = $_POST['notes'];
    $status = $_POST['status'];
    $assigned_sales_rep = $_POST['assigned_sales_rep'];
    $last_contacted = $_POST['last_contacted'];

    $sql = "INSERT INTO customer (
                business_name, owner_name, meeting_purpose, business_type, 
                unique_selling_product, phone_contact_1, phone_contact_2, 
                business_location, address, website_url, business_card, email, 
                customer_type, industry, company_size, annual_revenue, lead_source, 
                contact_preference, notes, status, assigned_sales_rep, last_contacted
            ) VALUES (
                '$business_name', '$owner_name', '$meeting_purpose', '$business_type', 
                '$unique_selling_product', '$phone_contact_1', '$phone_contact_2', 
                '$business_location', '$address', '$website_url', '$business_card', '$email', 
                '$customer_type', '$industry', '$company_size', '$annual_revenue', '$lead_source', 
                '$contact_preference', '$notes', '$status', '$assigned_sales_rep', '$last_contacted'
            )";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sidekick CRM</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body class="bg1">
    <div class="p-4">
        <a href="index.html" style="height: auto; width: 20px; ">
            <button class="btn btn-dark rounded-pill">
                Menu </button>
        </a>
        <a href="customer_read.php" style="height: auto; width: 20px; ">
            <button class="btn btn-dark rounded-pill">
                View </button>
        </a>
    </div>
    <div class="container mt-3">
        <h1 class="text-center mb-4">Sidekick CRM</h1>
        <form action="" method="POST">
            <div class="form-group">
                <label for="business_name">Name of Business *</label>
                <input type="text" class="form-control" id="business_name" name="business_name"
                    placeholder="Name of Business" required>
            </div>
            <div class="form-group">
                <label for="owner_name">Name of Owner *</label>
                <input type="text" class="form-control" id="owner_name" name="owner_name" placeholder="Name of Owner"
                    required>
            </div>
            <div class="form-group">
                <label for="meeting_purpose">Meeting Purpose *</label>
                <input type="text" class="form-control" id="meeting_purpose" name="meeting_purpose"
                    placeholder="Meeting Purpose" required>
            </div>
            <div class="form-group">
                <label for="business_type">Business Type *</label>
                <input type="text" class="form-control" id="business_type" name="business_type"
                    placeholder="Business Type" required>
            </div>
            <div class="form-group">
                <label for="unique_selling_product">Unique Selling Product</label>
                <input type="text" class="form-control" id="unique_selling_product" name="unique_selling_product"
                    placeholder="Unique Selling Product">
            </div>
            <div class="form-group">
                <label for="phone_contact_1">Phone Contact 1 *</label>
                <input type="tel" class="form-control" id="phone_contact_1" name="phone_contact_1"
                    placeholder="Phone Contact 1" required>
            </div>
            <div class="form-group">
                <label for="phone_contact_2">Phone Contact 2</label>
                <input type="tel" class="form-control" id="phone_contact_2" name="phone_contact_2"
                    placeholder="Phone Contact 2">
            </div>
            <div class="form-group" hidden>
                <label for="business_location">Business Location</label>
                <input type="text" class="form-control" id="business_location" name="business_location"
                    placeholder="Business Location" >
            </div>
            <div class="form-group">
                <label for="address">Address *</label>
                <textarea class="form-control" id="address" name="address" placeholder="Address" required></textarea>
            </div>
            <div class="form-group">
                <label for="website_url">Website URL</label>
                <input type="text" class="form-control" id="website_url" name="website_url" placeholder="Website URL">
            </div>
            <div class="form-group">
                <label for="business_card">Business Card</label>
                <input type="text" class="form-control" id="business_card" name="business_card"
                    placeholder="Business Card">
            </div>
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Email Address">
            </div>
            <div class="form-group">
                <label for="customer_type">Customer Type</label>
                <input type="text" class="form-control" id="customer_type" name="customer_type"
                    placeholder="Customer Type (e.g., Prospect, Existing Customer, Former Customer)">
            </div>
            <div class="form-group">
                <label for="industry">Industry</label>
                <input type="text" class="form-control" id="industry" name="industry" placeholder="Industry">
            </div>
            <div class="form-group">
                <label for="company_size">Company Size</label>
                <input type="text" class="form-control" id="company_size" name="company_size"
                    placeholder="Company Size (e.g., Small, Medium, Large)">
            </div>
            <div class="form-group">
                <label for="annual_revenue">Annual Revenue</label>
                <input type="number" step="0.01" class="form-control" id="annual_revenue" name="annual_revenue"
                    placeholder="Annual Revenue">
            </div>
            <div class="form-group">
                <label for="lead_source">Lead Source</label>
                <input type="text" class="form-control" id="lead_source" name="lead_source"
                    placeholder="Lead Source (e.g., Website, Referral, Social Media)">
            </div>
            <div class="form-group">
                <label for="contact_preference">Contact Preference</label>
                <input type="text" class="form-control" id="contact_preference" name="contact_preference"
                    placeholder="Contact Preference (e.g., Email, Phone, SMS)">
            </div>
            <div class="form-group">
                <label for="notes">Notes</label>
                <textarea class="form-control" id="notes" name="notes" placeholder="Notes"></textarea>
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <input type="text" class="form-control" id="status" name="status"
                    placeholder="Status (e.g., Active, Inactive, Follow-Up)">
            </div>
            <div class="form-group">
                <label for="assigned_sales_rep">Assigned Sales Rep</label>
                <input type="text" class="form-control" id="assigned_sales_rep" name="assigned_sales_rep"
                    placeholder="Assigned Sales Rep">
            </div>
            <div class="form-group">
                <label for="last_contacted">Last Contacted</label>
                <input type="datetime-local" class="form-control" id="last_contacted" name="last_contacted"
                    placeholder="Last Contacted">
            </div>
            <div class="form-group text-center">
                <button type="submit" class="btn btn-lg btn-primary">Submit</button>
            </div>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
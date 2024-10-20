<?php
require('dbconn.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
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

    $sql = "UPDATE customer SET 
            business_name='$business_name', 
            owner_name='$owner_name', 
            meeting_purpose='$meeting_purpose', 
            business_type='$business_type', 
            unique_selling_product='$unique_selling_product', 
            phone_contact_1='$phone_contact_1', 
            phone_contact_2='$phone_contact_2', 
            business_location='$business_location', 
            address='$address', 
            website_url='$website_url', 
            business_card='$business_card', 
            email='$email', 
            customer_type='$customer_type', 
            industry='$industry', 
            company_size='$company_size', 
            annual_revenue='$annual_revenue', 
            lead_source='$lead_source', 
            contact_preference='$contact_preference', 
            notes='$notes', 
            status='$status', 
            assigned_sales_rep='$assigned_sales_rep', 
            last_contacted='$last_contacted' 
            WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        header("Location: customer_read.php");
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM customer WHERE id='$id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "No customer found";
    }
} else {
    echo "No customer ID provided";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Customer - Sidekick CRM</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center mb-4">Edit Customer</h1>
    <form action="edit_customer.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
        <div class="form-group">
            <label for="business_name">Name of Business</label>
            <input type="text" class="form-control" id="business_name" name="business_name" value="<?php echo $row['business_name']; ?>" required>
        </div>
        <div class="form-group">
            <label for="owner_name">Name of Owner</label>
            <input type="text" class="form-control" id="owner_name" name="owner_name" value="<?php echo $row['owner_name']; ?>" required>
        </div>
        <div class="form-group">
            <label for="meeting_purpose">Meeting Purpose</label>
            <input type="text" class="form-control" id="meeting_purpose" name="meeting_purpose" value="<?php echo $row['meeting_purpose']; ?>" required>
        </div>
        <div class="form-group">
            <label for="business_type">Business Type</label>
            <input type="text" class="form-control" id="business_type" name="business_type" value="<?php echo $row['business_type']; ?>" required>
        </div>
        <div class="form-group">
            <label for="unique_selling_product">Unique Selling Product</label>
            <input type="text" class="form-control" id="unique_selling_product" name="unique_selling_product" value="<?php echo $row['unique_selling_product']; ?>" required>
        </div>
        <div class="form-group">
            <label for="phone_contact_1">Phone Contact 1</label>
            <input type="tel" class="form-control" id="phone_contact_1" name="phone_contact_1" value="<?php echo $row['phone_contact_1']; ?>" required>
        </div>
        <div class="form-group">
            <label for="phone_contact_2">Phone Contact 2</label>
            <input type="tel" class="form-control" id="phone_contact_2" name="phone_contact_2" value="<?php echo $row['phone_contact_2']; ?>">
        </div>
        <div class="form-group">
            <label for="business_location">Business Location</label>
            <input type="text" class="form-control" id="business_location" name="business_location" value="<?php echo $row['business_location']; ?>" required>
        </div>
        <div class="form-group">
            <label for="address">Address</label>
            <textarea class="form-control" id="address" name="address" required><?php echo $row['address']; ?></textarea>
        </div>
        <div class="form-group">
            <label for="website_url">Website URL</label>
            <input type="text" class="form-control" id="website_url" name="website_url" value="<?php echo $row['website_url']; ?>">
        </div>
        <div class="form-group">
            <label for="business_card">Business Card</label>
            <input type="text" class="form-control" id="business_card" name="business_card" value="<?php echo $row['business_card']; ?>">
        </div>
        <div class="form-group">
            <label for="email">Email Address</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo $row['email']; ?>" required>
        </div>
        <div class="form-group">
            <label for="customer_type">Customer Type</label>
            <input type="text" class="form-control" id="customer_type" name="customer_type" value="<?php echo $row['customer_type']; ?>" required>
        </div>
        <div class="form-group">
            <label for="industry">Industry</label>
            <input type="text" class="form-control" id="industry" name="industry" value="<?php echo $row['industry']; ?>">
        </div>
        <div class="form-group">
            <label for="company_size">Company Size</label>
            <input type="text" class="form-control" id="company_size" name="company_size" value="<?php echo $row['company_size']; ?>">
        </div>
        <div class="form-group">
            <label for="annual_revenue">Annual Revenue</label>
            <input type="number" step="0.01" class="form-control" id="annual_revenue" name="annual_revenue" value="<?php echo $row['annual_revenue']; ?>">
        </div>
        <div class="form-group">
            <label for="lead_source">Lead Source</label>
            <input type="text" class="form-control" id="lead_source" name="lead_source" value="<?php echo $row['lead_source']; ?>">
        </div>
        <div class="form-group">
            <label for="contact_preference">Contact Preference</label>
            <input type="text" class="form-control" id="contact_preference" name="contact_preference" value="<?php echo $row['contact_preference']; ?>">
        </div>
        <div class="form-group">
            <label for="notes">Notes</label>
            <textarea class="form-control" id="notes" name="notes"><?php echo $row['notes']; ?></textarea>
        </div>
        <div class="form-group">
            <label for="status">Status</label>
            <input type="text" class="form-control" id="status" name="status" value="<?php echo $row['status']; ?>" required>
        </div>
        <div class="form-group">
            <label for="assigned_sales_rep">Assigned Sales Rep</label>
            <input type="text" class="form-control" id="assigned_sales_rep" name="assigned_sales_rep" value="<?php echo $row['assigned_sales_rep']; ?>">
        </div>
        <div class="form-group">
            <label for="last_contacted">Last Contacted</label>
            <input type="datetime-local" class="form-control" id="last_contacted" name="last_contacted" value="<?php echo $row['last_contacted']; ?>">
        </div>
        <div class="form-group text-center">
            <button type="submit" class="btn btn-lg btn-primary">Update</button>
        </div>
    </form>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

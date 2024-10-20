<?php
require('dbconn.php');

$query = isset($_POST['query']) ? $_POST['query'] : '';
$filters = isset($_POST['filters']) ? $_POST['filters'] : [];

$sql = "SELECT * FROM customer WHERE 1";

if ($query) {
    $sql .= " AND (business_name LIKE '%$query%' OR owner_name LIKE '%$query%' OR meeting_purpose LIKE '%$query%' OR business_type LIKE '%$query%' OR unique_selling_product LIKE '%$query%' OR phone_contact_1 LIKE '%$query%' OR phone_contact_2 LIKE '%$query%' OR business_location LIKE '%$query%' OR address LIKE '%$query%' OR website_url LIKE '%$query%' OR business_card LIKE '%$query%' OR email LIKE '%$query%' OR customer_type LIKE '%$query%' OR industry LIKE '%$query%' OR company_size LIKE '%$query%' OR lead_source LIKE '%$query%' OR contact_preference LIKE '%$query%' OR notes LIKE '%$query%' OR status LIKE '%$query%' OR assigned_sales_rep LIKE '%$query%')";
}

foreach ($filters as $key => $value) {
    if ($value) {
        $sql .= " AND $key = '$value'";
    }
}

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo '<table class="table table-bordered table-striped">';
    echo '<thead><tr><th>Business Name</th><th>Owner Name</th><th>Meeting Purpose</th><th>Business Type</th><th>Unique Selling Product</th><th>Phone Contact 1</th><th>Phone Contact 2</th><th>Business Location</th><th>Address</th><th>Website URL</th><th>Business Card</th><th>Email</th><th>Customer Type</th><th>Industry</th><th>Company Size</th><th>Annual Revenue</th><th>Lead Source</th><th>Contact Preference</th><th>Notes</th><th>Status</th><th>Assigned Sales Rep</th><th>Last Contacted</th><th>Actions</th></tr></thead>';
    echo '<tbody>';
    while($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td>'.$row["business_name"].'</td>';
        echo '<td>'.$row["owner_name"].'</td>';
        echo '<td>'.$row["meeting_purpose"].'</td>';
        echo '<td>'.$row["business_type"].'</td>';
        echo '<td>'.$row["unique_selling_product"].'</td>';
        echo '<td>'.$row["phone_contact_1"].'</td>';
        echo '<td>'.$row["phone_contact_2"].'</td>';
        echo '<td>'.$row["business_location"].'</td>';
        echo '<td>'.$row["address"].'</td>';
        echo '<td>'.$row["website_url"].'</td>';
        echo '<td>'.$row["business_card"].'</td>';
        echo '<td>'.$row["email"].'</td>';
        echo '<td>'.$row["customer_type"].'</td>';
        echo '<td>'.$row["industry"].'</td>';
        echo '<td>'.$row["company_size"].'</td>';
        echo '<td>'.$row["annual_revenue"].'</td>';
        echo '<td>'.$row["lead_source"].'</td>';
        echo '<td>'.$row["contact_preference"].'</td>';
        echo '<td>'.$row["notes"].'</td>';
        echo '<td>'.$row["status"].'</td>';
        echo '<td>'.$row["assigned_sales_rep"].'</td>';
        echo '<td>'.$row["last_contacted"].'</td>';
        echo '<td><a href="customer_update.php?id='.$row["id"].'" class="btn btn-sm btn-warning">Edit</a></td>';
        echo '</tr>';
    }
    echo '</tbody></table>';
} else {
    echo "No results found";
}

$conn->close();
?>

<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$name = $stock = $description = "";
$name_err = $stock_err = $description_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate name
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Please enter a name.";
    
    } else{
        $name = $input_name;
    }
    
    // Validate address
    $input_stock = trim($_POST["stock"]);
    if(empty($input_stock)){
        $stock_err = "Please enter stock.";     
    } else{
        $stock = $input_stock;
    }
    
    // Validate description
    $input_description = trim($_POST["description"]);
    if(empty($input_description)){
        $description_err = "Please enter the description .";     
    } else{
        $description = $input_description;
    }
    
    // Check input errors before inserting in database
    if(empty($name_err) && empty($stock_err) && empty($description_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO stock (name, stock, description ) VALUES (?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sss", $param_name, $param_stock, $param_description);
            
            // Set parameters
            $param_name = $name;
            $param_stock = $stock;
            $param_description = $description;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
                header("location: index.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Create Record</h2>
                    <p>Please fill this form and submit to add stock record to the database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                            <span class="invalid-feedback"><?php echo $name_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>stock</label>
                            <textarea name="stock" class="form-control <?php echo (!empty($stock_err)) ? 'is-invalid' : ''; ?>"><?php echo $stock; ?></textarea>
                            <span class="invalid-feedback"><?php echo $stock_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>description</label>
                            <input type="text" name="description" class="form-control <?php echo (!empty($description_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $description; ?>">
                            <span class="invalid-feedback"><?php echo $description_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
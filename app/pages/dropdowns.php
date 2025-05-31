<!-- <?php require "adminfunctions.php" ?> -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scalforme=1.0">
    <link rel="stylesheet" href="styles.css">

    <title>Cascading Dropdowns 3 levels</title>

</head>
<body>
<div class="page">
    <h3>Please select your Country, State and region</h3>
    <form name="my-form" action="" method="post">
        <select name="countries" onclick="getProvState(this.value)">
            <option value="">Choose a Country</option>

            <?php
                $countries = getCountries();
                foreach($countries as $country) {
                    ?>
                        <option value="<?php echo $country['country'] ?>"><?php echo $country['country_name'] ?></option>

                    <?php
                }

            ?>

        </select>

        <select name="provstate" disabled onclick="getRegions(this.value)">
            <option value="">Choose a Province/State</option>
        
        </select>

        <select name="regions" disabled>
            <option value="">Choose a Region</option>
        
        </select>
    
    </form>

</div>

<script src="script.js"></script>
    
</body>
</html>

<!-- <!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1"> -->
<!-- 
<?php //require page('includes/header');?>

<h1>Cascading Dropdown Example</h1>

<div class="container">
    <h3>Please select your Country, State and region</h3>
    <form name="my-form" action="" method="post">
        <select name="countries" onclick="getProvState(this.value)">
            <option value="">Choose a Country</option>

            <?php
                $countries = getCountries();
                foreach($countries as $country) {
                    ?>
                        <option value="<?php echo $country['country'] ?>"><?php echo $country['country_name'] ?></option>

                    <?php
                }
            ?>

        </select>

        <select name="provstate" disabled onclick="getRegions(this.value)">
            <option value="">Choose a Province/State</option>
        
        </select>

        <select name="regions" disabled>
            <option value="">Choose a Region</option>
        
        </select>
    
    </form>
</div>


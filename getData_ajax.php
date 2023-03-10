<form action="index.php" method="POST">
    <link href="../css/bootstrap.min.css" rel="stylesheet" />
    <link href="autopotstyles.css" rel="stylesheet" />
    <style>
        .statstext {
            font-family: "Fjalla One";
            font-size: 5vh;
        }
        .statstitle {
            font-size: 2.1vh;
        }
        .card {
            height: 18vh;
            width: 15vw;
            margin: 2vh 2vh;
            overflow: auto;
            min-width: fit-content;
        }
    </style>
    <?php
            include_once('connects.php');

            $query = "SELECT * FROM `status` ORDER BY id DESC LIMIT 1";
            $check=mysqli_query($con,$query);
            $row=mysqli_num_rows($check);

            if($check == FALSE) {
                echo ".".$row.".";
            }
            $x = '';

            while($row=mysqli_fetch_array($check)) {
                if ($row['light_exp'] == 0){
                    $x = 'Shaded';
                }
                elseif ($row['light_exp'] >= 1){
                    $x = 'Bright';
                }
                echo "
                <div class='card-columns'>
                    <div class='card shadow border-0' id='tempCol'>
                        <div class='card-body' id='card1'>
                        <p class='card-title statstitle' align='left'>Temperature<p>
                        <p class='card-text statstext'>" . $row['temp'] . "°C</p>";
                    echo "</div>
                    </div>
                    <div class='card shadow border-0' id='humCol'>
                        <div class='card-body' id='card2'>
                        <p class='card-title statstitle' align='left'>Humidity<p>
                        <p class='card-text statstext'>" . $row['humidity'] . "%</p>";
                    echo "</div>
                    </div>
                    <div class='card shadow border-0' id='smCol'>
                        <div class='card-body' id='card3'>
                        <p class='card-title statstitle' align='left'>Soil Moisture<p>
                        <p class='card-text statstext'>" . $row['soil_mois'] . "%</p>";
                    echo "</div>
                    </div>
                    <div class='card shadow border-0' id='leCol'>
                            <div class='card-body' id='card4'>
                            <p class='card-title statstitle' align='left'>Light Exposure<p>
                            <p class='card-text statstext'>" . $x;
                    echo "</div>
                    </div>";
            }
    ?>
</form>

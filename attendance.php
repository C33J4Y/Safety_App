<!--attendance -->

<!DOCTYPE html>
<html>

<head>
    <?php
    require_once('db_connect.php');
    include 'includes/head.php';
    ?>
</head>
<body>
    <header>
        <?php include 'includes/navbar.php'; ?>
    </header>
    <div class="container">
        <?php
            // Oracle query to select from Student table
            $query = "SELECT s.fname, s.lname FROM student s WHERE s.tid = 100";
            $stid = oci_parse($conn, $query);
            oci_execute($stid);
            $row = oci_fetch_array($stid, OCI_ASSOC);
        ?>
        <form method='post' class='col-md-8 mt-5 pt-5 mx-auto w-75'>
            <table class="table">
                <tr>
                    
                </tr>


            </table>

            <?php
                while (($row = oci_fetch_array($stid, OCI_ASSOC)) != false) {
                    $fname = $row['FNAME'];
                    $lname = $row['LNAME'];
                    echo "<p><input type='checkbox' name='checklist[]' value='$fname $lname'/>$fname $lname<br>\n </p>";
                };
            ?>
            <p><input class='btn btn-primary btn-lg text-center textInput col-md-4' type='submit' name='submit' value='Submit' /></p>
        </form>
        <?php
            if (isset($_POST["submit"])) {
                if (!empty($_POST["checklist"])) {
                    echo '<h3>Students Accounted For:</h3>';
                    foreach ($_POST['checklist'] as $checklist) {
                        echo '<p>' . $checklist . '</p>';
                    }
                } else {
                    echo 'Please Select At Least One Student';
                }
            }
            // free query and close connection
            oci_free_statement($stid);
            oci_close($conn);
        ?>
    </div>
    <footer>
        <?php include 'includes/foot.php'; ?>
    </footer>
</body>
</html>
<!DOCTYPE html>
<html>

<head>
  <!-- LEAVE THIS-->
  <?php

  require_once('db_connect.php');
  include 'includes/head.php'; ?>

</head>

<script>
  $.get("includes/getSessionInfo.php", function(data) {
    document.getElementById('usrLvl').innerHTML = data.level;
    if (data.level == '1') {
      // Admin Level --- Show the table to change user level
      $('#adminSettings').show();
    } else if (data.level == '2') {
      // Teacher Level -- Only Show Name and Current Level
      $('#adminSettings').hide();
    } else {
      // Zero Level -- dont show anything
      $('#settings').hide();
    }

  }, 'json');
</script>

<body>

  <header>
    <!-- LEAVE THIS-->
    <?php include 'includes/navbar.php'; ?>
  </header>
  <div id='settings' style="width: 90%;
   
		height: 550px;
		margin: 0 auto;
		padding-top: 90px;
		padding-bottom: 10px;
        transition: height 0.66s ease-out;
        ">
    <div class="text-center">

      <b>
        <h2>Hi <?php echo ucfirst($_SESSION['username'])?></h2>
      </b>
      <h2>Level:<strong id='usrLvl'></strong></h2>

      <!--Admit Setting -->
      <form id="usrForm" method='post'>
        <div class="form-group">
          <div class="tbl-header">
            <table cellpadding="0" cellspacing="0" border="0">
              <thead class="tbl-header">
                <th class="text-center" scope="col">Name</th>
                <th class="text-center" scope="col">Current Level</th>
                <th class="text-center" scope="col">Update Level</th>

                </tr>
              </thead>
            </table>
          </div>
          <div class="tbl-content">
            <table class="table" cellpadding="0" cellspacing="0" border="0">
              <tbody class="tbl-content">
                <tr>
                  <?php

                  // oracle query
                  $query = "SELECT * FROM login";
                  $stid = oci_parse($conn, $query);
                  oci_execute($stid);
                  $row = oci_fetch_array($stid, OCI_ASSOC);
                  while (($row = oci_fetch_array($stid, OCI_ASSOC)) != false) {;
                    $name =  $row['USERNAME'];
                    $level = $row['USER_LVL'];

                    echo " 

                        <tr>
                        
                        <td class='text-center' ><label for='usrName[]'>$name</label></td> 
                        <input style='display:none' ype='text' name='usrName[]' value='$name'/>
                        <td class='text-center'>$level</td>
                        <td>    
                        <select name= 'lvl[]' class='form-control'>";
                        if($level == '0'){echo"
                          <option selected='selected' value='0'>0</option>
                          <option value='1'>1</option>
                          <option value='2'>2</option>";
                        }else if($level == '1'){
                          echo"
                          <option value='0'>0</option>
                          <option selected='selected' value='1'>1</option>
                          <option value='2'>2</option>";
                            
                        }else{
                          echo"
                          <option value='0'>0</option>
                          <option  value='1'>1</option>
                          <option selected='selected' value='2'>2</option>";
                        };
       

                      echo "
                      </select></td>
                      </tr>

                        
";
                  }
                  echo "            </tbody>
                 
                  </table>
              </div><input style='margin:45px;background-color:#308A20' class='btn btn-success' type='submit' name='submit' value='Submit' />
          </form>";  ?>
<script>
$("#usrForm").on('submit', function(event) {
 // alert('test')
});
</script>
                  <?php



                  
                  if (isset($_POST["submit"])) {
       
                      $name = $_POST['usrName'];
                      $lvl  = $_POST['lvl'];
                      $it = new MultipleIterator();
                      $it->attachIterator(new ArrayIterator($name));
                      $it->attachIterator(new ArrayIterator($lvl));
                      foreach ($it as $a) {
                        // This variable prints out the names
                        // echo $a[0] . "<br>";
                        // // This variable prints out the user level that has been entered 
                        // echo $a[1] . "<br><br>";
                        $query = "UPDATE login SET USER_LVL = '$a[1]' WHERE USERNAME = '$a[0]' ";
                        $stid = oci_parse($conn, $query);
                        oci_execute($stid);
                        if($stid){
                         // echo 'succes';

                          
                        }else{
                        //  echo 'failure';
                        }

                      }
                   
                      
                    } else {
                     // echo 'No Updates.';
                    }
                  

                  ?>





          </div>
        </div>




    </div>

    <script>
      // '.tbl-content' consumed little space for vertical scrollbar, scrollbar width depend on browser/os/platfrom. Here calculate the scollbar width .
      $(window).on("load resize ", function() {
        var scrollWidth = $('.tbl-content').width() - $('.tbl-content table').width();
        $('.tbl-header').css({
          'padding-right': scrollWidth
        });
      }).resize();
    </script>
    <style>
      h1 {
        font-size: 30px;
        color: black;
        text-transform: uppercase;
        font-weight: 300;
        text-align: center;
        margin-bottom: 15px;
      }

      table {
        width: 100%;
        table-layout: fixed;
        background-color: black;
      }

      .tbl-header {
        background-color: #567AA3;
      }

      .tbl-content {
        background-color: #253C57;
        height: 300px;
        overflow-x: auto;
        margin-top: 0px;
        border: 1px solid #567AA3;
      }

      th {
        padding: 20px 15px;
        text-align: left;
        font-weight: 500;
        font-size: 12px;
        color: #fff;
        text-transform: uppercase;
      }

      td {
        padding: 15px;
        text-align: left;
        vertical-align: middle;
        font-weight: 300;
        font-size: 12px;
        color: #fff;
        border-bottom: solid 1px #F0DA67;
      }


      /*update demo styles  */

      @import url(https://fonts.googleapis.com/css?family=Roboto:400,500,300,700);

      body {
        background: white;
        background: white;
        font-family: 'Roboto', sans-serif;
        overflow-x: none;
      }

      section {
        margin: 50px;
      }


      /* follow me template */
      .made-with-love {
        margin-top: 40px;
        padding: 10px;
        clear: left;
        text-align: center;
        font-size: 10px;
        font-family: arial;
        color: #fff;
      }

      .made-with-love i {
        font-style: normal;
        color: #F50057;
        font-size: 14px;
        position: relative;
        top: 2px;
      }

      .made-with-love a {
        color: #fff;
        text-decoration: none;
      }

      .made-with-love a:hover {
        text-decoration: underline;
      }


      /* for custom scrollbar for webkit browser*/

      ::-webkit-scrollbar {
        width: 6px;
      }

      ::-webkit-scrollbar-track {
        -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
      }

      ::-webkit-scrollbar-thumb {
        -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
      }
    </style>

    <footer>
      <!-- LEAVE THIS-->
      <?php include 'includes/foot.php'; ?>
    </footer>
</body>

</html>
<?php
include($_SERVER['DOCUMENT_ROOT'] . "/admin/system_config.php");
session_start();
if (isset($_SESSION['AdminLogin'])) {
} else {
  header("Location:" . SITEPATH . "admin/");
}
?>
<?php
$r = getuser_byID($_SESSION['AdminLogin']);
$user_id = $_SESSION['AdminLogin'];

function user_permission($link, $user_id)
{
  $sql = "SELECT * FROM `user_permission` where `user_id`='" . $user_id . "'";
  $q = mysqli_query($link, $sql);
  $permission = array();
  $i = 0;
  while ($rs = mysqli_fetch_array($q)) {
    $permission[$rs["module"]]['add'] = $rs["add"];
    $permission[$rs["module"]]['view'] = $rs["view"];
    $permission[$rs["module"]]['edit'] = $rs["edit"];
    $permission[$rs["module"]]['del'] = $rs["del"];
    $i++;
  }

  return $permission;
}

$per = user_permission($link, $user_id);

?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>ATHANG SOLUTIONS PRIVATE LIMITED</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.5 -->
  <link rel="stylesheet" href="<?php echo SITEPATH; ?>admin/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo SITEPATH; ?>admin/css/font-awesome.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo SITEPATH; ?>admin/css/admin.css">
  <!-- Skins -->
  <link rel="stylesheet" href="<?php echo SITEPATH; ?>admin/css/skin.css">
  <script src="<?php echo SITEPATH; ?>admin/js/jquery.min.js"></script>

  <link href="<?php echo SITEPATH; ?>admin/css/indexview.css" rel='stylesheet' type='text/css' />
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/r/dt/jq-2.1.4,jszip-2.5.0,pdfmake-0.1.18,dt-1.10.9,af-2.0.0,b-1.0.3,b-colvis-1.0.3,b-html5-1.0.3,b-print-1.0.3,se-1.0.1/datatables.min.css" />

  <script type="text/javascript" src="https://cdn.datatables.net/r/dt/jszip-2.5.0,pdfmake-0.1.18,dt-1.10.9,af-2.0.0,b-1.0.3,b-colvis-1.0.3,b-html5-1.0.3,b-print-1.0.3,se-1.0.1/datatables.min.js"></script>

  <!-- Editor CDN -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-migrate/1.2.1/jquery-migrate.min.js" type="text/javascript"></script>
  <script src="<?php echo SITEPATH; ?>ckeditor/ckeditor.js"></script>
  <script src="<?php echo SITEPATH; ?>ckeditor/samples/js/sample.js"></script>


  <!-- sweet alert  -->
  <script src="<?php echo SITEPATH; ?>admin/plugins/sweetalert/sweetalert2.all.min.js"></script>
  <link href="<?php echo SITEPATH; ?>admin/plugins/sweetalert/sweetalert2.min.css" rel="stylesheet">

  <!-- // Get all input elements with the class 'capitalize-both' -->
  <script>
    var inputElements = document.querySelectorAll('.capitalize-word');

    // Add an event listener to each input element
    inputElements.forEach(function(inputElement) {
      inputElement.addEventListener('input', function() {
        // Get the input value
        var inputValue = inputElement.value;

        // Capitalize the first letter of each word
        inputValue = inputValue.split(' ').map(function(word) {
          return word.charAt(0).toUpperCase() + word.slice(1).toLowerCase();
        }).join(' ');

        // Set the modified value back to the input element
        inputElement.value = inputValue;
      });
    });

    /*input hover effect*/
    function txtFocus(Inp) {
      $(Inp).next(".label-brdr").css("width", "100%");
      $(Inp).parent(".form-group").find("label").css("color", "#06b5ef");
    }

    function txtFocusOut(Inp) {
      $(Inp).next(".label-brdr").css("width", "0%");
      $(Inp).parent(".form-group").find("label").css("color", "#999");
    }
  </script>

  <!-- Loader -->
  <script src="<?php echo SITEPATH; ?>admin/plugins/loader/loader.js"></script>

  <?php if ($_SESSION['AdminLogin'] == 1) { ?>
    <script type="text/javascript">
      $(document).ready(function() {
        $('#exportable').DataTable({
          "lengthMenu": [
            [50, 100, 500 - 1],
            [50, 100, 500, "All"]
          ],
          "dom": 'lBfrtip',
          "buttons": [{
            extend: 'collection',
            text: 'Export',
            buttons: [
              'copy',
              'excel',
              'csv',
              'pdf',
              'print'
            ]
          }]
        });
      });
    </script>
  <?php } else { ?>
    <script type="text/javascript">
      $(document).ready(function() {
        $('#exportable').DataTable({
          "lengthMenu": [
            [50, 100, 500 - 1],
            [50, 100, 500, "All"]
          ],
          "dom": 'lBfrtip',
          "buttons": [{}]
        });
      });
    </script>
  <?php } ?>

  <script>
    function showbox(x) {
      document.getElementById(x).style.display = 'block';
    }

    function hidebox(x) {
      document.getElementById(x).style.display = 'none';
    }
  </script>

  <script>
    $(function() {
      $("#datepicker").datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'yy-mm-dd'

      });

    });
    $(function() {
      $("#datepicker1").datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'yy-mm-dd'

      });

    });
  </script>

  <style type="text/css">
    .fa {
      font-size: 20px;
    }
  </style>
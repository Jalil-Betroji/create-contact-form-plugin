<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

<?php




    global $wpdb;
    $sql = "SELECT * FROM `wp_contact_form`";
    $Submition = $wpdb->get_results($sql);


    ?>

    <h1 class="text-center text-secondary my-5 py-2">CONTACT FORM By Jalil Data</h1>




    <div class="container-fluid px-4 mx-fluid table-responsive">


<table id="CONTACT_FORM_By_Jalil_MESSAGES" class="table table-striped" style="width:100%">
        <thead>
        <tr>
                <th>id</th>
                <th>FirstName</th>
                <th>LastName</th>
                <th>Email</th>
                <th>Subject</th>
                <th>Message</th>
                <th>Recieved at</th>
            </tr>
        </thead>
        <tbody>
        <?php 
        foreach ($Submition as $key => $values) {
            
       ?>
            <tr>
                <td> <?php echo $values->id; ?></td>
                <td> <?php echo $values->FirstName; ?></td>
                <td> <?php echo $values->LastName; ?></td>
                <td> <?php echo $values->Email; ?></td>
                <td> <?php echo $values->Subject; ?></td>
                <td> <?php echo $values->Message; ?></td>
                <td> <?php echo $values->Sent_Date; ?></td>

            </tr>
            <?php
        }
        ?>
        </tbody>
       
    </table>

    </div>
  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
    <script>


        $(document).ready(function () {
    $('#CONTACT_FORM_By_Jalil_MESSAGES').DataTable({
    responsive: true
} );
});
        </script>
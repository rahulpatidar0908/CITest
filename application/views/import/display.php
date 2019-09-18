<script type="text/javascript" src="/CITest/assets/js//jquery.js"></script>
<script type="text/javascript">

var base_url='http://127.0.0.1/CITest/';


function get_excel_data(file_name){
   
console.log(file_name);
     request = $.ajax({
        url: base_url+'import/get_file_data',
        type: "post",
        data: {'file_name':file_name},
        dataType:'json'
    });

    // Callback handler that will be called on success
    request.done(function (response, textStatus, jqXHR){
        // Log a message to the console
        $('#info').html('');
        $.each(response, function(k, v) {
            /// do stuff
            $('#info').append('<tr><td>'+v.first_name+'</td> '+'<td>'+v.contact_no+'</td>');
            console.log(v.first_name);
        });
    });

    // Callback handler that will be called on failure
    request.fail(function (jqXHR, textStatus, errorThrown){
        // Log the error to the console
        console.error(
            "The following error occurred: "+
            textStatus, errorThrown
        );
    });

 
}

</script>
<style>
table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
}
th, td {
  padding: 5px;
  text-align: left;    
}
</style>
<div>
    
        <table width="100%">
            <tr>
                <th>Name</th>
                <th colspan="2">Telephone</th>
            </tr>
            <tr id="info">

            </tr>
        </table>
    
</div>
<div class="table-responsive">
    <div class="col-md-6">
        <ul>
            <?php 
                foreach ($excel_file_list as $excel_file_name) {?>
                    <li><a href="javascript:void(0)" onClick="get_excel_data('<?php echo $excel_file_name['uploaded_file'];?>')"><?php echo $excel_file_name['uploaded_file'];?></a></li>
                <?php }
            ?>
        </ul>
    </div>
    <div class="col-md-6">
    <table class="table table-hover tablesorter">
        <!-- <thead>
            <tr>
                <th class="header">First Name</th>
                <th class="header">Contact Name</th>
            </tr>
        </thead> -->
        <tbody id="fileData">
            <?php
            if (isset($employeeInfo) && !empty($employeeInfo)) {
                foreach ($employeeInfo as $key => $element) {
                    ?>
                    <tr>
                        <td><?php echo $element['first_name']; ?></td>   
                        <td><?php echo $element['contact_no']; ?></td>
                    </tr>
                    <?php
                }
            } else {
                ?>
                <tr>
                    <td colspan="5"></td>    
                </tr>
            <?php } ?>

        </tbody>
    </table>
    </div>
</div>

<script type="text/javascript" >
$('#i2c_simulation').change(function() {   
    //console.log(this);
    if(this.checked){      
        //alert("start simulation");
        $.ajax({
            url: 'core/i2c.php', 
            type: 'post',            
            data: {action: 'True'}
        });
    } else {
         $.ajax({
            url: 'core/i2c.php', 
            type: 'post',
            data: {action: 'False'}
         });
    }
});
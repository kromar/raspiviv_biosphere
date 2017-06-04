
$('#i2c_simulation').change(function() {   
    //console.log(this);
    if(this.checked){      
        //alert("start simulation");
        $.ajax({
            url: 'core/i2c.php', 
            type: 'post',            
            data: {action: true}
        })
    } else {
         $.ajax({
            url: 'core/i2c.php', 
            type: 'post',
            data: {action: false}
         });
    }
});
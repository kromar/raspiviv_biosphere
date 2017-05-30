$('#i2c_simulation').change(function() {   
    //console.log(this);
    if(this.checked){       
        //Do stuff
        $.ajax({
            type: 'POST',
            url: 'core/i2c.php',             
            data: {simulate: 'True'},
            success: function(msg) {
                alert("simulation:" + msg);
                }
        });
    } else {
         $.ajax({
            type: 'POST',
            url: 'core/i2c.php',
            data: {simulate: 'False'},
            success: function(msg) {
                alert("simulation:" + msg);
                }
         });
    }
});
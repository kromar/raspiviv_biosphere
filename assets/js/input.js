$('#i2c_simulation').change(function() {   
    //console.log(this);
    if(this.checked){       
        //Do stuff
        $.ajax({
            url: 'core/i2c.php', 
            type: 'post',            
            data: {"simulate": "True"},
            success: function(response) { alert(response); }
        });
    } else {
         $.ajax({
            url: 'core/i2c.php', 
            type: 'post',
            data: {"simulate": 'False'},
            success: function(msg) { alert("simulation:" + msg); }
         });
    }
});
$('#i2c_simulation').change(function() {   
    //console.log(this);
    if(this.checked){       
        //Do stuff
        $.get('core/i2c.php', function(simulationActive) {
                alert("simulation:" + simulationActive);
        });
    } else {
        
    }
});

$(document).ready(function(){
    $("#registration").submit(function(event){
    $.ajax({
        type: "POST",
        url: 'index.php',
        data: $("#registration").serialize(), // serializes the form's elements.
        success: function(data) {
            setTimeout(function() {
                alert('Testing'); // avoid to execute the actual submit of the form.
              }, 30000); // milliseconds
        }
        
      });
      event.preventDefault();
    });
});
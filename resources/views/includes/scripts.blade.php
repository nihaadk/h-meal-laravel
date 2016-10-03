  <!-- Compiled and minified JavaScript --> 
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.6/js/materialize.min.js"></script>
  <!-- subcategory food -->
  <script>
     $('#cateogries').on('change',function(e){
            console.log(e);
            var cat_id = e.target.value;

            //ajax
            $.get('/ajax-subfood?cat_id=' + cat_id, function(data){
                // success data        
                $("#subcategory").empty();
                $.each(data, function(index, subCatObj){
                  console.log(subCatObj);
                   $("#subcategory").append('<option value="'+subCatObj.food_code+'">'+subCatObj.title+'</option>');
                });
                $('#subcategory').removeAttr('disabled');
                // update the dropdown list
                $('#subcategory').material_select();
            });  
      });
  </script>

  <script>
  
    $(document).ready(function() {
        $('select').material_select();
    });

    $(document).ready(function(){
      // the "href" attribute of .modal-trigger must specify the modal ID that wants to be triggered
      $('.modal-trigger').leanModal(
        {
          dismissible: false, // Modal can be dismissed by clicking outside of the modal
          opacity: .8, // Opacity of modal background
          in_duration: 300, // Transition in duration
          out_duration: 200, // Transition out duration
          starting_top: '4%', // Starting top style attribute
          ending_top: '10%' // Ending top style attribute
        }
        );
    });

    $(document).ready(function(){
      $('.tooltipped').tooltip({delay: 50});
    });

   

    $(document).ready(function(){
      $('.collapsible').collapsible({
        accordion : false // A setting that changes the collapsible behavior to expandable instead of the default accordion style
      });
    });

    $('.datepicker').pickadate({
      selectMonths: true, // Creates a dropdown to control month
      selectYears: 80 // Creates a dropdown of 15 years to control year
    });

    //Toggle effect
    $(document).ready(function(){
      $("#search-toggle").click(function(){
        $("#search-field").toggle(500);
      });
    });
        
  </script>


  <script>
  // Search in table
  var $sumBody = $('#sumBody');
  var $rows = $('#table tr');
  $('#search').keyup(function() {
      var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();
      
      $rows.show().filter(function() {
          var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
          return !~text.indexOf(val);
      }).hide();

      $sumBody.hide();
  });    
  </script>


jQuery( document ).ready(function() {

   jQuery("#openai-data").click(function(){
      jQuery('.ai-loader').show();
      var aiData = jQuery('#ai-data').val();
      var panel = jQuery('#re-compare-bar');  
      jQuery.ajax({
               type : "POST",
            //   dataType : "json",
               url : ai_chat.ajax_url,
               data : {action: "ai_chat_ajax",aidata:aiData,_anonce:ai_chat._anonce},
               success: function(response) {
               jQuery('#re-compare-bar').append( response);
               jQuery('.ai-loader').hide();

                  }
         });   


   });


});
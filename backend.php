<?php

function ai_chatboat_option(){
    if(isset($_POST['aichatboat_upadte']) && !empty($_POST['aichatboat_upadte'])){
        $open_api_key = isset($_POST['open_api_key'])?$_POST['open_api_key']:'';

        $api = array('api_key'=>$open_api_key);
        if(ai_chatboat_get()){
            update_option( 'ai-chatbot', $api );
        }else{
            add_option( 'ai-chatbot', $api );
        }


    }
}


function ai_chatboat_get($key=false){
   $open_api =  get_option( 'ai-chatbot' );

   $option = isset($open_api[$key])?$open_api[$key]:$open_api;

   return $option;
}


function ai_chatboat_backend_form(){
    ai_chatboat_option();
?>
    <form method="post" action="#">
    <ul class="wrapper">
        <li class="form-row">
          <label for="open_api_key">Open AI Chatgpt API Key</label>
          <input type="text" id="open_api_key" name="open_api_key" value="<?php echo ai_chatboat_get('api_key'); ?>" class="regular-text"><br>
        </li>
        <li class="form-row">
        <input type="submit" value="UPDATE" name="aichatboat_upadte" class="button button-primary">
        </li>
      </ul>
    </form> 

    <?php
}


<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

add_action('admin_menu',  'ai_chat_admin_menu');

function ai_chat_admin_menu(){
    add_menu_page(__('AI Chatbot', 'ai-chat'), __('AI Chatbot', 'ai-chat'), 'manage_options', 'ai-chat','ai_chat', AI_CHAT_URL.'/images/icon-bot.png',66);

}

function ai_chat(){
    echo "<div class='ai-wrap'>";
    ai_chat_backend_form();
    echo "<h2>".__('AI Chatbot Testing Data','ai-chat')."</h2>";
    ai_chat_backend_input();
    echo "<img class='ai-loader' width='80px' src='".esc_url(AI_CHAT_URL)."images/spinner.gif'/>";
    echo "<div id='re-compare-bar'></div>";
    echo "</div>";

  }

function ai_chat_admin_enqueue($hook) {
  if($hook != 'toplevel_page_ai-chat') return;
  wp_enqueue_style('ai-chat-bstyle', AI_CHAT_URL.'/css/backend.css');
  wp_enqueue_script( 'ai-chat-backend',  AI_CHAT_URL. '/js/backend.js', array('jquery') );

  wp_localize_script( 'ai-chat-backend', 'ai_chat', array( 
    'ajax_url' => admin_url( 'admin-ajax.php' ),
  '_anonce'       => wp_create_nonce( 'ai-chat-nonec-ajax' )
  ) );
}
add_action( 'admin_enqueue_scripts', 'ai_chat_admin_enqueue' );


function ai_chat_enqueue() {

  wp_enqueue_style('ai-chat-style', AI_CHAT_URL.'/css/front.css');
  wp_enqueue_script( 'ai-chat-front',  AI_CHAT_URL. '/js/front.js', array('jquery') );
  wp_localize_script( 'ai-chat-front', 'ai_chat_ajax', array(
     'ai_chat_url'=>AI_CHAT_URL,
     '_anonce'       => wp_create_nonce( 'ai-chat-nonec-ajax' ),
     'ai_chat_audio'=>AI_CHAT_ENTER_AUDIO,
     'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
}
add_action( 'wp_enqueue_scripts', 'ai_chat_enqueue' );

require_once AI_CHAT_PATH . '/backend.php';
require_once AI_CHAT_PATH . '/open-ai.php';

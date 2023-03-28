<?php
/*
* Plugin Name: AI Chatbot
  Version: 1.0
  Author: ThemeHunk
  Description:AI Chatbot plugin integrated with OpenAI ChatGPT technology! Engage your website visitors like never before with a personalized chat experience.
  Text Domain: ai-chatboat
  Author URI: http://www.themehunk.com/
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
define('AI_CHATBOT_URL', plugin_dir_url(__FILE__));
define('AI_CHATBOT_PATH', plugin_dir_path(__FILE__));
define('AI_CHATBOT_ENTER_AUDIO', AI_CHATBOT_URL.'audio/enter.mp3');
define('AI_CHATBOT_AI_AUDIO', AI_CHATBOT_URL.'audio/ai-send.mp3');
define('AI_CHATBOT_IMG_BOT', AI_CHATBOT_URL.'images/bot-chat.png');

require_once AI_CHATBOT_PATH . '/load.php';







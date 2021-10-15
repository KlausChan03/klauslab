<?php
class red_envelope_widget extends WP_Widget
{

  public function __construct()
  {
    $widget_ops = array(
      'classname' => 'red_envelope_widget',
      'description' => '这是一个互利的领支付宝红包小工具',
    );
    parent::__construct('red_envelope_widget', '支付宝扫码领红包', $widget_ops);
  }
  

  public function widget($args, $instance)
  {
    echo $args['before_widget']; 
    echo '<h1 class="widget-title">福利</h1>';
    $red_envelope_code_id = cs_get_option('red_envelope_code_image');
    $red_envelope_code_image = wp_get_attachment_image_src($red_envelope_code_id, 'full');
    echo ('<div class="flex-v flex-hl-vc pt-10"><img src="' . $red_envelope_code_image[0] . '"><p class="mt-5">打开支付宝，扫码领红包。</p><p>赠人玫瑰，手留余香。</p></div>');
    echo $args['after_widget'];
  }
}
add_action(
  'widgets_init',
  create_function('', 'return register_widget("red_envelope_widget");')
);

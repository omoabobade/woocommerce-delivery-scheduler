<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       omoabobade.xyz
 * @since      1.0.0
 *
 * @package    Woocommerce_Delivery_Scheduler
 * @subpackage Woocommerce_Delivery_Scheduler/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Woocommerce_Delivery_Scheduler
 * @subpackage Woocommerce_Delivery_Scheduler/public
 * @author     Abobade Kolawole <kolawole.abobade@gmail.com>
 */
class Woocommerce_Delivery_Scheduler_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Woocommerce_Delivery_Scheduler_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Woocommerce_Delivery_Scheduler_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/woocommerce-delivery-scheduler-public.css', array(), $this->version, 'all' );
		wp_enqueue_style("pikaday", plugin_dir_url( __FILE__ ) . 'css/pikaday.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/pikaday.js');
		wp_enqueue_script( "pikaday", plugin_dir_url( __FILE__ ) . 'js/woocommerce-delivery-scheduler-public.js', array( 'jquery' ), $this->version, false );

	}

	protected function get_day_of_the_week(){
		$timestamp = strtotime('next Sunday');
		$days = array();
		for ($i = 0; $i < 7; $i++) {
			$days[] = strftime('%A', $timestamp);
			$timestamp = strtotime('+1 day', $timestamp);
		}
		return $days;
	}


	protected function get_time_interval(){
		$firstTime=strtotime("10:00:00");
		$lastTime=strtotime("17:00:00");
		$time=$firstTime;
		$interval = array();
			while ($time < $lastTime) {
				$newtime = strtotime('+1 hours', $time);
				$interval[date('H:i:s', $time)] = date('H:i:s', $newtime) ;
				$time = $newtime;
			}
		return $interval;
	}

	public function wcds_custom_checkout_action()
	{
		$days = self::get_day_of_the_week();
		$intervals = self::get_time_interval();
		?>
		<h4>Delivery Type : </h4>
		<p>
			Recurrent : <input type="radio" name="wcds_delivery_type" class="delivery_type" value="recurrent" /> &nbsp;&nbsp;&nbsp;
			One-Time : <input type="radio" checked name="wcds_delivery_type" class="delivery_type" value="one-time" />
		</p>
		<div style="display:none;">
			<?php
			echo woocommerce_form_field( 'wcds_delivery_type', array(
				'type'          => 'text',
				'class'         => array('wcd_cdd form-row-first'),
				'id'			=> "wcds_delivery_type",
				'label'         => "",
			), '');
			?>
		</div>

		
		<div class="recurrent" style="display:none;" >

				<?php
				echo woocommerce_form_field( 'wcds_schedule', array(
					'type'          => 'select',
					'class'         => array('wcd_cdd form-row-first'),
					'id'			=> "wcds_schedule",
					'label'         => "Schedule",
					'options'     => array(''=>'Select Schedule','weekly'=>'Weekly', 'monthly'=>'Monthly'),
					'clear'     => true
				), '');
				?>

				<?php
					$dayofweek = array(""=>"Select Day of Week");
					foreach ($days as $day){
						$dayofweek[$day] = $day;
					};
				echo woocommerce_form_field( 'wcds_day_of_the_week', array(
					'type'          => 'select',
					'class'         => array('wcd_cdd form-row-first'),
					'id'			=> "wcds_day_of_the_week",
					'label'         => "Day of the Week ",
					'options'     => $dayofweek,
					'clear'     => true
				), '');
				?>
					<?php
					$timeofday = array(""=>"Select hour of the day");
					foreach ($intervals as $key=>$value){
						$timeofday[$key."-".$value] = $key."-".$value;
					};
				echo woocommerce_form_field( 'wcds_time', array(
					'type'          => 'select',
					'class'         => array('wcd_cdd form-row-first'),
					'id'			=> "hour_of_the_day",
					'label'         => "Time of the Day ",
					'options'     => $timeofday,
					'clear'     => true
				), '');
				?>
	
		</div>
		<div class="one-time" >

				 <?php
				echo woocommerce_form_field( 'wcds_date', array(
					'type'          => 'text',
					'class'         => array('wcd_cdd form-row-first'),
					'id'			=> "datepicker",
					'required' 		=> true,
					'label'         => "Date :",
					'clear'     	=> true
				), '');

				 echo woocommerce_form_field( 'wcds_time', array(
					 'type'          => 'select',
					 'class'         => array('wcd_cdd form-row-first'),
					 'id'			=> "hour_of_the_day",
					 'label'         => "Time of the Day ",
					 'options'     => $timeofday,
					 'clear'     => true
				 ), '');
				 ?>
		</div>
		<script>
			var picker = new Pikaday({ field: document.getElementById('datepicker') });
		</script>
		<?php
	}


	public function wcds_field_validation() {
		! sanitize_text_field($_POST['wcds_delivery_type'])? '': wc_add_notice( __( 'Delivery Type is a required field.' ), 'error' );

		if($_POST['wcds_delivery_type'] == "recurrent"){
			! sanitize_text_field($_POST['wcds_schedule'])? '': wc_add_notice( __('Delivery Schedule is a required field.' ), 'error' );
			! sanitize_text_field($_POST['wcds_day_of_the_week'])? '': wc_add_notice( __('Delivery day of the week is a required field.' ), 'error' );
			! sanitize_text_field($_POST['wcds_time'])? '': wc_add_notice( __('Delivery time of the day is a required field.' ), 'error' );

		}else if($_POST['wcds_delivery_type'] == "one-time"){
			! sanitize_text_field($_POST['wcds_date'])? '': wc_add_notice( __( 'Delivery date is a required field.' ), 'error' );
			! sanitize_text_field($_POST['wcds_time'])? '': wc_add_notice( __( 'Delivery time is a required field.' ), 'error' );
		}

	}


	public function wcds_update_order_meta( $order_id ) {
		if (sanitize_text_field($_POST['wcds_delivery_type']) =="recurrent") {
			update_post_meta( $order_id, 'Wcds-Delivery-Type', esc_attr($_POST['wcds_delivery_type']));
			update_post_meta( $order_id, 'Wcds-Delivery-Schedule', esc_attr($_POST['wcds_schedule']));
			update_post_meta( $order_id, 'Wcds-Day-Of-Week', esc_attr($_POST['wcds_day_of_the_week']));
			update_post_meta( $order_id, 'Wcds-Time', esc_attr($_POST['wcds_time']));
		}

		if (sanitize_text_field($_POST['wcds_delivery_type']) == "one-time") {
			update_post_meta( $order_id, 'Wcds-Delivery-Type', esc_attr($_POST['wcds_delivery_type']));
			update_post_meta( $order_id, 'Wcds-Date', esc_attr($_POST['wcds_date']));
			update_post_meta( $order_id, 'Wcds-Time', esc_attr($_POST['wcds_time']));
		}
	}


	function wcds_append_to_order_email( $keys )
	{
		$keys["wcds_delivery_type"] = 'Wcds-Delivery-Type';
		$keys["wcds_delivery_schedule"] = 'Wcds-Delivery-Schedule';
		$keys["wcds_day_of_week"] = 'Wcds-Day-Of-Week';
		$keys["wcds_date"] = 'Wcds-Date';
		$keys["wcds_time"] = 'Wcds-Time';
		return $keys;
	}


	function wcds_order_delivery_schedule_columns($columns){
		$new_columns = (is_array($columns)) ? $columns : array();
		unset( $new_columns['order_actions'] );
		$new_columns["wcds_delivery_type"] = 'Delivery Type';
	/*	$new_columns["wcds_delivery_schedule"] = 'Delivery Schedule';
		$new_columns["wcds_day_of_week"] = 'Delivery Day Of Week';
		$new_columns["wcds_date"] = 'Delivery Date';
		$new_columns["wcds_time"] = 'Delivery Time';*/
		$new_columns['order_actions'] = $columns['order_actions'];
		return $new_columns;
	}

	function wcds_order_delivery_schedule_columnsvalue($column){
		global $post;
		$data = get_post_meta( $post->ID );
		echo ( $column == 'wcds_delivery_type' && isset($data['Wcds-Delivery-Type'][0]) )? $data['Wcds-Delivery-Type'][0] : '';
	/*	echo ( $column == 'wcds_delivery_schedule"' && isset($data['Wcds-Delivery-Schedule'][0]) )? $data['Wcds-Delivery-Schedule'][0] : '';
		echo ( $column == 'wcds_day_of_week' && isset($data['Wcds-Day-Of-Week'][0]) )? $data['Wcds-Day-Of-Week'][0] : '';
		echo ( $column == 'wcds_date' && isset($data['Wcds-Date'][0]) )? $data['Wcds-Date'][0] : '';*/
		echo ( $column == 'wcds_time' && isset($data['Wcds-Time'][0]) )? $data['Wcds-Time'][0] : '';

	}



	public function wcd_add_delivery_date_to_order_page($order)
	{
		$my_order_meta = get_post_custom( $order->id );
		if(array_key_exists('Wcds-Delivery-Type',$my_order_meta))
		{
			$order_page_delivery_type = $my_order_meta['Wcds-Delivery-Type'];
			$order_page_delivery_schedule = $my_order_meta['Wcds-Delivery-Schedule'];
			$order_page_delivery_dayofweek = $my_order_meta['Wcds-Day-Of-Week'];
			$order_page_delivery_time = $my_order_meta['Wcds-Time'];
			$order_page_delivery_date = $my_order_meta['Wcds-Date'];
			if($order_page_delivery_type == "recurrent"){
				echo '<p><strong>Delivery Type</strong> ' . $order_page_delivery_type[0] .'</p>';
				echo '<p><strong>Delivery Schedule</strong> ' . $order_page_delivery_schedule[0] .'</p>';
				echo '<p><strong>Delivery Day Of Week</strong> ' . $order_page_delivery_dayofweek[0] .'</p>';
				echo '<p><strong>Delivery Time</strong> ' . $order_page_delivery_time[0] .'</p>';
			}else if($order_page_delivery_type == "one-time"){
				echo '<p><strong>Delivery Type</strong> ' . $order_page_delivery_type[0] .'</p>';
				echo '<p><strong>Delivery Date/strong> ' . $order_page_delivery_date[0] .'</p>';
				echo '<p><strong>Delivery Time</strong> ' . $order_page_delivery_time[0] .'</p>';
			}

		}
	}
}

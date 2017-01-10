<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://adamwills.io
 * @since      1.0.0
 *
 * @package    Sacbrant_Wish_Exporter
 * @subpackage Sacbrant_Wish_Exporter/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Sacbrant_Wish_Exporter
 * @subpackage Sacbrant_Wish_Exporter/admin
 * @author     Adam Wills <adam@adamwills.com>
 */
class Sacbrant_Wish_Exporter_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/sacbrant-wish-exporter-admin.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/sacbrant-wish-exporter-admin.js', array( 'jquery', 'jquery-ui-datepicker' ), $this->version, false );
	}

	public function add_dashboard_widget() {
		wp_add_dashboard_widget(
			'sacbrant_wish_widget',         // Widget slug.
			'SacBrant WISH Exporter',         // Title.
			array($this, 'display_sacbrant_wish_widget') // Display function.
		);

	}

	public function display_sacbrant_wish_widget() {
		include_once('partials/_widget-form.php');
		// if (isset($_POST['wish-report-from'])) {
		// 	$data = $this->get_wish_data();
		// 	$this->generate_export($entries, '2016', '2017');
		// }
		// $entries = $this->get_wish_data();
		// echo '<pre><textarea style="width:100%" rows="200">';
		// echo $this->convert_data_to_xml($entries, '2016', '2017');
		// echo '</textarea></pre>';
	}

	public function get_wish_data( $start_date, $end_date ) {
		if (!class_exists('GFAPI')) return false;
		$search_criteria = array();
		$form_id = 1;
		$search_criteria['start_date'] = $start_date;
		$search_criteria['end_date'] = $end_date;
		$paging = array( 'offset' => 0, 'page_size' => 200 );
		$entries = GFAPI::get_entries($form_id, $search_criteria, array(), $paging);
		return $entries;
	}

	private function get_checkbox_fields( &$referral, $fields, $key, $element, $text_to_parse = '' ) {
		foreach ($fields as $k => $v) {
			if (strpos($k, $key.'.') > -1 && $v) {
				$referral->addChild($element, str_replace($text_to_parse, '', $v));
			}
		}
	}

	private function convert_to_yes_no( $response ) {
		return ('1' == $response) ? "Yes" : "No";
	}

	public function generate_export() {
		$start_date = $_POST['wish-report-from'];
		$end_date = $_POST['wish-report-to'];
		check_admin_referer('generate_wish_export', 'sac-wish-form-submit');
		$entries = $this->get_wish_data($start_date, $end_date);

		$date_generated = date('Y-m-d-H:i:s', time());
		$xml = new SimpleXMLElement('<entries/>');
		$xml->addAttribute('generated', $date_generated);
		$xml->addAttribute('start-date', $start_date);
		$xml->addAttribute('end-date', $end_date);

		foreach ($entries as $key => $value) {
			$entry = $xml->addChild('entry');
			$entry->addChild('ID', $value['id']);
			$entry->addChild('DateSubmitted', $value['date_created']);
			$entry->addChild('UserID', $value['created_by']);
			$entry->addChild('Date', $value[1]);
			$entry->addChild('Name', $value[2]);
			$entry->addChild('Position', $value[6]);
			$entry->addChild('CallStartTime', $value[11]);
			$entry->addChild('CallEndTime', $value[5]);
			$entry->addChild('CallLength', $value[50]);
			$entry->addChild('Called', $value[7]);
			$entry->addChild('LocationOfCall', $value[8]);
			$entry->addChild('LostCall', $value[9]);
			$referral = $entry->addChild('ReferredBy');
			$this->get_checkbox_fields($referral, $value, '10', 'Referral', 'Referred by ');
			$referral->addChild('OtherReferral', $value[14]);
			$entry->addChild('ReferredHospitalName', $value[12]);
			$entry->addChild('ReferredPoliceName', $value[13]);
			$entry->addChild('FirstTimeCaller', $value[15]);
			$previousContact = $entry->addChild('PreviousContactWith');
			$this->get_checkbox_fields($previousContact, $value, '16', 'Contact', 'Previous Contact With ');
			$entry->addChild('Challenges', $value[17]);
			$entry->addChild('Gender', $value[18]);
			$entry->addChild('Sexuality', $value[19]);
			$entry->addChild('Age', $value[20]);
			$diversity = $entry->addChild('Diversity');
			$this->get_checkbox_fields($diversity, $value, '21', 'Type');
			$survivor = $entry->addChild('SurvivorOf');
			$this->get_checkbox_fields($survivor, $value, '22', 'Survived', 'Caller is survivor of ');
			$perpetrator = $entry->addChild('PerpetratorOfSexualOffence');
			$this->get_checkbox_fields($perpetrator, $value, '23', 'Perpetrator', 'Perpetrator of Sexual Offence Only - ');
			$entry->addChild('Partner', $value[52]);
			$entry->addChild('Parent', $value[53]);
			$entry->addChild('FosterStepParent', $value[54]);
			$entry->addChild('OtherRelative', $value[54]);
			$entry->addChild('Acquaintance', $value[56]);
			$entry->addChild('Employer', $value[57]);
			$entry->addChild('Coworker', $value[58]);
			$entry->addChild('Clergy', $value[60]);
			$entry->addChild('ServiceProvider', $value[59]);
			$entry->addChild('Stranger', $value[61]);
			$entry->addChild('Self', $value[62]);
			$entry->addChild('Other', $value[35]);
			$survivor = $entry->addChild('SurvivorOf');
			$this->get_checkbox_fields($survivor, $value, '36', 'Experience', 'Survivor of ');
			$services = $entry->addChild('ServicesProvided');
			$services->addChild('SpecialLanguageRequest', $value[38]);
			$services->addChild('InformationRequest', $value[39]);
			$services->addChild('ReferraltoCentresService', $value[40]);
			$services->addChild('ReferraltoCommunityServices', $value[41]);
			$services->addChild('PracticalAssistance', $this->convert_to_yes_no($value['42.1']));
			$services->addChild('Accompaniment', $value[43]);
			$entry->addChild('PhoneCallMadeOnBehalfOfCaller', $value[44]);
			$entry->addChild('ReportToChildrensAidSociety', $value[45]);
			$police = $entry->addChild('PoliceContact');
			$this->get_checkbox_fields($police, $value, '46', 'Contact', '');
			$entry->addChild('Debriefed', $value[47]);
			$entry->addChild('DebriefedByStaff', $value[48]);
			$entry->addChild('AdditionalComments', $value[51]);
		}

		$dom = new DOMDocument();
		$output = $xml->asXML();
		$dom->loadXML($output);

		$xpath = new DOMXPath($dom);
		foreach( $xpath->query('//*[not(node())]') as $node ) {
	    $node->parentNode->removeChild($node);
		}

		$dom->formatOutput = true;
		$name = 'sacbrant-wish-export-' . $date_generated . '.xml';
		header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Cache-Control: private", false);
		header('Content-Disposition: attachment;filename=' . $name);
    header('Content-Type: text/xml');
		print $dom->saveXML();
		exit();
	}

}

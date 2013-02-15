<?php

/**
 * Activate Add-ons
 * Here you can enter your activation codes to unlock Add-ons to use in your theme. 
 * Since all activation codes are multi-site licenses, you are allowed to include your key in premium themes.
 */ 

function my_acf_settings( $options )
{
    // activate add-ons
    $options['activation_codes']['repeater'] = 'XXXX-XXXX-XXXX-XXXX';
    $options['activation_codes']['options_page'] = 'XXXX-XXXX-XXXX-XXXX';
    $options['activation_codes']['flexible_content'] = 'XXXX-XXXX-XXXX-XXXX';
    $options['activation_codes']['gallery'] = 'XXXX-XXXX-XXXX-XXXX';
    
    // setup other options (http://www.advancedcustomfields.com/docs/filters/acf_settings/)
    
    return $options;
    
}
add_filter('acf_settings', 'my_acf_settings');


/**
 * Register field groups
 * The register_field_group function accepts 1 array which holds the relevant data to register a field group
 * You may edit the array as you see fit. However, this may result in errors if the array is not compatible with ACF
 * This code must run every time the functions.php file is read
 */

if(function_exists("register_field_group"))
{
	register_field_group(array (
		'id' => '511a60a87239c',
		'title' => 'Show Info',
		'fields' => 
		array (
			0 => 
			array (
				'key' => 'field_1',
				'label' => 'Show Date',
				'name' => 'show_date',
				'type' => 'date_picker',
				'order_no' => 0,
				'instructions' => 'Enter the show date.',
				'required' => 1,
				'conditional_logic' => 
				array (
					'status' => 0,
					'rules' => 
					array (
						0 => 
						array (
							'field' => 'null',
							'operator' => '==',
							'value' => '',
						),
					),
					'allorany' => 'all',
				),
				'date_format' => 'yymmdd',
				'display_format' => 'dd/mm/yy',
			),
			1 => 
			array (
				'key' => 'field_4',
				'label' => 'Province',
				'name' => 'province',
				'type' => 'select',
				'order_no' => 1,
				'instructions' => '',
				'required' => 1,
				'conditional_logic' => 
				array (
					'status' => 0,
					'rules' => 
					array (
						0 => 
						array (
							'field' => 'null',
							'operator' => '==',
							'value' => '',
						),
					),
					'allorany' => 'all',
				),
				'choices' => 
				array (
					'Alberta' => 'Alberta',
					'British Columbia' => 'British Columbia',
					'Manitoba' => 'Manitoba',
					'New Brunswick' => 'New Brunswick',
					'Newfoundland and Labrador' => 'Newfoundland and Labrador',
					'Northwest Territories' => 'Northwest Territories',
					'Nova Scotia' => 'Nova Scotia',
					'Nunavut' => 'Nunavut',
					'Ontario' => 'Ontario',
					'Prince Edward Island' => 'Prince Edward Island',
					'Quebec' => 'Quebec',
					'Saskatchewan' => 'Saskatchewan',
					'Yukon' => 'Yukon',
				),
				'default_value' => '',
				'allow_null' => 0,
				'multiple' => 0,
			),
		),
		'location' => 
		array (
			'rules' => 
			array (
				0 => 
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'show',
					'order_no' => 0,
				),
			),
			'allorany' => 'all',
		),
		'options' => 
		array (
			'position' => 'normal',
			'layout' => 'no_box',
			'hide_on_screen' => 
			array (
				0 => 'the_content',
				1 => 'excerpt',
				2 => 'custom_fields',
				3 => 'discussion',
				4 => 'comments',
				5 => 'revisions',
				6 => 'slug',
				7 => 'author',
				8 => 'format',
				9 => 'featured_image',
				10 => 'tags',
				11 => 'send-trackbacks',
			),
		),
		'menu_order' => 0,
	));
}

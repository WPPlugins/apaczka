<?php

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Settings for flexible shipping
 */

$options_hours = array(
);
for ( $h = 9; $h < 20; $h++ ) {
	$options_hours[$h . ':00'] = $h . ':00';
	if ( $h < 19 ) {
		$options_hours[$h . ':30'] = $h . ':30';
	}
}


$settings = array(
	array(
		'title'     => __( 'Ustawienia główne', 'apaczka' ),
		'type'     => 'title',
		'description'     => '',
	),
	'title' => array(
		'title' 		=> __( 'Tytuł', 'apaczka' ),
		'type' 			=> 'text',
		'description' 	=> __( 'Tytuł metody widoczny w koszyku i formularzu zamówienia.', 'apaczka' ),
		'default'		=> __( 'Apaczka', 'apaczka' ),
		'desc_tip'		=> true,
		'custom_attributes' => array(
				'required' => 'required'
		)
	), 
	'enabled' => array(
		'title' 		=> __( 'Włącz/Wyłącz', 'apaczka' ),
		'type' 			=> 'checkbox',
		'label' 		=> __( 'Włącz metodę wysyłki', 'apaczka' ),
		'default' 		=> 'no',
	),
	array(
		'title'     => __( 'Logowanie', 'apaczka' ),
		'type'     => 'title',
		'description'     => '',
	),
	'login' => array(
		'title' 		=> __( 'Login', 'apaczka' ),
		'type' 			=> 'text',
		'description' 	=> __( 'Login do serwisu Apaczka.', 'apaczka' ),
		'default'		=> '',
		'desc_tip'		=> true,
		'custom_attributes' => array(
				'required' => 'required'
		)
	), 
	'password' => array(
		'title' 		=> __( 'Hasło', 'apaczka' ),
		'type' 			=> 'password',
		'description' 	=> __( 'Hasło do serwisu Apaczka.', 'apaczka' ),
		'default'		=> '',
		'desc_tip'		=> true,
		'custom_attributes' => array(
				'required' => 'required'
		)
	),
	'api_key' => array(
			'title' 		=> __( 'Klucz API', 'apaczka' ),
			'type' 			=> 'text',
			'description' 	=> __( 'Klucz API serwisu Apaczka.', 'apaczka' ),
			'default'		=> '',
			'desc_tip'		=> true,
			'custom_attributes' => array(
					'required' => 'required'
			)				
	),		
	'test_mode' => array(
		'title' 		=> __( 'Tryb testowy', 'apaczka' ),
		'label'			=> __( 'Włącz tryb testowy', 'apaczka' ),
		'type' 			=> 'checkbox',
		'description'	=> __( 'Jeśli włączasz tryb testowy - wpisz Login, Hasło i Klucz API do serwisu testowego, a nie do produkcyjnego.', 'apaczka' ),
		'default' 		=> 'no',
		'desc_tip'		=> true
	),
	array(
		'title'     	=> __( 'Ustawienia ceny', 'apaczka' ),
		'type'     		=> 'title',
		'description'   => '',
	),
	'tax_status' => array(
		'title' 		=> __( 'Status podatku', 'apaczka' ),
		'type' 			=> 'select',
		'class'         => 'wc-enhanced-select',
		'default' 		=> 'taxable',
		'options'		=> array(
			'taxable' 	=> __( 'Opodatkowany', 'apaczka' ),
			'none' 		=> _x( 'Brak', 'Tax status', 'apaczka' )
		),				
	),
	'cost' => array(
			'title' 		=> __( 'Koszt na zamówienie', 'apaczka' ),
			'type' 			=> 'price',
			'description' 	=> __( 'Koszt na zamówienie.', 'apaczka' ),
			'default'		=> '',
			'desc_tip'		=> true,
			'custom_attributes' => array(
					'required' => 'required'
			)
	),		
	'cost_cod' => array(
			'title' 		=> __( 'Koszt na zamówienie (pobranie)', 'apaczka' ),
			'type' 			=> 'price',
			'description' 	=> __( 'Koszt na zamówienie (pobranie).', 'apaczka' ),
			'default'		=> '',
			'desc_tip'		=> true
	),		
	array(
		'title'     	=> __( 'Domyślne ustawienia przesyłki', 'apaczka' ),
		'type'     		=> 'title',
		'description'   => '',
	),
	'service' => array(
			'title' 		=> __( 'Usługa', 'apaczka' ),
			'type' 			=> 'select',
			'description' 	=> __( 'Usługa.', 'apaczka' ),
			'default'		=> '',
			'desc_tip'		=> true,
			'options'		=> self::$services
	),		
	'insurance' => array(
			'title' 		=> __( 'Ubezpieczenie', 'apaczka' ),
			'type' 			=> 'select',
			'description' 	=> __( 'Ubezpieczenie.', 'apaczka' ),
			'default'		=> '',
			'desc_tip'		=> true,
			'options'		=> array(
					'yes' 	=> __( 'Tak', 'apaczka' ),
					'no' 	=> __( 'Nie', 'apaczka' ),
			)
	),		
	'pickup_hour_from' => array(
			'title' 		=> __( 'Odbiór od godziny', 'apaczka' ),
			'type' 			=> 'select',
			'description' 	=> __( 'Odbiór od godziny.', 'apaczka' ),
			'default'		=> '',
			'desc_tip'		=> true,
			'options'		=> $options_hours
	),		
	'pickup_hour_to' => array(
			'title' 		=> __( 'Odbiór do godziny', 'apaczka' ),
			'type' 			=> 'select',
			'description' 	=> __( 'Odbiór do godziny.', 'apaczka' ),
			'default'		=> '',
			'desc_tip'		=> true,
			'options'		=> $options_hours	
	),		
	'package_width' => array(
			'title' 		=> __( 'Długość paczki [cm]', 'apaczka' ),
			'type' 			=> 'number',
			'description' 	=> __( 'Długość paczki [cm].', 'apaczka' ),
			'default'		=> '',
			'desc_tip'		=> true,
			'custom_attributes' => array(
					'min' 	=> 0,
					'max' 	=> 10000,
					'step'	=> 1,
					'required' => 'required'
			)
	),		
	'package_depth' => array(
			'title' 		=> __( 'Szerokość paczki [cm]', 'apaczka' ),
			'type' 			=> 'number',
			'description' 	=> __( 'Szerokość paczki [cm].', 'apaczka' ),
			'default'		=> '',
			'desc_tip'		=> true,
			'custom_attributes' => array(
					'min' 	=> 0,
					'max' 	=> 10000,
					'step'	=> 1,
					'required' => 'required'
			)
	),		
	'package_height' => array(
			'title' 		=> __( 'Wysokość paczki [cm]', 'apaczka' ),
			'type' 			=> 'number',
			'description' 	=> __( 'Wysokość paczki [cm].', 'apaczka' ),
			'default'		=> '',
			'desc_tip'		=> true,
			'custom_attributes' => array(
					'min' 	=> 0,
					'max' 	=> 10000,
					'step'	=> 1,
					'required' => 'required'
			)
	),		
	'package_weight' => array(
			'title' 		=> __( 'Waga paczki [kg]', 'apaczka' ),
			'type' 			=> 'number',
			'description' 	=> __( 'Waga paczki [kg].', 'apaczka' ),
			'default'		=> '',
			'desc_tip'		=> true,
			'custom_attributes' => array(
					'min' 	=> 0,
					'max' 	=> 10000,
					'step'	=> 'any',
					'required' => 'required'
			)
	),		
	'package_contents' => array(
			'title' 		=> __( 'Zawartość', 'apaczka' ),
			'type' 			=> 'text',
			'description' 	=> __( 'Zawartość paczki.', 'apaczka' ),
			'default'		=> '',
			'desc_tip'		=> true,
	),		
	array(
			'title'     	=> __( 'Dane nadawcy', 'apaczka' ),
			'type'     		=> 'title',
			'description'   => '',
	),
	'sender_name' => array(
			'title' 		=> __( 'Nazwa', 'apaczka' ),
			'type' 			=> 'text',
			'description' 	=> __( 'Nazwa.', 'apaczka' ),
			'default'		=> '',
			'desc_tip'		=> true,
			'custom_attributes' => array(
					'required' => 'required'
			)
	),
	'sender_address_line1' => array(
			'title' 		=> __( 'Adres', 'apaczka' ),
			'type' 			=> 'text',
			'description' 	=> __( 'Adres.', 'apaczka' ),
			'default'		=> '',
			'desc_tip'		=> true,
			'custom_attributes' => array(
					'required' => 'required'
			)
	),
	'sender_address_line2' => array(
			'title' 		=> __( 'Adres cd.', 'apaczka' ),
			'type' 			=> 'text',
			'description' 	=> __( 'Adres cd.', 'apaczka' ),
			'default'		=> '',
			'desc_tip'		=> true
	),
	'sender_postal_code' => array(
			'title' 		=> __( 'Kod pocztowy', 'apaczka' ),
			'type' 			=> 'text',
			'description' 	=> __( 'Kod pocztowy.', 'apaczka' ),
			'default'		=> '',
			'desc_tip'		=> true,
			'custom_attributes' => array(
					'required' => 'required'
			)
	),
	'sender_city' => array(
			'title' 		=> __( 'Miasto', 'apaczka' ),
			'type' 			=> 'text',
			'description' 	=> __( 'Miasto.', 'apaczka' ),
			'default'		=> '',
			'desc_tip'		=> true
	),	
/*		
	'sender_country' => array(
			'title' 		=> __( 'Kraj', 'apaczka' ),
			'type' 			=> 'select',
			'description' 	=> __( 'Kraj.', 'apaczka' ),
			'default'		=> 'PL',
			'desc_tip'		=> true,
			'options'		=> WC()->countries->get_countries()
	),
*/	
	'sender_contact_name' => array(
			'title' 		=> __( 'Osoba kontaktowa', 'apaczka' ),
			'type' 			=> 'text',
			'description' 	=> __( 'Osoba kontaktowa.', 'apaczka' ),
			'default'		=> '',
			'desc_tip'		=> true,
			'custom_attributes' => array(
					'required' => 'required'
			)
	),
	'sender_phone' => array(
			'title' 		=> __( 'Telefon', 'apaczka' ),
			'type' 			=> 'text',
			'description' 	=> __( 'Telefon.', 'apaczka' ),
			'default'		=> '',
			'desc_tip'		=> true,
			'custom_attributes' => array(
					'required' => 'required'
			)
	),
	'sender_email' => array(
			'title' 		=> __( 'E-mail', 'apaczka' ),
			'type' 			=> 'text',
			'description' 	=> __( 'E-mail.', 'apaczka' ),
			'default'		=> '',
			'desc_tip'		=> true,
			'custom_attributes' => array(
					'required' => 'required'
			)
	),
	'sender_account_number' => array(
			'title' 		=> __( 'Konto pobraniowe', 'apaczka' ),
			'type' 			=> 'text',
			'description' 	=> __( 'Konto pobraniowe.', 'apaczka' ),
			'default'		=> '',
			'desc_tip'		=> true
	),
		
);

return $settings;

<?php

namespace Drupal\contactmap\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure contact map settings for this site.
 */
class ContactMapForm extends ConfigFormBase {

  /**
   * Implements getEditableConfigNames().
   */
  protected function getEditableConfigNames() {
    return [
      'contactmap.settings',
    ];
  }

  /**
   * Implements getFormId().
   */
  public function getFormId() {
    return 'contactmap_form';
  }

  /**
   * Implements buildForm().
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $config = $this->config('contactmap.settings');
    // Google map api key.
    $form['google_map_api_settings'] = [
      '#type' => 'details',
      '#title' => $this->t('Google Map API Key settings'),
    ];
    $form['google_map_api_settings']['mapGooglekey'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Google Map API Key'),
      '#description' => $this->t('Enter Google Map API Key.'),
      '#default_value' => $config->get('mapGooglekey'),
    ];
    // Form for the button setting.
    $form['contactmap_custom_settings'] = [
      '#type' => 'details',
      '#title' => $this->t('Contact Map Address And Phone Number Settings'),
      '#open' => TRUE,
    ];
    $form['contactmap_custom_settings']['mapPhoneNumber'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Phone Number'),
      '#description' => $this->t('Contact Map Phone Number Add.'),
      '#default_value' => $config->get('mapPhoneNumber'),
      '#required' => TRUE,
    ];
    $form['contactmap_custom_settings']['mapAddressContact'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Contact Address'),
      '#description' => $this->t('Your Contact Address.'),
      '#default_value' => $config->get('mapAddressContact'),
    ];
    // Social Button Settings form.
    $form['contactmap_settings'] = [
      '#type' => 'details',
      '#title' => $this->t('Contact Map settings'),
    ];
    $form['contactmap_settings']['mapLatitude'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Latitude'),
      '#description' => $this->t('Enter Map Latitude.'),
      '#default_value' => $config->get('mapLatitude'),
    ];
    $form['contactmap_settings']['mapLongitude'] = [
      '#type' => 'textfield',
      '#title' => $this->t('longitude'),
      '#description' => $this->t('Enter Map longitude.'),
      '#default_value' => $config->get('mapLongitude'),
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * Implement validateForm().
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    $phone = $form_state->getValue('mapPhoneNumber');
    if (strlen($phone) < 10) {
      $form_state->setErrorByName('mapPhoneNumber', $this->t('Mobile number is too short.'));
    }
    if (!preg_match("/^\+?\d[0-9-]{9,12}/", $phone)) {
      $form_state->setErrorByName('mapPhoneNumber', $this->t('Mobile number is only numeric Valid.'));
    }
  }

  /**
   * Implement submitForm().
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Map API get value.
    $mapGooglekey = $form_state->getValues('mapGooglekey');
    // Getting Value for button.
    $mapPhoneNumber = $form_state->getValues('mapPhoneNumber');
    $mapAddressContact = $form_state->getValues('mapAddressContact');
    // Map latitude and longitude settings Get value.
    $mapLatitude = $form_state->getValues('mapLatitude');
    $mapLongitude = $form_state->getValues('mapLongitude');

    $this->config('contactmap.settings')
       // Set google map API key value.
      ->set('mapGooglekey', $mapGooglekey['mapGooglekey'])
      // Set button value setting.
      ->set('mapPhoneNumber', $mapPhoneNumber['mapPhoneNumber'])
      ->set('mapAddressContact', $mapAddressContact['mapAddressContact'])
      // Map latitude and longitude set varible value.
      ->set('mapLatitude', $mapLatitude['mapLatitude'])
      ->set('mapLongitude', $mapLongitude['mapLongitude'])
      ->save();
    parent::submitForm($form, $form_state);

  }

}

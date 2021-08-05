<?php

namespace Drupal\material\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\FormBase;

/**
 * Class showWhetherForm.
 */
class showWeatherForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'material_weather_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['city'] = [
      '#type' => 'textfield',
      '#title' => $this->t('City'),
      '#description' => $this->t('Enter city name'),
      '#maxlength' => 64,
      '#size' => 64,
    ];
    $form['latitude'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Latitude'),
      '#description' => $this->t('Latitude of the Geographical Location'),
      '#maxlength' => 64,
      '#size' => 64,
    ];
    $form['longitude'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Longitude'),
      '#description' => $this->t('Longitude of the Geographical Location'),
      '#maxlength' => 64,
      '#size' => 64,
    ];
    $form['actions'] = [
      '#type' => 'button',
      '#value' => $this->t('Submit'),
      '#ajax' => [
        'callback' => '::returnWeatherElement',
        'wrapper' => 'weatherPlaceholder',
      ],
    ];
  
    if ($form_state->getValue('city')) {
      $city = $form_state->getValue('city');
    }
    else {
      $city = 'London';	// Set default city
    }

    // Call service to get weather data.
    $service = \Drupal::service('material.weather_service');
    $weather_data = $service->getWeatherDataViaApi($city);
    if ($weather_data) {
      \Drupal::logger('weather')->notice('<pre>' . print_r($weather_data, TRUE) . '</pre>');
    }
    $form['weather_element'] = [
      '#type' => 'inline_template',
      '#theme' => 'weather_rendered_data',
      '#data' => $weather_data,
      '#prefix' => '<div id="weatherPlaceholder">',
      '#suffix' => '</div>',
    ];

    $form['#attached']['library'][] = 'material/weather';
    return $form;
  }

  /**
   * Ajax submit handler to return update weather element.
   */
  public function returnWeatherElement(array $form, FormStateInterface $form_state) {
    return $form['weather_element'];
  }

  /**
   * Submit handler for the form.
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

  }

}
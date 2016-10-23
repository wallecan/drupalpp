<?php

/**
 * @file
 * Contains \Drupal\reservations\Entity\Reservation.
 */

namespace Drupal\reservations\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Entity\EntityChangedTrait;

use Drupal\user\UserInterface;

use Drupal\Core\Field\BaseFieldDefinition;

use Drupal\reservations\ReservationInterface;


/**
 * Defines the Reservation entity.
 *
 * @ingroup reservations
 *
 *
 * @ContentEntityType(
 *   id = "reservation",
 *   label = @Translation("Reservation"),
 *   label_singular = @Translation("reservation"),
 *   label_plural = @Translation("reservations"),
 *   label_count = @PluralTranslation(
 *     singular = "@count reservation",
 *     plural = "@count reservations",
 *   ),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\reservations\ReservationListBuilder",
 *     "access" = "Drupal\reservations\ReservationAccessControlHandler",
 *     "form" = {
 *       "add" = "Drupal\reservations\Form\ReservationForm",
 *       "edit" = "Drupal\reservations\Form\ReservationForm",
 *       "delete" = "Drupal\reservations\Form\ReservationDeleteForm",
 *     },
 *     "views_data" = "\Drupal\views\EntityViewsData",
 *     "route_provider" = {
 *       "html" = "\Drupal\Core\Entity\Routing\AdminHtmlRouteProvider",
 *     },
 *   },
 *   list_cache_contexts = { "user" },
 *   base_table = "reservation",
 *   admin_permission = "administer reservations",
 *   fieldable = FALSE,
 *   entity_keys = {
 *     "id" = "rid",
 *     "uuid" = "uuid",
 *     "label" = "label",
 *   },
 *   links = {
 *     "canonical" = "/admin/reservation/{reservation}",
 *     "collection" = "/admin/reservation/manage/reservations",
 *     "add-form" = "/admin/reservation/add",
 *     "add-page" = "/admin/reservation/addPage",
 *     "edit-form" = "/admin/reservation/{reservation}/edit",
 *     "delete-form" = "/admin/reservation/{reservation}/delete",
 *   }
 * )
 */
class Reservation extends ContentEntityBase implements ReservationInterface {

  use EntityChangedTrait;

  /**
   * Gets the reservation creation timestamp
   */
  public function getCreatedTime() {
    return $this->get('created')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function getOwner() {
    return $this->get('owner_uid')->entity;
  }

  /**
   * {@inheritdoc}
   */
  public function getOwnerId() {
    return $this->get('owner_uid')->target_id;
  }

  /**
   * {@inheritdoc}
   */
  public function setOwnerId($uid) {
    $this->set('owner_uid', $uid);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function setOwner(UserInterface $account) {
    $this->set('owner_uid', $account->id());
    return $this;
  }

  /**
   * {@inheritdoc}
   *
   * Define the field properties here.
   *
   * Field name, type and size determine the table structure.
   *
   * In addition, we can define how the field and its content can be manipulated
   * in the GUI. The behaviour of the widgets used can be determined here.
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {

    $fields = parent::baseFieldDefinitions($entity_type);

    $fields['label'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Label'))
      ->setDescription(t('The label of the reservation'))
      ->setRequired(TRUE)
      ->setSettings(array(
        'default_value' => 'Label 1',
        'max_length' => 64,
        'text_processing' => 0,
      ))
      ->setDisplayOptions('view', array(
        'label' => 'above',
        'type' => 'string',
        'weight' => -6,
      ))
      ->setDisplayOptions('form', array(
        'type' => 'string',
        'weight' => -6,
      ));


    $fields['owner_uid'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Reservation owner'))
      ->setDescription(t('The owner of the reservation.'))
      ->setDefaultValueCallback('Drupal\reservations\Entity\Reservation::getCurrentUserId')
      ->setSetting('target_type', 'user')
      ->setDisplayOptions('view', array(
        'label' => 'above',
        'type' => 'author',
        'weight' => 0,
      ))
      ->setDisplayOptions('form', array(
        'type' => 'entity_reference_autocomplete',
        'weight' => 5,
        'settings' => array(
          'match_operator' => 'CONTAINS',
          'size' => '60',
          'placeholder' => '',
        ),
      ))
      ->setDisplayConfigurable('form', TRUE);

    $fields['season'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Season'))
      ->setDescription(t('The reservation\'s season.'))
      ->setSetting('target_type', 'season')
      ->setDefaultValue('2017');
      
    $fields['start'] = BaseFieldDefinition::create('datetime')
      ->setLabel(t('Start date'))
      ->setDescription(t('The date of the arrival'))
      ->setSetting('datetime_type', 'date')
      ->setDisplayOptions('view', array(
        'label' => 'above',
        'weight' => -5,
      ))
      ->setDisplayOptions('form', array(
        'weight' => -5,
      ))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);
      
    $fields['end'] = BaseFieldDefinition::create('datetime')
      ->setLabel(t('End date'))
      ->setDescription(t('The date of the departure'))
      ->setSetting('datetime_type', 'date')
      ->setDisplayOptions('view', array(
        'label' => 'above',
        'weight' => -5,
      ))
      ->setDisplayOptions('form', array(
        'weight' => -5,
      ))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['state'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('State'))
      ->setDescription(t('The reservation state.'))
      ->setRequired(TRUE)
      ->setDefaultValue('ReservationInterface::SUBMITTED')
      ->setSetting('unsigned', TRUE)
      ->setSetting('size', 'tiny')
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => '',
        'weight' => 0,
      ])
      ->setDisplayOptions('form', [
        'type' => 'hidden',
        'weight' => -1,
      ])
      ->setDisplayConfigurable('form', TRUE);

    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Created'))
      ->setDescription(t('The time that the entity was created.'));

    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setDescription(t('The time that the entity was last edited.'));

    return $fields;
  }

  /**
   * Default value callback for 'owner_uid' base field definition.
   *
   * @see ::baseFieldDefinitions()
   *
   * @return array
   *   An array of default values.
   */
  public static function getCurrentUserId() {
    return [\Drupal::currentUser()->id()];
  }

}

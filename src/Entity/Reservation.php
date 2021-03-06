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
 *   bundle_label = @Translation("Season"),
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
 *   },
 *   bundle_entity_type = "season",
 *   list_cache_contexts = { "user" },
 *   base_table = "reservation",
 *   admin_permission = "administer reservations",
 *   fieldable = FALSE,
 *   entity_keys = {
 *     "id" = "rid",
 *     "uuid" = "uuid",
 *     "label" = "name",
 *     "bundle" = "season",
 *   },
 *   links = {
 *     "canonical" = "/reservation/{reservation}",
 *     "edit-form" = "/reservation/{reservation}/edit",
 *     "delete-form" = "/reservation/{reservation}/delete",
 *     "collection" = "/admin/reservation/manage/reservations"
 *   }
 * )
 */
class Reservation extends ContentEntityBase implements ReservationInterface {

  use EntityChangedTrait;

  /**
   * {@inheritdoc}
   *
   * When a new entity instance is added, set the user_id entity reference to
   * the current user as the creator of the instance.
   */
  public static function preCreate(EntityStorageInterface $storage_controller, array &$values) {
    parent::preCreate($storage_controller, $values);
    $values += array(
      'holder_uid' => \Drupal::currentUser()->id(),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getCreatedTime() {
    return $this->get('created')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function getChangedTime() {
    return $this->get('changed')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function getOwner() {
    return $this->get('holder_uid')->entity;
  }

  /**
   * {@inheritdoc}
   */
  public function getOwnerId() {
    return $this->get('holder_uid')->target_id;
  }

  /**
   * {@inheritdoc}
   */
  public function setOwnerId($uid) {
    $this->set('holder_uid', $uid);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function setOwner(UserInterface $account) {
    $this->set('holder_uid', $account->id());
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

    // Standard field, used as unique if primary index.
    $fields['rid'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('ID'))
      ->setDescription(t('The ID of the Reservation.'))
      ->setReadOnly(TRUE);

    // Standard field, unique outside of the scope of the current project.
    $fields['uuid'] = BaseFieldDefinition::create('uuid')
      ->setLabel(t('UUID'))
      ->setDescription(t('The UUID of the reservation.'))
      ->setReadOnly(TRUE);

    $fields['season'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Season'))
      ->setDescription(t('The season for this reservation'))
      ->setSetting('target_type', 'season');

    $fields['name'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Name'))
      ->setDescription(t('The name of the booker.'))
      ->setRequired(TRUE)
      ->setSettings(array(
        'default_value' => '',
        'max_length' => 255,
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

    $fields['first_name'] = BaseFieldDefinition::create('string')
      ->setLabel(t('First Name'))
      ->setDescription(t('The first name of the booker.'))
      ->setRequired(TRUE)
      ->setSettings(array(
        'default_value' => '',
        'max_length' => 255,
        'text_processing' => 0,
      ))
      ->setDisplayOptions('view', array(
        'label' => 'above',
        'type' => 'string',
        'weight' => -5,
      ))
      ->setDisplayOptions('form', array(
        'type' => 'string',
        'weight' => -5,
      ));

    $fields['email'] = BaseFieldDefinition::create('email')
      ->setLabel(t('Booker\'s e-mail'))
      ->setDescription(t('The contact email address of the booker'))
      ->setRequired(TRUE)
      ->setDisplayOptions('view', array(
        'label' => 'above',
        'weight' => -5,
      ))
      ->setDisplayOptions('form', array(
        'weight' => -5,
      ));

    $fields['holder_uid'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Reservation holder uid'))
      ->setDescription(t('The uid of the reservation holder.'))
      ->setSetting('target_type', 'user')
      ->setDisplayOptions('view', array(
        'label' => 'above',
        'type' => 'entity_reference',
        'weight' => -3,
      ));

    $fields['uid'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('booker uid'))
      ->setDescription(t('The booker name.'))
      ->setSetting('target_type', 'user')
      ->setRequired(FALSE)
      ->setDisplayOptions('view', array(
        'label' => 'above',
        'type' => 'entity_reference',
        'weight' => -3,
      ))
      ->setDisplayOptions('form', array(
        'type' => 'entity_reference_autocomplete',
        'settings' => array(
          'match_operator' => 'CONTAINS',
          'size' => 60,
          'placeholder' => '',
        ),
        'weight' => -3,
      ));
      
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

    $fields['status'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Status'))
      ->setDescription(t('The reservation status.'))
      ->setRequired(TRUE)
      ->setDefaultValue('active')
      ->setSetting('max_length', 255)
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'string',
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

}

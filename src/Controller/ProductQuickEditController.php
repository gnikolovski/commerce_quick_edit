<?php

namespace Drupal\commerce_quick_edit\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Entity\EntityFormBuilder;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\OpenModalDialogCommand;

/**
 * ProductQuickEditController class.
 */
class ProductQuickEditController extends ControllerBase {

  /**
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * @var \Drupal\Core\Entity\EntityFormBuilder
   */
  protected $entityFormBuilder;

  /**
   * QuickNoteController constructor.
   *
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   * @param \Drupal\Core\Entity\EntityFormBuilder $entity_form_builder
   */
  public function __construct(EntityTypeManagerInterface $entity_type_manager, EntityFormBuilder $entity_form_builder) {
    $this->entityTypeManager = $entity_type_manager;
    $this->entityFormBuilder = $entity_form_builder;
  }

  /**
   * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
   *
   * @return static
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity_type.manager'),
      $container->get('entity.form_builder')
    );
  }

  /**
   * Open product edit form in a modal.
   *
   * @param integer $id
   *
   * @return \Drupal\Core\Ajax\AjaxResponse
   */
  public function openModalForm($id) {
    $product_entity = $this->entityTypeManager
      ->getStorage('commerce_product')
      ->load($id);

    $quick_note_form = $this->entityFormBuilder->getForm($product_entity);
    $quick_note_form['#attributes']['class'][] = 'commerce-quick-edit';
    $response = new AjaxResponse();

    return $response->addCommand(
      new OpenModalDialogCommand(
        'Product edit',
        $quick_note_form,
        ['width' => '95%']
      )
    );
  }

}

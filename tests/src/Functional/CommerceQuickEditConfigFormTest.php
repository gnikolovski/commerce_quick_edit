<?php

namespace Drupal\Tests\commerce_quick_edit\Functional;

use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\Tests\BrowserTestBase;

/**
 * Tests the config form.
 *
 * @group commerce_quick_edit
 */
class CommerceQuickEditConfigFormTest extends BrowserTestBase {

  use StringTranslationTrait;

  /**
   * Modules to enable.
   *
   * @var array
   */
  public static $modules = [
    'commerce_product',
    'commerce_quick_edit',
  ];

  /**
   * {@inheritdoc}
   */
  protected $defaultTheme = 'stark';

  /**
   * {@inheritdoc}
   */
  protected function setUp() {
    parent::setUp();

    $this->drupalLogin($this->drupalCreateUser(['access commerce administration pages']));
  }

  /**
   * Tests form structure.
   */
  public function testFormStructure() {
    $this->drupalGet('admin/commerce/config/commerce-quick-edit');
    $this->assertSession()->statusCodeEquals(200);
    $this->assertSession()->titleEquals('Commerce Quick Edit | Drupal');
    $this->assertSession()->fieldExists('edit-modal-width');
    $this->assertSession()->buttonExists($this->t('Save configuration'));
  }

  /**
   * Tests form access.
   */
  public function testFormAccess() {
    $this->drupalLogout();
    $this->drupalGet('admin/commerce/config/commerce-quick-edit');
    $this->assertSession()->statusCodeEquals(403);
  }

}

<?php

/**
 * Pest bootstrap
 * Binds the package TestCase to all tests in this directory.
 */

use InEngine\Alert\Tests\TestCase;

uses(TestCase::class)->in(__DIR__);

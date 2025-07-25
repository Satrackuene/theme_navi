<?php
namespace Navicore;

class Plugin
{
  private static $instance;

  public $admin;
  public $vehicles;
  public $recall_cpt;
  public $rest;
  public $shortcode;

  public static function instance()
  {
    if (null === self::$instance) {
      self::$instance = new self();
    }
    return self::$instance;
  }

  private function __construct()
  {
    $this->admin = new Admin();
    $this->vehicles = new Vehicles();
    $this->recall_cpt = new Recall_CPT();
    $this->rest = new Rest();
    $this->shortcode = new Shortcode();
  }
}
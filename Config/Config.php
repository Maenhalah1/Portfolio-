<?php 

namespace Config;

abstract class Config {

    const ROOT_PATH =  __DIR__ . DS . ".." . DS;
    const APP_PATH =  self::ROOT_PATH . "App" . DS;
    const CONFIG_PATH = self::ROOT_PATH  . "Config" . DS;
    const UPLOADS_PATH = self::ROOT_PATH  . "public_html" . DS . "uploads" . DS;
    const MEDIA_UPLOAD_PATH = self::ROOT_PATH  . "public_html" . DS . "media";

    const SESSIONS_SAVE_PATH = self::ROOT_PATH . "sessions";

    //Paths
    const CONTROLLERS_PATH = self::APP_PATH . DS . "Controllers" . DS;
    const MODELS_PATH  = self::APP_PATH . DS . "Models" . DS;
    const VIEWS_PATH = self::APP_PATH . DS . "Views" . DS;
    const LANGUAGES_PATH = self::APP_PATH . DS . "Languages" . DS;
    const INCLUDE_PATH = self::VIEWS_PATH . DS . "Include" . DS;
    const CSS_PATH = DS ."css" . DS;
    const JS_PATH = DS . "js" . DS;
    const MEDIA_PATH = DS . "media" . DS;

    // Settings
    const SHOW_ERRORS = FALSE;
    const ACTIVE_APP = TRUE;
    const DEFAULT_LANGUAGE = "en";
    const MAX_FILES_SIZE = 10485760; // 10 MB
    const MAX_IMAGES_SIZE = 8388608; // 10 MB
    const MAX_VIDEOS_SIZE = 52428800;

    // const DB_HOST = "localhost";
    // const DB_NAME = "id16938976_maenhalah";
    // const DB_USER = "id16938976_maen";
    // const DB_PASSWORD = 'SFnL*1^bjbNVdxf1';

    const DB_HOST = "localhost";
    const DB_NAME = "portfolio";
    const DB_USER = "root";
    const DB_PASSWORD = '';

    /* TODO:: Move it To Method in Service Class */

}
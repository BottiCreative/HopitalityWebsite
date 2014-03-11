<?php    
defined('C5_EXECUTE') or die("Access Denied.");

class MagicDataSymbolsHelper {
 
    static $md_pkg;
    static $token_replacement;
 
    public function __construct($keep=true){
       MagicDataSymbolsHelper::$md_pkg  = Package::getByHandle('jl_magic_data');
      if (is_object(MagicDataSymbolsHelper::$md_pkg)){
         Loader::library('magic_data/token_replacement', 'jl_magic_data');
         MagicDataSymbolsHelper::$token_replacement = new MagicDataTokenReplacement();
         MagicDataSymbolsHelper::$token_replacement -> set_keep_unfulfilled_tokens($keep);
       }
    }
 
    public function confirm_installed(){
       return is_object(MagicDataSymbolsHelper::$token_replacement);
     }
 
    public function fill($content){
       if (MagicDataSymbolsHelper::$token_replacement){
          return MagicDataSymbolsHelper::$token_replacement -> fill($content);
       }
       return $content;
    }
}
?>
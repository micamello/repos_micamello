<?php
 /*** Token generator/validator.
  * Ported from Django: http://git.io/pZjqWA
  *
  * @author Carlos Escribano Rey
*/
class PasswordResetTokenGenerator{
    protected $secret;
    protected $timeout;
 
    /*** Configure the secret key and token expiration in days.*/
    public function __construct($secret, $timeout){
      $this->secret = $this->forceBytes($secret);
      $this->timeout = intval($timeout);
    }

    /**Create a token for a User.*
     * @param  sfGuardUser $user
     * @return string*/
    public function makeToken($idusu,$fechausu){
      return $this->makeTokenWithTimestamp($idusu,$fechausu,$this->days($this->today()));
    }
 
    /*** Validates a token
     * @param  sfGuardUser $user
     * @param  string $token
     * @return boolean*/
    public function checkToken($idusu, $fechausu, $token){      
      list($ts_b36, $hash) = explode("-", $token);
      $ts = base_convert($ts_b36, 36, 10);      
      if (!$this->tokensAreEqual($token,$this->makeTokenWithTimestamp($idusu, $fechausu, $ts))){
        return false;
      }
      if ( $this->timeout < $this->days($this->today()) - $ts ){
        return false;
      }
      return true;
    }
 
    /*** Generates a token for a user using the number of days since
     * 2001-1-1.
     ** @param  sfGuardUser  $user   The user object.
      * @param  integer      $ts     Number of days since 2001-1-1.
      * @return string               The token*/
    protected function makeTokenWithTimestamp($idusu,$fechausu, $ts){
      // timestamp is number of days since 2001-1-1.  Converted to
      // base 36, this gives us a 3 digit string until about 2121
      $ts_b36 = base_convert((string) $ts, 10, 36);

      // By hashing on the internal state of the user and using state
      // that is sure to change (the password salt will change as soon as
      // the password is set, at least for current Django auth, and
      // last_login will also change), we produce a hash that will be
      // invalid as soon as it is used.
      // We limit the hash to 20 chars to keep URL short
      $key_salt = "contrasena";
      $value = sprintf("%d%s%s", $idusu, $fechausu, $ts);      
      return sprintf("%s-%s", $ts_b36, $this->getHash($key_salt, $value));
    }

    /*** Generates a "short" hash for a value.
     * @param  string $key_salt
     * @param  string $value
     * @return string*/
    protected function getHash($key_salt, $value){
      $key_salt = $this->forceBytes($key_salt);
      // We need to generate a derived key from our base key.  We can do
      // this by passing the key_salt and our base key through a
      // pseudo-random function and SHA1 works nicely.
      $key = sha1($key_salt . $this->secret);
      // If len(key_salt + secret) > sha_constructor().block_size, the
      // above line is redundant and could be replaced by:
      //        key = key_salt + secret
      // since the hmac module does the same thing for keys longer than
      // the block size. However, we need to ensure that we *always* do
      // this.
      $hash = hash_hmac('sha1', $this->forceBytes($value), $key);
      // Filter out even characters
      $result = array();
      foreach (str_split($hash) as $index => $character){
       if ($index % 2 != 0) continue;
         $result[] = $character;
      }
      return implode('', $result);
    }

    protected function forceBytes($value){
      return mb_convert_encoding($value, 'ISO-8859-1');
    }

    /*** Returns the current date as an integer value
     * @return integer */
    protected function today(){
      $today = new DateTime("now", new DateTimeZone("America/Guayaquil"));      
      return $today->getTimestamp();
    }

    /*** Returns the number of days between the timestamp passed as parameter
     * and 2001-01-01.*
     * @param  integer $dt A timestamp
     * @return integer*/
    protected function days($dt){
      $baseDate = new DateTime("2001-01-01T00:00:00",new DateTimeZone("America/Guayaquil"));
      $dateDiff = $dt - $baseDate->getTimestamp();
      return floor($dateDiff / (60 * 60 * 24));
    }

    /** Returns true if the two tokens are equal. The comparison is made
     * at bit level.*
     * @param  string $token1
     * @param  string $token2
     * @return boolean*/
    protected function tokensAreEqual($token1, $token2){
      $a_token1 = str_split($token1);
      $a_token2 = str_split($token2);
      if ( count($a_token1) != count($a_token2) ){
        return false;
      }
      $result = 0;
      for ($i = 0, $N = count($a_token1); $i < $N; $i++){
        $x = $a_token1[$i];
        $y = $a_token2[$i];
        $result |= ord($x) ^ ord($y);
      }
      return $result == 0;
    }
}
?>
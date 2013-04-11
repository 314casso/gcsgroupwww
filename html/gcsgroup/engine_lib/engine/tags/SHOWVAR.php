<?

/*
 *  $Id: $
 */

global ${$given};
echo htmlspecialchars(isset(${$given}) ? ${$given} : $_SESSION[$given]);
?>
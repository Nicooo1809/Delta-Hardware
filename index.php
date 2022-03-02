<?php 
require_once("templates/header.php");
?>


<div
  class="bg-image p-5 text-center shadow-1-strong rounded mb-5 text-white"
  style="background-image: url('/media/RTX_Showcase.jpg');"
>

  <h1 class="mb-3 h2">Lorem ipsum</h1>

  <p>
    Lorem ipsum dolor, sit amet consectetur adipisicing elit. Repellendus praesentium
    labore accusamus sequi, voluptate debitis tenetur in deleniti possimus modi voluptatum
    neque maiores dolorem unde? Aut dolorum quod excepturi fugit.
  </p>
</div>

<div class="alert text-center cookiealert" role="alert">
    <b>Magst du Kekse?</b> &#x1F36A; Wir verwenden Cookies um dir ein großartiges Website-Erlebnis zu bieten. <a href="https://cookiesandyou.com/" target="_blank">Mehr erfahren</a>
  
    <button type="button" class="btn btn-primary btn-sm acceptcookies">
        Ich stimme zu
    </button>
  </div>
  
  <script src="/js/cookies.js"></script>

<?php
require_once("templates/footer.html");
?>

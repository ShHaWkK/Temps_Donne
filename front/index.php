
<?php

require_once('includes/head.php');
require_once('includes/header.php');

echo "<title>Accueil - Au temps donné</title>";
?>

<body>
  
  <div class="carousel-container">
    <button class="carousel-arrow">&lt;</button>
    <div class="carousel-caption">
      <h1>ENSEMBLE, CHANGEONS DES VIES</h1>
      <center>
     Devenez bénévole dès maintenant !
      </center>
      <button>JE DEVIENS BÉNÉVOLE</button>
    </div>
    <button class="carousel-arrow">&gt;</button>
  </div>

  <div class="section">
    <div class="section-title">QUI SOMMES NOUS ?</div>
    <p class="section-content">Fondée en 1987 à Saint-Quentin, dans l'Aisne, en réponse à la crise industrielle locale, “Au temps donné” n’a cessé de proposer son aide à ceux qui en ont besoin.
    À l'origine centrée sur la distribution alimentaire et les maraudes urbaines,nous avons progressivement élargi notre gamme de services au fil du temps:
    de l'administratif aux navettes pour les rendez-vous éloignés, des cours d'alphabétisation au soutien scolaire, 
    ainsi que des événements de collecte de fonds et des activités pour les personnes âgées. 
  Notre engagement envers la communauté reste notre priorité.</p>
    <button class="section-button"><i class="fa-solid fa-house"></i> Découvrir nos services</button>
  </div>

  <div class="location-section">
    <h2 class="location-title">OÙ NOUS TROUVER ?</h2>
    <p class="location-text">Le local historique de l’association a été créé à Saint-Quentin, au 6 boulevard Gambetta...
      Mais au fil des années, l’association s’est dotée d’un entrepôt et de plusieurs annexes.
      Que vous souhaitiez vous engager en tant que bénévole ou bénéficier de nos services,
      découvrez nos différents sites une différence dans la vie des autres.
    </p>
    <i class="fas fa-map-marker-alt location-icon"></i>
  </div>

  <div class="section">
    <div class="section-title">COMMENT NOUS AIDER ?</div>
    <p class="section-content">Vous pouvez nous aider de différentes manières: en faisant un don, en devenant bénévole, en participant à nos événements de collecte de fonds, ou en partageant notre cause sur les réseaux sociaux.
    Chaque geste compte, et nous vous en sommes reconnaissants.</p>
    <button class="section-button"><i class="fa-solid fa-hand-holding-heart"></i> Faire un don</button>
  </div>

  <?php 
    include_once('includes/footer.php');
  ?>

</body>
</html>
<?php
include './Partial/header.php';
  
  // On enregistre notre autoload.

include './config/Autoloader.php';



  // On fait appel à la connexion à la bdd
  require 'config/init.php';

  // On fait appel à le code métier
  require 'combat.php';
?>

    <p>Nombre de personnages créés : <?= $manager->count() ?></p>
<?php

  // On a un message à afficher ?
  if (isset($message)) {
    echo '<b>', $message, '</b>'; // Si oui, on l'affiche.
  }
  // Si on utilise un personnage (nouveau ou pas).
  if (isset($perso)) {

?>
<div class='ml-4'>
    <p ><a href="?deconnexion=1">Déconnexion</a></p>
    
    <fieldset >
      <legend>Mes informations</legend>
      <p>
        Nom : <?= htmlspecialchars($perso->nom()) ?><br />
        Type : <?= htmlspecialchars($perso->type()) ?><br />
        Dégâts : <?= $perso->degats() ?><br />
        niveau : <?= $perso->niveau() ?><br />
        experience : <?= $perso->experience() ?><br />
        force : <?= $perso->strength() ?><br />
      </p>
    </fieldset>
    
    <fieldset >
      <legend>Qui frapper ?</legend>
      <p>
        <?php
          $persos = $manager->getList($perso->nom());
          if (empty($persos)) {
            echo 'Personne à frapper !';
          } 
          else {
            foreach ($persos as $unPerso)
            {    
            if ($unPerso->type() == "Guerrier") {
              $bgCard = "bg-danger";
            }elseif ($unPerso->type() == "Archer"){
              $bgCard = "bg-warning";
            }else {
              $bgCard = "bg-info";
            }
              echo '
              <div class ="card m-5 text-center shadow p-3 mb-5 rounded '.$bgCard.'">',
              
              '<h5>',htmlspecialchars($unPerso->nom()),'</h5>', '<br />',
              '<h6>',$unPerso->type(),'</h6>', '<br />',
              '(dégâts : ', $unPerso->degats(), '
              niveau : ', $unPerso->niveau(), '
              experience : ', $unPerso->experience(), '
              force : ', $unPerso->strength(), ')<br />', '<br />',
              '<a href="?frapper=',$unPerso->id(), '">', '<button>Attack</button>','</a>',
              '</div>';
            }
          }
        ?>
      </p>
    </fieldset>
</div>
<?php
}
// Sinon on affiche le formulaire de création de personnage
else {
?>


<!-- Création Personnage -->
  <form action="" method="post">
    <p>
      Nom : <input type="text" name="nom" maxlength="50" />
      Type : 
        <select name="type" >
          <option value="Guerrier">Guerrier</option>
          <option value="Archer">Archer</option>
          <option value="Magicien">Magicien</option>
        </select>

      <input type="submit" value="Créer ce personnage" name="creer" />
    </p>
  </form>

  <br>
  <hr>
  <br>


  <!-- Selection personnage -->
  <form action="" method="post">
    <p>
    Nom :  <input type="text" name="nom" maxlength="50" />
      <input type="submit" value="Utiliser ce personnage" name="utiliser" />
    </p>
  </form>

<?php } ?>

<?php
include './config/DebugInfo.php';
include './Partial/footer.php';
  // Si on a créé un personnage, on le stocke dans une variable session afin d'économiser une requête SQL.
  if (isset($perso)) {
    $_SESSION['perso'] = $perso;
  }
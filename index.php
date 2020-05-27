<?php
// Autoloader.

  include './config/Autoloader.php';

  // connexion à la DB
  require 'config/init.php';

  // Code métier
  require 'combat.php';
  
  
  //Header Page
  include './Partial/header.php';
?>

<?php

  // On a un message à afficher ?
  if (isset($message)) {
    echo '<b>', $message, '</b>'; // Si oui, on l'affiche.
  }
  // Si on utilise un personnage (nouveau ou pas).
  if (isset($perso)) {

?>
<div class='p-5'>
    
    <fieldset class='p-5'>

      <legend>Mes informations</legend>

      <div class ="card mx-5 text-white text-center bg-secondary p-3">
      
        <h4>
          Nom : <?= htmlspecialchars($perso->nom()) ?>
        </h4>
        <br>
        <h5>
          Type : <?= htmlspecialchars($perso->type()) ?>
        </h5>
        <br>
         <hr>
        <p>
          Dégâts : <?= $perso->degats() ?>
          /
          Niveau : <?= $perso->niveau() ?>
          /
          Experience : <?= $perso->experience() ?>
          /
          Force : <?= $perso->strength() ?>
          <br >
        </p>
      </div>

      <p class ='ml-5 mt-4'>
        <button class="btn btn-danger"> 
          <a href="?deconnexion=1"> 
            Déconnexion 
          </a>
        </button>
      </p>
    
    </fieldset>
    
    <fieldset class='p-5'>
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
            ?>
              
              <div id="divList" class ="card mx-5 mb-5 text-center p-3 <?= $bgCard ?>">
                <a href="?frapper=<?= $unPerso->id() ?>">
                  <h4>
                    <?=htmlspecialchars($unPerso->nom())?>
                  </h4>
                  <br>
                  <h5>
                    <?= $unPerso->type()?>
                  </h5>
                  <br>
                   <hr> 
                  <p>
                    Dégâts :  <?=$unPerso->degats()?>
                     / 
                     Niveau :  <?=$unPerso->niveau()?>
                     /
                     Experience : <?=$unPerso->experience()?>
                     / 
                     Force :  <?=$unPerso->strength()?>
                    <br>
                  <p>
                </a>
              </div>

            <?php
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
//include './config/DebugInfo.php';
include './Partial/footer.php';
  // Si on a créé un personnage, on le stocke dans une variable session afin d'économiser une requête SQL.
  if (isset($perso)) {
    $_SESSION['perso'] = $perso;
  }
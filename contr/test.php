<?php

session_start();
/**
 * Elenco degli indici del database
 *
 * @copyright  Copyright (C) 2014 Renato Tamilio
 * @license    GNU Affero General Public License versione 3 o successivi; vedete agpl-3.0.txt
 */
require_once '../php-ini' . $_SESSION['suffisso'] . '.php';
require_once '../lib/funzioni.php';
require_once("../lib/crud/CRUD.php");
//require_once '../lib/ db / query.php';
//$lQuery = LQuery::getIstanza();
// istruzioni per tornare alla pagina di login 
////session_start();

$tipoutente = $_SESSION["tipoutente"]; //prende la variabile presente nella sessione

if ($tipoutente == "")
{
    header("location: ../login/login.php?suffisso=" . $_SESSION['suffisso']);
    die;
}
$titolo = "TEST CRUD";
$script = "";
stampa_head($titolo, "", $script, "PMSDA");
stampa_testata("<a href='../login/ele_ges.php'>PAGINA PRINCIPALE</a> - $titolo", "", "$nome_scuola", "$comune_scuola");
$con = mysqli_connect($db_server, $db_user, $db_password, $db_nome);



$daticrud = array();
// Tabella da modificare
$daticrud['tabella'] = inspref("tbl_alunni");
$daticrud['aliastabella'] = "Alunni";
// Campo con l'id univoco per la tabella
$daticrud['campochiave'] = "idalunno";
// Campi da visualizzare senza chiave esterna
$daticrud['elencocampi'] = ["fk_1","cognome", "nome","fk_0","telcell"];
// Intestazioni da usare nella visualizzazione tabellare(una per ogni campo e per ogni fk), 
// se vuota non verrà visualizzato nell'elenco
$daticrud['intestazioni']=["Classe","Cognome","Nome","Comune nascita",""];
// Etichette per maschere di modifica e inserimento.
$daticrud['intcampi']=["Classe","Cognome","Nome","Comune nascita","Telefono cellulare"];
// Campi con chiave esterna (tabella esterna, chiave primaria nella tabella esterna, campi da visualizzare,chiave esterna)
$daticrud['fk']=array();
$daticrud['fk'][] = [inspref("tbl_comuni"),"idcomune",array("denominazione"),"idcomres"];
$daticrud['fk'][] = [inspref("tbl_classi"),"idclasse",array("anno","sezione", "specializzazione"),"idclasse"];


// Campi in base ai quali ordinare
$daticrud['campiordinamento']= array("cognome","nome");
// Condizione di selezione, specificare solo 'true' se non ce ne sono
$daticrud['condizione']= inspref("tbl_alunni.idclasse<>0");
$_SESSION['daticrud'] = $daticrud;

$c = new CRUD($con);

$c->visualizza();


stampa_piede();

/*
// creaGruppoGlobaleMoodle($tokenservizimoodle,$urlmoodle, "5ainf2017", "5ainf2017");
AggiungiGruppoClasse($con, $tokenservizimoodle, $urlmoodle, 28,$annoscol);
 

 $esito=invia_mail("pietro.tamburrano@gmail.com", "Prova", "Mail di prova.");
//$esito=mail("pietro.tamburrano@gmail.com", "Conferma", "prova","From: scaforchio@gmail.com");  
print "Esito $esito";
$esito=mail("pietro.tamburrano@gmail.com", "Conferma", "prova","From: lampschool@isdimaggio.it");  
print "Esito $esito";
stampa_piede("");

function AggiungiGruppoClasse($con,$token,$urlmoodle,$idclasse,$annoscol)
{
    $annocl=decodifica_anno_classe($idclasse, $con);
    $sezicl=decodifica_classe_sezione($idclasse, $con);
    $speccl= substr(decodifica_classe_spec($idclasse, $con),0,3);
    $identgruppo= strtolower($annocl.$sezicl.$speccl.$annoscol);
    $queryalunni="select idalunno from tbl_alunni where idclasse='$idclasse'";
    $res=mysqli_query($con, inspref($queryalunni)) or die("Errore $queryalunni");
    while ($rec=mysqli_fetch_array($res))
    {
        $idalunno=$rec['idalunno'];
        $username= costruisciUsernameMoodle($idalunno);
        aggiungiUtenteAGruppoGlobale($token, $urlmoodle, $identgruppo, $username);

        
    }
}
 * 
 */
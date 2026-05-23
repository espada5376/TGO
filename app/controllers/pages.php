<?php

function publier_une_annoncePage($conn)
{
    require __DIR__ . '/addproductpage.php';
    addproductpagecontroller($conn);
}

function apresCommandePage($conn)
{
    require __DIR__ . '/aprèscommandepage.php';
    apresCmdpage($conn);
}

function boutiquePage($conn)
{
    require __DIR__ . '/boutiquepage.php';
}

function annoncePage($conn)
{
    require_once __DIR__ . '/commandpage.php';
    commandpagecontroller($conn);
}

function deconnexionPage()
{
    require __DIR__ . '/deconnexionpage.php';
}

function infoComptePage($conn)
{
    require __DIR__ . '/infocomptepage.php';
    infocomptepagecontroller($conn);
}

function mescommandesPage($conn)
{
    require_once __DIR__ . '/mescommandespage.php';
    mescommandespagecontroller();
}

function panierPage($conn)
{
    require_once __DIR__ . '/panierpage.php';
    panierpagecontroller($conn);
}

function profilPage($conn)
{
    require __DIR__ . '/profilpage.php';
    profilpagecontroller($conn);
}

function profil_boutiquePage($conn)
{
    require_once __DIR__ . '/profilboutiquepage.php';
    profilboutiquepagecontroller($conn);
}

function voir_mes_annoncesPage($conn)
{
    require __DIR__ . '/viewmyproductpage.php';
    viewmyproductpagecontroller($conn);
}

function connexionPage($conn)
{
    require_once __DIR__ . '/signInpage.php';
    signInPagecontroller($conn);
}

function inscriptionPage($conn)
{
    require_once __DIR__ . '/signInpage.php';
    signUppagecontroller($conn);
}

function homePage(PDO $conn)
{
    require_once __DIR__ . '/homepage.php';
    homepagecontroller($conn);
}


function modifier_annoncePage($conn)
{
    require_once __DIR__ . '/modproductpage.php';
    modproductpagecontroller($conn);
}

function cguPage(){
    require_once __DIR__ . '/cgupage.php';
    cgupagecontroller();
}

function pcPage(){
    require_once __DIR__ . '/pcpage.php';
    pcpagecontroller();
}
function sharePage($conn){
    require_once __DIR__ . '/sharepage.php';
    sharepage($conn);
}

function modepaiementPage($conn){
    require_once __DIR__ . '/modepaiementpage.php';
    modepaiementpagecontroller($conn);
}

function creer_ma_boutiquePage($conn){
    require_once __DIR__ . '/createboutiquepage.php';
    creerboutique($conn); 
}

function searchPage($conn){
    require_once __DIR__ . '/searchpage.php';
    searchcontroller($conn);
}

function accesrefusePage($conn){
    require_once __DIR__ . '/accesrefusepage.php';
    error403Controller($conn);
}

?>
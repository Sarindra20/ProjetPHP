<style>
/* ================= FOOTER ================= */

.footer{
    position: fixed;
    bottom: 0;
    left: 0;
    width: 100%;

    height: 60px;

    background: #04371d;
    color: white;

    display: flex;
    justify-content: space-between;
    align-items: center;

    padding: 0 30px;

    box-shadow: 0 -3px 12px rgba(0,0,0,.2);

    z-index: 999;
}

/* Partie gauche */
.footer-left{
    font-size:14px;
}

/* Partie centre */
.footer-center{
    font-size:14px;
    font-weight:bold;
}

/* Partie droite */
.footer-right{
    font-size:14px;
}

.footer a{
    color:#f0a90f;
    text-decoration:none;
    font-weight:bold;
}

.footer a:hover{
    text-decoration:underline;
}
</style>

<footer class="footer">

    <div class="footer-left">
        © <?= date("d/m/Y") ?>
    </div>

    <div class="footer-center">
        Gestion des Soutenances | Projet PHP
    </div>

    <div class="footer-right">
        Développé par <strong>Tefy & Kanto</strong>
    </div>

</footer>
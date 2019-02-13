<div id="tabs" class="tabs">
    <nav>
        <ul>
            <li id="tab1" <?= $displayTab; ?>><a href="<?= URL ?>/panel#seccion-1" class="icon-profile"><span>Empresa</span></a>
            </li>
            <li class="hidden-plan1" id="tab2" <?= $displayTab; ?>><a href="<?= URL ?>/panel#seccion-2" class="icon-menut-items"><span>Menús</span></a>
            </li>
            <li id="tab3" <?= $classTab ?>><a href="<?= URL ?>/panel#seccion-3"
                                              class="icon-settings"><span>Perfil</span></a>
            </li>
        </ul>
    </nav>
    <div class="content">
        <section id="seccion-1" <?= $displaySeccion ?>>
            <?php include("tabs/modificarEmpresa.php") ?>
        </section><!-- seccion 1 -->
        <section class="hidden-plan1" id="seccion-2" <?= $displaySeccion ?>>
            <?php include("tabs/verMenus.php") ?>
        </section><!-- seccion 2 -->
        <section id="seccion-3" <?= $classSeccion ?>>
            <?php include("tabs/modificarPerfil.php") ?>
        </section><!-- seccion 3 -->
    </div><!-- End content -->
</div>
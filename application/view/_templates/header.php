<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?= $this->config_sistema->titulo; ?></title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="icon" type="imagem/png" href="<?= URL . 'img/logos/favicon.png' ?>" />
  <?= $this->renderStyle() ?>

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>

<body class="hold-transition skin-blue sidebar-mini">

  <div class="wrapper">
    <header class="main-header">
      <a href="#" class="logo">
        <div class="row">
          <img class="logo-mini" src="<?= URL . 'img/logos/mini.png' ?>">
          <img class="logo-lg" src="<?= URL . 'img/logos/logo_menu.png' ?>">
        </div>
      </a>
      <nav class="navbar navbar-static-top">
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
          <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">
            <li class="dropdown user user-menu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <span class="hidden-xs"><?= $_SESSION['ops']['nome'] ?></span>
              </a>
              <ul class="dropdown-menu">
                <li class="user-header" style="height: 100px">
                  <p>
                    <?= $_SESSION['ops']['nome'] ?>
                    <br>
                    <small><?= $_SESSION['ops']['email'] ?></small>
                  </p>
                </li>
                <li class="user-footer">
                  <div class="pull-right">
                    <a href="<?= URL ?>login/logout" class="btn btn-default btn-flat"><i class="fa fa-sign-out"></i> Sair</a>
                  </div>
                </li>
              </ul>
            </li>
          </ul>
        </div>
      </nav>
    </header>
    <aside class="main-sidebar">
      <section class="sidebar">
        <?php if (isset($this->paginas) && count($this->paginas) >= 1) : ?>
          <?php $id_celula = (isset($id_celula) ? $id_celula : null); ?>
          <?php $id_plataforma = (isset($id_plataforma) ? $id_plataforma : null); ?>
          <?php $id_vendedor = (isset($id_vendedor) ? $id_vendedor : null); ?>
          <?php $id_cliente = (isset($id_cliente) ? $id_cliente : null); ?>
          <ul class="sidebar-menu" data-widget="tree">
            <li class="header">GERENCIAMENTO</li>

            <?php
            $id = "";
            if (isset($_SESSION['ops']['id_plataforma']) && $_SESSION['ops']['id_plataforma'] != null) {
              $id = $_SESSION['ops']['id_plataforma'];
            }

            if (isset($_SESSION['ops']['id_vendedor']) && $_SESSION['ops']['id_vendedor'] != null) {
              $id = $_SESSION['ops']['id_vendedor'];
            }

            if (isset($_SESSION['ops']['id_celula']) && $_SESSION['ops']['id_celula'] != null) {
              $id = $_SESSION['ops']['id_celula'];
            }
            ?>
            <?php foreach ($this->paginas as $pagina) : ?>
              <li class="pagina <?= count($this->menu->getSubmenuByMenu($pagina->id_menu)) >= 1 ? 'treeview' : ''; ?>">
                <?php if ($pagina->nome == "Listar" && isset($_SESSION['ops']['nivel']) && $_SESSION['ops']['nivel'] > 0) : ?>
                  <?php continue ?>
                <?php endif ?>
                <a id="<?= $pagina->id_menu; ?>" href="<?= URL . $pagina->rota . "/" . ($pagina->id_sub_pagina == 14 || $pagina->id_sub_pagina == 19 && $pagina->rota != '#' ? $id : null); ?>">
                  <i class="fa <?= $pagina->icone; ?>"></i>
                  <span><?= $pagina->nome; ?></span>

                  <?php if (count($this->menu->getSubmenuByMenu($pagina->id_menu)) >= 1) : ?>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  <?php endif; ?>
                </a>

                <?php if (count($this->menu->getSubmenuByMenu($pagina->id_menu)) >= 1) : ?>
                  <ul class="treeview-menu">
                    <?php foreach ($this->menu->getSubmenuByMenu($pagina->id_menu) as $submenu) : ?>
                      <?php
                      if ($pagina->id_menu == 14 && $submenu->nome != 'Listar' && is_null($id_plataforma)) {
                        continue;
                      }

                      if ($pagina->id_menu == 19 && $submenu->nome != 'Listar' && is_null($id_vendedor)) {
                        continue;
                      }

                      if ($pagina->id_menu == 11 && $submenu->nome != 'Listar' && is_null($id_celula)) {
                        continue;
                      }

                      if ($pagina->id_menu == 22 && $submenu->nome != 'Listar' && is_null($id_cliente)) {
                        continue;
                      }
                      ?>

                      <li class="pagina">
                        <?php
                        $pagina_href = URL . $submenu->rota;
                        if ($submenu->rota != "#" && $submenu->nome != "Listar") {
                          if ($pagina->id_menu == 14) {
                            $pagina_href .= "/" . $id_plataforma;
                          } elseif ($pagina->id_menu == 19) {
                            $pagina_href .= "/" . $id_vendedor;
                          } elseif ($pagina->id_menu == 11) {
                            $pagina_href .= "/" . $id_celula;
                          }
                        }
                        ?>
                        <a id="<?= $submenu->id_menu; ?>" href="<?= $pagina_href; ?>">
                          <i class="fa <?= $submenu->icone; ?>"></i>
                          <span><?= $submenu->nome; ?></span>
                        </a>
                      </li>
                    <?php endforeach; ?>
                  </ul>
                <?php endif; ?>
              </li>
            <?php endforeach; ?>
          </ul>
        <?php endif; ?>
      </section>
    </aside>
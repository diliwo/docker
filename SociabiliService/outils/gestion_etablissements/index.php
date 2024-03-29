<?php
session_start();

require 'config.php';
$conn = oci_connect(ORACLE_USERNAME, ORACLE_PASSWORD, ORACLE_CONNECTION_STRING, ORACLE_CHARSET);

$sqlt = "SELECT * FROM SSC_ETABLISSEMENT_TYPE ORDER BY LIBELLE";
$stid = oci_parse($conn, $sqlt);
oci_execute($stid);
oci_fetch_all($stid, $types_enseignement, 0, -1, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
oci_free_statement($stid);

oci_close($conn);
?><!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Listing | Gestion des établissements (Helpdesk Social)</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <link rel="stylesheet" href="../libs/bootstrap/3.3.7/css/bootstrap.min.css">
    <!--[if lt IE 9]>
        <script src="../libs/legacy/html5shiv.js"></script>
        <script src="../libs/legacy/respond.min.js"></script>
    <![endif]-->
</head>
<body style="padding-top: 70px;">   
    <div class="container">
        <div class="row">
            <form id="frmAjax" class="col-lg-4">
                <div class="input-group">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-search"></span></span>
                    <input type="text" class="form-control" name="libelle" placeholder="Libellé">
                </div>
                <br>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Filtres</h3>
                    </div>
                    <div class="panel-body">
                        <?php foreach ($types_enseignement as $type_enseignement): ?>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="type[]" value="<?php echo $type_enseignement['ID_ETABLISSEMENT_TYPE']; ?>">
                                    <?php echo $type_enseignement['LIBELLE']; ?>
                                </label>
                            </div>
                        <?php endforeach; ?>
                        <div class="checkbox text-muted"><label><input type="checkbox" name="type[]" value="all"> Tous</label></div>
                        <hr>
                        <div class="checkbox"><label><input type="checkbox" name="codePostal[]" value="1000-1299">Bruxelles-Capitale (1000-1299)</label></div>
                        <div class="checkbox"><label><input type="checkbox" name="codePostal[]" value="1300-1499">Brabant wallon (1300-1499)</label></div>
                        <div class="checkbox"><label><input type="checkbox" name="codePostal[]" value="4000-4999">Liège (4000-4999)</label></div>
                        <div class="checkbox"><label><input type="checkbox" name="codePostal[]" value="5000-5999">Namur (5000-5999)</label></div>
                        <div class="checkbox"><label><input type="checkbox" name="codePostal[]" value="6000-6599">Hainaut (6000-6599)</label></div>
                        <div class="checkbox"><label><input type="checkbox" name="codePostal[]" value="6600-6999">Luxembourg (6600-6999)</label></div>
                        <div class="checkbox"><label><input type="checkbox" name="codePostal[]" value="7000-7999">Hainaut (7000-7999)</label></div>
                        <div class="checkbox text-muted"><label><input type="checkbox" name="codePostal[]" value="all"> Tous</label></div>
                        <hr>
                        <div class="checkbox"><label><input type="checkbox" name="active[]" value="1"> Activé</label></div>
                        <div class="checkbox"><label><input type="checkbox" name="active[]" value="0"> Désactivé</label></div>
                        <div class="checkbox text-muted"><label><input type="checkbox" name="active[]" value="all"> Tous</label></div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Tri</h3>
                    </div>
                    <div class="panel-body">
                        <div class="radio"><label><input type="radio" name="trier" value="libelle"> Libellé</label></div>
                        <div class="radio"><label><input type="radio" name="trier" value="type"> Type d'enseignement</label></div>
                        <div class="radio"><label><input type="radio" name="trier" value="codePostal"> Code postal</label></div>
                    </div>
                </div>
            </form>
            <div class="col-lg-8">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Établissements
                            <img src="../libs/spinner/spinner1.gif" id="spinner" style="visibility:hidden;">
                            <a href="./creer.php" class="btn btn-default btn-xs pull-right">
                                <span class="glyphicon glyphicon-plus-sign"></span>
                                Créer un établissement
                            </a>
                        </h3>
                    </div>
                    <div id="results" class="list-group"></div>
                </div>
            </div>
        </div>
    </div>
    <script src="../libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="../libs/jquery.cookie/jquery.cookie.min.js"></script>
    <script src="../libs/jquery.unserializeform/jquery.unserializeform.min.js"></script>
    <script src="../libs/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script>
        $(function(){
            function ajaxSelect() {
                $.cookie('etablissements', $('#frmAjax').serialize());

                $container = $('#results');
                $container.empty();

                $.ajax({
                    url: 'ajax.php',
                    data: $('#frmAjax').serialize(),
                    beforeSend: function(xhr) {
                        $('#spinner').css('visibility', 'visible');
                        $('body').scrollTop(-70);
                    },
                    success: function(result) {
                        var items = JSON.parse(result);

                        if (items.length > 0) {
                            for (var i=0; i < items.length; i++) {
                                var active = items[i].active == 0 ? false : true;
                                var id = items[i].id;
                                var libelle = items[i].libelle;
                                var type = items[i].type;
                                var codePostal = items[i].codePostal;
                                var commune = items[i].commune;

                                $content = $(
                                    '<div class="list-group-item ' + (active ? 'list-group-item-success' : '') + '">' +
                                        '<div class="row">' +
                                            '<div class="col-lg-10">' +
                                                '<ul class="list-inline">' +
                                                    '<li><strong>' + libelle + '</strong></li>' +
                                                '</ul>' +
                                                '<ul class="list-inline">' +
                                                    '<li><span class="glyphicon glyphicon-map-marker"></span> ' + codePostal + ' ' + commune + '</li>' +
                                                    '<li><span class="glyphicon glyphicon-tag"></span> ' + type + '</li>' +
                                                '</ul>' +
                                            '</div>' +
                                            '<div class="col-lg-2 text-right">' +
                                                '<div class="btn-group-vertical btn-group-sm">' +
                                                    '<a href="modifier.php?id=' + id + '" class="btn btn-default" title="Éditer">' +
                                                        '<span class="glyphicon glyphicon-pencil"></span>' +
                                                    '</a>' +
                                                    '<a href="modifier.php?id=' + id + '&active=' + (active ? '0' : '1') + '" class="btn btn-default ajax-update" title="' + (active ? 'Désactiver' : 'Activer') + '">' +
                                                        '<span class="glyphicon ' + (active ? 'glyphicon-eye-close' : 'glyphicon-eye-open') + '"></span>' +
                                                    '</a>' +
                                                '</div>' +
                                            '</div>' +
                                        '</div>' +
                                    '</div>'
                                );
                                $content.hide();
                                $container.append($content);
                                $content.fadeIn();

                                $('.ajax-update', $content).click(ajaxUpdate);
                            }
                        } else {
                            $content = $('<div class="list-group-item text-warning">Aucun résultat ne correspond à vos critères.</div>');
                            $content.hide();
                            $container.append($content);
                            $content.fadeIn();
                        }
                    },
                    error: function(response) {
                        $content = $('<div class="list-group-item text-danger">Une erreur s\'est produite. La réponse du serveur est : ' + response.statusText + '</div>');
                        $content.hide();
                        $container.append($content);
                        $content.fadeIn();
                    },
                    complete: function() {
                        $('#spinner').css('visibility', 'hidden');
                    }
                });
            }

            function ajaxUpdate(event) {
                event.preventDefault();

                var $button = $(event.delegateTarget);
                var $item =  $button.parents('.list-group-item');
                var $icon =  $button.children('.glyphicon');

                var href = $button.attr('href');

                $.ajax({
                    url: href,
                    beforeSend: function() {
                        $button.addClass('disabled');
                    },
                    success: function() {
                        var wasActive = $item.hasClass('list-group-item-success');
                        var isActive = !wasActive;
                        
                        if (isActive && $('input[name="active[]"][value="0"]').prop('checked') && !$('input[name="active[]"][value="1"]').prop('checked')) {
                            $item.remove();
                        } else if (!isActive && $('input[name="active[]"][value="1"]').prop('checked') && !$('input[name="active[]"][value="0"]').prop('checked')) {
                            $item.remove();
                        } else {
                            var newItemClass = isActive ? 'list-group-item-success' : '';
                            var newIconClass = isActive ? 'glyphicon-eye-close' : 'glyphicon-eye-open';

                            $item.removeClass('list-group-item-success').addClass(newItemClass);
                            $icon.removeClass('glyphicon-eye-open glyphicon-eye-close').addClass(newIconClass);
                        }
                    },
                    complete: function() {
                        $button.removeClass('disabled');
                    }
                });
            }

            function checkAll() {
                $('input[name="'+$(this).attr('name')+'"]').prop('checked', $(this).prop('checked'));
            }

            function uncheckAll() {
                $('input[name="'+$(this).attr('name')+'"][value="all"]').prop('checked', false);
            }

            function reloadFilters() {
                var filtres = $.cookie('etablissements');

                if (filtres !== undefined && filtres !== null) {
                    $('#frmAjax').unserializeForm($.cookie('etablissements'));
                } else {
                    $('#frmAjax input[name="type[]"]').prop('checked', true);
                    $('#frmAjax input[name="codePostal[]"][value="1000-1299"]').prop('checked', true);
                    $('#frmAjax input[name="active[]"]').prop('checked', true);
                    $('#frmAjax input[name="trier"][value="libelle"]').prop('checked', true);
                }
            }

            $('#frmAjax input[value="all"]').click(checkAll);
            $('#frmAjax input[value!="all"]').click(uncheckAll);

            $('#frmAjax input[type="checkbox"]').click(ajaxSelect);
            $('#frmAjax input[type="radio"]').click(ajaxSelect);
            $('#frmAjax input[type="text"]').keyup(ajaxSelect);

            reloadFilters();
            ajaxSelect();
        });
    </script>
</body>
</html>
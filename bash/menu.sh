#!/bin/bash

read -p 'Site: ' site
echo $site

home_link=$(wp option get home --url=$site --allow-root)

menu_id=$(wp menu create "Default" --porcelain --url=$site --allow-root)
echo "menu id - " $menu_id
wp menu location assign $menu_id pa-menu-default --url=$site --allow-root

wp menu item add-custom $menu_id "Home" $home_link --url=$site --allow-root
menu_depto=$(wp menu item add-custom $menu_id "Departamentos" "#" --porcelain --url=$site --allow-root)
 
wp menu item add-custom default "AFAM" "#" --parent-id=$menu_depto --url=$site --allow-root
wp menu item add-custom default "ASA" "#" --parent-id=$menu_depto --url=$site --allow-root
wp menu item add-custom default "Associação\ Ministerial" "#" --parent-id=$menu_depto --url=$site --allow-root
wp menu item add-custom default "Aventureiros" "#" --parent-id=$menu_depto --url=$site --allow-root
wp menu item add-custom default "Comunicação" "#" --parent-id=$menu_depto --url=$site --allow-root
wp menu item add-custom default "Desbravadores" "#" --parent-id=$menu_depto --url=$site --allow-root
wp menu item add-custom default "Educação" "#" --parent-id=$menu_depto --url=$site --allow-root
wp menu item add-custom default "Escola\ Sabatina" "#" --parent-id=$menu_depto --url=$site --allow-root
wp menu item add-custom default "Espírito\ de\ Profecia" "#" --parent-id=$menu_depto --url=$site --allow-root
wp menu item add-custom default "Evangelismo" "#" --parent-id=$menu_depto --url=$site --allow-root
wp menu item add-custom default "Liberdade\ Religiosa" "#" --parent-id=$menu_depto --url=$site --allow-root
wp menu item add-custom default "Ministério\ da\ Criança" "#" --parent-id=$menu_depto --url=$site --allow-root
wp menu item add-custom default "Ministério\ da\ Família" "#" --parent-id=$menu_depto --url=$site --allow-root
wp menu item add-custom default "Ministério\ da\ Mulher" "#" --parent-id=$menu_depto --url=$site --allow-root
wp menu item add-custom default "Ministério\ da\ Música" "#" --parent-id=$menu_depto --url=$site --allow-root
wp menu item add-custom default "Ministério\ de\ Surdos" "#" --parent-id=$menu_depto --url=$site --allow-root
wp menu item add-custom default "Ministério\ do\ Adolescente" "#" --parent-id=$menu_depto --url=$site --allow-root
wp menu item add-custom default "Ministério\ Jovem" "#" --parent-id=$menu_depto --url=$site --allow-root
wp menu item add-custom default "Ministério\ Pessoal" "#" --parent-id=$menu_depto --url=$site --allow-root
wp menu item add-custom default "Missão\ Global" "#" --parent-id=$menu_depto --url=$site --allow-root
wp menu item add-custom default "Mordomia\ Cristã" "#" --parent-id=$menu_depto --url=$site --allow-root
wp menu item add-custom default "Publicações" "#" --parent-id=$menu_depto --url=$site --allow-root
wp menu item add-custom default "Saúde" "#" --parent-id=$menu_depto --url=$site --allow-root
wp menu item add-custom default "Serviço\ Voluntário\ Adventista" "#" --parent-id=$menu_depto --url=$site --allow-root


menu_sedes=$(wp menu item add-custom $menu_id "Sedes Regionais" "#" --porcelain --url=$site --allow-root)
wp menu item add-custom	default	"União Argentina" "#" --parent-id=$menu_sedes --url=$site --allow-root
wp menu item add-custom	default	"União Boliviana" "#" --parent-id=$menu_sedes --url=$site --allow-root
wp menu item add-custom	default	"União Central Brasileira" "#" --parent-id=$menu_sedes --url=$site --allow-root
wp menu item add-custom	default	"União Centro-Oeste Brasileira" "#" --parent-id=$menu_sedes --url=$site --allow-root
wp menu item add-custom	default	"União Chilena" "#" --parent-id=$menu_sedes --url=$site --allow-root
wp menu item add-custom	default	"União Ecuatoriana" "#" --parent-id=$menu_sedes --url=$site --allow-root
wp menu item add-custom	default	"União Leste Brasileira" "#" --parent-id=$menu_sedes --url=$site --allow-root
wp menu item add-custom	default	"União Nordeste Brasileira" "#" --parent-id=$menu_sedes --url=$site --allow-root
wp menu item add-custom	default	"União Noroeste Brasileira" "#" --parent-id=$menu_sedes --url=$site --allow-root
wp menu item add-custom	default	"União Norte Brasileira" "#" --parent-id=$menu_sedes --url=$site --allow-root
wp menu item add-custom	default	"União Paraguaya" "#" --parent-id=$menu_sedes --url=$site --allow-root
wp menu item add-custom	default	"União Peruana do Norte" "#" --parent-id=$menu_sedes --url=$site --allow-root
wp menu item add-custom	default	"União Peruana do Sul" "#" --parent-id=$menu_sedes --url=$site --allow-root
wp menu item add-custom	default	"União Sudeste Brasileira" "#" --parent-id=$menu_sedes --url=$site --allow-root
wp menu item add-custom	default	"União Sul Brasileira" "#" --parent-id=$menu_sedes --url=$site --allow-root
wp menu item add-custom	default	"União Uruguaya" "#" --parent-id=$menu_sedes --url=$site --allow-root


wp menu item add-custom $menu_id "Sobre nós" $home_link --url=$site --allow-root
wp menu item add-custom $menu_id "Feliz7Play" "https://feliz7play.com/pt/" --url=$site --allow-root
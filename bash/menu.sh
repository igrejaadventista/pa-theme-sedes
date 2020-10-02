#!/bin/bash

home_link=$(wp option get home)

menu_id=$(wp menu create "Default" --porcelain)
echo "menu id - " $menu_id
wp menu location assign $menu_id pa-menu-default

wp menu item add-custom $menu_id "Home" $home_link
menu_depto=$(wp menu item add-custom $menu_id "Departamentos" "#" --porcelain)
 
wp menu item add-custom default "AFAM" "#" --parent-id=$menu_depto
wp menu item add-custom default "ASA" "#" --parent-id=$menu_depto
wp menu item add-custom default "Associação\ Ministerial" "#" --parent-id=$menu_depto
wp menu item add-custom default "Aventureiros" "#" --parent-id=$menu_depto
wp menu item add-custom default "Comunicação" "#" --parent-id=$menu_depto
wp menu item add-custom default "Desbravadores" "#" --parent-id=$menu_depto
wp menu item add-custom default "Educação" "#" --parent-id=$menu_depto
wp menu item add-custom default "Escola\ Sabatina" "#" --parent-id=$menu_depto
wp menu item add-custom default "Espírito\ de\ Profecia" "#" --parent-id=$menu_depto
wp menu item add-custom default "Evangelismo" "#" --parent-id=$menu_depto
wp menu item add-custom default "Liberdade\ Religiosa" "#" --parent-id=$menu_depto
wp menu item add-custom default "Ministério\ da\ Criança" "#" --parent-id=$menu_depto
wp menu item add-custom default "Ministério\ da\ Família" "#" --parent-id=$menu_depto
wp menu item add-custom default "Ministério\ da\ Mulher" "#" --parent-id=$menu_depto
wp menu item add-custom default "Ministério\ da\ Música" "#" --parent-id=$menu_depto
wp menu item add-custom default "Ministério\ de\ Surdos" "#" --parent-id=$menu_depto
wp menu item add-custom default "Ministério\ do\ Adolescente" "#" --parent-id=$menu_depto
wp menu item add-custom default "Ministério\ Jovem" "#" --parent-id=$menu_depto
wp menu item add-custom default "Ministério\ Pessoal" "#" --parent-id=$menu_depto
wp menu item add-custom default "Missão\ Global" "#" --parent-id=$menu_depto
wp menu item add-custom default "Mordomia\ Cristã" "#" --parent-id=$menu_depto
wp menu item add-custom default "Publicações" "#" --parent-id=$menu_depto
wp menu item add-custom default "Saúde" "#" --parent-id=$menu_depto
wp menu item add-custom default "Serviço\ Voluntário\ Adventista" "#" --parent-id=$menu_depto


menu_sedes=$(wp menu item add-custom $menu_id "Sedes Regionais" "#" --porcelain)
wp menu item add-custom	default	"União Argentina" "#" --parent-id=$menu_sedes
wp menu item add-custom	default	"União Boliviana" "#" --parent-id=$menu_sedes
wp menu item add-custom	default	"União Central Brasileira" "#" --parent-id=$menu_sedes
wp menu item add-custom	default	"União Centro-Oeste Brasileira" "#" --parent-id=$menu_sedes
wp menu item add-custom	default	"União Chilena" "#" --parent-id=$menu_sedes
wp menu item add-custom	default	"União Ecuatoriana" "#" --parent-id=$menu_sedes
wp menu item add-custom	default	"União Leste Brasileira" "#" --parent-id=$menu_sedes
wp menu item add-custom	default	"União Nordeste Brasileira" "#" --parent-id=$menu_sedes
wp menu item add-custom	default	"União Noroeste Brasileira" "#" --parent-id=$menu_sedes
wp menu item add-custom	default	"União Norte Brasileira" "#" --parent-id=$menu_sedes
wp menu item add-custom	default	"União Paraguaya" "#" --parent-id=$menu_sedes
wp menu item add-custom	default	"União Peruana do Norte" "#" --parent-id=$menu_sedes
wp menu item add-custom	default	"União Peruana do Sul" "#" --parent-id=$menu_sedes
wp menu item add-custom	default	"União Sudeste Brasileira" "#" --parent-id=$menu_sedes
wp menu item add-custom	default	"União Sul Brasileira" "#" --parent-id=$menu_sedes
wp menu item add-custom	default	"União Uruguaya" "#" --parent-id=$menu_sedes


wp menu item add-custom $menu_id "Sobre nós" $home_link
wp menu item add-custom $menu_id "Feliz7Play" "https://feliz7play.com/pt/"


# while true; do
#     read -p "Deseja excluir o menu ? s/n" yn
#     case $yn in
#         [Yy]* ) wp menu delete $menu_id; break;;
#         [Nn]* ) e$menu_sedesit;;
#         * ) echo "Please answer yes or no.";;
#     esac
# done
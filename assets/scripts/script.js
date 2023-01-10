/* Arquivo Root */
import * as Menus from './_pa-menus';
import * as Feliz7Play from './_pa-slider-feliz7play';
import * as SliderFeatured from './_pa-slider-destaques';
import * as SliderMain from './_pa-slider-principal';
import * as SliderVideos from './_pa-slider-videos';
import * as utils from './_pa-img-error';
import * as SliderDownloads from './_pa-slider-downloads';
import * as TextSize from './_pa-tamanho-texto';
import * as Share from './_pa-share';
import Glide from '@glidejs/glide';

window.Menus = Menus;
window.TextSize = TextSize;
window.Share = Share;
window.Glide = Glide;

function onload() {
	Menus.pa_dropdown();
	Feliz7Play.pa_slider_feliz7play();
	SliderFeatured.pa_slider_destaques();
	SliderFeatured.pa_slider_destaque_deptos();
	SliderMain.pa_slider_principal();
	SliderFeatured.pa_slider_magazines();
	SliderVideos.pa_slider_videos();
	utils.pa_img_error();
	utils.pa_truncate();
	Menus.pa_number_of_columns_menu();
	SliderDownloads.pa_slider_downloads();
}
document.addEventListener("DOMContentLoaded", onload, false);
export function pa_dataLayer() {
    window.onload = () => {
        setTimeout(() => {
            window.dataLayer = window.dataLayer || [];
            
            if(document.querySelector('body').classList.contains('single-post')){
                const data = get_dataLayerData();
                dataLayer.push(data);
            }
        }, 1000);
    }
}

function get_dataLayerData(){
    let data = {
        'url': window.location.href,
        'event': 'Pageview',
    }

    const noticia_autor = document.querySelector('meta[name="pa_autor"]')?.content;
    const noticia_sedes_regionais = document.querySelector('meta[name="pa_sedes_regionais"]')?.content;
    const noticia_sedes_proprietarias = document.querySelector('meta[name="pa_sedes_proprietarias"]')?.content;
    const noticia_editoriais = document.querySelector('meta[name="pa_editoriais"]')?.content;
    const noticia_departamento = document.querySelector('meta[name="pa_departamento"]')?.content;
    const noticia_projeto = document.querySelector('meta[name="pa_projeto"]')?.content;
    const noticia_regiao = document.querySelector('meta[name="pa_regiao"]')?.content;
    const noticia_formato_post = document.querySelector('meta[name="pa_formato_post"]')?.content;

    noticia_autor ? data['pa_autor'] = noticia_autor : '';
    noticia_sedes_regionais ? data['pa_sedes_regionais'] = noticia_sedes_regionais : '';
    noticia_sedes_proprietarias ? data['pa_sedes_proprietarias'] = noticia_sedes_proprietarias : '';
    noticia_editoriais ? data['pa_editoriais'] = noticia_editoriais : '';
    noticia_departamento ? data['pa_departamento'] = noticia_departamento : '';
    noticia_projeto ? data['pa_projeto'] = noticia_projeto : '';
    noticia_regiao ? data['pa_regiao'] = noticia_regiao : '';
    noticia_formato_post ? data['pa_formato_post'] = noticia_formato_post : '';

    return data;
}